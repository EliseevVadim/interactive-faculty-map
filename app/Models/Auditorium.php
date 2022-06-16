<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditorium extends Model
{
    use HasFactory;

    protected $table = 'auditoriums';

    protected $fillable = [
        'auditorium_name',
        'position_info',
        'floor_id',
        'holder_id'
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'holder_id');
    }

    public function pairs()
    {
        return $this->hasMany(Pair::class);
    }
}
