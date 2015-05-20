<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'area';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Many to many relation user_role table.
     *
     * @return relation
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('current');
    }

    /**
     * one to many relation unit.
     *
     * @return relation
     */
    public function units()
    {
        return $this->belongsTo('App\Unit');
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

    /**
     * Active condition
     *
     * @return query
     */
    public function scopeUnit($query, $unit)
    {
        return $query->where('unit_id', '=', $unit);
    }

}
