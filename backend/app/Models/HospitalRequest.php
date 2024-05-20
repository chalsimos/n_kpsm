<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalRequest extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
