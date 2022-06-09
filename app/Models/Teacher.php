<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'fio',
        'photo_path',
        'science_rank_id',
        'email',
        'birth_date'
    ];

    public function scienceRank()
    {
        return $this->belongsTo(ScienceRank::class);
    }

    public function pairs()
    {
        return $this->hasMany(Pair::class);
    }

    public function teachersDisciplines()
    {
        return $this->hasMany(TeacherDiscipline::class);
    }
}
