<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Food;
use App\Restaurant;

class FoodController extends Controller
{
    public function show(Request $request){
        $id = $request->query('id');
        if($id){
            $data = Food::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($data, 200);
        }
        else{
            $data = Food::all();
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

    public function getByRestaurant($id) {
        $find = Food::where('restaurant_id', $id);
        if ($find->exists()) {
            $data = $find->get()->toJson(JSON_PRETTY_PRINT);
            return response($data, 200);
        }
        else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    public function create(Request $request){
        if (is_null($request->restaurant_id) || is_null($request->name) || is_null($request->price) || is_null($request->logo)) {
            return response()->json([
                "message" => "Data request is incomplete"
            ], 400);
        }
        else {
            if(Restaurant::where('id', $request->restaurant_id)->exists()){
                $data = new Food;
                $data->restaurant_id = $request->restaurant_id;
                $data->name = $request->name;
                $data->price = $request->price;
                $data->logo = $request->logo;
                $data->save();
                
                return response()->json([
                    "message" => "Data has been created"
                ], 201);
            }
            else{
                return response()->json([
                    "message" => "ID restaurant not found"
                ], 400);
            }
        }
    }

    public function update(Request $request, $id){
        if (Food::where('id', $id)->exists()) {
            if(is_null($request->restaurant_id) || is_null($request->name) || is_null($request->price) || is_null($request->logo)){
                return response()->json([
                    "message" => "Data request is incomplete"
                ], 400);
            }
            else{
                if(Restaurant::where('id', $request->restaurant_id)->exists()){
                    $data = Food::find($id);
                    $data->restaurant_id = $request->restaurant_id;
                    $data->name = $request->name;
                    $data->price = $request->price;
                    $data->logo = $request->logo;
                    $data->save();

                    return response()->json([
                        "message" => "Data has been updated"
                    ], 200);
                }
                else{
                    return response()->json([
                        "message" => "ID restaurant not found"
                    ], 400);
                }
            }
        }
        else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    public function delete($id){
        if (Food::where('id', $id)->exists()) {
            $data = Food::find($id);
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
