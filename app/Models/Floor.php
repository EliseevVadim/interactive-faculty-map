<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bounds'
    ];

    public function auditoriums()
    {
        return $this->hasMany(Auditorium::class);
    }

    public function secondaryObjects()
    {
        return $this->hasMany(SecondaryObject::class);
    }
}
