<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamStaffChose extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function exam_staff(){
        return $this->belongsTo(ExamStaffs::class, 'exam_staff_id');
    }
    public function question(){
        return $this->belongsTo(Questions::class, 'question_id');
    }
    public function rely(){
        return $this->belongsTo(Relies::class, 'relies_id');
    }
}
