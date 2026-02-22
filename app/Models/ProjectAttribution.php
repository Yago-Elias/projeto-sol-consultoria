<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAttribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribution'
    ];
    public $timestamps = false;
}
