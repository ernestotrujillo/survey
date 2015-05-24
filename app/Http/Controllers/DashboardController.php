<?php namespace App\Http\Controllers;

use App\Survey;
use App\User;
use App\Unit;
use App\Area;

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


        return view('dashboard.admin', compact('stadistics'));
    }

}