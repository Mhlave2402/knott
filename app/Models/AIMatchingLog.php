<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AIMatchingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_request_id',
        'ai_prompt',
        'ai_response',
        'processed_matches',
        'total_matches_found',
        'processing_time',
        'ai_model_version',
        'was_successful',
        'error_message',
        'fallback_matches',
    ];

    protected $casts = [
        'ai_response' => 'array',
        'processed_matches' => 'array',
        'fallback_matches' => 'array',
        'processing_time' => 'decimal:3',
        'was_successful' => 'boolean',
    ];

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function quoteRequest(): BelongsTo
    {
        return $this->belongsTo(QuoteRequest::class);
    }

    // =============================================================================
    // SCOPES
    // =============================================================================

    public function scopeSuccessful($query)
    {
        return $query->where('was_successful', true);
    }

    public function scopeFailed($query)
    {
        return $query->where('was_successful', false);
    }

    public function scopeSlowQueries($query, $threshold = 5.0)
    {
        return $query->where('processing_time', '>', $threshold);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // =============================================================================
    // ACCESSORS
    // =============================================================================

    public function getFormattedProcessingTimeAttribute(): string
    {
        return number_format($this->processing_time, 3) . 's';
    }

    public function getMatchQualityAttribute(): string
    {
        $avgConfidence = collect($this->processed_matches)->avg('confidence_score') ?? 0;
        
        if ($avgConfidence >= 0.8) return 'Excellent';
        if ($avgConfidence >= 0.6) return 'Good';
        if ($avgConfidence >= 0.4) return 'Fair';
        return 'Poor';
    }

    public function getHasErrorAttribute(): bool
    {
        return !$this->was_successful && !is_null($this->error_message);
    }

    // =============================================================================
    // STATIC METHODS FOR ANALYTICS
    // =============================================================================

    public static function getAverageProcessingTime(): float
    {
        return static::successful()->avg('processing_time') ?? 0;
    }

    public static function getSuccessRate(): float
    {
        $total = static::count();
        if ($total === 0) return 100;
        
        $successful = static::successful()->count();
        return ($successful / $total) * 100;
    }

    public static function getMostCommonErrors(): array
    {
        return static::failed()
            ->whereNotNull('error_message')
            ->groupBy('error_message')
            ->selectRaw('error_message, count(*) as count')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->toArray();
    }
}
