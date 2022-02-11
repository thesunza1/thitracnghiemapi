<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamStaffs extends Model
{
    use HasFactory;
    const UPDATED_AT = NULL;

    protected $casts = [
        'time_limit' => 'timestamp'
    ];
    public function staff()
    {
        return $this->belongsTo(Staffs::class, 'staff_id');
    }
    public function examQueRels() {
        return $this->hasMany(ExamQueRel::class, 'exam_staff_id');
    }
}
