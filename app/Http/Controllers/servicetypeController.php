<?php

namespace App\Http\Controllers;

use App\Models\serviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class servicetypeController extends Controller
{
    public function getServiceTypes(){
        $st =new serviceType();
        return $st->all();
    }
    public function addServiceType(Request $request)
    {
        $st = new serviceType();
        $validatest = Validator::make(
            $request->all(),
            [
                'name'=> 'required|unique:servicetype,name'
            ]

        );
        if($validatest->fails()){
            return json_encode([
                'message' => $validatest->errors(),
                'status' => 'failed'
            ]); 
        }
        $st->name = $request->name;
        $st->save();
        if($st){
            return json_encode([
                'status' => 'success'
            ]);
        }
        return json_encode([
            'status' => 'failed'
        ]); 
    }
    public function updateServiceType(Request $request)
    {

        $st = new serviceType();
        $st = $st::find($request->id);
        $validatest = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:servicetype,name'
            ]

        );
        if ($validatest->fails()) {
            return  json_encode([
                'message' => $validatest->errors(),
                'status' => 'failed'
            ]);
        }
        if($st){
            $st->name = $request->name;
            $st->save();
            if ($st) {
                return  json_encode([
                    'status' => 'success'
                ]);
            }
        }
            return json_encode([
            'status' => 'failed'
        ]); 
        
    }
    public function deleteServiceType(Request $request)
    {
        $st = new serviceType();
        $st = $st::find($request->id);
       
        if ($st) {
            $st->delete();
       
            return  json_encode([
                'status' => 'success'
            ]);
        }
        return json_encode([
            'status' => 'failed'
        ]);
    }
}
