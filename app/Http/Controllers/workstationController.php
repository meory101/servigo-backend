<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Workstation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\JsonDecoder;

use function PHPUnit\Framework\isEmpty;

class workstationController extends Controller
{

    public function getWorkstations($profileid)
    {
        $message = [];
        $wks = Workstation::where('profileid', $profileid)->get();
        for ($i = 0; $i < count($wks); $i++) {
            array_push(
                $message,
                [
                    'workstationdata' => $wks[$i],
                    'image' => $wks[$i]['imageurl'],
                    'subcategorydata' => $wks[$i]->subcategory
                ]
            );
        }
        if (count($wks) > 0) {
            return json_encode(
                [
                    'status' => 'success',
                    'message' => $message
                ]
            );
        }
        return json_encode(
            [
                'status' => 'failed'
            ]
        );
    }

    public function addWorkstation(Request $request)
    {
        $wk = new Workstation();

        $validatewk = Validator::make(
            $request->all(),
            [
                'title' => 'min:50|max:100',
                'content' => 'min:100|max:1000'
            ]
        );
        if ($validatewk->fails()) {
            return json_encode([
                'status' => 'failed',
                'message' => $validatewk->errors()
            ]);
        }

        if ($request->file('file')) {
            $wk->title = $request->title;
            $wk->content = $request->content;
            $wk->link = $request->link;
            $wk->subcategoryid = $request->subcategoryid;
            $wk->profileid = $request->profileid;
            $file =  $request->file('file')->store('public');
            $wk->imageurl = basename($file);
            $wk =  $wk->save();
            if ($wk) {
                return json_encode([
                    'status' => 'success',
                ]);
            }
        } else {
            return json_encode([
                'message' => 'Workstation musth have image',
                'status' => 'failed',
            ]);
        }
        return json_encode([
            'status' => 'failed',
        ]);
    }
    public function updateWorkstation(Request $request)
    {
        $wk =  Workstation::where('id', $request->wkid)->first();


        if ($wk) {
            if ($request->has('title')) {
                $wk->title = $request->title;
                $wk->content = $request->content;
                $wk->link = $request->link;
                $wk->subcategoryid = $request->subcategoryid;
                $wk->profileid = $request->profileid;
                $res = $wk->save();
            }
            if ($request->file('file')) {
                Storage::delete('public/' . $wk->imageurl);
                $file = $request->file('file')->store('public');
                $wk->imageurl = basename($file);
                $res = $wk->save();
            }
            if ($res) {
                return json_encode([
                    'status' => 'success',
                ]);
            }
        }

        return json_encode([
            'status' => 'failed',
        ]);
    }

    public function deleteWorkstation(Request $request)
    { {
            $post = Workstation::find($request->id);

            if ($post) {
                Storage::delete('public/' . $post->imageurl);
                $post = $post->delete();

                return json_encode([
                    'status' => 'success',
                ]);
            }
            return json_encode([
                'status' => 'failed',
            ]);
        }
    }
}
