<?php

namespace App\Models;
use App\Models\Staffs;
use App\Models\Branchs;
use App\Models\Exams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Contests extends Model
{
    use HasFactory;

    const UPDATED_AT = NULL;
    // const CREATED_AT = NULL;
    protected $dates = ['created_at','begintime_at','date_limit'];
    // protected $fillable = [
    //     'name',
    //     'testmaker_id',
    //     'branchcontest_id',
    //     'begintime_at' ,
    //     'created_at' ,
    //     'content'
    // ];
    protected $gaurded = [];
    protected $casts = [
        'begintime_at' => 'timestamp',
        'date_limit' => 'timestamp',
        'last_create' => 'timestamp',
    ];

    public function staff() {
        return $this->belongsTo(Staffs::class,'testmaker_id');
    }
    public function branch() {
        return $this->belongsTo(Branchs::class,'branchcontest_id');
    }

    public function exams()
    {
        return $this->hasMany(Exams::class);
    }

    public function contest_specials(){
        return $this->hasMany(Contest_specials::class, 'contest_id');
    }

    public function testmaker() {
        return $this->belongsTo(Staffs::class, 'testmaker_id');
    }

    public function contest_themes() {
        return $this->hasMany(ContestTheme::class, 'contest_id' );
    }


}
