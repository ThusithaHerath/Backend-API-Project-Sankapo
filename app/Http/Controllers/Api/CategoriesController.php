<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
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
        if (Categories::where('category','=', $request->input('category'))->exists()) {
			return response()->json([
				'message' => 'Sorry, Category with the provided name is already exists!',
			], 403);
		}else{
            $category = new Categories();
            $category->category = $request->input('category');
            $category->save();

            return response()->json([
                'message' => 'New category has been addedd successfully!',
                'data' => $category
            ], 200);
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
        $categories = Categories::all();
        if($categories->isEmpty()){
            return response()->json([
                'message' => 'Sorry!, Category table is empty',
            ], 500);
        }else{
            $data = Categories::all();
            return response()->json([
                'data'=> $data,
                'message' => 'Categories fetched successfully',
            ], 200);        
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
        if (Categories::where('id',$id)->exists()) {
            return response()->json([
                'data'=> Categories::find($id),
                'message' => 'Category fetched successfully!',
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
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
        if (Categories::where('id',$id)->exists()) {
            $category  = Categories::find($id);
    
            $category->category = $request->input('category');
        
            $category->update();
            
            return response()->json([
                'data'=> $category,
                'message' => 'Category updated successfully!',
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Categories::where('id',$id)->exists()) {
            $category=Categories::find($id);
            $category->delete();
            return response()->json([
                'message' => 'Category removed successfully!',
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'There is no record for this id',
            ], 500);
        }
    }
}
