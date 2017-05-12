<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;

class RoleController extends Controller
{
    public function __construct()
  {

    $this->middleware("jwt.auth", ["only" => ["storeRole", "destroyRole"]]);
  }


  {
    public function index()
  {
    $roleS = Role::alL("id","desc")->get();
    return Response::json($role);
  }

    public function storeRole(Request $request)
  {
    $rules =[
      'Rolename' => 'required',
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

    $role = new Role;
    $role->name = $request->input('name');
    $role->save();

    return Response::json(["success" => "You did it."]);

  }

    public function updateRole($id, Request $request)
  {
    $rules =[
      'name' => 'required',
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

    $role= Role::find($id);
    $role->name = $request->input('name');
    $role->save();


    return Response::json(["success" => "Role Updated."]);

  }
    public function showRole($id)
  {
    $role = Role::find($id);

    return Response::json($role);

  }
    public function destroyRole($id)
  {
    $role = Role::find($id);

    $role->delete();

    return Response::json(['success' => 'Deleted Role.']);

  }
}
