<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;


use Exception;
use GrahamCampbell\ResultType\Success;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        try {
            if (count($user) > 0) {
                return response()->json([
                    'success' => 1,
                    'result' => $user,
                    'message' => '',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => $e
            ], 200);
        }
    }
    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            "email" => 'required|email|unique:users,email',
            "phone_number" => 'required', //|unique:users,phone_number',
            "address" => "string|required"
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => $validator->errors(),
            ], 200);
        }
        try {
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->address = $request->address;
            $user->save();

            return response()->json([
                'success' => 1,
                'result' => 'user store sucsessfully',
                'message' => ''
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => $e
            ], 200);
        }
    }
    public function show($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => 'user not found'
            ], 200);
        } else {
            return response()->json([
                'success' => 1,
                'result' => $user,
                'message' => ''
            ], 200);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            "email" => 'required|email|unique:users,email',
            "phone_number" => 'required|phone_number|unique:users,phone_number',
            "address" => "string|required"
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => $validator->errors(),
            ], 200);
        }
        try {
            $user = User::find($id);
            if ($user) {
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->phone_number = $request->phone_number;
                $user->address = $request->address;
                $user->save();
            }
            else{
               return response()->json([
                    'success' => 0,
                    'result' => null,
                    'message' => 'user not found',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => $e
            ], 200);
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user != null) {
            $user->delete();
            return response()->json([
                'success' => 1,
                'result' => null,
                'message' => 'user deleted sucsessfully'
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'result' => null,
                'message' => 'user not found'
            ], 200);
        }
    }
}
