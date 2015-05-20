<?php namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Unit;
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
		//$users = User::paginate(20);
		$users = User::with('roles')->paginate(20);

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

		return view('user.list', compact('users', 'roles', 'units'));
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
	public function filter($id)
	{
		//$users = Role::find($id)->users()->where('users.active', '=', 1)->paginate(20);

		$users = Role::find($id)->users()->paginate(20);

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

		return view('user.list', compact('users', 'roles', 'units'));

	}

}
