<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\appToken;
use App\Models\Message;
use App\Models\User;
use App\Models\userRooms;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class messageController extends Controller
{

    public function getMessages($roomid)
    {
        $messages =  Message::where('roomid', $roomid)->get();

        if (count($messages) > 0) {
            
            $userroom = new userRooms();
            $userroom = $userroom->where('roomid',$messages[0]['roomid'])->first();
            return json_encode([
                'status' => 'success',
                'userroom' => $userroom,
                'message' => $messages
            ]);
        }

        return json_encode([
            'status' => 'failed'
        ]);
    }

    public function addMessage(Request $request)
    {

        $message = new Message();

        $message->content = $request->content;
        $message->date = $request->date;
        $message->status = $request->status;
        $message->senderid = $request->senderid;
        $message->recieverid = $request->recieverid;
        $message->roomid = $request->roomid;
        $message = $message->save();
        $profile =(app(\App\Http\Controllers\profileController::class)->getProfile($request->senderid));
        // return $profile;
        $SERVER_API_KEY = 'AAAABTF30Lw:APA91bFSp0jTie__TDBFxIacdKoauejX_B7uKt8mhWiyk3SyAD9W_UQhHdjiWOPXptdTeKuF9I6jphP1X3E21fEbLgbr4MoFmOeE2f4kWppYURs3nnmDCyDtPvM2E8yDiF95rU5qOT1T';
        $apptokens = appToken::where('userid', $request->recieverid)->get()->makeHidden(['created_at', 'updated_at', 'userid', 'id']);
        for ($i = 0; $i < count($apptokens); $i++) {
            $apptokens[$i] = $apptokens[$i]['token'];
        }
        $data = [

            "registration_ids" => $apptokens,
            "data" => [
                'roomid' => $request->roomid,
                'profile' => $profile
            ],

            "notification" => [

                "title" =>
                User::where('id', $request->senderid)->first()['name'],

                "body" => $request->content,

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



        if ($message) {
            return json_encode([
                'status' => 'success'
            ]);
        }
        return json_encode([
            'status' => 'failed'
        ]);
    }
    public function updateMessage(Request $request)
    {
        $message =  Message::where('id', $request->id)->first();
        if ($message) {
            $message->content = $request->content;
            $message->date = $request->date;
            $message->status = $request->status;
            $message->senderid = $request->senderid;
            $message->recieverid = $request->recieverid;
            $message->roomid = $request->roomid;
            $message = $message->save();
            if ($message) {
                return [
                    'status' => 'success'
                ];
            }
        }
        return [
            'status' => 'failed'
        ];
    }
    public function deleteMessage(Request $request)
    {
        $message =  Message::where('id', $request->id)->first();
        if ($message) {
            $message = $message->delete();
            if ($message) {
                return [
                    'status' => 'success'
                ];
            }
        }
        return [
            'status' => 'failed'
        ];
    }
}
