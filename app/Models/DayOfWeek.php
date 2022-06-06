<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayOfWeek extends Model
{
    use HasFactory;

    protected $table = 'days_of_week';

    protected $fillable = [
        'days_name'
    ];

    public function pairs()
    {
        return $this->hasMany(Pair::class, 'day_of_week_id');
    }
}
