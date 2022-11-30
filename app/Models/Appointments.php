<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;


    protected $fillable=['date', 'appointment_hour', 'program_id', 'user_id'];
    protected $table="appointments";

    public function program(){
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
