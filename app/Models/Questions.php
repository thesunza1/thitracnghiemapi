<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Relies;
use App\Models\Levels;
use App\Models\Themes;
use App\Models\Staffs;

class Questions extends Model
{
    use HasFactory;
    // const CREATED_AT = NULL;
    const UPDATED_AT = NULL;

    protected $fillable = ['content','level_id','theme_id','staffcreated_id','created_at'];

    public function relies(){
        return $this->hasMany(Relies::class , 'question_id');
    }


    public function level() {
        return $this->belongsTo(Levels::class,'level_id','id');

     }
    public function theme() {
        return $this->belongsTo(Themes::class);

    }
    public function staff() {
        return $this->belongsTo(Staffs::class,'staffcreated_id','id');
    }

}
