<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryObjectType extends Model
{
    use HasFactory;

    protected $fillable = [
        'object_type_name',
        'type_path'
    ];

    public function secondaryObjects()
    {
        return $this->hasMany(SecondaryObject::class);
    }

}
