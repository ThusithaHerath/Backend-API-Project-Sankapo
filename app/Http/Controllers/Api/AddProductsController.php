<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddProducts;
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
            'condition' => 'required'
        ]);
        if($validated){
                $data = new AddProducts;
                $data->title = $request->input('title');
                $data->category = $request->input('category');
                $data->description = $request->input('description');
                $data->condition = $request->input('condition');
                $data->buy = $request->input('buy');   
                $data->owner =Auth::user()->id; 

                $imageArray = [];
                foreach ($request->images as $imagefile) {
                    $randomString = Str::random(5);
                    $insertId = $randomString .''. $request->input('title') ;
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
        $isApprove = DB::table('add_products')->where('id',$id)->update(['isApprove'=>'1']);
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


    public function show()
    {
        $products = AddProducts::where('isApprove','1')->get()->all();
        if($products){
            return response()->json([
                'data' => $products,
            ], 200);
        }else{
            return response()->json([
                'message' => "Can't find approved adds",
            ], 500);
        }
       
    }

    public function approveAd(Request $request, $id)
    {
        if (AddProducts::where('id', $id)->exists()) {
            $ad  = AddProducts::find($id);

            $ad->isApprove = '1';

            $ad->update();

            return response()->json([
                'data' => $ad,
                'message' => 'property approved successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }

    public function search($id)
    {
        if (AddProducts::where('id', $id)->exists()) {
            return response()->json([
                'data' => AddProducts::find($id),
                'message' => 'Ad fetched successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }



    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        if (AddProducts::where('id', $id)->exists()) {
            $ad = AddProducts::find($id);
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
