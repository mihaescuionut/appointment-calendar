<?php

namespace Database\Seeders;

use App\Models\Program;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $endYear = date(('Y-m-d'), strtotime('12/31'));
        $period = CarbonPeriod::create(Carbon::now()->format('Y-m-d'), $endYear);
        $programs = Program::all();
        if (count($programs) > 0 == false) {
            foreach ($period as $date) {
                if ($date->isWeekday()) {
                    $firstProgram = Program::create([
                        'date' => $date->format('Y-m-d'),
                        'from' => '09:00:00',
                        'to' => '13:00:00'
                    ]);
                    $secondProgram = Program::create([
                        'date' => $date->format('Y-m-d'),
                        'from' => '15:30:00',
                        'to' => '21:00:00'
                    ]);
                }
            }
        }   
    }
}
