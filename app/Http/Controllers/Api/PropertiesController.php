<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertiesController extends Controller
{
    public function create(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'tittle' => 'required',
            'images' => 'required',
            'buy' => 'required',
            'city' => 'required',
            'province' => 'required',
            'town' => 'required',
            'residential_type' => 'required',
            'living_area_square_meters' => 'required',
            'running_water' => 'required',
            'electricity' => 'required',
            'restroom' => 'required',
            'room_arrangement' => 'required',
            'number_of_rooms' => 'required',
            'additional_info' => 'required',
            'security' => 'required',
            'mobile' => 'required',
            'landline' => 'required',
            'email' => 'required'
        ]);

        if ($validated) {
            $data = new Property;
            $data->tittle = $request->input('tittle');
            $data->buy = $request->input('buy');
            $data->province = $request->input('province');
            $data->city = $request->input('city');
            $data->town = $request->input('town');
            $data->residential_type = $request->input('residential_type');
            $data->living_area_square_meters = $request->input('living_area_square_meters');
            $data->number_of_rooms = $request->input('number_of_rooms');
            $data->additional_info = $request->input('additional_info');
            $data->security = $request->input('security');
            $data->isRentOrSale = $request->input('isRentOrSale');
            $data->running_water = $request->input('running_water');
            $data->electricity = $request->input('electricity');
            $data->restroom = $request->input('restroom');
            $data->room_arrangement = $request->input('room_arrangement');
            $data->owner =$request->input('owner');
            $data->mobile = $request->input('mobile');  
            $data->landline = $request->input('landline');  
            $data->email = $request->input('email');  
           
 

            $images = $request->file('images');
            $imageArray = [];
            foreach ($images as $imagefile) {
                $randomString = Str::random(5);
                $insertId = $randomString .''. $request->input('title');
                $imagename = $insertId . '.' . $imagefile->getClientOriginalExtension();
                $imagefile->move('uploads/images', $imagename);
                array_push($imageArray, $imagename);
            }

            $data->images = json_encode($imageArray);
            $data->save();

            return response()->json([
                'message' => 'Congratulations!, your add is up and running',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error while posting Ad!',
            ], 500);
        }
    }

    public function showAll()
    {
        $properties = Property::where('isApprove', '1')->get()->all();
        if ($properties) {
            return response()->json([
                'data' => $properties,
            ], 200);
        } else {
            return response()->json([
                'message' => "Can't find properties",
            ], 500);
        }
    }

    public function approved()
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

    public function declined()
    {
        $properties = Property::where('isApprove', '2')->get()->all();
        if ($properties) {
            return response()->json([
                'data' => $properties,
            ], 200);
        } else {
            return response()->json([
                'message' => "Can't find declined Ads",
            ], 500);
        }
    }

    public function approve(Request $request, $id)
    {
        // dd($request);
        if (Property::where('id', $id)->exists()) {
            $property  = Property::find($id);


            $property->isApprove = '1';

            $property->update();

            return response()->json([
                'data' => $property,
                'message' => 'property approved successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }

    public function decline(Request $request, $id)
    {
        // dd($request);
        if (Property::where('id', $id)->exists()) {
            $property  = Property::find($id);


            $property->isApprove = '2';

            $property->update();

            return response()->json([
                'data' => $property,
                'message' => 'property declined successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }


    public function search($id)
    {
        if (Property::where('id', $id)->exists()) {
            return response()->json([
                'data' => Property::find($id),
                'message' => 'Property Ad fetched successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }


    public function latestProperties(){
        $latestProperties = DB::table('properties')->orderBy('created_at', 'desc')->first();
        return response()->json([
            'data' => $latestProperties,
            'message' => 'Latest ads properties successfully!',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        if (Property::where('id', $id)->exists()) {
            $property  = Property::find($id);

            $data->tittle = $request->input('tittle');
            $data->buy = $request->input('buy');
            $data->province = $request->input('province');
            $data->city = $request->input('city');
            $data->town = $request->input('town');
            $data->residential_type = $request->input('residential_type');
            $data->living_area_square_meters = $request->input('living_area_square_meters');
            $data->number_of_rooms = $request->input('number_of_rooms');
            $data->additional_info = $request->input('additional_info');
            $data->security = $request->input('security');
            $data->isRentOrSale = $request->input('isRentOrSale');
            $data->running_water = $request->input('running_water');
            $data->electricity = $request->input('electricity');
            $data->restroom = $request->input('restroom');
            $data->room_arrangement = $request->input('room_arrangement');
            $data->owner =$request->input('owner'); 
            $data->mobile = $request->input('mobile');  
            $data->landline = $request->input('landline');  
            $data->email = $request->input('email'); 

            $imageArray = [];

            foreach ($request->images as $imagefile) {
                $newImageName = $property->id . '_' . uniqid() . '.' . $imagefile->getClientOriginalExtension();

                if (file_exists(public_path('uploads/images/' . $imagefile->getClientOriginalName()))) {
                    unlink(public_path('uploads/images/' . $imagefile->getClientOriginalName()));
                    $imagefile->move('uploads/images', $newImageName);
                    array_push($imageArray, $newImageName);
                } else {
                    $imagefile->move('uploads/images', $newImageName);
                    array_push($imageArray, $newImageName);
                }
            }

            $property->images = json_encode($imageArray);
            $property->update();

            return response()->json([
                'data' => $property,
                'message' => 'property updated successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }

  

    public function destroy($id)
    {
        if (Property::where('id', $id)->exists()) {
            $category = Property::find($id);
            $category->delete();
            return response()->json([
                'message' => 'Property removed successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }
}