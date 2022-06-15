<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    use HasFactory;

    protected $fillable = [
        'pair_name',
        'pair_info_id',
        'teacher_id',
        'auditorium_id',
        'discipline_id',
        'day_of_week_id',
        'repeating_id',
        'group_id'
    ];

    public function pairInfo()
    {
        return $this->belongsTo(PairInfo::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function auditorium()
    {
        return $this->belongsTo(Auditorium::class);
    }

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function dayOfWeek()
    {
        return $this->belongsTo(DayOfWeek::class);
    }

    public function repeating()
    {
        return $this->belongsTo(PairRepeating::class, 'repeating_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
