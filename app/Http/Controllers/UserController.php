<?php namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Unit;
use App\Area;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//$users = User::has('role')->paginate(20);
		$users = DB::table('users')
			->join('roles', 'roles.id', '=', 'users.role_id')
			->leftJoin('unit_user', 'unit_user.user_id', '=', 'users.id')
			->leftJoin('area_user', 'area_user.user_id', '=', 'users.id')
			->leftJoin('area', 'area.id', '=', 'area_user.area_id')
			->select(DB::raw('users.id as id, users.firstname, users.lastname, users.unumber, users.role_id as role_id, roles.name as role_name, users.active, unit_user.unit_id as unit_id, area.name as area_name, area.id as area_id, area.unit_id as area_unit_id'))
			->orderBy('users.created_at', 'desc')
			->paginate(20);

		$managers = DB::table('users')
			->join('area_user', 'area_user.user_id', '=', 'users.id')
			->join('area', 'area.id', '=', 'area_user.area_id')
			->select(DB::raw('users.firstname, users.lastname, area.id'))
			->where('users.role_id', '=', 2)
			->get();

		$manager = array();
		foreach ($managers as $value)
		{
			// Create the options array
			$manager[$value->id] = $value->firstname.' '.$value->lastname;
		}

		$directors = DB::table('users')
			->join('unit_user', 'unit_user.user_id', '=', 'users.id')
			->join('unit', 'unit.id', '=', 'unit_user.unit_id')
			->select(DB::raw('users.firstname, users.lastname, unit.id'))
			->where('users.role_id', '=', 3)
			->get();
		$director = array();
		foreach ($directors as $value)
		{
			// Create the options array
			$director[$value->id] = $value->firstname.' '.$value->lastname;
		}

		$admins = DB::table('users')
			->join('unit_user', 'unit_user.user_id', '=', 'users.id')
			->join('unit', 'unit.id', '=', 'unit_user.unit_id')
			->select(DB::raw('users.firstname, users.lastname, unit.id'))
			->where('users.role_id', '=', 4)
			->get();
		$admin = array();
		foreach ($admins as $value)
		{
			// Create the options array
			$admin[$value->id] = $value->firstname.' '.$value->lastname;
		}

		$data = Role::where('active', '=', 1)->get(array('id','name'));
		foreach ($data as $key => $value)
		{
			// Create the options array
			$roles[$value->id] = $value->name;
		}

		//get all current active units
		$units = array();
		$data = Unit::where('active', '=', 1)->get(array('id','name'));
		foreach ($data as $key => $value)
		{
			// Create the options array
			$units[$value->id] = $value->name;
		}

		return view('user.list', compact('users', 'roles', 'units', 'manager', 'director', 'admin'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
		$user = User::find($id);
		$affectedRows = $user->delete();

		return response()->json(array('deleted' => $affectedRows));
	}

	/**
	 * Ban an user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function ban($id)
	{
		$user = User::find($id);
		$user->active = 0;
		$user->save();

		return response()->json(array('user' => $user));
	}

	/**
	 * Active an user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function active($id)
	{
		$user = User::find($id);
		$user->active = 1;
		$user->save();

		return response()->json(array('user' => $user));
	}

	/**
	 * Filter users.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function filter($role, $unit = null, $area = null)
	{
		if($role == 4 || $role == 'all' || $unit == null)
		{
			if($role == 'all'){
				$users = User::with('role')->paginate(20);
			}else{
				$users = Role::find($role)->users()->paginate(20);
			}
		}
		else
		{
			//general query
			$query = DB::table('users')
				->join('roles', 'users.role_id', '=', 'roles.id')
				->select('users.id', 'users.firstname', 'users.lastname', 'users.unumber', 'users.email', 'users.active', 'users.role_id', 'roles.name as role_name')
				->where('users.role_id', '=', $role);

			//si es director
			if($role == 3){
				if($unit == 'all'){
					$users = $query->join('unit_user', 'users.id', '=', 'unit_user.user_id')
								   ->paginate(20);
				}else{
					$users = $query->join('unit_user', 'users.id', '=', 'unit_user.user_id')
								   ->where('unit_user.unit_id', '=', $unit)
								   ->paginate(20);
				}
			}else if($role == 1 || $role ==2){
				if(($area == 'all') || ($area == null && $unit != 'all')){
					$users = $query->join('area_user', 'users.id', '=', 'area_user.user_id')
									->join('area', 'area.id', '=', 'area_user.area_id')
									->where('area.unit_id', '=', $unit)
									->paginate(20);
				}else if($unit == 'all'){
					$users = $query->join('area_user', 'users.id', '=', 'area_user.user_id')
									->join('area', 'area.id', '=', 'area_user.area_id')
									->paginate(20);
				}else{
					$users = $query->join('area_user', 'users.id', '=', 'area_user.user_id')
								   ->where('area_user.area_id', '=', $area)->paginate(20);
				}
			}else{
				$users = $query->paginate(20);
			}
		}

		//get all current active roles
		$data = Role::where('active', '=', 1)->get(array('id','name'));
		foreach ($data as $key => $value)
		{
			// Create the options array
			$roles[$value->id] = $value->name;
		}

		//get all current active units
		$data = Unit::where('active', '=', 1)->get(array('id','name'));
		foreach ($data as $key => $value)
		{
			// Create the options array
			$units[$value->id] = $value->name;
		}

		if($area != null && $unit != null && $unit != 'all'){
			//get all current active areas
			$data = Area::where('active', '=', 1)->where('unit_id', '=', $unit)->get(array('id','name'));
			foreach ($data as $key => $value)
			{
				// Create the options array
				$areas[$value->id] = $value->name;
			}
		}else{
			$areas = null;
		}

		return view('user.list', compact('users', 'roles', 'units', 'areas', 'role', 'unit', 'area'));

	}

}
