<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaptainTupadExcelForm extends Model
{
     use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
     protected $fillable = [
        'tupad_code_id',
        'given_by_captainID',
        'tupad_slot_id',
        'excel_path',
        'images_path',
        'status',
    ];
}
