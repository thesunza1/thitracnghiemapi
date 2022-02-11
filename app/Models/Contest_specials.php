<?php

namespace App\Models;
// use illuminate\Database as DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest_specials extends Model
{
    // public function __construct()
    // {
    //     $this->middleware('auth')   ;
    // }

    use HasFactory;
    protected $fillable = [
        'staff_id',
        'contest_id'
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;
    public function contest(){
        return $this->belongsTo(Contests::class, 'contest_id');
    }
    public function staff() {
        return $this->belongsTo(Staffs::class, 'staff_id');
    }
}
