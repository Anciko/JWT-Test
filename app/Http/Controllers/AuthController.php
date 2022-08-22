<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6|max:9',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Error!',
                'data' => $validator->errors()
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Registration success, Plesae Login',
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6|max:9'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'data' => $validator->errors()
            ]);
        }

        $token = Auth::attempt($validator->validated());

        if (!$token) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }

        return $this->createNewToken($token);
    }


    public function agentProfile()
    {
        $user = auth()->user();
        return response()->json([
            'status' => 200,
            'data' => $user
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validatioin Error',
                'data' => $validator->errors()
            ]);
        }

        $user = auth()->user();

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;

        $user->update();

        return response()->json([
            'status' => 200,
            'data' => $user
        ]);
    }

    public function promoteRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'status' => 'required',
            'remark' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => "Validation Error",
                'data' => $validator->errors()
            ]);
        }

        $user = auth()->user();

        if ($request->phone == $user->phone) {
            $user->phone = $request->phone;
            $user->status = $request->status;
            $user->remark = $request->remark;
        }

        $user->update();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully Promoted',
            'data' => $user
        ]);
    }

    // https://smspoh.com/api/

    public function sendSMS()
    {
        $result = Http::post('https://verify.smspoh.com/api/v2/send', [
            "to" => "09963356789",
            "message" => "Hello World",
            "sender" => "SMSPoh"
        ]);

        return "Result is => $result";
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
