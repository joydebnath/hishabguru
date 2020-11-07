<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSeriesStatistic extends Model
{
    use HasFactory;
    protected $table = 'time_series_statistics';

    protected $guarded = ['id'];

    protected $casts = [
      'date' => 'date:Y-m-d'
    ];
}
