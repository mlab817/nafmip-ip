<?php

namespace App\Http\Controllers;

use App\Models\CommodityType;
use App\Models\Investment;
use App\Models\InvestmentType;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $investments = Investment::paginate();

        return view('investments.index', compact('investments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('investments.create')
            ->with([
                'commodityTypes' => CommodityType::with('commodities')->get(),
                'investmentTypes' => InvestmentType::with('interventions')->get(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'commodity_id',
            'title',
            'intervention_id',
            'description',
            'quantity',
            'cost',
            'proponent',
            'beneficiaries',
            'justification',
        ]);

        $location = json_decode($request->location_map);
        $locationMap = new Point($location->lat, $location->lng);

        Investment::create($data+['location_map' => $locationMap]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
