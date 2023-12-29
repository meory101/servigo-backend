<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\sellerModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\UrlGeneration\PublicUrlGenerator;
use PhpParser\JsonDecoder;
use PhpParser\Node\Expr\Print_;

class userController extends Controller
{
    public function signUp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:6|unique:users,name|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])/',
                'email' => 'required | email | unique:users,email',
                'password' =>
                'required|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])/'
            ]
        );
        if ($validator->fails()) {
            return json_encode([
                'status' => 'failed',
                'message' => $validator->errors()
            ]);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->roleid = $request->roleid;
        $user->save();
        $userid = DB::getPdo()->lastInsertId();
        return json_encode([
            'status' => 'success',
            'message' =>  'Signing up is successfully done',
            'userid' => $userid,
            'token' =>  $user->createToken('token')->plainTextToken
        ]);
    }

    public function signIn(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' =>
                'required|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])/'
            ]
        );
        if ($validator->fails()) {
            return json_encode([
                'status' => 'failed',
                'message' => $validator->errors()
            ]);
        }

        $user =  User::where('email', $request->email)->first();

        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                return json_encode([
                    'status' => 'failed',
                    'message' => [
                        'name' =>
                        'Password is wrong'
                    ]
                ]);
            }

            return json_encode([
                'status' => 'success',
                'message' =>  'Signing in is successfully done',
                'userid' =>  "$user->id",
                'roleid' => "$user->roleid",
                'token' =>  $user->createToken('token')->plainTextToken
            ]);
        }
        return json_encode([
            'status' => 'failed',
            'message' => [
                'email' =>
                'Email is not found'
            ]
        ]);
    }
    public function upgradeUser(Request $request)
    {
        $user = User::find($request->userid);
        if ($user) {
            $user->roleid = $request->roleid;
            $user->save();
            return json_encode([
                'status' => 'success',
            ]);
        }
        return json_encode([
            'status' => 'failed',

        ]);
    }
    public function userSearch($string)
    {
        $message = [];
        $users = User::where('name', 'like', '%' . $string . '%')->where('roleid', 1)->where('status',null)->get();
        $users1 = User::where('name', 'like', '%' . $string . '%')->where('roleid', 2)->where('status', null)->get();
        $mergedArray = array_merge($users->toArray(), $users1->toArray());
        
        if ($mergedArray) {
            for ($i = 0; $i < count($mergedArray); $i++) {
                array_push($message, [
                    "userdata" => $mergedArray[$i],
                    "profiledata" => json_decode(app(\App\Http\Controllers\profileController::class)->getProfile($mergedArray[$i]['id']))

                ]);
            }
            if (count($message) > 0) {
                return
                    json_encode([
                        'status' => 'success',
                        'message' => $message
                    ]);
            }
        }
        return json_encode([
            'status' => 'failed',

        ]);
    }
    public function addUser(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:6|unique:users,name|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])/',
                'email' => 'required | email | unique:users,email',
                'password' =>
                'required|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])/'
            ]
        );
        if ($validator->fails()) {
            return json_encode([
                'status' => 'failed',
                'message' => $validator->errors()
            ]);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->roleid = $request->roleid;
        $user = $user->save();
        if ($user) {
            return json_encode([
                'status' => 'success',
            ]);
        } else {
            return json_encode([
                'status' => 'failed',
            ]);
        }
    }
    public function blockUser(Request $request)
    {


        $user = User::where('id', $request->id)->first();
        if ($user) {
            $user->status = 0;
            $user = $user->save();
            return json_encode([
                'status' => 'success',
            ]);
        }
        return json_encode([
            'status' => 'failed',
        ]);
    }

    public function getUsers()
    {

        $message = [];
        $users = User::where('roleid', 1)->where('status', null)->get();
        $users1 = User::where('roleid', 2)->where('status', null)->get();
        $mergedArray = array_merge($users->toArray(), $users1->toArray());
        if ($mergedArray) {
            for ($i = 0; $i < count($mergedArray); $i++) {
                array_push($message, [
                    "userdata" => $mergedArray[$i],
                    "profiledata" => json_decode(app(\App\Http\Controllers\profileController::class)->getProfile($mergedArray[$i]['id']))

                ]);
            }
            if (count($message) > 0) {
                return
                    json_encode([
                        'status' => 'success',
                        'message' => $message
                    ]);
            }
        }
        return json_encode([
            'status' => 'failed',
        ]);
    }
}
