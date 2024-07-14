<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleViewCounter extends Model
{
    use HasFactory;
    protected $table ='articlecount';
    protected $fillable = ['articleid', 'type'];
}
