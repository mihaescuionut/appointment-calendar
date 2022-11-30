<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable=['date', 'from', 'to'];
    protected $table="program";

    protected $appends = [
        'available'
    ];

    public function programari(){
        return $this->hasMany(Appointments::class, 'program_id');
    }

    public function getAvailableAttribute(){
        $period = CarbonPeriod::create($this->date . ' ' . $this->from, '90 minutes', $this->date . ' ' . $this->to)->toArray();
        $programari = $this->programari()->pluck('appointment_hour')->toArray();
        $available = [];
        foreach($period as $time){
            if(!in_array($time->format('H:i:s'), $programari)){
               $available[] = $time->format('H:i:s');
            }
        }
        return $available;
    }
}
