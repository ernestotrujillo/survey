<?php namespace App\Http\Controllers\Survey;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateSurveyRequest;
use App\Survey;
use App\Question;
use App\Option;
Use App\SurveyImage;
use App\User;
use App\Unit;
use App\Area;
Use Input;
Use File;
Use Validator;
Use Session;
Use Redirect;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination;
//use PhpSpec\Console\Prompter\Question;

class SurveyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($unit = null)
	{

        if ($unit){
            $surveys = Survey::where('unit_id','=',$unit)->paginate(100);
        }else {
            $surveys = Survey::paginate(100);
        }

        //get all current active units
        $data = Unit::where('active', '=', 1)->get(array('id','name'));
        foreach ($data as $key => $value)
        {
            $units[$value->id] = $value->name;
        }

        return view('survey.list', compact('surveys', 'units'));
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

        $units = $request->input('unit_id');
        $surveys = array();
        foreach($units as $unit)
        {
            $survey = new Survey;
            $survey->name = $request->input('name');
            $survey->unit_id = $unit;
            $surveys[] = $survey;
        }

        $files = $request->file('file');
        if($files) {
            $file_count = count($files);
            $uploadcount = 0;
            foreach ($files as $file) {
                if (File::exists($file)) {
                    $rules = array('file' => 'required|mimes:png,gif,jpeg'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                    $validator = Validator::make(array('file' => $file), $rules);
                    if ($validator->passes()) {
                        //$extension = $file->getClientOriginalExtension();

                        $destinationPath = 'uploads';
                        $filename = $file->getFilename().$file->getClientOriginalName();
                        $upload_success = $file->move($destinationPath, $filename);
                        $uploadcount++;
                    }
                }elseif ($file == null){
                    $uploadcount++;
                }

            }

            if ($uploadcount != $file_count) {
                return Redirect::back()->with('message', array('type' => 'error', 'message' => 'Error subiendo archivos'));
            } else {
                foreach($surveys as $survey)
                {
                    $survey->save();
                    foreach ($files as $file)
                    {
                        if ($file) {
                            $surveyImg = new SurveyImage();
                            //$surveyImg->original_filename = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension();
                            $surveyImg->name = $file->getClientOriginalName();
                            $surveyImg->image = $file->getFilename() . $file->getClientOriginalName();
                            $surveyImg->survey_id = $survey->id;
                            $surveyImg->save();
                        }
                    }
                }
            }
        }else{
            foreach($surveys as $survey)
            {
                $survey->save();
            }
        }

        foreach($surveys as $survey) {
            $questions = json_decode($request->input('qInput'));

            foreach ($questions as $question) {
                $qObject = new Question;
                $qObject->name = $question->name;
                $qObject->type = $question->type;
                $qObject->survey_id = $survey->id;
                $qObject->save();

                if ($question->options) {
                    foreach ($question->options as $option) {
                        $oObject = new Option;
                        $oObject->name = $option;
                        $oObject->question_id = $qObject->id;
                        $oObject->save();
                    }
                }
            }
        }

        $data = Unit::where('active', '=', 1)->get(array('id','name'));
        foreach ($data as $key => $value)
        {
            $units[$value->id] = $value->name;
        }

        return redirect('/survey')
            ->with('message', array( 'type' => 'success', 'message' => 'Encuesta creada con éxito'))
            ->with('units', $units);

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
        $survey = Survey::find($id);

        $surveyImgsData = SurveyImage::where('active', '=', 1)->where('survey_id', '=', $id)->get(array('id','name','image','survey_id'));
        foreach ($surveyImgsData as $key => $value)
        {
            $surveyImgs[$value->id] = $value;
        }


        if($survey == null){
            return redirect('/survey')
                ->with('message', array( 'type' => 'error', 'message' => 'Encuesta no existe'));
        }else{
            $data = Unit::where('active', '=', 1)->get(array('id','name'));
            foreach ($data as $key => $value)
            {
                $units[$value->id] = $value->name;
            }

            $data = Question::where('active', '=', 1)->where('survey_id', '=', $id)->get(array('id','name','type','survey_id'));
            foreach ($data as $key => $question)
            {
                $options = [];
                $data = Option::where('active', '=', 1)->where('question_id', '=', $question->id)->get(array('id','name','question_id'));
                foreach ($data as $key => $value)
                {
                    $options[$value->id] = $value->name;
                }
                if (isset($options)){
                    $question['options']=$options;
                }else{
                    $question['options']='';
                }
                $questions[]= $question;

                //$questions[$value->id] = $value;
            }
            return view('survey.update', compact('units','questions','survey','surveyImgs'));
        }

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, CreateSurveyRequest $request)
	{
        $survey = Survey::findOrFail($id);
        $survey->name = $request->input('name');
        $survey->unit_id = $request->input('unit_id');
        $survey->save();

        $questions =  json_decode($request->input('qInput'));
        $questId =  json_decode($request->input('qIdInput'));
        $imgsId =  json_decode($request->input('imgsInput'));

        $desactivateOld = DB::table('question')->where('survey_id', '=', $id)->whereNotIn('id', $questId)->update(array("active"=>0));
        $removeOldImgs = DB::table('survey_image')->where('survey_id', '=', $id)->whereNotIn('id', $imgsId)->update(array("active"=>0));

        //Images section
        $files = $request->file('file');
        if($files) {
            $file_count = count($files);
            $uploadcount = 0;
            foreach ($files as $file) {
                if (File::exists($file)) {
                    $rules = array('file' => 'required|mimes:png,gif,jpeg'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                    $validator = Validator::make(array('file' => $file), $rules);
                    if ($validator->passes()) {
                        //$extension = $file->getClientOriginalExtension();

                        $destinationPath = 'uploads';
                        $filename = $file->getFilename().$file->getClientOriginalName();
                        $upload_success = $file->move($destinationPath, $filename);
                        $uploadcount++;
                    }
                }elseif ($file == null){
                    $uploadcount++;
                }

            }

            if ($uploadcount != $file_count) {
                return Redirect::back()->with('message', array('type' => 'error', 'message' => 'Error subiendo archivos'));
            } else {
                $survey->save();
                foreach ($files as $file) {

                    if ($file) {
                        $surveyImg = new SurveyImage();
                        //$surveyImg->original_filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $surveyImg->name = $file->getClientOriginalName();
                        $surveyImg->image = $file->getFilename() . $file->getClientOriginalName();
                        $surveyImg->survey_id = $survey->id;
                        $surveyImg->save();
                    }
                }

            }
        }

        // Questions section
        foreach ($questions as $question){
            $qObject = new Question;
            $qObject->name = $question->name;
            $qObject->type = $question->type;
            $qObject->survey_id = $id;
            $qObject->save();

            if ($question->options){
                foreach ($question->options as $option){
                    $oObject = new Option;
                    $oObject->name = $option;
                    $oObject->question_id = $qObject->id;
                    $oObject->save();
                }
            }
        }

        $data = Unit::where('active', '=', 1)->get(array('id','name'));
        foreach ($data as $key => $value)
        {
            $units[$value->id] = $value->name;
        }
        //return view('survey.list',array("units"=>$units,'message', array( 'type' => 'success', 'message' => 'Encuesta modificada con éxito')));


        return redirect('/survey')
            ->with('message', array( 'type' => 'success', 'message' => 'Encuesta modificada con éxito'))
            ->with('units', $units);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $survey = Survey::find($id);
        $affectedRows = $survey->delete();

        return response()->json(array('deleted' => $affectedRows));
	}

    /**
     * Deactivate survey.
     *
     * @param  int  $id
     * @return Response
     */
    public function deactivate($id)
    {
        $survey = Survey::find($id);
        $survey->active = 0;
        $survey->save();

        return response()->json(array('survey' => $survey));
    }
    /**
     * Activate survey.
     *
     * @param  int  $id
     * @return Response
     */
    public function activate($id)
    {
        $survey = Survey::find($id);
        $survey->active = 1;
        $survey->save();

        return response()->json(array('survey' => $survey));
    }

    public function galleryPage(){
        return view('survey.gallery');
    }

    public function gallery($id){
        $surveyImgsData = SurveyImage::where('active', '=', 1)->where('survey_id', '=', $id)->get(array('id','name','image','survey_id'));
        foreach ($surveyImgsData as $key => $value)
        {
            $surveyImgs[$value->id] = $value;
        }
        return response()->json(array('images' => $surveyImgs));
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
			->select('survey_user.id as survey_user_id', 'survey.id as survey_id', 'users.id as user_id', 'users.firstname', 'users.lastname', 'users.unumber', 'users.role_id', 'roles.name as role_name', 'unit.id as unit_id', 'unit.name as unit_name', 'area.id as area_id', 'area.name as area_name', 'survey.name as survey_name', 'survey_user.created_at', 'survey_user.updated_at', 'survey_user.status as status', 'survey_user.cicle as cicle')
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
					$users = $query->where('area.id', '=', $area)->paginate(100);
				}else{
					$users = $query->where('unit.id', '=', $unit)->paginate(100);
				}
			}else{
				$users = $query->paginate(100);
			}
		}else{
			$users = $query->paginate(100);
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

		return view('survey.report', compact('users', 'units', 'areas', 'unit', 'area', 'manager', 'director'));
	}

	public function roleFilter($unit = null, $area = null)
	{
		//check role of the user to set default unit or area
		$user = Auth::user();

		if($user->role_id == 3)
		{
			$unit_query = DB::table('unit_user')
				->select(DB::raw('unit_user.unit_id as id'))
				->where('unit_user.user_id', '=', $user->id)
				->where('unit_user.active', '=', 1)
				->first();

			$unit = $unit_query->id;
		}
		else if($user->role_id == 2)
		{
			$area_query = DB::table('area_user')
				->select(DB::raw('area_user.area_id as area_id, area.unit_id as unit_id'))
				->join('area', 'area.id', '=', 'area_user.area_id')
				->where('area_user.user_id', '=', $user->id)
				->where('area_user.active', '=', 1)
				->first();

			$unit = $area_query->unit_id;
			$area = $area_query->area_id;
		}

		return $this->answerSurvey($unit, $area);
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function surveyList()
    {
        //check role of the user to set default unit or area
        $user = Auth::user();

        $area_query = DB::table('area_user')
            ->select(DB::raw('area_user.area_id as area_id, area.unit_id as unit_id'))
            ->join('area', 'area.id', '=', 'area_user.area_id')
            ->where('area_user.user_id', '=', $user->id)
            ->where('area_user.active', '=', 1)
            ->first();

        $unit = $area_query->unit_id;
        $area = $area_query->area_id;

        $surveys = DB::table('survey')
            ->select(DB::raw('*'))
            ->where('unit_id', '=', $unit)
            ->where('active', '=', 1)
            ->orderBy('survey.created_at', 'desc')
            ->paginate(100);

        return view('user.survey_list', compact('surveys'));
    }

    public function mySurveyList()
    {
        //check role of the user to set default unit or area
        $user = Auth::user();

        $area_query = DB::table('area_user')
            ->select(DB::raw('area_user.area_id as area_id, area.unit_id as unit_id'))
            ->join('area', 'area.id', '=', 'area_user.area_id')
            ->where('area_user.user_id', '=', $user->id)
            ->where('area_user.active', '=', 1)
            ->first();

        $unit = $area_query->unit_id;
        $area = $area_query->area_id;

        $surveys = DB::table('survey_user')
            ->select(DB::raw('survey_user.id as survey_user_id, survey.id as survey_id, survey.name, survey_user.status, survey_user.created_at, survey_user.cicle as cicle'))
            ->join('survey', 'survey.id', '=', 'survey_user.survey_id')
            ->where('survey_user.user_id', '=', $user->id)
            ->orderBy('survey_user.created_at', 'desc')
            ->paginate(100);

        return view('user.my_survey_list', compact('surveys'));
    }

    public function deleteSurveyUser($id)
    {
        $affectedRows = DB::table('survey_user')->where('id', '=', $id)->delete();

        return response()->json(array('deleted' => $affectedRows));
    }

    /**
     * Show the survey form for answer.
     *
     * @param  int  $id
     * @return Response
     */
    public function getSurvey($id)
    {
        //check role of the user to set default unit or area
        $user = Auth::user();
        $survey = Survey::find($id);

        if($survey == null)
        {
            return redirect('/dashboard/surveys')
                ->with('message', array( 'type' => 'error', 'message' => 'Encuesta no existe'));
        }
        else
        {
            $area_query = DB::table('area_user')
                ->select(DB::raw('area_user.area_id as area_id, area.unit_id as unit_id'))
                ->join('area', 'area.id', '=', 'area_user.area_id')
                ->where('area_user.user_id', '=', $user->id)
                ->where('area_user.active', '=', 1)
                ->first();

            $unit = $area_query->unit_id;

            if($survey->unit_id != $unit)
            {
                return redirect('/dashboard/surveys')
                    ->with('message', array( 'type' => 'error', 'message' => 'No tiene acceso a esa pregunta'));
            }

            $data = Question::where('active', '=', 1)->where('survey_id', '=', $id)->get(array('id','name','type','survey_id'));
            foreach ($data as $key => $question)
            {
                $options = [];
                $data = Option::where('active', '=', 1)->where('question_id', '=', $question->id)->get(array('id','name','question_id'));
                foreach ($data as $key => $value)
                {
                    $options[$value->id] = $value->name;
                }
                if (isset($options)){
                    $question['options']=$options;
                }else{
                    $question['options']='';
                }
                $questions[]= $question;

            }
            return view('survey.answer', compact('survey', 'questions'));
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function postAnswers()
    {
        //check role of the user to set default unit or area
        $user = Auth::user();
        if (Input::has('data'))
        {
            $data = Input::get('data');

            DB::transaction(function() use($data, $user)
            {
                $survey_id = $data['survey_id'];
                $question_count = $data['question_count'];
                $answers = $data['answers'];
                $status = $data['status'];
                $now = date('Y-m-d H:i:s', strtotime("now"));

                $id = DB::table('survey_user')->insertGetId(
                    ['survey_id' => $survey_id, 'user_id' => $user->id, 'status' => $status, 'created_at' => $now, 'updated_at' => $now]
                );

                $cicle = null;
                foreach($answers as $value)
                {
                    $answerdb = null;
                    switch ($value['question_type']) {
                        case '1':
                        case '5':
                            $answerdb = ['value' => $value['value'], 'survey_user' => $id, 'question_id' => $value['question_id'], 'created_at' => $now, 'updated_at' => $now];
                            break;
                        case '2':
                            $select = ($value['value'] != null ? implode("-", $value['value']) : null);
                            $answerdb = ['value' => $select, 'survey_user' => $id, 'question_id' => $value['question_id'], 'created_at' => $now, 'updated_at' => $now];
                            break;
                        case '3':
                        case '4':
                            $answerdb = ['value' => $value['value'], 'survey_user' => $id, 'question_id' => $value['question_id'], 'option_id' => $value['value'], 'created_at' => $now, 'updated_at' => $now];
                            break;
                        case '6':
                            $cicle = $value['value'];
                            break;
                    }
                    if($answerdb != null)
                        DB::table('answer')->insert($answerdb);
                }

                DB::table('survey_user')
                    ->where('id', $id)
                    ->update(['cicle' => $cicle]);

            });

            return response()->json(array('success' => true));
        }

        return redirect('/dashboard/surveys')
            ->with('message', array( 'type' => 'error', 'message' => 'Disculpe! Hay un error en los datos.'));

    }

    /**
     * Show the survey form for answer.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEditAnswers($id)
    {
        //check role of the user to set default unit or area
        $user = Auth::user();

        $survey_user = DB::table('survey_user')
        ->select(DB::raw('*'))
        ->where('user_id', '=', $user->id)
        ->where('id', '=', $id)
        ->first();

        if(!empty($survey_user))
        {
            $survey = Survey::find($survey_user->survey_id);

            if($survey == null)
            {
                return redirect('/dashboard/surveys')
                    ->with('message', array( 'type' => 'error', 'message' => 'La encuesta no existe'));
            }
            else
            {
                $area_query = DB::table('area_user')
                    ->select(DB::raw('area_user.area_id as area_id, area.unit_id as unit_id'))
                    ->join('area', 'area.id', '=', 'area_user.area_id')
                    ->where('area_user.user_id', '=', $user->id)
                    ->where('area_user.active', '=', 1)
                    ->first();

                $unit = $area_query->unit_id;

                if($survey->unit_id != $unit)
                {
                    return redirect('/dashboard/surveys')
                        ->with('message', array( 'type' => 'error', 'message' => 'No tiene acceso a esa pregunta'));
                }

                $data = Question::where('active', '=', 1)->where('survey_id', '=', $survey->id)->get(array('id','name','type','survey_id'));

                foreach ($data as $key => $question)
                {
                    $options = [];
                    $data2 = Option::where('active', '=', 1)->where('question_id', '=', $question->id)->get(array('id','name','question_id'));

                    $answer = DB::table('answer')
                        ->select(DB::raw('id, value, survey_user, question_id, option_id'))
                        ->where('survey_user', '=', $survey_user->id)
                        ->where('question_id', '=', $question->id)
                        ->orderBy('id', 'desc')
                        ->first();

                    $question['answer'] = $answer;

                    foreach ($data2 as $key => $value)
                    {
                        $options[$value->id] = $value->name;
                    }
                    if (isset($options)){
                        $question['options']=$options;
                    }else{
                        $question['options']='';
                    }
                    $questions[]= $question;

                }
                return view('survey.answer_edit', compact('survey', 'questions', 'survey_user'));
            }
        }
        else
        {
            return redirect('/dashboard/mysurveys')
                ->with('message', array( 'type' => 'error', 'message' => 'La encuesta no exíste.'));
        }

    }

    public function postEditAnswers()
    {
        //check role of the user to set default unit or area
        $user = Auth::user();
        if (Input::has('data'))
        {
            $data = Input::get('data');

            DB::transaction(function() use($data, $user)
            {
                $survey_id = $data['survey_id'];
                $answers = $data['answers'];
                $status = $data['status'];
                $now = date('Y-m-d H:i:s', strtotime("now"));

                $survey_user = DB::table('survey_user')
                    ->select(DB::raw('*'))
                    ->where('user_id', '=', $user->id)
                    ->where('id', '=', $data['survey_user_id'])
                    ->first();

                if(empty($survey_user)){
                    return redirect('/dashboard/surveys')
                        ->with('message', array( 'type' => 'error', 'message' => 'Disculpe! Hay un error en los datos.'));
                }

                foreach($answers as $value)
                {
                    $answerdb = null;
                    switch ($value['question_type']) {
                        case '1':
                        case '5':
                            $answerdb = ['value' => $value['value'], 'updated_at' => $now];
                            break;
                        case '2':
                            $select = ($value['value'] != null ? implode("-", $value['value']) : null);
                            $answerdb = ['value' => $select, 'updated_at' => $now];
                            break;
                        case '3':
                        case '4':
                            $answerdb = ['value' => $value['value'], 'option_id' => $value['value'], 'updated_at' => $now];
                            break;
                        case '6':
                            $cicle = $value['value'];
                            break;
                    }
                    if($answerdb != null)
                        DB::table('answer')->where('id', $value['answer_id'])->update($answerdb);

                }

                DB::table('survey_user')
                    ->where('id', $survey_user->id)
                    ->update(['cicle' => $cicle, 'status' => $status]);

            });

            return response()->json(array('success' => true));
        }

        return redirect('/dashboard/mysurveys')
            ->with('message', array( 'type' => 'error', 'message' => 'Disculpe! Hay un error en los datos.'));

    }

    public function getSurveyAjax($id)
    {
        //check role of the user to set default unit or area
        //$user = Auth::user();

        $survey_user = DB::table('survey_user')
            ->select(DB::raw('id, cicle, user_id, survey_id'))
            ->where('id', '=', $id)
            ->first();

        $survey = Survey::find($survey_user->survey_id);

        if($survey == null)
        {
            return redirect('/dashboard/surveys')
                ->with('message', array( 'type' => 'error', 'message' => 'Encuesta no existe'));
        }
        else
        {

            if(!empty($survey_user))
            {
                $area_query = DB::table('area_user')
                    ->select(DB::raw('area_user.area_id as area_id, area.unit_id as unit_id'))
                    ->join('area', 'area.id', '=', 'area_user.area_id')
                    ->where('area_user.user_id', '=', $survey_user->user_id)
                    ->where('area_user.active', '=', 1)
                    ->first();

                $unit = $area_query->unit_id;

                if($survey->unit_id != $unit)
                {
                    return redirect('/dashboard/surveys')
                        ->with('message', array( 'type' => 'error', 'message' => 'No tiene acceso a esa pregunta'));
                }

                $data = Question::where('active', '=', 1)->where('survey_id', '=', $survey->id)->get(array('id','name','type','survey_id'));
                foreach ($data as $key => $question)
                {
                    $options = [];
                    $data2 = Option::where('active', '=', 1)->where('question_id', '=', $question->id)->get(array('id','name','question_id'));

                    $answer = DB::table('answer')
                        ->select(DB::raw('id, value, survey_user, question_id, option_id'))
                        ->where('survey_user', '=', $survey_user->id)
                        ->where('question_id', '=', $question->id)
                        ->orderBy('id', 'desc')
                        ->first();

                    $question['answer'] = $answer;

                    foreach ($data2 as $key => $value)
                    {
                        $options[$value->id] = $value->name;
                    }
                    if (isset($options)){
                        $question['options']=$options;
                    }else{
                        $question['options']='';
                    }
                    $questions[]= $question;

                }

                return response()->json(array('success' => true, 'survey' => $survey, 'questions' => $questions, 'survey_user' => $survey_user));
            }
            else
            {
                return response()->json(array('success' => false));
            }
        }

    }

}
