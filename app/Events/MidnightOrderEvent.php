<?php

namespace App\Events;

use App\Models\appToken;
use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MidnightOrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $SERVER_API_KEY = 'AAAABTF30Lw:APA91bFSp0jTie__TDBFxIacdKoauejX_B7uKt8mhWiyk3SyAD9W_UQhHdjiWOPXptdTeKuF9I6jphP1X3E21fEbLgbr4MoFmOeE2f4kWppYURs3nnmDCyDtPvM2E8yDiF95rU5qOT1T';
        $apptokens = appToken::all();
        

        $data = [

            "registration_ids" => $apptokens,
          

            "notification" => [

                "title" =>
                'ddddddd',

                "body" => 'cddtes',

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
