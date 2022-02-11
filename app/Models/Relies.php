<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Questions;

class Relies extends Model
{
    use HasFactory;
    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;


    protected $fillable = ['noidung','answer'];

    public function question() {
        return $this->belongsTo(Questions::class, 'question_id' , 'id');
    }
}
