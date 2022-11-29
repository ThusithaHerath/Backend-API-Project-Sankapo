<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
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
     * @param  \App\Models\Categories  $categories
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
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
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
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
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
