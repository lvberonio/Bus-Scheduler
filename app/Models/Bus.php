<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'buses';

    public $timestamps = false;

    /**
     * One to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }

    /**
     * Gets status by id.
     *
     * @return string
     */
    public function getStatus()
    {
        if ($this->status == 1)
            return 'Active';
        elseif ($this->status == 2)
            return 'Inactive';
        else
            return 'undefined';
    }
}