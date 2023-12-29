<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class pricingController extends Controller
{


    public function getallPricing()
    {
        $message = [];

        $pricings = Pricing::all();
        if ($pricings) {
            for ($i = 0; $i < count($pricings); $i++) {
                if ($pricings[$i]['content']) {
                    array_push(
                        $message,
                        [
                            'pricingdata' => $pricings[$i],
                            'pricingsubcategory' => $pricings[$i]->subcategory,
                            'profiledata' => $pricings[$i]->profile,
                            'name' => $pricings[$i]->profile->user->name
                        ]
                    );
                }
            }
        }
        // print(count($message));

        if (count($message) > 0) {
            return json_encode([
                'status' => 'success',
                'message' => $message
            ]);
        }
        return json_encode(
            [
                'status' => 'failed',

            ]
        );
    }


    public function getPricing($profileid)
    {
        $message = [];

        $pricings = Pricing::where('profileid', $profileid)->get();
        if (count($pricings) > 0) {

            for ($i = 0; $i < count($pricings); $i++) {
                array_push(
                    $message,

                    [
                        'pricingdata' => $pricings[$i],
                        'pricingsubcategory' => $pricings[$i]->subcategory,
                    ]
                );
            }
            return json_encode([
                'status' => 'success',
                'message' => $message
            ]);
        }
        return json_encode(
            [
                'status' => 'failed',

            ]
        );
    }
    public function addPricing(Request $request)
    {
        $pricing = new Pricing();
        $validatepost = Validator::make(
            $request->all(),
            [
                'content' => 'min:100|max:1000'
            ]
        );
        if ($validatepost->fails()) {
            return json_encode(
                [
                    'status' => 'failed',
                    'message' => $validatepost->errors()
                ]
            );
        }


        $pricing->content = $request->content;
        $pricing->price = $request->price;
        $pricing->subcategoryid = $request->subcategoryid;
        $pricing->profileid = $request->profileid;
        $pricing = $pricing->save();

        if ($pricing) {
            return json_encode([
                'status' => 'success',
            ]);
        }


        return json_encode([
            'status' => 'failed',
        ]);
    }
    public function updatePricing(Request $request)
    {

        $pricing = Pricing::find($request->id);
        if ($pricing) {

            $validatepost = Validator::make(
                $request->all(),
                [
                    'content' => 'min:100|max:1000'
                ]
            );
            if ($validatepost->fails()) {
                return json_encode([
                    'status' => 'failed',
                    'message' => $validatepost->errors()
                ]);
            }
            $pricing->content = $request->content;
            $pricing->price = $request->price;
            $pricing->subcategoryid = $request->subcategoryid;
            $pricing->profileid = $request->profileid;
            $pricing = $pricing->save();
            if ($pricing) {
                return json_encode([
                    'status' => 'success',
                ]);
            }
        }
        return  json_encode([
            'status' => 'failed',
        ]);
    }
    public function deletePricing(Request $request)
    {
        $pricing = Pricing::find($request->id);

        if ($pricing) {
            $pricing = $pricing->delete();
            return [
                'status' => 'success',
            ];
        }
        return [
            'status' => 'failed',
        ];
    }
}
