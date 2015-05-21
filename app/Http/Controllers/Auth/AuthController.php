<?php namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use App\Unit;
use App\Area;
use Validator;
use Input;

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
    public function getRegister($id = null)
    {
        $roles = array();
        $units = array();

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

        return view('auth.register', compact('roles', 'units'));
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

        $role = $request->input('role');
        if($role == 1 || $role == 2)
        {
            $v = $this->registrar->areaValidator($request->all());

            if ($v->fails())
            {
                $this->throwValidationException(
                    $request, $v
                );
            }
        }
        elseif($role == 3)
        {
            $v = $this->registrar->unitValidator($request->all());

            if ($v->fails())
            {
                $this->throwValidationException(
                    $request, $v
                );
            }
        }

        if($this->registrar->create($request->all()))
        {
            return redirect('/user')
                ->with('message', array( 'type' => 'success', 'message' => 'Cuenta creada con éxito'));
        }
        else
        {
            return redirect('/user/create')
                ->with('message', array( 'type' => 'error', 'message' => 'Ocurrió un error al crear la cuenta'));
        }
    }

    /**
     * Show the application registration form for edit user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccount($id = null)
    {
        $user = User::find($id);

        if($user == null){
            return redirect('/user')
                ->with('message', array( 'type' => 'error', 'message' => 'Usuario no existe'));
        }else{
            return view('auth.update', compact('user'));
        }
    }

    /**
     * Edit the application registration form for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function postAccount(Request $request)
    {
        $v = Validator::make($request->all(), [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'unumber' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($v->fails())
        {
            $this->throwValidationException(
                $request, $v
            );
        }else{
            $user = User::find(Input::get('id'));
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->unumber = Input::get('unumber');
            $user->email = Input::get('email');
            $user->password = bcrypt(Input::get('password'));
            $user->save();

            return redirect('/user')
                ->with('message', array( 'type' => 'success', 'message' => 'Cuenta actualizada.'));
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
