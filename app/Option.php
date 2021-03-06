<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'option';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'active'];

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = ['id'];

}
