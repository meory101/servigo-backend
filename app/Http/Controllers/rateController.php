<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;

class rateController extends Controller
{
    public function addRate(Request $request)
    {
        $rate = new Rate();
        $rate->ratevalue = $request->ratevalue;
        $rate->ratedes = $request->ratedes;
        $rate->profileid = $request->profileid;
        $rate->userid = $request->userid;
        $rate = $rate->save();
        if ($rate) {
            return json_encode([
                'status' => 'success'
            ]);
        }

        return json_encode([
            'status' => 'failed'
        ]);
    }
    public function getRates($profileid)
    {
        $ratesdata = [];
        $rate = new Rate();
        $rates =  $rate::where('profileid', $profileid)->get();

        for ($i = 0; $i < count($rates); $i++) {
            json_encode(array_push(
                $ratesdata,
                [
                    $rates[$i],
                    $rates[$i]->user
                ]
            ));
        }


        if ($ratesdata) {
            return json_encode([
                'status' => 'success',
                'ratesdata' => $ratesdata
            ]);
        }

        return json_encode([
            'status' => 'failed'
        ]);
    }
}
