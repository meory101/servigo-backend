<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Http\Request;

class attachmentController extends Controller
{
    public function getAttach($docid){
        $att = new Attachment();
        $att =$att->where('documentid' ,$docid)->first();
        if($att){
          
             return $att;
            
        }
        else{
            return null;
        }
    }
}
