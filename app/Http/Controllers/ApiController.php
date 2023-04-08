<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppScan;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function WhatsApiHint(Request $request)
    {
        // return $request;
        $status = $request->status;
        $number = $request->number;
        //
        // $number = preg_replace('/@s.whatsapp.net/', '', $number);
        //
        $dt = WhatsAppScan::where('id', trim($number))->where('is_whatsapp', 0)->update(['is_whatsapp' => $status]);
        // if($dt){
        //     $dt->is_whatsapp = $status;
        //     $dt->save();
        // }
        // return "Done";
    }
}
