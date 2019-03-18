<?php namespace App\Http\Controllers;

use App\Models\Bus;
use \Illuminate\Http\Request;
use App\Repositories\BusRepository;
use App\Http\Requests\BusRequest;

class BusController extends Controller {

    /**
     * The BusRepository instance.
     *
     * @var App\Repositories\BusRepository
     */
    protected $bus;

    /**
     * Create a new BusController instance.
     *
     * @param  App\Repositories\BusRepository $bus
     * @return void
     */
    public function __construct(BusRepository $bus)
    {
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
        return view('front.bus.bus');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('front.bus.bus');
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param  App\Models\Bus
     * @return Response
     */
    public function edit(Bus $bus)
    {
        return view('front.bus.edit', compact('bus'));
    }

    /**
     * Store a newly created resource in storage
     *
     * @param  App\requests\BusRequest $request
     * @return Response
     */
    public function store(BusRequest $request)
    {

        $this->bus->store($request->all());

        return redirect('bus')->with('ok', trans('front/bus.stored'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param  App\requests\BusRequest $request
     * @param  App\Models\Bus
     * @return Response
     */
    public function update(
        BusRequest $request,
        Bus $bus)
    {
        $this->bus->update($request->all(), $bus);

        return redirect('bus')->with('ok', trans('front/bus.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\user $user
     * @return Response
     */
    public function delete($id)
    {
        $this->bus->getById($id)->delete();

        return redirect('bus')->with('ok', trans('front/bus.deleted'));
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

        $busses = Bus::take($perPage);

        $recordsTotal = $busses->count();

        if (!empty($request->input('search')['value'])) {
            $search = $request->input('search')['value'];
            $busses->where('route_no', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }

        $recordsFiltered = $busses->count();

        if ($skip > 0) {
            $busses->skip($skip);
        }

        $busses = $busses->orderBy('route_no')->get();

        $i = 1;
        $data = [];
        foreach ($busses as $bus) {
            $data[] = [
                $i++,
                $bus->route_no,
                $bus->description,
                $bus->getStatus(),
                '<a href="/bus/' . $bus->id . '/edit/">Edit</a> | <a onclick="return confirm(\'Are you sure you want to delete this item?\');" href="/bus/' . $bus->id . '/delete/">Delete</a>'
            ];
        }

        return response(json_encode(compact('draw', 'recordsTotal', 'recordsFiltered', 'data')), 200, ['Content-Type' => 'application/json']);
    }
}
