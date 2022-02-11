<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Branchs extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    public function staffs(){
        return $this->hasMany(Staffs::class, 'branch_id');
    }

}
