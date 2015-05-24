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
        $stadistics = DB::table('survey_user')
            ->select(DB::raw('count(*) as count, unit.id, unit.name'))
            ->join('users', 'users.id', '=', 'survey_user.user_id')
            ->join('area_user', 'area_user.user_id', '=', 'users.id')
            ->join('area', 'area.id', '=', 'area_user.area_id')
            ->join('unit', 'unit.id', '=', 'area.unit_id')
            ->where('users.role_id', '=', 1)
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
            ->first();


        $unit = $unit_query->id;

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

}