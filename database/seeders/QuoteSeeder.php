<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    public function run(): void
    {
        Quote::factory()->count(10)->create();
        Quote::factory()->approved()->count(5)->create();
        Quote::factory()->rejected()->count(3)->create();
        Quote::factory()->scheduled()->count(7)->create();
        Quote::factory()->invoiced()->count(4)->create();
    }
}
