<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScienceRank extends Model
{
    use HasFactory;

    protected $fillable = [
        'rank_name'
    ];

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
