<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Room;
use App\Models\userRooms;
use Illuminate\Http\Request;
use PDO;
use PhpParser\JsonDecoder;

class roomController extends Controller
{
    //title
    //userid1
    //userid2

    public function createRoom(Request $request)
    {
        $uu1 = userRooms::where('userid1', $request->userid2)->where('userid2', $request->userid1)->first();
        $uu = userRooms::where('userid1', $request->userid1)->where('userid2', $request->userid2)->first();

        if ($uu || $uu1) {
            if ($uu1 == null) {
                // print($uu);
                $uu->lat = $request->lat;
                $uu->long = $request->long;
                $uu->save();
            } else {
                $uu1->lat = $request->lat;
                $uu1->long = $request->long;
                $uu1->save();
            }
            return json_encode([
                'status' => 'success',
                'message' => 'room already exist',
                'roomid' => $uu == null ? $uu1->room['id'] : $uu->room['id'],
                'userdata' => $uu == null  ? $uu1->user2 : $uu->user2,
                'userprofile' =>    json_decode(
                    app(\App\Http\Controllers\profileController::class)->getProfile($uu == null ? $uu1->user1['id'] : $uu->user2['id']),
                ),

            ]);
        } else {
            $room = new Room();
            $room->title = $request->title;
            $room->save();
            $roomid = $room->id;
            $userroom = new userRooms();
            $userroom->userid1 = $request->userid1;
            $userroom->userid2 = $request->userid2;
            $userroom->roomid = $roomid;
            $userroom->lat = $request->lat;
            $userroom->long = $request->long;
            $res = $userroom->save();
            if ($res) {
                return json_encode([
                    'status' => 'success',
                    'roomid' => $userroom->room['id'],
                    'userdata' => $userroom->user2,
                    'userprofile' =>    json_decode(
                        app(\App\Http\Controllers\profileController::class)->getProfile($userroom->user2['id']),
                    ),
                ]);
            }
            return json_encode([
                'status' => 'failed'
            ]);
        }
    }

    public function getRooms($userid)
    {
        $message = [];
        $userrooms =  userRooms::where('userid1', $userid)->orWhere('userid2', $userid)->get();

        if ($userrooms) {
            for ($i = 0; $i < count($userrooms); $i++) {
                if ($userrooms[$i]['userid1'] == $userid) {
                    $response = json_decode(app(\App\Http\Controllers\messageController::class)->getMessages($userrooms[$i]->room['id']), true);

                    if ($response['status'] == 'success') {
                        $response = $response['message'];
                        $response =
                            collect($response)->sortByDesc('created_at')->first();
                    } else {
                        $response  = null;
                    }

                    array_push(
                        $message,

                        [
                            'userroom' => $userrooms[$i],
                            'roomdata' => $userrooms[$i]->room,
                            'lastmessage' => $response,
                            'userdata' => $userrooms[$i]->user2,
                            'userprofile' =>    json_decode(
                                app(\App\Http\Controllers\profileController::class)->getProfile($userrooms[$i]->user2['id']),
                            ),

                        ]


                    );
                }
                if ($userrooms[$i]['userid2'] == $userid) {
                    $response = json_decode(app(\App\Http\Controllers\messageController::class)->getMessages($userrooms[$i]->room['id']), true);

                    if ($response['status'] == 'success') {
                        $response = $response['message'];
                        $response =
                            collect($response)->sortByDesc('created_at')->first();
                    } else {
                        $response  = null;
                    }
                    array_push(
                        $message,

                        [
                            'userroom' => $userrooms[$i],
                            'roomdata' => $userrooms[$i]->room,
                            'lastmessage' => $response,
                            'userdata' => $userrooms[$i]->user1,
                            'userprofile' =>    json_decode(
                                app(\App\Http\Controllers\profileController::class)->getProfile($userrooms[$i]->user1['id']),
                            ),

                        ]


                    );
                }
            }
            $message =
                collect($message)->sortByDesc('lastmessage')->values()->all();

            // return($message);
            if ($message) {
                return json_encode([
                    'status' => 'success',
                    'message' => $message
                ]);
            }
        }
        return json_encode([
            'status' => 'failed'
        ]);
    }
}
