<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\mainCategory;
use App\Models\servicetypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class maincategoryController extends Controller
{
    public function getMainCategories()
    {
        $message = [];
        $mc = mainCategory::all();
        if ($mc) {
            for ($i = 0; $i < count($mc); $i++) {
                array_push($message, [
                    "maincategorydata" =>   $mc[$i],
                    "servicetypedata" =>  $mc[$i]->servicetype
                ]);
            }
            return json_encode([

                'status' => 'success',
                'message' => $message,

            ]);
        }
    }
    public function addMainCategory(Request $request)
    {
        $mc = new mainCategory();
        $validatemc = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:maincategory,name'
            ]

        );
        if ($validatemc->fails()) {
            return json_encode([
                'message' => $validatemc->errors(),
                'status' => 'failed'
            ]);
        }
        if ($request->file('file')) {
            $mc->name = $request->name;
            $mc->servicetypeid = $request->servicetypeid;
            $file = $request->file('file')->store('public');
            $mc->imageurl = basename($file);
            $mc = $mc->save();
        } else {
            return json_encode([
                'message' => 'Main category must have image',
                'status' => 'failed'
            ]);
        }
        if ($mc && $file) {
            return json_encode([
                'status' => 'success'
            ]);
        }
        return json_encode([
            'status' => 'failed'
        ]);
    }
    public function updateMainCategory(Request $request)
    {

        $mc = new mainCategory();
        $mc = $mc::find($request->id);
        if ($mc) {
            $mc->name = $request->name;
            $resname =  $mc->save();
            if (!$resname) {
                return [
                    'status' => 'failed'
                ];
            }
        }


        if ($request->file('file')) {
            $oldimageurl = $mc->imageurl;
            Storage::delete('public/'.$oldimageurl);
            $newimage = $request->file('file')->store('public');
            $mc->imageurl = basename($newimage);
            $resimage = $mc->save();
            if (!$resimage) {
               return json_encode( [
                    'status' => 'failed'
                ]);
            }
        }


        return json_encode([
            'status' => 'success'
        ]);
    }


    public function deleteMainCategory(Request $request)
    {
        $mc = new mainCategory();
        $mc = $mc::find($request->id);
        if ($mc) {
            Storage::delete('public/'.$mc->imageurl);
            $mc->delete();
            return json_encode([
                'status' => 'success'
            ]);
        }

        return json_encode([
            'status' => 'failed'
        ]);
    }
}
