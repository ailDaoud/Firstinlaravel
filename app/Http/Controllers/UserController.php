<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
//use Dotenv\Validator;
use Illuminate\Support\Facades\Validator;


use Exception;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    function store_user(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'first_name' => 'required|string|min:3',
                'last_name' => 'required|string|min:3',
                "email" => 'required|email|unique:users,email',
                "phone_number" => 'required|phone_number|unique:users,phone_number',
                "address" => "string|required"
            ]);
           $user=new User();
           $user->first_name=$request->first_name;
           $user->last_name=$request->last_name;
           $user->email=$request->email;
           $user->phone_number=$request->phone_number;
           $user->address=$request->address;
           $user->save();

            return response()->json([
                'status' => 'sucsess',
                'message' => 'done'
            ], 200);


        }
        catch(Exception $e){
            return response()->json([
                'status'=>'failed',
                'validator errors'=>$validator->errors(),
                'Exceptions'=>$e
            ],200);
        }




    }
    public function showusers(){
        $user=User::all();
        return response()->json([
            'status' => 'success',
            'users' => $user
        ], 200);
    }
}
