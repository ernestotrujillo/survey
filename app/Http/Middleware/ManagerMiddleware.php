<?php namespace App\Http\Middleware;

use Closure;
use Session;

class ManagerMiddleware {

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
			if($user_session['role'] != 2)
			{
				return response('Unauthorized.', 401);
			}
		}
		else
		{
			return redirect()->guest('login');
		}

		return $next($request);
	}

}
