<?php namespace App\Services;

use DB;
use App\User;
use App\Role;
use App\Unit;
use App\Area;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'firstname' => 'required|max:255',
			'lastname' => 'required|max:255',
			'unumber' => array('required', 'regex:/^[u][0-9]{6}$/', 'unique:users'),
			/*'email' => 'required|email|max:255|unique:users',*/
			'password' => 'required|confirmed|min:6',
            'role' => 'required|exists:roles,id',
		]);
	}

	public function unitValidator(array $data)
	{
		return Validator::make($data, [
			'unit' => 'required|exists:unit,id',
		]);
	}

	public function areaValidator(array $data)
	{
		return Validator::make($data, [
			'area' => 'required|exists:area,id',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{

		DB::beginTransaction(); //Start transaction!

		try{
			$user = new User([
				'firstname' => $data['firstname'],
				'lastname'  => $data['lastname'],
				'unumber'   => $data['unumber'],
				'email' 	=> $data['email'],
				'role_id' 	=> $data['role'],
				'password' 	=> bcrypt($data['password']),
			]);

			$user->save();

			switch ($user->role_id) {
				case '1':
				case '2':
					Area::find($data['area'])->users()->save($user);
					break;
				case '3':
					Unit::find($data['unit'])->users()->save($user);
					break;
				/*case '4':
					Unit::find($data['unit'])->users()->save($user);
					break;*/
			}

		}
		catch(\Exception $e)
		{
			//failed logic here
			DB::rollback();
			throw $e;
		}

		DB::commit();

		return $user;

	}

}
