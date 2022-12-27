<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\negotiation;
use Illuminate\Http\Request;

class NegotiationController extends Controller
{
    public function create(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'negotiation_price' => 'required',
            'bid_user' => 'required',
            'auction_id' => 'required',
        ]);

        if ($validated) {
            $data = new negotiation;
            $data->negotiation_price = $request->input('negotiation_price');
            $data->bid_user = '456';
            $data->auction_id = $request->input('auction_id');

            $data->save();

            return response()->json([
                'message' => 'Congratulations!, your negotiation is up and running',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error while posting your negotiation!',
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        if (negotiation::where('id', $id)->exists()) {
            $data  = negotiation::find($id);

            $data->negotiation_price = $request->input('negotiation_price');

            $data->update();

            return response()->json([
                'data' => $data,
                'message' => 'negotiation updated successfully!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'There is no record for this negotiation',
            ], 500);
        }
    }


    public function auctionNegotiations($id)
    {

        $negotiation = negotiation::where('auction_id', $id)->get()->all();
        if ($negotiation) {
            return response()->json([
                'data' => $negotiation,
            ], 200);
        } else {
            return response()->json([
                'message' => "no data found",
            ], 500);
        }
    }



    // public function destroy($id)
    // {
    //     if (negotiation::where('id', $id)->exists()) {
    //         $category = negotiation::find($id);
    //         $category->delete();
    //         return response()->json([
    //             'message' => 'negotiation removed successfully!',
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'message' => 'There is no record for this id',
    //         ], 500);
    //     }
    // }



}