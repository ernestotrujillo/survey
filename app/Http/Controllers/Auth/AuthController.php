<?php namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;
	}

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'unumber' => 'required', 'password' => 'required',
        ]);

        $unumber = $request->input('unumber');
        $password = $request->input('password');

        //$credentials = $request->only('email', 'unumber', 'password', 'active');

        if ($this->auth->attempt(['unumber' => $unumber, 'password' => $password, 'active' => 1], $request->has('remember')))
        {
            //set user session
            $user = $this->auth->user();
            $role = $user->roles()->wherePivot('current', 1)->first();
            $user_role = array(
                'id' => $role->id,
                'name' => $role->name
            );
            $user_session = array(
                'user.id' => $user->id,
                'user.firstname' => $user->firstname,
                'user.lastname' => $user->lastname,
                'user.unumber' => $user->unumber,
                'user.email' => $user->email,
                'user.role' => $user_role
            );

            session($user_session);
            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
            ->withInput($request->only('unumber', 'remember'))
            ->withErrors([
                'unumber' => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'Disculpe! sus datos son inválidos.';
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        //if ($this->auth->check())
        //{
            //get all current active roles
            $data = Role::where('active', '=', 1)->get(array('id','name'));
            foreach ($data as $key => $value)
            {
                // Create the options array
                $roles[$value->id] = $value->name;
            }

            return view('auth.register', ['roles' => $roles]);
       /* }
        else
        {
            return redirect($this->loginPath());
        }*/
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->registrar->validator($request->all());

        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
        }

        if($this->registrar->create($request->all()))
        {
            return redirect($this->redirectPath())
                ->with('message', array( 'type' => 'success', 'message' => 'Cuenta creada con éxito'));
        }
        else
        {
            return redirect('/user/create')
                ->with('message', array( 'type' => 'error', 'message' => 'Ocurrió un error al crear la cuenta'));
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->auth->logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/login';
    }

}
