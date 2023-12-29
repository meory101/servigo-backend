<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\appToken;
use App\Models\Document;
use App\Models\Order;
use App\Models\orderModel;
use App\Models\Pricing;
use App\Models\Profile;
use App\Models\User;
use Faker\Documentor;
use Illuminate\Http\Request;
use PhpParser\JsonDecoder;
use PhpParser\Node\Expr\Print_;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class orderController extends Controller
{

    public function checkOrder(Request $request)
    {
        $order = new Order();
        $order1 =  $order->where('sellerid', $request->sellerid)->where('buyerid', $request->buyerid)->where('status', 'available')->first();
        $order2 =  $order->where('sellerid', $request->sellerid)->where('buyerid', $request->buyerid)->where('status', 'waiting')->first();
        if ($order1 || $order2) {
            return [
                'message'  => 'order'
            ];
        } else {
            return [
                'message'  => 'no order'
            ];
        }
    }
    public function getOrders($userid)
    {
        $orders3 =[];
        $selling_orders = [];
        $buying_orders = [];
        $orders1 = Order::where('sellerid', $userid)->get();
        $orders2 = Order::where('buyerid', $userid)->get();
        if($userid == 0){
            $orders3 = Order::all();
        }
        
        if (count($orders1) > 0 || count($orders2) > 0) {
            //find you as seller
            for ($i = 0; $i < count($orders1); $i++) {
                if (app(\App\Http\Controllers\documentController::class)->getDocument($orders1[$i]['id'])['status'] != 'failed') {
                    array_push($selling_orders, [
                        'profiledata' => json_decode(app(\App\Http\Controllers\profileController::class)->getProfile($orders1[$i]['buyerid'])),
                        'orderdata' => $orders1[$i],
                        'documentdata' => app(\App\Http\Controllers\documentController::class)->getDocument($orders1[$i]['id']),
                        'dd' => app(\App\Http\Controllers\documentController::class)->getDocument($orders1[$i]['id'])['documentdata']['deliverytime'],
                        'project' =>  app(\App\Http\Controllers\projectFilesController::class)->getFile($orders1[$i]['id'])

                    ]);
                }
            }
            //find you as buyer
            for ($i = 0; $i < count($orders2); $i++) {
                if (app(\App\Http\Controllers\documentController::class)->getDocument($orders2[$i]['id'])['status'] != 'failed') {
                    array_push($buying_orders, [
                        'profiledata' => json_decode(app(\App\Http\Controllers\profileController::class)->getProfile($orders2[$i]['sellerid'])),
                        'orderdata' => $orders2[$i],
                        'documentdata' => app(\App\Http\Controllers\documentController::class)->getDocument($orders2[$i]['id']),
                        'dd' => app(\App\Http\Controllers\documentController::class)->getDocument($orders2[$i]['id'])['documentdata']['deliverytime'],
                        'project' =>  app(\App\Http\Controllers\projectFilesController::class)->getFile($orders2[$i]['id'])


                    ]);
                }
            }
            $selling_orders =
                collect($selling_orders)->sortBy('dd')->values()->all();
            $buying_orders =
                collect($buying_orders)->sortBy('dd')->values()->all();
         
            return [
                // 'status' => 'success',
                'selling orders' => $selling_orders,
                'buying orders' => $buying_orders,
            ];
        }
        if (count($orders3) > 0) {
            for ($i = 0; $i < count($orders3); $i++) {
                $sellerprofile = json_decode(app(\App\Http\Controllers\profileController::class)->getProfile($orders3[$i]['sellerid']));
                $buyerprofile = json_decode(app(\App\Http\Controllers\profileController::class)->getProfile($orders3[$i]['buyerid']));
              
                if (app(\App\Http\Controllers\documentController::class)->getDocument($orders3[$i]['id'])['status'] != 'failed') {
                    
                    array_push($buying_orders, [
                        'buyerprofile' => $buyerprofile,
                        'sellerprofile' =>  $sellerprofile,
                        'orderdata' => $orders3[$i],
                        'documentdata' => app(\App\Http\Controllers\documentController::class)->getDocument($orders3[$i]['id']),
                        'dd' => app(\App\Http\Controllers\documentController::class)->getDocument($orders3[$i]['id'])['documentdata']['deliverytime'],
                        'project' =>  app(\App\Http\Controllers\projectFilesController::class)->getFile($orders3[$i]['id'])

                    ]);
                }

           
            }
            $buying_orders =
                collect($buying_orders)->sortBy('dd')->values()->all();
            return [
                'status' => 'success',
                'orderdata' => $buying_orders
            ];
        }

        return [
            'status' => 'failed'
        ];
    }
    public function addOrder(Request $request)
    {
        $order = new Order();
        $order->status = $request->status;
        $order->subcategoryid = $request->subcategoryid;
        $order->sellerid = $request->sellerid;
        $order->buyerid = $request->buyerid;
        // $order->mediatorid  = $request->mediatorid;
        $res = $order->save();
        if ($res) {
            return json_encode(
                [
                    'status' => 'success',
                    'orderid' => $order['id']

                ]
            );
        }
        return json_encode([
            'status' => 'failed'
        ]);
    //     $SERVER_API_KEY = 'AAAABTF30Lw:APA91bFSp0jTie__TDBFxIacdKoauejX_B7uKt8mhWiyk3SyAD9W_UQhHdjiWOPXptdTeKuF9I6jphP1X3E21fEbLgbr4MoFmOeE2f4kWppYURs3nnmDCyDtPvM2E8yDiF95rU5qOT1T';
    //     $apptokens = appToken::where('userid', $request->sellerid)->get();
    //     for ($i = 0; $i < count($apptokens); $i++) {
    //         $apptokens[$i] = $apptokens[$i]['token'];
    //     }
    //     $data = [

    //         "registration_ids" => $apptokens,

    //         "notification" => [

    //             "title" =>
    //             User::where('id', $request->buyerid)->first()['name'],

    //             "body" => 'wants to make deal with you',

    //             "sound" => "default"

    //         ],

    //     ];

    //     $dataString = json_encode($data);

    //     $headers = [

    //         'Authorization: key=' . $SERVER_API_KEY,

    //         'Content-Type: application/json',

    //     ];

    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

    //     curl_setopt($ch, CURLOPT_POST, true);

    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    //     $response = curl_exec($ch);

    //     dd($response);
    }
    public function updateOrder(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        if ($order) {
            $order->status = $request->status;
            // $order->subcategoryid = $request->subcategoryid;
            // $order->sellerid = $request->sellerid;
            // $order->buyerid = $request->buyerid;
            // $order->mediatorid  = $request->mediatorid;
            $order->save();
            if ($order) {
                return [
                    'status' => 'success'
                ];
            }
        }
        return [
            'status' => 'failed'
        ];
    }

    public function deleteOrder(Request $request)
    {
        $order = Order::where('id', $request->orderid)->first();
        // print($order);
        $document = Document::where('id', $request->docid)->first();
        // print($document);
        if ($order && $document) {
            $document = $document->delete();
            $order = $order->delete();}
        if ($request->type == 'reject order') {
            $SERVER_API_KEY = 'AAAABTF30Lw:APA91bFSp0jTie__TDBFxIacdKoauejX_B7uKt8mhWiyk3SyAD9W_UQhHdjiWOPXptdTeKuF9I6jphP1X3E21fEbLgbr4MoFmOeE2f4kWppYURs3nnmDCyDtPvM2E8yDiF95rU5qOT1T';
            $apptokens = appToken::where('userid', $request->userid)->get()->makeHidden(['created_at', 'updated_at', 'userid', 'id']);
            for ($i = 0; $i < count($apptokens); $i++) {
                $apptokens[$i] = $apptokens[$i]['token'];
            }


            $data = [

                "registration_ids" => $apptokens,
                "notification" => [

                    "title" =>
                    'Order rejected',

                    "body" => User::where('id', $request->sellerid)->first()['name'],

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
    
}
