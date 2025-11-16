<?php

namespace App\Services;

use App\Models\Vendor;
use App\Models\QuoteRequest;
use App\Models\QuoteResponse;
use App\Models\AiMatchingLog;
use App\Jobs\ProcessAIMatching;
use App\Events\VendorsMatched;
use App\Events\QuoteRequestSent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Exception;

/**
 * AI Vendor Matching Service
 * 
 * Handles intelligent vendor matching using Google Gemini API
 * with fallback to rule-based matching for reliability
 * 
 * Location: app/Services/AiVendorMatchingService.php
 */
class AiVendorMatchingService
{
    private string $geminiApiKey;
    private string $geminiEndpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';
    
    public function __construct()
    {
        $this->geminiApiKey = config('services.google.gemini_api_key');
        
        if (!$this->geminiApiKey) {
            throw new Exception('Google Gemini API key not configured');
        }
    }

    /**
     * Main matching orchestrator
     * Handles the complete flow from request to vendor notifications
     */
    public function matchVendorsForQuoteRequest(QuoteRequest $quoteRequest): array
    {
        $startTime = microtime(true);
        
        try {
            // Step 1: Get vendor matches
            $matches = $this->findVendorMatches($quoteRequest);
            
            // Step 2: Send quote requests to matched vendors
            $sentRequests = $this->sendQuoteRequestsToVendors($quoteRequest, $matches);
            
            // Step 3: Log the matching process
            $this->logMatchingResult($quoteRequest, $matches, $startTime, true);
            
            // Step 4: Fire events for notifications
            event(new VendorsMatched($quoteRequest, $matches));
            
            return [
                'success' => true,
                'matches_count' => count($matches),
                'vendors_notified' => count($sentRequests),
                'matches' => $matches->map(fn($match) => [
                    'vendor_id' => $match['vendor']->id,
                    'vendor_name' => $match['vendor']->business_name,
                    'confidence_score' => $match['confidence_score'],
                    'match_reasons' => $match['reasons']
                ])
            ];
            
        } catch (Exception $e) {
            $this->logMatchingResult($quoteRequest, collect(), $startTime, false, $e->getMessage());
            throw $e;
        }
    }

    /**
     * Find vendor matches using AI + fallback logic
     */
    private function findVendorMatches(QuoteRequest $quoteRequest): Collection
    {
        // Try AI matching first
        try {
            $aiMatches = $this->getAiVendorMatches($quoteRequest);
            
            if ($aiMatches->isNotEmpty()) {
                Log::info('AI matching successful', ['quote_request_id' => $quoteRequest->id]);
                return $aiMatches;
            }
        } catch (Exception $e) {
            Log::warning('AI matching failed, using fallback', [
                'quote_request_id' => $quoteRequest->id,
                'error' => $e->getMessage()
            ]);
        }

        // Fallback to rule-based matching
        return $this->getRuleBasedMatches($quoteRequest);
    }

    /**
     * AI-powered vendor matching using Google Gemini
     */
    private function getAiVendorMatches(QuoteRequest $quoteRequest): Collection
    {
        // Get eligible vendors based on basic criteria
        $eligibleVendors = $this->getEligibleVendors($quoteRequest);
        
        if ($eligibleVendors->isEmpty()) {
            return collect();
        }

        // Prepare vendor data for AI analysis
        $vendorData = $eligibleVendors->map(function ($vendor) {
            return [
                'id' => $vendor->id,
                'business_name' => $vendor->business_name,
                'services' => $vendor->services,
                'location' => $vendor->location,
                'average_rating' => $vendor->average_rating ?? 0,
                'price_range_min' => $vendor->price_range_min ?? 0,
                'price_range_max' => $vendor->price_range_max ?? 999999,
                'specialties' => $vendor->specialties ?? [],
                'portfolio_count' => $vendor->portfolio_images_count ?? 0,
                'years_experience' => $vendor->years_experience ?? 0,
                'tags' => $vendor->tags ?? []
            ];
        })->toArray();

        // Create AI prompt
        $prompt = $this->buildAiMatchingPrompt($quoteRequest, $vendorData);
        
        // Call Gemini API
        $aiResponse = $this->callGeminiApi($prompt);
        
        // Parse AI response and create matches
        return $this->parseAiResponse($aiResponse, $eligibleVendors);
    }

