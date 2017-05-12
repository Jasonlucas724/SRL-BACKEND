<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;


class ProductController extends Controller
{

    public function __construct()
    {

        $this->middleware("jwt.auth", ["only" => ["storeProduct", "destroyProduct"]]);
      }  
    public function index()
    {
    $products = Product::orderby("id","desc")->get();
    return Response::json($products);
    }


    public function storeProduct(Request $request)
  {
    $rules =[
      'Product' => 'required',
      'image' => 'required',
      'description' => 'required',
      'stock' => 'required',
      'categoryID' => 'required',
      'price' => 'required',
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
    {
    return Response::json(["error" => "You need to fill out all fields."]);
  }

    $user=Auth::User();
    if($user->roleID !=1)
    {
      return Response::json(["Error" =>"Not Allowed."]);
    }

    $product = new Product;
    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $image->move("storage/", $imageName);
    $product->image = $request->root()."/storage/".$imageName;

    $product->price = $request->input('price');
    $product->description = $request->input('description');
    $product->name = $request->input('name');
    $product->categoryID = $request->input('categoryID');
    $product->availability = $request->input('availability');
    $product->save();

    return Response::json(["success" => "You did it."]);
    }

    public function update($id, Request $request)
  {
    $rules =[

      'Product' => 'required',
      'categoryID' => 'required',
      'description' => 'required',
      'stock' => 'required',
      'categoryID' => 'required',
      'price' => 'required',

    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
    {
    return Response::json(["error" => "You need to fill out all fields"]);
  }

    $user=Auth::User();
    if($user->roleID !=1)
    {
      return Response::json(["Error" =>"Not Allowed."]);
    }

    $product = new Product;
    $product= Product::find($id);
    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $image->move("storage/", $imageName);
    $product->image = $request->root()."/storage/".$imageName;
    $product->price = $request->input('price');
    $product->description = $request->input('description');
    $product->name = $request->input('name');
    $product->categoryID = $request->input('categoryID');
    $product->availability = $request->input('availability');
    if(!empty($image))

    {
      $imageName = $image->getClientOriginalName();
      $image->move("storage/",$imageName);
      $product->image = request->root()."/storage/".$imageName;
    }

      $product->save();


    return Response::json(["success" => "Product Updated."]);

 }
    public function showProduct($id)
 {
    $product = Product::find($id);

    return Response::json($product);
 }
    public function destroy($id)
 {
    $product = Product::find($id);
    $product->delete();

    return Response::json(['success' => 'Deleted Order.']);

 }
}
