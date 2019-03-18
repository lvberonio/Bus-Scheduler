<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Station extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'stations';

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

    /**
     * Gets next available schedules by station_id
     *
     * @param @id = station_id
     *
     * @return array
     */
    public function getNextAvailableSchedules() {
        $today = Carbon::now('Asia/Singapore');

        $schedules = Schedule::where('station_id', '=', $this->id)
            ->join('buses', function($join) {
                $join->on('buses.id', '=', 'schedules.bus_id');
            })->where('day', '=', $today->dayOfWeek)
            ->whereRaw('CAST("' . $today->toTimeString() . '" AS time) <= departure_time')
            ->where('schedules.status', '=', '1')
            ->where('buses.status', '=', '1')
            ->orderBy('departure_time')
            ->get(['schedules.*', 'buses.route_no', 'buses.description'])
            ->toArray();

        return $schedules;
    }
}