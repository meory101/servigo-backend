<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\subCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class subcategoryController extends Controller
{
    public function getsubCategories()
    {
        $message = [];
        $sc = subCategory::all();
        if ($sc) {
            for ($i = 0; $i < count($sc); $i++) {
                array_push($message, [
                    "subcategorydata" => $sc[$i],
                    "maincategorydata" =>  $sc[$i]->maincategory,
                    "servicetypedata" =>  $sc[$i]->maincategory->servicetype
                ]);
            }
            return json_encode([

                'status' => 'success',
                'message' => $message,

            ]);
        }
    }
    public function addsubCategory(Request $request)
    {
        $sc = new subCategory();
        $validatesc = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:subcategory,name'
            ]

        );
        if ($validatesc->fails()) {
            return json_encode([
                'message' => $validatesc->errors(),
                'status' => 'failed'
            ]);
        }
        $sc->name = $request->name;
        $sc->maincategoryid = $request->maincategoryid;

        $sc->save();
        if ($sc) {
            return json_encode([
                'status' => 'success'
            ]);
        }
        return  json_encode([
            'status' => 'failed'
        ]);
    }
    public function updatesubCategory(Request $request)
    {

        $sc = new subCategory();
        $sc = $sc::find($request->id);
        if ($sc) {
            $sc->name = $request->name;
            $sc->save();
            if ($sc) {
                return json_encode([
                    'status' => 'success'
                ]);
            }
        }
        return json_encode([
            'status' => 'failed'
        ]);
    }
    public function deletesubCategory(Request $request)
    {
        $sc = new subCategory();
        $sc = $sc::find($request->id);

        if ($sc) {
            $sc->delete();

            return json_encode([
                'status' => 'success'
            ]);
        }
        return json_encode([
            'status' => 'failed'
        ]);
    }


    public function categorySearch($string)
    {
        $categories = subCategory::where('name', 'LIKE', '%' . $string . '%')->get();
        if ($categories) {
            return json_encode([
                'status' => 'success',
                'message' => $categories
            ]);
        }
        return json_encode([
            'status' => 'failed',

        ]);
    }
}
