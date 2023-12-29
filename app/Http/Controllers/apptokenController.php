<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\appToken;
use Illuminate\Http\Request;

class apptokenController extends Controller
{
    public function addAppToken(Request $request)
    {
        
        $apptoken = new appToken();
        $at = new appToken();
        $at= $at->where('token',$request->token)->where('userid',$request->userid)->first();
        if($at){
            return [
                'status' => 'success',
            ];
        }
       else{
            $apptoken->token = $request->token;
            $apptoken->userid = $request->userid;
            $apptoken = $apptoken->save();
            if ($apptoken) {
                return [
                    'status' => 'success',
                ];
            }
       }
        return [
            'status' => 'failed'
        ];
    }


    public function deleteToken(Request $request)
    {
        $token = appToken::where('token', $request->token)->where('userid',$request->userid)->first();
       
        if ($token) {
            $token = $token->delete();
            
            return [
                'status' => 'success'
            ];
        }
        return [
            'status' => 'failed'
        ];
    }
}
