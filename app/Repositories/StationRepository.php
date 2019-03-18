<?php

namespace App\Repositories;

use App\Models\Station;

class StationRepository extends BaseRepository
{

    /**
     * Create a new CommentRepository instance.
     *
     * @param  App\Models\Station $station
     * @return void
     */
    public function __construct(Station $station)
    {
        $this->model = $station;
    }

    /**
     * Get all stations
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->model->orderBy('name')->get();
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
     * Store a station
     *
     * @param  array $inputs
     * @return void
     */
    public function store($inputs)
    {
        $station = new $this->model;

        $station->name      = $inputs['name'];
        $station->location  = $inputs['location'];
        $station->latitude  = $inputs['latitude'];
        $station->longitude = $inputs['longitude'];
        $station->status    = $inputs['status'];

        $station->save();
    }

    /**
     * Update a station
     *
     * @param  App\Models\Station $station
     * @param  array  $inputs
     *
     * @return App\Models\Station
     */
    public function update($inputs, $station)
    {
        $station->name      = $inputs['name'];
        $station->location  = $inputs['location'];
        $station->latitude  = $inputs['latitude'];
        $station->longitude = $inputs['longitude'];
        $station->status    = $inputs['status'];

        $station->save();

        return $station;
    }

    /**
     * Get station collection
     *
     * @param  App\Models\Station
     * @return Array
     */
    public function getAllSelect()
    {
        return $this->all()->pluck('name', 'id');
    }
}
