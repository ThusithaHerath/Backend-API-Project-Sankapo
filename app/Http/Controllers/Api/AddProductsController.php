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

class AddProductsController extends Controller
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
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                $data->owner = Auth::id();    

                $lastId = AddProducts::orderBy('id', 'DESC')->pluck('id');
                $insertId = json_decode($lastId)[0] + 1;
    
                $imageArray = [];
                foreach ($request->images as $imagefile) {
                    $imagename = $insertId . '_' . uniqid() . '.' . $imagefile->getClientOriginalExtension();
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
