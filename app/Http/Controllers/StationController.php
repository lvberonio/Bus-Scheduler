<?php namespace App\Http\Controllers;

use App\Models\Station;
use \Illuminate\Http\Request;
use App\Repositories\StationRepository;
use App\Http\Requests\StationRequest;

class StationController extends Controller {

    /**
     * The StationRepository instance.
     *
     * @var App\Repositories\StationRepository
     */
    protected $station;

    /**
     * Create a new StationController instance.
     *
     * @param  App\Repositories\StationRepository $station
     * @return void
     */
    public function __construct(StationRepository $station)
    {
        $this->station = $station;

        $this->middleware('admin', ['except' => ['getNearestStations']]);
        $this->middleware('ajax', ['only' => 'getData']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('front.station.station');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('front.station.station');
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param  App\Models\Station
     * @return Response
     */
    public function edit(Station $station)
    {
        return view('front.station.edit', compact('station'));
    }

    /**
     * Store a newly created resource in storage
     *
     * @param  App\requests\StationRequest $request
     * @return Response
     */
    public function store(StationRequest $request)
    {

        $this->station->store($request->all());

        return redirect('station')->with('ok', trans('front/station.stored'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param  App\requests\StationRequest $request
     * @param  App\Models\Station
     * @return Response
     */
    public function update(
        StationRequest $request,
        Station $station)
    {
        $this->station->update($request->all(), $station);

        return redirect('station')->with('ok', trans('front/station.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\user $user
     * @return Response
     */
    public function delete($id)
    {
        $this->station->getById($id)->delete();

        return redirect('station')->with('ok', trans('front/station.deleted'));
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

        $stations = Station::take($perPage);

        $recordsTotal = $stations->count();

        if (!empty($request->input('search')['value'])) {
            $search = $request->input('search')['value'];
            $stations->where('name', 'like', "%$search%")
                ->orWhere('location', 'like', "%$search%");
        }

        $recordsFiltered = $stations->count();

        if ($skip > 0) {
            $stations->skip($skip);
        }

        $stations = $stations->orderBy('name')->get();

        $i = 1;
        $data = [];
        foreach ($stations as $station) {
            $data[] = [
                $i++,
                $station->name,
                $station->location,
                $station->latitude,
                $station->longitude,
                $station->getStatus(),
                '<a href="/station/' . $station->id . '/edit/">Edit</a> | <a onclick="return confirm(\'Are you sure you want to delete this item?\');" href="/station/' . $station->id . '/delete/">Delete</a>'
            ];
        }

        return response(json_encode(compact('draw', 'recordsTotal', 'recordsFiltered', 'data')), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function getNearestStations()
    {
        // gets user current location
        $latitude = auth()->user()->latitude;
        $longitude = auth()->user()->longitude;

        // gets nearby (less than 20 kms) stations based from https://stackoverflow.com/questions/11112926/how-to-find-nearest-location-using-latitude-and-longitude-from-sql-database
        $stations = Station::select('*')
            ->selectRaw('6371*(acos(cos(radians(' . $latitude . '))*cos(radians(latitude))*cos(radians(longitude)-radians(' . $longitude . '))+sin(radians(' . $latitude . '))*sin(radians(latitude)))) AS distance')
            ->having('distance', '<', 20)
            ->orderBy('distance')
            ->limit(5)
            ->get();

        return view('front.station.show', compact('stations'));
    }
}
