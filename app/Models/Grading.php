<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grading extends Model
{
    protected $table = 'grading';
    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'Grade',
        'From',
        'To',
        'Comment',
        'Level',
        'Weight',
        'Type',
    ];

    protected $casts = [
        'From' => 'float',
        'To' => 'float',
        'Weight' => 'float',
    ];
}
