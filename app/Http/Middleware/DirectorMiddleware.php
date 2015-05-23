<?php namespace App\Http\Middleware;

use Closure;
use Session;

class DirectorMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (Session::has('user'))
		{
			$user_session = session('user');
			if($user_session['role'] != 3)
			{
				return redirect('/')
					->with('message', array( 'type' => 'error', 'message' => 'No tiene privilegios para acceder.'));
			}
		}
		else
		{
			return redirect()->guest('login');
		}

		return $next($request);
	}

}
