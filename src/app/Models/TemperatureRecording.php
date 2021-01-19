<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemperatureRecording extends Model
{
    protected $table = 'history';
    protected $fillable = ['temp', 'date_at'];

    protected $casts = [
        'date_at' => 'date',
        'temp' => 'float'
    ];

    public $timestamps = false;
}
