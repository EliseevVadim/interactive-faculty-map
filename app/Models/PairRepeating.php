<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PairRepeating extends Model
{
    use HasFactory;

    protected $fillable = [
        'repeating_name'
    ];

    public function pairs()
    {
        return $this->hasMany(Pair::class, 'repeating_id');
    }
}
