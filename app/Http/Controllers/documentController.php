<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\appToken;
use App\Models\Attachment;
use App\Models\Document;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class documentController extends Controller
{

    public function checkDocument(Request $request)
    {
        $document = new Document();
        $document  = $document->where('orderid', $request->orderid)->where('isapprov', 0)->first();
        if ($document) {
            return [
                'message' => 'document'

            ];
        } else {
            return
                [
                    'message' => 'no document'
                ];
        }
    }
    public function getDocument($orderid)
    {
        $document = new Document();
        $order = new Order();
        $order = $order->where('id', $orderid)->first();
        if ($order['status'] == 'waiting') {
            $document = $document->where('orderid', $orderid)->first();
            $undocument = null;
        } else if ($order['status'] == 'unavailable') {
            $document = $document->where('orderid', $orderid)->where('isapprov', 1)->first();
            $undocument = null;
        } else {
            $document = $document->where('orderid', $orderid)->where('isapprov', 1)->first();
            // $document = $document->sortByDesc('id')->first();
            $undocument = Document::where('orderid', $orderid)->where('isapprov', 0)->first();
        }

        if ($document) {
            return [
                'status' => 'success',
                'documentdata' => $document,
                'attachment' => app(\App\Http\Controllers\attachmentController::class)->getAttach($document['id']),
                'unattachemnt' => $undocument == null ? null : app(\App\Http\Controllers\attachmentController::class)->getAttach($undocument['id']),
                'undocument' => $undocument ? $undocument : null
            ];
        }
        return [
            'status' => 'failed'
        ];
    }
    public function addDocument(Request $request)
    {
        $att = new Attachment();

        $document = new Document();
        $document->startuptime = $request->startuptime;
        $document->deliverytime = $request->deliverytime;
        $document->isapprov = $request->isapprov;
        $document->price = $request->price;
        $document->title  = $request->title;
        $document->content  = $request->content;
        $document->worklocation  = $request->worklocation;
        $document->orderid  = $request->orderid;
        $document->createrid  = $request->createrid;
        $dres =  $document->save();
        if ($request->file('file')) {
            $file = $request->file('file')->store('public');
            $att->attachmenturl = basename($file);
            $att->documentid = $document->id;
            $att = $att->save();
        }
        if ($request->type == 'new order') {
            $SERVER_API_KEY = 'AAAABTF30Lw:APA91bFSp0jTie__TDBFxIacdKoauejX_B7uKt8mhWiyk3SyAD9W_UQhHdjiWOPXptdTeKuF9I6jphP1X3E21fEbLgbr4MoFmOeE2f4kWppYURs3nnmDCyDtPvM2E8yDiF95rU5qOT1T';
            $apptokens = appToken::where('userid', $request->userid)->get()->makeHidden(['created_at', 'updated_at', 'userid', 'id']);
            for ($i = 0; $i < count($apptokens); $i++) {
                $apptokens[$i] = $apptokens[$i]['token'];
            }


            $data = [

                "registration_ids" => $apptokens,

                "notification" => [

                    "title" =>
                    'New order request',

                    "body" => User::where('id', $request->buyerid)->first()['name'],

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

        if ($request->type == 'new doc') {
            $document = app(\App\Http\Controllers\documentController::class)->getDocument($request->orderid);
            $SERVER_API_KEY = 'AAAABTF30Lw:APA91bFSp0jTie__TDBFxIacdKoauejX_B7uKt8mhWiyk3SyAD9W_UQhHdjiWOPXptdTeKuF9I6jphP1X3E21fEbLgbr4MoFmOeE2f4kWppYURs3nnmDCyDtPvM2E8yDiF95rU5qOT1T';
            $apptokens = appToken::where('userid', $request->userid)->get()->makeHidden(['created_at', 'updated_at', 'userid', 'id']);
            for ($i = 0; $i < count($apptokens); $i++) {
                $apptokens[$i] = $apptokens[$i]['token'];
            }


            $data = [

                "registration_ids" => $apptokens,
                "data" => [
                    'document' => $document,
                    'sellerid' => $request->sellerid,
                    'buyerid' => $request->buyerid,
                    'orderid' => $request->orderid
                ],

                "notification" => [

                    "title" =>
                    'New Document',

                    "body" => 'check the updates',

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

        if ($dres && $att) {
            return json_encode([
                'status' => 'success'
            ]);
        }
        return json_encode([
            'status' => 'failed'
        ]);
    }
    public function updateDocument(Request $request)
    {
        $document = new Document();
        $document = $document::where('id', $request->id)->first();
        if ($document) {
            $document->isapprov = $request->isapprov;
            $document = $document->save();

            if ($request->type == 'accept order') {
                $SERVER_API_KEY = 'AAAABTF30Lw:APA91bFSp0jTie__TDBFxIacdKoauejX_B7uKt8mhWiyk3SyAD9W_UQhHdjiWOPXptdTeKuF9I6jphP1X3E21fEbLgbr4MoFmOeE2f4kWppYURs3nnmDCyDtPvM2E8yDiF95rU5qOT1T';
                $apptokens = appToken::where('userid', $request->userid)->get()->makeHidden(['created_at', 'updated_at', 'userid', 'id']);
                for ($i = 0; $i < count($apptokens); $i++) {
                    $apptokens[$i] = $apptokens[$i]['token'];
                }


                $data = [

                    "registration_ids" => $apptokens,

                    "notification" => [

                        "title" =>
                        'Order accepted',

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
            if ($request->type == 'accept doc') {
                $document = app(\App\Http\Controllers\documentController::class)->getDocument($request->orderid);
                $SERVER_API_KEY = 'AAAABTF30Lw:APA91bFSp0jTie__TDBFxIacdKoauejX_B7uKt8mhWiyk3SyAD9W_UQhHdjiWOPXptdTeKuF9I6jphP1X3E21fEbLgbr4MoFmOeE2f4kWppYURs3nnmDCyDtPvM2E8yDiF95rU5qOT1T';
                $apptokens = appToken::where('userid', $request->userid)->get()->makeHidden(['created_at', 'updated_at', 'userid', 'id']);
                for ($i = 0; $i < count($apptokens); $i++) {
                    $apptokens[$i] = $apptokens[$i]['token'];
                }


                $data = [

                    "registration_ids" => $apptokens,
                    "data" => [
                        'document' => $document,
                        'sellerid' => $request->sellerid,
                        'buyerid' => $request->buyerid,
                        'orderid' => $request->orderid
                    ],
                    "notification" => [

                        "title" =>
                        'Document accepted',

                        "body" => 'check the updates',

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

            if ($document) {
                return [
                    'status' => 'success'
                ];
            }
        }
        return [
            'status' => 'failed'
        ];
    }
    public function deleteDocument(Request $request)
    {

        $document = Document::where('id', $request->docid)->first();
        $document =   $document->delete();

        if ($request->type == 'reject doc') {
            $document = app(\App\Http\Controllers\documentController::class)->getDocument($request->orderid);
            $SERVER_API_KEY = 'AAAABTF30Lw:APA91bFSp0jTie__TDBFxIacdKoauejX_B7uKt8mhWiyk3SyAD9W_UQhHdjiWOPXptdTeKuF9I6jphP1X3E21fEbLgbr4MoFmOeE2f4kWppYURs3nnmDCyDtPvM2E8yDiF95rU5qOT1T';
            $apptokens = appToken::where('userid', $request->userid)->get()->makeHidden(['created_at', 'updated_at', 'userid', 'id']);
            for ($i = 0; $i < count($apptokens); $i++) {
                $apptokens[$i] = $apptokens[$i]['token'];
            }


            $data = [

                "registration_ids" => $apptokens,
                "data" => [
                    'document' => $document,
                    'sellerid' => $request->sellerid,
                    'buyerid' => $request->buyerid,
                    'orderid' => $request->orderid
                ],

                "notification" => [

                    "title" =>
                    'Document rejected',

                    "body" => 'check the updates',

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
        // if ($document) {
        //     return [
        //         'status' => 'success'
        //     ];
        // }
        // return [
        //     'status' => 'failed'
        // ];
    }
}
