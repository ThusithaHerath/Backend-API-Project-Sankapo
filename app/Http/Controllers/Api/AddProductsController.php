<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ads;
use File;
use Image;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AddProductsController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'condition' => 'required',
            'description' => 'required',
            'buy' => 'required',
            'owner' => 'required',
            'mobile' => 'required',
            'landline' => 'required',
            'email' => 'required'
        ]);
        if($validated){
                $data = new ads;
                $data->title = $request->input('title');
                $data->category = $request->input('category');
                $data->description = $request->input('description');
                $data->condition = $request->input('condition');
                $data->buy = $request->input('buy');   
                $data->mobile = $request->input('mobile');  
                $data->landline = $request->input('landline');  
                $data->email = $request->input('email');  
                $data->province = $request->input('province'); 
                $data->city = $request->input('city'); 
                $data->town = $request->input('town'); 
                $data->sellerName = $request->input('sellerName'); 
                $data->owner =$request->input('owner'); 

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

        }else{
            return response()->json([
                'message' => 'Error while posting add!',
            ], 500);
        }
    }

    public function approve($id){
        $isApprove = DB::table('ads')->where('id',$id)->update(['isApprove'=>'1']);
        if($isApprove){
            return response()->json([
                'message' => 'Your add has been approved',
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Error while approving add!',
            ], 500);
        }
    }


    public function showAll()
    {
        //status = 0 newly added ads

        //status = 1 approved ads
        //status = 2 declined ads
        $ads = ads::get()->all();
        if($ads){
            return response()->json([
                'data' => $ads,
            ], 200);
        }else{
            return response()->json([
                'message' => "Can't find ads",
            ], 500);
        }
       
    }

    public function approved()
    {
        //status = 0 newly added ads
        //status = 1 approved ads
        //status = 2 declined ads
        $ads = ads::where('isApprove','1')->get()->all();
        if($ads){
            return response()->json([
                'data' => $ads,
            ], 200);
        }else{
            return response()->json([
                'message' => "Can't find approved adds",
            ], 500);
        }
       
    }

    public function declined()
    {
        //status = 0 newly added ads
        //status = 1 approved ads
        //status = 2 declined ads
        $ads = ads::where('isApprove','2')->get()->all();
        if($ads){
            return response()->json([
                'data' => $ads,
            ], 200);
        }else{
            return response()->json([
                'message' => "Can't find declined adds",
            ], 500);
        }
       
    }

    public function approveAd(Request $request, $id)
    {
        if (ads::where('id', $id)->exists()) {
            $ad  = ads::find($id);
            $ad->isApprove = '1';
            $ad->update();

            return response()->json([
                'data' => $ad,
                'message' => 'Ad has been approved successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }

    public function declineAd(Request $request, $id)
    {
        if (ads::where('id', $id)->exists()) {
            $ad  = ads::find($id);

            $ad->isApprove = '2';

            $ad->update();

            return response()->json([
                'data' => $ad,
                'message' => 'Ad has been declined successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }

    public function search($id)
    {
        if (ads::where('id', $id)->exists()) {
            return response()->json([
                'data' => ads::find($id),
                'message' => 'Ad fetched successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }

    public function latestAds(){
        $latestAds = DB::table('ads')->orderBy('created_at', 'desc')->first();
        return response()->json([
            'data' => $latestAds,
            'message' => 'Latest ads fetched successfully!',
        ], 200);
    }

    public function searchbycategory($id){
        // $results = DB::table('ads')->where('category',$id)->get();
        return response()->json([
            'data' => $results,
            'message' => 'Search by category ads fetched successfully!',
        ], 200);
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        if (ads::where('id', $id)->exists()) {
            $ad = ads::find($id);
            $ad->delete();
            return response()->json([
                'message' => 'Ad removed successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }

    
}
