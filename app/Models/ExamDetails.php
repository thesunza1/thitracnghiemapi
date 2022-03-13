<?php

namespace App\Models;
// use illuminate\Database as DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamDetails extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function question() {
        return $this->belongsTo(Questions::class, 'question_id');
    }
}
