<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Hash;
use JWTAuth;
use Response;

class UsersController extends Controller
{
    public function __construct()
  {

    $this->middleware("jwt.auth", ["only" => ["storeRole", "destroyRole"]]);
  }

    public function signUp(Request $request)
  {
    $rules =[
      'username' => 'required',
      'password' => 'required',
      'email' => 'required',
    ];

    $validator = Validator::make(Purifier::clean($request->all()),$rules);

    $check = User::where("email","=",$request->input("email"))->orWhere("name","=",$request->input("username"))->first();

    if (!empty($check)) {
        return Response::json(["error" => "Email or usernam already in use"]);
  }

    $user = new User;
    $user->name = $request->input('username');
    $user->password = Hash::make($request->input('password'));
    $user->email = $request->input('email');
    $user->roleID = 2;

    $user->save();
    return Response::json(["success" => "Account created successfully"]);
  }

    public function signIn(Request $request)
 {
    $validator = Validator::make(Purifier::clean($request->all()), [
      'email' => 'required',
      'password' => 'required',
    ]);

    if ($validator->fails()) {
      return Response::json(["error" => "You must enter an email and a password."]);
    }



    $email = $request->input('email');
    $password = $request->input('password');
    $cred = compact("email","password",["email","password"]);

    $token = JWTAuth::attempt($cred);
    
    return Response::json(compact("token"));
  }
  {
      public function index()
    {
      $user = User::all();

      return Response::json($User);
    }

      public function store(Request $request)
    {
      $rules =[
        'name' => 'required',
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

      $user = new Role;

      $user->name = $request->input('name');

      $user->save();

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
      return Response::json(["error" => "You need to fill out all fields"]);
    }

    $user=Auth::User();
    if($user->roleID !=1)
    {
      return Response::json(["Error" =>"Not Allowed."]);
    }

      $user= Role::find($id);

      $user->name = $request->input('name');

      $user->save();


      return Response::json(["success" => "Role Updated."]);

    }
      public function show($id)
    {
      $user = Role::find($id);

      return Response::json($role);

    }
      public function destroy($id)
    {
      $user = Role::find($id);

      $user->delete();

      return Response::json(['success' => 'Deleted Role.']);

    }
  }


}
