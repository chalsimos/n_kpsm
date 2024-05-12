<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\SoftDeletes;
class TupadCode extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;


    public function slot()
    {
        return $this->belongsTo(TupadSlot::class, 'slot_id');
    }
}