    /**
     * Build the AI prompt for vendor matching
     */
    private function buildAiMatchingPrompt(QuoteRequest $quoteRequest, array $vendorData): string
    {
        return "
        You are a wedding planning expert helping match couples with the best vendors for their special day.
        
        COUPLE'S REQUIREMENTS:
        - Budget: R" . number_format($quoteRequest->budget) . "
        - Guest Count: " . $quoteRequest->guest_count . "
        - Location: " . $quoteRequest->location . "
        - Wedding Style: " . $quoteRequest->style . "
        - Preferred Date: " . ($quoteRequest->preferred_date ? $quoteRequest->preferred_date->format('Y-m-d') : 'Flexible') . "
        - Special Requirements: " . ($quoteRequest->special_requirements ?? 'None') . "
        
        AVAILABLE VENDORS:
        " . json_encode($vendorData, JSON_PRETTY_PRINT) . "
        
        TASK:
        Analyze each vendor and provide a matching score (0-100) with detailed reasoning.
        Consider: budget compatibility, service quality, location convenience, style alignment, experience level.
        
        Return your response as a JSON array with this exact structure:
        [
            {
                \"vendor_id\": 123,
                \"confidence_score\": 85,
                \"reasons\": [\"Budget perfect match\", \"Specializes in vintage style\", \"5-star ratings\"],
                \"potential_concerns\": [\"Location might be 30km away\"]
            }
        ]
        
        Only include vendors with confidence_score >= 60. Limit to top 8 matches.
        ";
    }

