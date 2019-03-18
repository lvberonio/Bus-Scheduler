<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'schedules';

    public $timestamps = false;

    /**
     * One to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function station()
    {
        return $this->belongsTo('App\Models\Station');
    }

    /**
     * One to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bus()
    {
        return $this->belongsTo('App\Models\Bus');
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

    /**
     * Gets day by id.
     *
     * @return string
     */
    public function getDay()
    {
        if ($this->day == 0)
            return 'Sunday';
        elseif ($this->day == 1)
            return 'Monday';
        elseif ($this->day == 2)
            return 'Tuesday';
        elseif ($this->day == 3)
            return 'Wednesday';
        elseif ($this->day == 4)
            return 'Thursday';
        elseif ($this->day == 5)
            return 'Friday';
        elseif ($this->day == 6)
            return 'Saturday';
        else
            return 'undefined';
    }
}