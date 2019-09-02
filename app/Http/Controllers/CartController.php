<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Order;
use App\Food;

class CartController extends Controller
{
    public function getByOrder($id) {
        $find = Cart::where('order_id', $id);
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
        if (is_null($request->order_id) || is_null($request->food_id)) {
            return response()->json([
                "message" => "Data request is incomplete"
            ], 400);
        }
        else {
            $findOrder = Order::where('id', $request->order_id);
            if($findOrder->exists()){
                $findRestaurant = $findOrder->get(['restaurant_id']);
                foreach ($findRestaurant as $key) {
                    $id_restaurant = $key->restaurant_id;
                };
                $findFood = Food::where('restaurant_id', $id_restaurant)->get(['id']);
                foreach ($findFood as $key) {
                    if ($key->id == $request->food_id) {
                        if(Cart::where('food_id', $request->food_id)->exists()){
                            $getFood = Cart::where('food_id', $request->food_id)->get();                       
                            foreach ($getFood as $key) {
                                $data = Cart::find($key->id);
                                $data->order_id = $key->order_id;
                                $data->food_id = $key->food_id;
                                $data->qty = ($key->qty + 1);       
                                $data->request_notes = $key->request_notes;
                                $data->save();
                                
                                return response()->json([
                                    "message" => "Data has been added"
                                ], 200);
                            }
                        }
                        $data = new Cart;
                        $data->order_id = $request->order_id;
                        $data->food_id = $request->food_id;
                        $data->qty =  1;
                        $data->request_notes = $request->request_notes;
                        $data->save();
                        
                        return response()->json([
                            "message" => "Data has been created"
                        ], 201);
                    }
                };
                return response()->json([
                    "message" => "ID Food not found"
                ], 400);
            }
            else{
                return response()->json([
                    "message" => "ID Order not found"
                ], 400);
            }
        }
    }

    public function update(Request $request, $id){
        if (Cart::where('id', $id)->exists()) {
            if(is_null($request->order_id) || is_null($request->food_id)){
                return response()->json([
                    "message" => "Data request is incomplete"
                ], 400);
            }
            else{
                $findOrder = Order::where('id', $request->order_id);
                if($findOrder->exists()){
                    $findRestaurant = $findOrder->get(['restaurant_id']);
                    foreach ($findRestaurant as $key) {
                        $id_restaurant = $key->restaurant_id;
                    };
                    $findFood = Food::where('restaurant_id', $id_restaurant)->get(['id']);
                    foreach ($findFood as $key) { 
                        if ($key->id == $request->food_id) {
                            $data = Cart::find($id);
                            $data->order_id = $request->order_id;
                            $data->food_id = $request->food_id;
                            $data->qty = (is_null($request->qty) || $request->qty == 0) ? 1 : $request->qty;    
                            $data->request_notes = $request->request_notes;
                            $data->save();
                            
                            return response()->json([
                                "message" => "Data has been updated"
                            ], 201);
                        }
                    };
                    return response()->json([
                        "message" => "ID Food not found"
                    ], 400);
                }
                else{
                    return response()->json([
                        "message" => "ID Order not found"
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
        if (Cart::where('id', $id)->exists()) {
            $data = Cart::find($id);
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
