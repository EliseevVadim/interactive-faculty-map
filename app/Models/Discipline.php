<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    protected $fillable = [
        'discipline_name'
    ];

    public function pairs()
    {
        return $this->hasMany(Pair::class);
    }

    public function teachersDisciplines()
    {
        return $this->hasMany(TeacherDiscipline::class);
    }
}
