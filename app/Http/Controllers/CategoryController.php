<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;


class CategoryController extends Controller
{
  public function __construct()
  {
    $this->middleware("jwt.auth", ["only" => ["storeCategory", "destroyCategory"]]);
  }
    public function index()
  {
    $category = Category::all();

    return Response::json($category);
  }

    public function store(Request $request)
  {
    $rules =[
      'name' => 'required',
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
  {
      return Response::json(["error" => "You need to fill out all fields"]);
  }

    $category = new Category;

    $category->name = $request->input('name');

    $category->save();

    return Response::json(["success" => "You did it."]);


  }

  public function update($id, Request $request)
  {
    $rules =[
      'name' => 'required',
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);

    if($validator->fails())
  {
      return Response::json(["error" => "You need to fill out all fields."]);
  }

    $category= Category::find($id);

    $category->name = $request->input('name');

    $category->save();

    return Response::json(["success" => "Category Updated."]);

  }

    public function show($id)
  {
    $category = Category::find($id);

    return Response::json($category);

  }
    public function destroy($id)
  {
    $category = Category::find($id);

    $category->delete();

    return Response::json(['success' => 'Deleted Category.']);

  }

}
