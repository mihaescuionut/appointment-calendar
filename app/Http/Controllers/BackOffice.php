<?php

namespace App\Http\Controllers;

use PDO;
use App\Models\Program;
use Carbon\CarbonPeriod;
use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BackOffice extends Controller
{
    public function index()
    {
        $appointments = Appointments::all();
        $programs = Program::all();
        return view('backOffice', ['appointments' => $appointments, 'programs' => $programs]);
    }

    public function deleteProgram($id){
        $program = Program::find($id);
        $appointment = Appointments::where('program_id', $id)->first();
        if($appointment){
            $appointment->delete();
        }
        $program->delete();
        return redirect()->back();
    }
    
}
