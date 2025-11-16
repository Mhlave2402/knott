<?php

return [
    
    // AI Matching Configuration
    'ai' => [
        'gemini' => [
            'api_key' => env('GOOGLE_GEMINI_API_KEY'),
            'model' => env('GEMINI_MODEL', 'gemini-pro'),
            'max_tokens' => env('GEMINI_MAX_TOKENS', 2048),
            'temperature' => 0.7,
            'timeout' => 30, // seconds
        ],
        
        'matching' => [
            'min_confidence_score' => 0.3,
            'max_vendors_per_category' => 5,
            'budget_flexibility_percent' => 20,
            'location_radius_km' => 50,
        ],
    ],

    // Quote Request Settings
    'quotes' => [
        'request_expiry_days' => env('QUOTE_REQUEST_EXPIRY_DAYS', 14),
        'response_expiry_days' => env('QUOTE_RESPONSE_EXPIRY_DAYS', 7),
        'max_quotes_per_request' => env('MAX_QUOTES_PER_REQUEST', 10),
        'auto_expire_enabled' => true,
        'reminder_days_before_expiry' => 3,
    ],

    // Negotiator Configuration
    'negotiators' => [
        'verification_required' => env('NEGOTIATOR_VERIFICATION_REQUIRED', true),
        'min_experience_years' => env('NEGOTIATOR_MIN_EXPERIENCE_YEARS', 2),
        'max_travel_distance' => env('NEGOTIATOR_MAX_TRAVEL_DISTANCE', 500),
        'booking_advance_days' => 7, // Minimum days to book in advance
        'cancellation_hours' => 24, // Hours before booking can be cancelled
        
        'cultural_backgrounds' => [
            'Zulu', 'Xhosa', 'Sotho', 'Tswana', 'Pedi', 'Venda', 'Ndebele', 'Swati', 'Tsonga'
        ],
        
        'default_languages' => [
            'English', 'Afrikaans', 'Zulu', 'Xhosa', 'Sotho'
        ],
    ],

    // Competition Settings
    'competitions' => [
        'max_photos' => env('COMPETITION_MAX_PHOTOS', 20),
        'max_videos' => env('COMPETITION_MAX_VIDEOS', 5),
        'voting_duration_days' => env('COMPETITION_VOTING_DURATION_DAYS', 30),
        'file_max_size_kb' => env('COMPETITION_FILE_MAX_SIZE', 10240),
        'min_vendors_required' => 4,
        'auto_approval' => false,
        
        'judging_criteria' => [
            'photography_quality' => 30,
            'story_telling' => 25,
            'vendor_coordination' => 20,
            'creativity_style' => 15,
            'overall_presentation' => 10,
        ],
        
        'voting_weights' => [
            'public' => 30,
            'admin' => 70,
        ],
        
        'allowed_themes' => [
            'Traditional', 'Modern', 'Rustic', 'Classic', 'Bohemian', 
            'Vintage', 'Garden', 'Beach', 'Cultural', 'Destination'
        ],
    ],

    // File Upload Settings
    'uploads' => [
        'max_size_kb' => env('UPLOAD_MAX_SIZE', 10240),
        'allowed_images' => ['jpeg', 'jpg', 'png', 'gif', 'webp'],
        'allowed_videos' => ['mp4', 'mov', 'avi', 'wmv'],
        'allowed_documents' => ['pdf', 'doc', 'docx'],
        
        'image_processing' => [
            'thumbnail_size' => 300,
            'medium_size' => 800,
            'large_size' => 1920,
            'quality' => 85,
        ],
    ],

    // Notification Settings
    'notifications' => [
        'quote_requests' => env('NOTIFY_QUOTE_REQUESTS', true),
        'competition_updates' => env('NOTIFY_COMPETITION_UPDATES', true),
        'booking_confirmations' => env('NOTIFY_BOOKING_CONFIRMATIONS', true),
        'ai_matching_results' => true,
        'expiry_reminders' => true,
        
        'channels' => [
            'mail' => true,
            'database' => true,
            'sms' => false, // Can be enabled later
        ],
    ],

    // Business Logic Settings
    'business' => [
        'commission_rate' => 5.0, // Percentage
        'platform_fee' => 3.95, // Percentage for withdrawals
        'guest_contribution_fee' => 10.0, // Percentage
        'featured_listing_boost' => 2.0, // Multiplier for featured vendors
        'subscription_grace_days' => 7,
    ],

    // Regional Settings
    'regions' => [
        'provinces' => [
            'Gauteng' => ['Johannesburg', 'Pretoria', 'Sandton', 'Midrand', 'Centurion'],
            'Western Cape' => ['Cape Town', 'Stellenbosch', 'Paarl', 'Somerset West', 'Hermanus'],
            'KwaZulu-Natal' => ['Durban', 'Pietermaritzburg', 'Ballito', 'Umhlanga', 'Newcastle'],
            'Eastern Cape' => ['Port Elizabeth', 'East London', 'Grahamstown', 'George'],
            'Free State' => ['Bloemfontein', 'Welkom', 'Kroonstad'],
            'Limpopo' => ['Polokwane', 'Tzaneen', 'Thohoyandou'],
            'Mpumalanga' => ['Nelspruit', 'Witbank', 'Secunda'],
            'North West' => ['Potchefstroom', 'Klerksdorp', 'Rustenburg'],
            'Northern Cape' => ['Kimberley', 'Upington', 'Springbok'],
        ],
        
        'major_cities' => [
            'Johannesburg', 'Cape Town', 'Durban', 'Pretoria', 'Port Elizabeth',
            'Bloemfontein', 'East London', 'Pietermaritzburg', 'Witbank', 'Welkom'
        ],
    ],
];
