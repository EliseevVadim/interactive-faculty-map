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
            ['repeating_name' => 'Каждую неделю']
        );
        $repeating = PairRepeating::firstOrCreate(
            ['repeating_name' => 'По верхней неделе']
        );
        $repeating = PairRepeating::firstOrCreate(
            ['repeating_name' => 'По нижней неделе']
        );
    }
}
