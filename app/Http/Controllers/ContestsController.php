<?php

namespace App\Http\Controllers;

use App\Models\Contests;

use Illuminate\Http\Request;

use App\Models\Branchs;
use App\Models\Staffs;
use App\Models\Themes;
use App\Models\Levels;
use App\Models\Exams;
use App\Models\Contest_specials;
use App\Models\ContestTheme;
use App\Models\ExamThemes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ContestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function home(Request $request)
    {
        // $contests = Contests::where('branchcontest_id', $request->user()->branch_id )->get();
        $special_contests = Contest_specials::where('staff_id', $request->user()->id)->get();
        return view('home')->with('contests', $special_contests);
    }


    public function index()
    {
        $contests = Contests::all();
        return view('contests/home')->with('contests', $contests);
    }

    public function add()
    {
        $branchs = Branchs::all();
        $themes = Themes::all();
        $levels = Levels::all();
        return view('contests/add')->with('branchs', $branchs)
            ->with('themes', $themes)->with('levels', $levels);
    }

    public function getValues(Request $request)
    {
        $data = $request->all();
        return $data;
    }

    public function create(Request $request)
    {
        DB::transaction(function () use ($request) {
            // dd($request->all());
            $data = $this->getValues($request);

            $contest = new Contests();
            $contest->name = $data['contest'];
            // $time = str_replace("T"," ", $data['begin_time']);
            // $time = date_create($time.":00");
            // $contest->begintime_at = $time;
            $contest->begintime_at = $request->begin_time;
            $contest->content = $request->content;
            $contest->testmaker_id = $request->user()->id;
            $contest->special_staff = 1;
            $contest->date_limit = $request->date_limit;

            //automake exam
            $automake = $request->auto_make;
            if ($automake == 'on') {
                $contest->auto_make_exam = 1;
                $contest->relymix = $request->relymix == 'on' ? 1 : 0;
                $contest->questionmix = $request->questionmix == 'on' ? 1 : 0;
                $contest->num_date_create = $request->num_date_create;
                $contest->create_num = $request->create_num;
                $contest->time_create = $request->time_create;
                $contest->examtime_at = $request->examtime_at;
                $contest->examcan = $request->examcan;
            }

            $contest->save();
            //create contestthemes for $contest;
            if ($automake == 'on') {
                $themes = $request->exam_theme;
                $levels = $request->exam_level;
                $questionnums = $request->questionnum;
                foreach ($themes as $key => $theme) {
                    $contest_theme = new ContestTheme();
                    $contest_theme->theme_id = $theme;
                    $contest_theme->level_id = $levels[$key];
                    $contest_theme->questionnum = $questionnums[$key];
                    $contest->contest_themes()->save($contest_theme);
                }
            }
            // dd($data['staff_name']);
            //create contest_specials ;
            foreach ($request->staff_name as $staff) {
                $participant = new Contest_specials();
                if ($staff != null) {
                    $participant->staff_id = $staff;
                    $contest->contest_specials()->save($participant);
                }
            }

            if ($automake == 'on') {

                $bindings = [
                    'v_contest_id' => $contest->id,
                ];
                $insert_exam = 'thuctap.p_i_exam';
                $init = DB::executeProcedure($insert_exam, $bindings);
            }
        });
        return Redirect('/contests');
    }

    public function edit($id)
    {
        $contest = Contests::find($id);
        $staffs = Staffs::all();
        $branchs = Branchs::all();
        return view('contests/edit')->with('staffs', $staffs)->with('branchs', $branchs)->with('contest', $contest);
    }

    public function update($id, Request $request)
    {
        // $length = count($request->staff_name) - 1;
        $special_contests = Contest_specials::where('contest_id', $id)->get();
        foreach ($special_contests as $contest) {
            $contest->delete();
        }
        foreach ($request->staff_name as $staff) {
            $participant = new Contest_specials();
            if ($staff != null) {
                $participant->contest_id = $id;
                $participant->staff_id = $staff;
                $participant->save();
            }
        }
        // dd($length . '-' . $special_contests->count());

        $data = $this->getValues($request);
        $contest = Contests::find($id);
        $contest->name = $data['contest'];
        $time = str_replace("T", " ", $data['begintime_at']);
        $time = date_create($time . ":00");
        $contest->begintime_at = $time;
        $contest->content = $data['content'];
        $contest->testmaker_id = $data['test_maker_id'];
        $contest->save();
        return Redirect()->back();
        // dd($contest);
    }

    public function detail($id)
    {
        $contest = Contests::find($id);
        $staffs = Staffs::all();
        $branchs = Branchs::all();
        $themes = Themes::all();
        $levels = Levels::all();
        $exams = Exams::where('contest_id', '=', $id)->get();
        return view('contests/detail')
            ->with('contest', $contest)->with('staffs', $staffs)
            ->with('branchs', $branchs)->with('themes', $themes)
            ->with('levels', $levels)->with('exams', $exams);
    }

    public function delete($id)
    {
        $contest = Contests::find($id);
        $contest->delete();
        return redirect()->back();
        // dd($contest);

    }
    //------------------------------------------
    //api
    public function ApiGetContests(Request $request)
    {
        $staffId = $request->user()->id;
        $special_contests = Contest_specials::where('staff_id', $staffId)->orderByDesc('created_at')->with('contest.testmaker')->paginate(3);

        return response()->json([
            'statuscode' => 1,
            'specialcontests' => $special_contests,
        ]);
    }
}
