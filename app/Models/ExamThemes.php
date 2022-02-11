<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exams;

class ExamThemes extends Model
{
    use HasFactory;
    const UPDATED_AT = NULL;
    const CREATED_AT = NULL;
    protected $fillable = ['exam_id','theme_id','level_id','question'];

    public function exam()
    {
        return $this->belongsTo(Exams::class, 'exam_id');
    }
}
