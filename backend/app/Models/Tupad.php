<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\SoftDeletes;
class Tupad extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    public function code()
    {
        return $this->belongsTo(TupadCode::class, 'used_code_id');
    }
}
