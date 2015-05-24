<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyImage extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'survey_image';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','image','survey_id','active'];

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = ['id'];

}
