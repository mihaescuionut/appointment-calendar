<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Carbon\CarbonPeriod;
use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    
        $program = Program::all();
        $appointments = Appointments::all();

        return view('appointment', ['program' => $program, 'appointments' => $appointments]);
    }


    public function getHours(Request $request)
    {
        $shifts = Program::where('date', $request->date)->get();
        if ($shifts->count() > 0) {
            $hours = [];
            $available = [];
           foreach($shifts as $shift){
                if($request->date == Carbon::now()->format('Y-m-d')){
                    foreach($shift->available as $av){
                        if($av > Carbon::now()->format('H:i:s')){
                            $hours[] = $av;
                            $hours = array_merge($available, $hours);
                        }
                    }
                }else if($request->date > Carbon::now()->format('Y-m-d')){
                    $hours = array_merge($hours, $shift->available);
                }
             
                
           }

            return response()->json($hours);
        }
        return response()->json('No available hours');
    }

    public function makeAppointment(Request $request){
        $program = Program::where('date', $request->date)->where('to', '>=', $request->time)->first();
        $appointment = Appointments::create([
            'date' => $request->date,
            'appointment_hour' => Carbon::parse($request->time)->format('H:i:s'),
            'program_id' => $program->id,
            'user_id' => Auth::user()->id
        ]);
        return response(['success' => 'Appointment created successfully']);
    }

    public function deleteAppointment($id)
    {
        $appointment = Appointments::find($id);
        $appointment->delete();
        return redirect()->back();
    }
}
