<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branchs;
use App\Models\Themes;
use App\Models\Roles;

use App\Models\Levels;
use App\Models\Staffs;
use App\Models\Relies;
use App\Models\Questions;
use Carbon\Carbon;

class adddulieuController extends Controller
{
    //
    public function themlevel () {
        Levels::insert([

            'difficult' => 'easy',
            'coefficient' => 1.0,
        ]);
        Levels::insert([

            'difficult' => 'medium',
            'coefficient' => 1.5,
        ]);
        Levels::insert([

            'difficult' => 'hard',
            'coefficient' => 2.0,
        ]);
    }

    public function thembranch() {
        $branch= Branchs::factory()->count(8)->create();
        dd($branch);
    }

    public function themtheme() {
        $theme= Themes::factory()->count(4)->create();
        dd($theme);
    }
    public function themstaff() {
        $data = [
            'email' => 'quynhtran1@gmail.com',
            'password' => '1',
            'name' => 'manh quynh',
            'sdt' => '1234587',
            'address' => 'vinh long',
            'branch_id' => 2,
            'role' => 0
        ];
        Staffs::insert($data);
    }
    public function themrl() {
        $data = [['name' => 'admin'],
        ['name'=>'staff'],
        ['name' => 'issuer maker']];

        Roles::insert($data);

    }
    public function themqr() {
        $data = [
            //'id' => 1,
            'content' => 'đây là câu hỏi số 2 ',
            'level_id' => 1,
            'theme_id' => 1,
            'staffcreated_id' => 1,
            'created_at' => Carbon::now(),
        ];
        $question = new Questions($data);

        //$question = Questions::insert($data);
        $question->save();

        $question->relies()->createMany([
            [
                'noidung' => 'cau tra loi 1 ',
                'answer' => 1,
            ],
            [
                'noidung' => 'cau tra loi 2',
                'answer' => 0,
            ],             [
                'noidung' => 'cau tra loi 3',
                'answer' => 0,
            ],        ]);

    }

}
