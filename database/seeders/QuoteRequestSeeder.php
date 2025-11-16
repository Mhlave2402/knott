<?php

namespace Database\Seeders;

use App\Models\Couple;
use App\Models\QuoteRequest;
use Illuminate\Database\Seeder;

class QuoteRequestSeeder extends Seeder
{
    public function run(): void
    {
        $couples = Couple::all();
        
        foreach ($couples as $couple) {
            // Create 1-3 quote requests per couple
            QuoteRequest::factory()
                ->count(rand(1, 3))
                ->for($couple)
                ->create();
        }
    }
}
