<?php

namespace Database\Seeders;

use App\Models\DayOfWeek;
use Illuminate\Database\Seeder;

class DayOfWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $day = DayOfWeek::firstOrCreate(
            ['days_name' => 'Понедельник']
        );
        $day = DayOfWeek::firstOrCreate(
            ['days_name' => 'Вторник']
        );
        $day = DayOfWeek::firstOrCreate(
            ['days_name' => 'Среда']
        );
        $day = DayOfWeek::firstOrCreate(
            ['days_name' => 'Четверг']
        );
        $day = DayOfWeek::firstOrCreate(
            ['days_name' => 'Пятница']
        );
        $day = DayOfWeek::firstOrCreate(
            ['days_name' => 'Суббота']
        );
    }
}
