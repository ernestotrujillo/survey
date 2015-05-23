<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'survey';

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

    /**
     * Many to many relation survey_user table.
     *
     * @return relation
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

}
