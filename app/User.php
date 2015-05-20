<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['firstname', 'lastname', 'unumber', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * Many to many relation user_role table.
	 *
	 * @return relation
	 */
	public function roles()
	{
		return $this->belongsToMany('App\Role')->withPivot('current');
	}

	/**
	 * Many to many relation area_user table.
	 *
	 * @return relation
	 */
	public function areas()
	{
		return $this->belongsToMany('App\Area');
	}

	/**
	 * Many to many relation unit_user table.
	 *
	 * @return relation
	 */
	public function units()
	{
		return $this->belongsToMany('App\Unit');
	}

	/**
	 * Active condition
	 *
	 * @return query
	 */
	public function scopeActive($query, $active)
	{
		return $query->where('active', '=', $active);
	}

}
