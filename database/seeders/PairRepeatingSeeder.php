<?php

namespace Database\Seeders;

use App\Models\PairRepeating;
use Illuminate\Database\Seeder;

class PairRepeatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repeating = PairRepeating::firstOrCreate(
            ['repeating_name' => 'EveryWeek']
        );
        $repeating = PairRepeating::firstOrCreate(
            ['repeating_name' => 'HighWeek']
        );
        $repeating = PairRepeating::firstOrCreate(
            ['repeating_name' => 'LowWeek']
        );
    }
}