    /**
     * Call Google Gemini API
     */
    private function callGeminiApi(string $prompt): array
    {
        $cacheKey = 'gemini_response_' . md5($prompt);
        
        return Cache::remember($cacheKey, 300, function () use ($prompt) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->geminiEndpoint . '?key=' . $this->geminiApiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.3,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 2048,
                ]
            ]);

            if (!$response->successful()) {
                throw new Exception('Gemini API request failed: ' . $response->body());
            }

            return $response->json();
        });
    }

    /**
     * Parse AI response and create vendor matches
     */
    private function parseAiResponse(array $aiResponse, Collection $eligibleVendors): Collection
    {
        try {
            $responseText = $aiResponse['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            // Extract JSON from response (AI might include extra text)
            preg_match('/\[.*\]/s', $responseText, $matches);
            $jsonStr = $matches[0] ?? $responseText;
            
            $aiMatches = json_decode($jsonStr, true);
            
            if (!is_array($aiMatches)) {
                throw new Exception('Invalid AI response format');
            }

            return collect($aiMatches)->map(function ($match) use ($eligibleVendors) {
                $vendor = $eligibleVendors->firstWhere('id', $match['vendor_id']);
                
                if (!$vendor) return null;
                
                return [
                    'vendor' => $vendor,
                    'confidence_score' => (int) $match['confidence_score'],
                    'reasons' => $match['reasons'] ?? [],
                    'concerns' => $match['potential_concerns'] ?? [],
                    'match_type' => 'ai'
                ];
            })->filter()->sortByDesc('confidence_score');
            
        } catch (Exception $e) {
            Log::error('Failed to parse AI response', ['error' => $e->getMessage()]);
            throw new Exception('AI response parsing failed');
        }
    }

    /**
     * Fallback rule-based matching
     */
    private function getRuleBasedMatches(QuoteRequest $quoteRequest): Collection
    {
        $eligibleVendors = $this->getEligibleVendors($quoteRequest);
        
        return $eligibleVendors->map(function ($vendor) use ($quoteRequest) {
            $score = $this->calculateRuleBasedScore($vendor, $quoteRequest);
            
            if ($score < 60) return null;
            
            return [
                'vendor' => $vendor,
                'confidence_score' => $score,
                'reasons' => $this->generateRuleBasedReasons($vendor, $quoteRequest),
                'concerns' => [],
                'match_type' => 'rule_based'
            ];
        })->filter()->sortByDesc('confidence_score')->take(8);
    }

    /**
     * Get vendors eligible for matching based on basic criteria
     */
    private function getEligibleVendors(QuoteRequest $quoteRequest): Collection
    {
        $budgetFlexibility = 0.2; // 20% flexibility
        $minBudget = $quoteRequest->budget * (1 - $budgetFlexibility);
        $maxBudget = $quoteRequest->budget * (1 + $budgetFlexibility);

        return Vendor::active()
            ->verified()
            ->where('location', 'LIKE', '%' . $quoteRequest->location . '%')
            ->where(function ($query) use ($minBudget, $maxBudget) {
                $query->whereBetween('price_range_min', [0, $maxBudget])
                      ->orWhereBetween('price_range_max', [$minBudget, PHP_INT_MAX])
                      ->orWhere(function ($q) use ($minBudget, $maxBudget) {
                          $q->where('price_range_min', '<=', $minBudget)
                            ->where('price_range_max', '>=', $maxBudget);
                      });
            })
            ->with(['user', 'reviews'])
            ->withCount('portfolio_images')
            ->get();
    }

    /**
     * Calculate rule-based matching score
     */
    private function calculateRuleBasedScore(Vendor $vendor, QuoteRequest $quoteRequest): int
    {
        $score = 0;
        
        // Budget compatibility (40 points)
        $budgetScore = $this->calculateBudgetScore($vendor, $quoteRequest);
        $score += $budgetScore * 40;
        
        // Rating score (25 points)
        $ratingScore = ($vendor->average_rating ?? 0) / 5;
        $score += $ratingScore * 25;
        
        // Experience score (15 points)
        $experienceScore = min(($vendor->years_experience ?? 0) / 10, 1);
        $score += $experienceScore * 15;
        
        // Portfolio completeness (10 points)
        $portfolioScore = min(($vendor->portfolio_images_count ?? 0) / 20, 1);
        $score += $portfolioScore * 10;
        
        // Location proximity (10 points)
        $locationScore = str_contains(strtolower($vendor->location), strtolower($quoteRequest->location)) ? 1 : 0.5;
        $score += $locationScore * 10;
        
        return (int) $score;
    }

    /**
     * Calculate budget compatibility score
     */
    private function calculateBudgetScore(Vendor $vendor, QuoteRequest $quoteRequest): float
    {
        $vendorMin = $vendor->price_range_min ?? 0;
        $vendorMax = $vendor->price_range_max ?? PHP_INT_MAX;
        $coupleBudget = $quoteRequest->budget;
        
        // Perfect match if couple's budget falls within vendor's range
        if ($coupleBudget >= $vendorMin && $coupleBudget <= $vendorMax) {
            return 1.0;
        }
        
        // Calculate how far outside the range
        if ($coupleBudget < $vendorMin) {
            $gap = ($vendorMin - $coupleBudget) / $coupleBudget;
        } else {
            $gap = ($coupleBudget - $vendorMax) / $vendorMax;
        }
        
        // Reduce score based on gap (20% gap = 50% score)
        return max(0, 1 - ($gap / 0.4));
    }

    /**
     * Generate reasons for rule-based matching
     */
    private function generateRuleBasedReasons(Vendor $vendor, QuoteRequest $quoteRequest): array
    {
        $reasons = [];
        
        // Budget reasons
        $budgetScore = $this->calculateBudgetScore($vendor, $quoteRequest);
        if ($budgetScore >= 0.9) {
            $reasons[] = "Perfect budget match";
        } elseif ($budgetScore >= 0.7) {
            $reasons[] = "Good budget compatibility";
        }
        
        // Rating reasons
        if (($vendor->average_rating ?? 0) >= 4.5) {
            $reasons[] = "Excellent customer reviews ({$vendor->average_rating}/5)";
        } elseif (($vendor->average_rating ?? 0) >= 4.0) {
            $reasons[] = "Great customer ratings";
        }
        
        // Experience reasons
        if (($vendor->years_experience ?? 0) >= 5) {
            $reasons[] = "Experienced vendor ({$vendor->years_experience} years)";
        }
        
        // Portfolio reasons
        if (($vendor->portfolio_images_count ?? 0) >= 15) {
            $reasons[] = "Extensive portfolio";
        }
        
        // Location reasons
        if (str_contains(strtolower($vendor->location), strtolower($quoteRequest->location))) {
            $reasons[] = "Local to your area";
        }
        
        return array_slice($reasons, 0, 4); // Limit to 4 reasons
    }

    /**
     * Send quote requests to matched vendors
     */
    private function sendQuoteRequestsToVendors(QuoteRequest $quoteRequest, Collection $matches): Collection
    {
        return $matches->map(function ($match) use ($quoteRequest) {
            try {
                // Create quote response record for vendor to respond to
                $quoteResponse = QuoteResponse::create([
                    'quote_request_id' => $quoteRequest->id,
                    'vendor_id' => $match['vendor']->id,
                    'ai_confidence_score' => $match['confidence_score'],
                    'ai_match_reasons' => $match['reasons'],
                    'status' => 'pending',
                    'expires_at' => now()->addDays(7) // Vendors have 7 days to respond
                ]);

                // Fire event to send notification to vendor
                event(new QuoteRequestSent($quoteResponse));
                
                return $quoteResponse;
                
            } catch (Exception $e) {
                Log::error('Failed to send quote request to vendor', [
                    'vendor_id' => $match['vendor']->id,
                    'quote_request_id' => $quoteRequest->id,
                    'error' => $e->getMessage()
                ]);
                return null;
            }
        })->filter();
    }

    /**
     * Log matching results for analytics
     */
    private function logMatchingResult(
        QuoteRequest $quoteRequest, 
        Collection $matches, 
        float $startTime, 
        bool $success, 
        ?string $errorMessage = null
    ): void {
        AiMatchingLog::create([
            'quote_request_id' => $quoteRequest->id,
            'matches_found' => $matches->count(),
            'ai_used' => $matches->where('match_type', 'ai')->isNotEmpty(),
            'processing_time_ms' => (int) ((microtime(true) - $startTime) * 1000),
            'success' => $success,
            'error_message' => $errorMessage,
            'match_details' => $matches->map(fn($match) => [
                'vendor_id' => $match['vendor']->id,
                'confidence_score' => $match['confidence_score'],
                'match_type' => $match['match_type']
            ])->toArray()
        ]);
    }

    /**
     * Get matching statistics for admin dashboard
     */
    public function getMatchingStats(int $days = 30): array
    {
        $logs = AiMatchingLog::where('created_at', '>=', now()->subDays($days))->get();
        
        return [
            'total_requests' => $logs->count(),
            'success_rate' => $logs->count() > 0 ? ($logs->where('success', true)->count() / $logs->count()) * 100 : 0,
            'ai_usage_rate' => $logs->count() > 0 ? ($logs->where('ai_used', true)->count() / $logs->count()) * 100 : 0,
            'average_matches_per_request' => $logs->avg('matches_found') ?? 0,
            'average_processing_time_ms' => $logs->avg('processing_time_ms') ?? 0,
            'total_matches_generated' => $logs->sum('matches_found')
        ];
    }

    /**
     * Retry failed AI matching for a quote request
     */
    public function retryMatching(QuoteRequest $quoteRequest): array
    {
        Log::info('Retrying AI matching', ['quote_request_id' => $quoteRequest->id]);
        
        return $this->matchVendorsForQuoteRequest($quoteRequest);
    }
}