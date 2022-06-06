<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryObject extends Model
{
    use HasFactory;

    protected $fillable = [
        'object_name',
        'position_info'
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }
}
