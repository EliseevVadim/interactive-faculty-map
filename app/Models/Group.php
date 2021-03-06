<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function pairs()
    {
        return $this->hasMany(Pair::class);
    }
}
