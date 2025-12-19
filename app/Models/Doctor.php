<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $guarded = [];

    // Dokter milik User
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Dokter punya banyak Janji Temu
    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
}