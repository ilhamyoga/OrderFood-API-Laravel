<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Restaurant;
use App\Transaction;
use App\Cart;

class OrderController extends Controller
{
    public function show(Request $request){
        $id = $request->query('id');
        if($id){
            $data = Order::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($data, 200);
        }
        else{
            $data = Order::all();
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
        $find = Order::where('restaurant_id', $id);
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
        if (is_null($request->name) || is_null($request->restaurant_id) || is_null($request->pickup)) {
            return response()->json([
                "message" => "Data request is incomplete"
            ], 400);
        }
        else {
            if(Restaurant::where('id', $request->restaurant_id)->exists()){
                $data = new Order;
                $data->name = $request->name;
                $data->restaurant_id = $request->restaurant_id;
                $data->pickup = $request->pickup;
                $data->request_notes = $request->request_notes;
                $data->status = "Not yet Paid";
                $data->order_status = "Pending";
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
        if (Order::where('id', $id)->exists()) {
            if(is_null($request->name) || is_null($request->restaurant_id) || is_null($request->pickup)){
                return response()->json([
                    "message" => "Data request is incomplete"
                ], 400);
            }
            else{
                if(Restaurant::where('id', $request->restaurant_id)->exists()){
                    $findTransaction = Transaction::where('order_id', $id);
                    $data = Order::find($id);
                    $data->name = $request->name;
                    $data->restaurant_id = $request->restaurant_id;
                    $data->pickup = $request->pickup;
                    $data->request_notes = $request->request_notes;
                    $data->status = $findTransaction->exists() ? "Paid" : "Not yed Paid";
                    $data->order_status = "Pending";
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

    public function changeStatusOrder($id){
        $find = Order::where('id', $id);
        if ($find->exists()) {
            $getFood = $find->get();                       
            foreach ($getFood as $key) {
                $data = Order::find($id);
                $data->name = $key->name;
                $data->restaurant_id = $key->restaurant_id;
                $data->pickup = $key->pickup;
                $data->request_notes = $key->request_notes;
                $data->status = $key->status;
                $data->order_status = "Success";
                $data->save();
                
                return response()->json([
                    "message" => "Data has been changed"
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
        if (Order::where('id', $id)->exists()) {
            $cart = Cart::where('order_id', $id);
            $cart->delete();

            $data = Order::find($id);
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
