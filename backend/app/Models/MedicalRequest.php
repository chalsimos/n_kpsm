<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\SoftDeletes;
class MedicalRequest extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'age',
        'birthday',
        'gender',
        'province',
        'municipality',
        'barangay',
        'representativefullname',
        'contactnumber',
        'diagnosis',
        'hospital',
        'request',
        'status',
        'Hor_code',
        'decline_reason'
    ];
}
