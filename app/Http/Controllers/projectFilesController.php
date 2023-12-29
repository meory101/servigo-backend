<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\appToken;
use App\Models\ProjectFiles;
use App\Models\User;
use Illuminate\Http\Request;


class projectFilesController extends Controller
{
    public function addFile(Request $request)
    {
        $pfile = new ProjectFiles();
        $file = $request->file('file')->store('public');
        $fileurl = basename($file);
        $pfile->fileurl = $fileurl;
        $pfile->orderid = $request->orderid;
        $pfile->isapprov = $request->isapprov;
        $pfile = $pfile->save();

        $SERVER_API_KEY = 'AAAABTF30Lw:APA91bFSp0jTie__TDBFxIacdKoauejX_B7uKt8mhWiyk3SyAD9W_UQhHdjiWOPXptdTeKuF9I6jphP1X3E21fEbLgbr4MoFmOeE2f4kWppYURs3nnmDCyDtPvM2E8yDiF95rU5qOT1T';
        $apptokens = [];
        $user = User::where('id', $request->sellerid)->first();
        $users = User::where('roleid', 3)->orwhere('roleid', 4)->get();
        $tokens = appToken::all();

        for ($i = 0; $i < count($users); $i++) {
            for ($j = 0; $j < count($tokens); $j++) {
                if ($tokens[$j]->userid == $users[$i]->id) {
                    array_push($apptokens, $tokens[$j]->token);
                }
            }
        }
        $data = [

            "registration_ids" => $apptokens,
            "data" => [
                'key' => 'admin'

            ],

            "notification" => [

                "title" =>
                "Project has been uploaded",

                "body" => $user->name,

                "sound" => "default"

            ],

        ];

        $dataString = json_encode($data);

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        dd($response);
    }
    public function getFile($orderid)
    {
        $pfile =  ProjectFiles::where('orderid', $orderid)->first();
        return $pfile;
    }

    public function updateFile(Request $request)
    {
        $pfile =  ProjectFiles::where('id', $request->id)->first();
        $pfile->isapprov = $request->isapprov;
        $pfile = $pfile->save();

        $SERVER_API_KEY = 'AAAABTF30Lw:APA91bFSp0jTie__TDBFxIacdKoauejX_B7uKt8mhWiyk3SyAD9W_UQhHdjiWOPXptdTeKuF9I6jphP1X3E21fEbLgbr4MoFmOeE2f4kWppYURs3nnmDCyDtPvM2E8yDiF95rU5qOT1T';
        $apptokens = appToken::where('userid', $request->userid)->get()->makeHidden(['created_at', 'updated_at', 'userid', 'id']);
        for ($i = 0; $i < count($apptokens); $i++) {
            $apptokens[$i] = $apptokens[$i]['token'];
        }

        $data = [

            "registration_ids" => $apptokens,

            "notification" => [

                "title" =>
                "Project is ready",

                "body" => 'check your orders',

                "sound" => "default"

            ],

        ];

        $dataString = json_encode($data);

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        dd($response);
    }
}
