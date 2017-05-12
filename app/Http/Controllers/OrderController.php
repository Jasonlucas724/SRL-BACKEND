<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Auth;
use JWTAuth;


class OrderController extends Controller
{
      public function __construct()
      {
      $this->middleware('jwt.auth', ['only' => ["store",'update','destroy']]);
      }

      public function index()
      {
      $order = Order::all();

      return Response::json($order);
      }

      public function storeOrder(Request $request)
      {
        $rules =[
          "productID" => "required",
          "userID" => "required",
          "amount" => "required",
          "comment" => "required",
          "totalPrice" => "required",

          ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);

      if($validator->fails())
      {
        return Response::json(["error" => "You need to fill out all fields."])
      }

      $user=Auth::User();
      if($user->roleID !=1)


      {
        return Response::json(["Error" =>"Not Allowed."]);
      }


      $product=Product::find($request->input("productID"));
      if(empty($product)
      {
        return Response::json(["error" => "Invalid productID."])
      }

      if($product->availability== 0)
      {
        return Response::json(["error" => "invalid"]);
      }



      $order = new Order;

      $order->userID = Auth::user()->id;
      $order->productID = $request->input('productID');
      $order->amount = $request->input('amount');
      $order->totalPrice=$request->input('amount')*$product->price;
      $order->comments = $request->input('comment');
      $order->save();

      return Response::json(["success" => "You did it."]);

      }

      public function updateOrder($id, Request $request)
      {
      $rules =[

        "productID" => "required",
        "userID" => "required",
        "amount" => "required",
        "comment" => "required",


      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);

      if($validator->fails())
      {
      return Response::json(["error" => "You need to fill out all fields"]);
      }


      $product=Product::find($request->input("productID"));
      if(empty($product)
      {
      return Response::json(["error" => "Invalid Product."])
      }

      if($product->availability== 0)


      {
      return Response::json(["success" => "Success"]);
      }


      $order= Order::find($id);
      $order->userID = Auth::user()->id;
      $order->productID = $request->input("productID");
      $order->amount = $request->input("amount");
      $order->totalPrice = $request->input("amount")*$product->price;
      $order->comment = $request->input("comment");
      $order->save();

      return Response::json(["success" => "Order Updated."]);


      $user=Auth::user();
      if($user->roleID !=1 || $user->id != order->userID)
      {return Response...}


     }
      public function showOrder($id)
     {


        $order = Order::find($id);


        return Response::json($order);
      }
      public function destroyOrder($id)
      {
      $order = Order::find($id);
      $user=Auth::user();
      if($user->roleID !=1 || $user->id != order->userID)

      {
      return Response::json(["error" => "You are not authorized to do this."]);
      }

      $order->delete();

      return Response::json(['success' => 'Order has been Deleted .']);

      }
}
