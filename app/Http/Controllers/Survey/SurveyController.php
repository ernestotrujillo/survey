<?php namespace App\Http\Controllers\Survey;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Survey;
use App\User;
use App\Unit;
use App\Area;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination;

class SurveyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

        $data = Unit::where('active', '=', 1)->get(array('id','name'));
        foreach ($data as $key => $value)
        {
            $units[$value->id] = $value->name;
        }
        return view('survey.add',array("units"=>$units));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Surveys answered.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function answerSurvey($unit = null, $area = null)
	{
		//general query
		$query = DB::table('survey_user')
			->select('survey_user.id as survey_user_id', 'survey.id as survey_id', 'users.firstname', 'users.lastname', 'users.unumber', 'users.role_id', 'roles.name as role_name', 'unit.name as unit_name', 'area.name as area_name', 'survey.name as survey_name', 'survey_user.created_at', 'survey_user.updated_at')
			->join('users', 'users.id', '=', 'survey_user.user_id')
			->join('roles', 'roles.id', '=', 'users.role_id')
			->join('survey', 'survey.id', '=', 'survey_user.survey_id')
			->join('area_user', 'area_user.user_id', '=', 'users.id')
			->join('area', 'area.id', '=', 'area_user.area_id')
			->join('unit', 'unit.id', '=', 'area.unit_id')
			->where('roles.id', '=', 1)
			->orderBy('survey_user.created_at', 'desc');
			//->paginate(30);

		if($unit != null)
		{
			if($unit > 0){
				if($area != null && $area > 0){
					$users = $query->where('area.id', '=', $area)->paginate(30);
				}else{
					$users = $query->where('unit.id', '=', $unit)->paginate(30);
				}
			}else{
				$users = $query->paginate(30);
			}
		}else{
			$users = $query->paginate(30);
		}
		//get all current active units
		$units = null;
		$data = Unit::where('active', '=', 1)->get(array('id','name'));
		foreach ($data as $key => $value)
		{
			// Create the options array
			$units[$value->id] = $value->name;
		}

		$areas = null;
		if($area != null && $unit != null && $unit != 'all'){
			//get all current active areas
			$data = Area::where('active', '=', 1)->where('unit_id', '=', $unit)->get(array('id','name'));
			foreach ($data as $key => $value)
			{
				// Create the options array
				$areas[$value->id] = $value->name;
			}
		}

		return view('survey.report', compact('users', 'units', 'areas', 'unit', 'area'));
	}
}
