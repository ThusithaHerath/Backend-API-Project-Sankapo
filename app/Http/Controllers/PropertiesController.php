<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'tittle' => 'required',
            'images' => 'required',
            'condition' => 'required',
            'buy' => 'required',
            'city' => 'required',
            'province' => 'required',
            'town' => 'required',
            'residential_type' => 'required',
            'living_area_square_meters' => 'required',
            'bed_space' => 'required',
            'running_water' => 'required',
            'electricity' => 'required',
            'restroom' => 'required',
            'room_arrangement' => 'required',

        ]);
        if ($validated) {
            $data = new Property;
            $data->tittle = $request->input('tittle');
            $data->condition = $request->input('condition');
            $data->buy = $request->input('buy');
            $data->province = $request->input('province');
            $data->city = $request->input('city');
            $data->town = $request->input('town');
            $data->residential_type = $request->input('residential_type');
            $data->living_area_square_meters = $request->input('living_area_square_meters');
            $data->bed_space = $request->input('bed_space');
            $data->running_water = $request->input('running_water');
            $data->electricity = $request->input('electricity');
            $data->restroom = $request->input('restroom');
            $data->room_arrangement = $request->input('room_arrangement');
            // $data->isApprove = $request->input('isApprove');


            $image = $request->images;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->images->move('uploads/images', $imagename);
            $data->images = $imagename;
            $data->save();

            // foreach ($request->file('images') as $imagefile) {
            //     $image = new Image;
            //     $imagename=time().'.'.$imagefile->getClientOriginalExtension();
            //     $imagefile->move('uploads/images',$imagename);
            //     $data->image=$imagename;
            //     $image->save();
            // }

            return response()->json([
                'message' => 'Congratulations!, your add is up and running',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error while posting Ad!',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $properties = Property::where('isApprove', '1')->get()->all();
        if ($properties) {
            return response()->json([
                'data' => $properties,
            ], 200);
        } else {
            return response()->json([
                'message' => "Can't find approved Ads",
            ], 500);
        }
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