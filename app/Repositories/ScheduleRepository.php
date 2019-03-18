<?php

namespace App\Repositories;

use App\Models\Schedule;

class ScheduleRepository extends BaseRepository
{

    /**
     * Create a new CommentRepository instance.
     *
     * @param  App\Models\Schedule $schedule
     * @return void
     */
    public function __construct(Schedule $schedule)
    {
        $this->model = $schedule;
    }

    /**
     * Get comments collection.
     *
     * @param  int  $n
     * @return Illuminate\Support\Collection
     */
    public function index($n)
    {
        return $this->model
            ->paginate($n);
    }

    /**
     * Store a schedule
     *
     * @param  array $inputs
     * @return void
     */
    public function store($inputs)
    {
        $schedule = new $this->model;

        $schedule->station_id = $inputs['station'];
        $schedule->bus_id    = $inputs['bus'];
        $schedule->day       = $inputs['day'];
        $schedule->arrival_time   = $inputs['arrival_time'];
        $schedule->departure_time = $inputs['departure_time'];
        $schedule->status    = $inputs['status'];

        $schedule->save();
    }

    /**
     * Update a schedule
     *
     * @param  App\Models\Schedule $schedule
     * @param  array  $inputs
     *
     * @return App\Models\Schedule
     */
    public function update($inputs, $schedule)
    {
        $schedule->station_id = $inputs['station'];
        $schedule->bus_id    = $inputs['bus'];
        $schedule->day       = $inputs['day'];
        $schedule->arrival_time   = $inputs['arrival_time'];
        $schedule->departure_time = $inputs['departure_time'];
        $schedule->status    = $inputs['status'];

        $schedule->save();

        return $schedule;
    }
}
