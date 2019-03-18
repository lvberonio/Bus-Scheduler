<?php namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Repositories\StationRepository;
use App\Repositories\BusRepository;
use \Illuminate\Http\Request;
use App\Repositories\ScheduleRepository;
use App\Http\Requests\ScheduleRequest;

class ScheduleController extends Controller {

    /**
     * The ScheduleRepository instance.
     *
     * @var App\Repositories\ScheduleRepository
     */
    protected $schedule;

    /**
     * The StationRepository instance.
     *
     * @var App\Repositories\StationRepository
     */
    protected $station;

    /**
     * The BusRepository instance.
     *
     * @var App\Repositories\BusRepository
     */
    protected $bus;

    /**
     * Create a new ScheduleController instance.
     *
     * @param  App\Repositories\ScheduleRepository $schedule
     * @param  App\Repositories\StationRepository $station
     * @param  App\Repositories\BusRepository $bus
     * @return void
     */
    public function __construct(ScheduleRepository $schedule, StationRepository $station, BusRepository $bus)
    {
        $this->schedule = $schedule;
        $this->station = $station;
        $this->bus = $bus;

        $this->middleware('admin');
        $this->middleware('ajax', ['only' => 'getData']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $stations = $this->station->getAllSelect();
        $bus = $this->bus->getAllSelect();
        return view('front.schedule.schedule', compact('stations', 'bus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('front.schedule.schedule');

    }

    /**
     * Show the form for editing the specified resource
     *
     * @param  App\Models\Schedule
     * @return Response
     */
    public function edit(Schedule $schedule)
    {
        $stations = $this->station->getAllSelect();
        $bus = $this->bus->getAllSelect();
        return view('front.schedule.edit', compact('schedule', 'stations', 'bus'));
    }

    /**
     * Store a newly created resource in storage
     *
     * @param  App\requests\ScheduleRequest $request
     * @return Response
     */
    public function store(ScheduleRequest $request)
    {

        $this->schedule->store($request->all());

        return redirect('schedule')->with('ok', trans('front/schedule.stored'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param  App\requests\ScheduleRequest $request
     * @param  App\Models\Schedule
     * @return Response
     */
    public function update(
        ScheduleRequest $request,
        Schedule $schedule)
    {
        $this->schedule->update($request->all(), $schedule);

        return redirect('schedule')->with('ok', trans('front/schedule.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\user $user
     * @return Response
     */
    public function delete($id)
    {
        $this->schedule->getById($id)->delete();

        return redirect('schedule')->with('ok', trans('front/schedule.deleted'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $request
     * @return Response
     */
    public function getData(Request $request)
    {
        $draw = $request->input('draw');
        $perPage = $request->input('length') ?: 25;
        $skip = $request->input('start');

        $schedules = Schedule::join('buses', 'buses.id', '=', 'schedules.bus_id')
            ->join('stations', 'stations.id', '=', 'schedules.station_id')
            ->take($perPage);

        $recordsTotal = $schedules->count();

        if (!empty($request->input('search')['value'])) {
            $search = $request->input('search')['value'];
            $schedules->where('buses.route_no', 'like', "%$search%")
                ->orWhere('buses.description', 'like', "%$search%")
                ->orWhere('stations.name', 'like', "%$search%")
                ->orWhere('stations.location', 'like', "%$search%");
        }

        $recordsFiltered = $schedules->count();

        if ($skip > 0) {
            $schedules->skip($skip);
        }

        $schedules = $schedules->orderBy('name')->get(['schedules.*', 'buses.route_no AS bus_route', 'stations.name AS station_name']);

        $i = 1;
        $data = [];
        foreach ($schedules as $schedule) {
            $data[] = [
                $i++,
                $schedule->bus_route,
                $schedule->station_name,
                $schedule->getDay(),
                $schedule->arrival_time,
                $schedule->departure_time,
                $schedule->getStatus(),
                '<a href="/schedule/' . $schedule->id . '/edit/">Edit</a> | <a onclick="return confirm(\'Are you sure you want to delete this item?\');" href="/schedule/' . $schedule->id . '/delete/">Delete</a>'
            ];
        }

        return response(json_encode(compact('draw', 'recordsTotal', 'recordsFiltered', 'data')), 200, ['Content-Type' => 'application/json']);
    }
}
