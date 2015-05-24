<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination;

class DashboardController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Dashboard Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('home');
    }

    public function adminDashboard()
    {
        //estadisticas de encuestas tomadas
        $now = date("Y-m-d H:i:s");
        $month = $this->rangeMonth($now);
        $stadistics = DB::table('survey_user')
            ->select(DB::raw('count(*) as count, unit.id, unit.name'))
            ->join('users', 'users.id', '=', 'survey_user.user_id')
            ->join('area_user', 'area_user.user_id', '=', 'users.id')
            ->join('area', 'area.id', '=', 'area_user.area_id')
            ->join('unit', 'unit.id', '=', 'area.unit_id')
            ->where('users.role_id', '=', 1)
            ->whereBetween('survey_user.created_at', array($month['start'], $month['end']))
            ->groupBy('unit.id')
            ->get();

        //estadisticas de encuestas tomadas
        $last_survey_answer = DB::table('survey_user')
            ->select(DB::raw('survey_user.id as survey_user_id, survey.name as survey_name, unit.name as unit_name, users.firstname, users.lastname, survey_user.created_at'))
            ->join('survey', 'survey.id', '=', 'survey_user.survey_id')
            ->join('unit', 'unit.id', '=', 'survey.unit_id')
            ->join('users', 'users.id', '=', 'survey_user.user_id')
            ->orderBy('survey_user.created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stadistics', 'last_survey_answer'));
    }

    public function directorDashboard()
    {
        $user = Auth::user();

        $unit_query = DB::table('unit_user')
            ->select(DB::raw('unit_user.unit_id as id'))
            ->where('unit_user.user_id', '=', $user->id)
            ->where('unit_user.active', '=', 1)
            ->first();


        $unit = $unit_query->id;

        $now = date("Y-m-d H:i:s");
        $month = $this->rangeMonth($now);

        //estadisticas de encuestas tomadas
        $stadistics = null;
        $stadistics = DB::table('survey_user')
            ->select(DB::raw('count(*) as count, area.id, area.name'))
            ->join('users', 'users.id', '=', 'survey_user.user_id')
            ->join('area_user', 'area_user.user_id', '=', 'users.id')
            ->join('area', 'area.id', '=', 'area_user.area_id')
            ->join('unit', 'unit.id', '=', 'area.unit_id')
            ->where('unit.id', '=', $unit)
            ->where('users.role_id', '=', 1)
            ->whereBetween('survey_user.created_at', array($month['start'], $month['end']))
            ->groupBy('area.id')
            ->get();

        //estadisticas de encuestas tomadas
        $last_survey_answer = null;
        $last_survey_answer = DB::table('survey_user')
            ->select(DB::raw('survey_user.id as survey_user_id, survey.name as survey_name, area.name as area_name, users.firstname, users.lastname, survey_user.created_at'))
            ->join('users', 'users.id', '=', 'survey_user.user_id')
            ->join('survey', 'survey.id', '=', 'survey_user.survey_id')
            ->join('area_user', 'area_user.user_id', '=', 'users.id')
            ->join('area', 'area.id', '=', 'area_user.area_id')
            ->join('unit', 'unit.id', '=', 'survey.unit_id')
            ->where('unit.id', '=', $unit)
            ->orderBy('survey_user.created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.director', compact('stadistics', 'last_survey_answer'));
    }

    public function managerDashboard()
    {
        $user = Auth::user();

        $area_query = DB::table('area_user')
            ->select(DB::raw('area_user.area_id as id'))
            ->where('area_user.user_id', '=', $user->id)
            ->where('area_user.active', '=', 1)
            ->first();

        $area = $area_query->id;

        $now = date("Y-m-d H:i:s");
        $month = $this->rangeMonth($now);

        //estadisticas de encuestas tomadas
        $stadistics = null;
        $stadistics = DB::table('users')
            ->select(DB::raw('users.id as user_id, users.firstname, users.lastname, users.unumber, GROUP_CONCAT(survey_user.id) as surveys, count(1) as count'))
            ->join('area_user', 'area_user.user_id', '=', 'users.id')
            ->join('area', 'area.id', '=', 'area_user.area_id')
            ->leftJoin('survey_user', 'survey_user.user_id', '=', 'users.id')
            ->where('area.id', '=', $area)
            ->where('users.role_id', '=', 1)
            ->whereBetween('survey_user.created_at', array($month['start'], $month['end']))
            ->groupBy('users.id')
            ->get();

        //estadisticas de encuestas tomadas
        $last_survey_answer = null;
        $last_survey_answer = DB::table('survey_user')
            ->select(DB::raw('survey_user.id as survey_user_id, survey.name as survey_name, area.name as area_name, users.firstname, users.lastname, survey_user.created_at'))
            ->join('users', 'users.id', '=', 'survey_user.user_id')
            ->join('survey', 'survey.id', '=', 'survey_user.survey_id')
            ->join('area_user', 'area_user.user_id', '=', 'users.id')
            ->join('area', 'area.id', '=', 'area_user.area_id')
            ->join('unit', 'unit.id', '=', 'survey.unit_id')
            ->where('area.id', '=', $area)
            ->orderBy('survey_user.created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.manager', compact('stadistics', 'last_survey_answer'));
    }

    public function rangeMonth($datestr) {
        $dt = strtotime($datestr);
        $res['start'] = date('Y-m-d H:i:s', strtotime('first day of this month', $dt));
        $res['end'] = date('Y-m-d H:i:s', strtotime('last day of this month', $dt));
        return $res;
    }

    function rangeWeek($datestr) {
        $dt = strtotime($datestr);
        $res['start'] = date('N', $dt)==1 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('last monday', $dt));
        $res['end'] = date('N', $dt)==7 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('next sunday', $dt));
        return $res;
    }

}