<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PairInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'pair_number',
        'start_time',
        'end_time'
    ];

    public function pairs()
    {
        return $this->hasMany(Pair::class, 'pair_info_id');
    }
}
