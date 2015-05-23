<?php namespace App\Http\Controllers\Survey;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateSurveyRequest;
use App\Survey;
use App\Unit;
use Illuminate\Http\Request;

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
    public function store(CreateSurveyRequest $request)
	{

        $survey = new Survey;
        $survey->name = $request->input('name');
        $survey->unit_id = $request->input('unit');
        $survey->save();

        /*foreach ($request->input('questions') as $question){

        }*/

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
	public function answerSurvey()
	{
		$surveys = Survey::with('users')->paginate(20);

		return view('survey.report', compact('surveys'));
	}
}
