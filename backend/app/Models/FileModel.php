<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileModel extends Model
{
    use HasFactory;
    protected $table = 'files';
    protected $fillable = [
    'location', 'caption', 'position', 'news_id','status'
    ];
}
