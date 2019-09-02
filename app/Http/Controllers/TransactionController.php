<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Order;

class TransactionController extends Controller
{
    public function getByRestaurant($id) {
        $find = Transaction::where('restaurant_id', $id);
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
        if (is_null($request->name) || is_null($request->order_id) || is_null($request->total)) {
            return response()->json([
                "message" => "Data request is incomplete"
            ], 400);
        }
        else {
            $find = Order::where('id', $request->order_id);
            if($find->exists()){
                $getOrder = $find->get();
                foreach ($getOrder as $key) {
                    $id_restaurant = $key->restaurant_id;
                    $name = $key->name;
                    $pickup = $key->pickup;
                    $request_notes = $key->request_notes;
                    $order_status = $key->order_status;
                }
                $data = new Transaction;
                $data->name = $request->name;
                $data->restaurant_id = $id_restaurant;
                $data->order_id = $request->order_id;
                $data->total = $request->total;
                $data->save();

                //change status order to paid
                $order = Order::find($request->order_id);
                $order->name = $name;
                $order->restaurant_id = $id_restaurant;
                $order->pickup = $pickup;
                $order->request_notes = $request_notes;
                $order->status = "Paid";
                $order->order_status = $order_status;
                $order->save();

                return response()->json([
                    "message" => "Data has been created"
                ], 201);
            }
            else{
                return response()->json([
                    "message" => "ID Order not found"
                ], 400);
            }
        }
    }

    public function delete($id){
        if (Transaction::where('id', $id)->exists()) {
            $data = Transaction::find($id);
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
