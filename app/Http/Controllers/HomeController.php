<?php namespace App\Http\Controllers;

use Session;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
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
		if (Session::has('user'))
		{
			$user_session = session('user');
			if($user_session['role'] == 4)
			{
				return redirect('/admin');
			}
			else if($user_session['role'] == 3)
			{
				return redirect('/director');
			}
			else if($user_session['role'] == 2)
			{
				return redirect('/manager');
			}
			else if($user_session['role'] == 1)
			{
				return redirect('/dashboard');
			}
			else
			{
				return redirect()->guest('login');
			}
		}
		else
		{
			return redirect()->guest('login');
		}

		//return view('home');
	}

}
