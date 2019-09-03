<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;

class RestaurantController extends Controller
{
    public function show(Request $request){
        $id = $request->query('id');
        if($id){
            $data = Restaurant::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($data, 200);
        }
        else{
            $data = Restaurant::all();
            if(count($data)>0) {
                return $data;
            }
            else {
                return response()->json([
                    "message" => "Data not found"
                ], 404);
            }
        }
    }

    public function create(Request $request){
        if(strlen($request->name)>128){
            return response()->json([
                "message" => "Restaurant name should be less than 128 characters"
            ], 400);    
        }
        if (is_null($request->name) || is_null($request->address) || is_null($request->logo)) {
            return response()->json([
                "message" => "Data request is incomplete"
            ], 400);
        }
        else {
            $data = new Restaurant;
            $data->name = $request->name;
            $data->address = $request->address;
            $data->logo = $request->logo;
            $data->save();

            return response()->json([
                "message" => "Data has been created"
            ], 201);
        }
    }

    public function update(Request $request, $id){
        if (Restaurant::where('id', $id)->exists()) {
            if(is_null($request->name) || is_null($request->address) || is_null($request->logo)){
                return response()->json([
                    "message" => "Data request is incomplete"
                ], 400);
            }
            else{
                $data = Restaurant::find($id);
                $data->name = $request->name;
                $data->address = $request->address;
                $data->logo = $request->logo;
                $data->save();

                return response()->json([
                    "message" => "Data has been updated"
                ], 200);
            }
        }
        else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    public function delete($id){
        if (Restaurant::where('id', $id)->exists()) {
            $data = Restaurant::find($id);
            $data->delete();
            
            return response()->json([
                "message" => "Data has been deleted"
            ], 202);
        }
        else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }
}
