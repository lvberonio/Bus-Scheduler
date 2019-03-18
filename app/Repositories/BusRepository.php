<?php

namespace App\Repositories;

use App\Models\Bus;

class BusRepository extends BaseRepository
{

    /**
     * Create a new CommentRepository instance.
     *
     * @param  App\Models\Bus $bus
     * @return void
     */
    public function __construct(Bus $bus)
    {
        $this->model = $bus;
    }

    /**
     * Get all buses
     *
     * @return Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->model->orderBy('route_no')->get();
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
     * Store a bus
     *
     * @param  array $inputs
     * @return void
     */
    public function store($inputs)
    {
        $bus = new $this->model;

        $bus->route_no      = $inputs['route_no'];
        $bus->description   = $inputs['description'];
        $bus->status        = $inputs['status'];


        $bus->save();
    }

    /**
     * Update a bus
     *
     * @param  App\Models\Bus $bus
     * @param  array  $inputs
     *
     * @return App\Models\Bus
     */
    public function update($inputs, $bus)
    {
        $bus->route_no      = $inputs['route_no'];
        $bus->description   = $inputs['description'];
        $bus->status        = $inputs['status'];

        $bus->save();

        return $bus;
    }

    /**
     * Get station collection
     *
     * @param  App\Models\Station
     * @return Array
     */
    public function getAllSelect()
    {
        return $this->all()->pluck('route_no', 'id');
    }
}
