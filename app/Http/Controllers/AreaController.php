<?php namespace App\Http\Controllers;

use App\Area;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AreaController extends Controller {

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//get all current active areas
		$data = Area::where('active', '=', 1)->get(array('id','name'));
		foreach ($data as $key => $value)
		{
			// Create the options array
			$units[$value->id] = $value->name;
		}
		return response()->json(['name' => 'Abigail', 'state' => 'CA'], 200);
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
		//
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function filterByUnit($id)
	{
		//get all current active areas
		$units = array();
		$data = Area::active(1)->unit($id)->get(array('id','name'));
		foreach ($data as $key => $value)
		{
			// Create the options array
			$units[$value->id] = $value->name;
		}

		return response()->json($units);
	}

}
