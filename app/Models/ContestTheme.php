<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestTheme extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function contest() {
        return $this->belongsTo(Contests::class, 'contest_id');
    }
    public function level() {
        return $this->belongsTo(Levels::class, 'contest_id');
    }
    public function theme() {
        return $this->belongsTo(Themes::class, 'contest_id');
    }
}
