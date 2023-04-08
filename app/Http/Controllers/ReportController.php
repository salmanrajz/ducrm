<?php

namespace App\Http\Controllers;

use App\Exports\ActivationSheet;
use App\Exports\P2PTracker;
use App\Models\call_center;
use App\Models\lead_sale;
use App\Models\main_data_manager_assigner;
use App\Models\main_data_user_assigner;
use App\Models\MissionDU;
use App\Models\product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
    //
    public function tlcard(Request $request){
        $breadcrumbs = [
            [
                'link' => "/", 'name' => "Home"
            ], ['link' => "javascript:void(0)", 'name' => "Main Daily | Monthly Report"]
        ];
        // $cc = call_center::where('status', 1)->get();
        $numberOfAgent = \App\Models\User::where('role', 'TeamLeader')->get();
        return view('admin.report.tl-card', compact('breadcrumbs', 'numberOfAgent'));

    }
    // /
    public function tlreport(Request $request){
        //
        // return "s";
        $pageConfigs = ['pageHeader' => false];
        $product = product::where('status', 1)->get();
        $numberOfAgent = \App\Models\User::where('teamleader',$request->id)->where('role', 'Sale')->get();
        $tlid = $request->id;
        return view('/content/dashboard/tlreport', ['pageConfigs' => $pageConfigs, 'product' => $product, 'numberOfAgent' => $numberOfAgent, 'tlid'=> $tlid]);
        //
    }
    //
    public function mainreport(Request $request){
        // return $request;
        $breadcrumbs = [
            [
                'link' => "/", 'name' => "Home"
            ], ['link' => "javascript:void(0)", 'name' => "Main Daily | Monthly Report"]
        ];
        $cc = call_center::where('status',1)->get();
        return view('admin.report.view-main-report', compact('breadcrumbs','cc'));

    }

    public function ActivationSheet(Request $request){
        // return\
        ob_end_clean();

        return Excel::download(new ActivationSheet, 'p2p_mnp_activation.xlsx');
    }
    //
    public function AllActivationSheet(Request $request){
        // return\
        ob_end_clean();

        return Excel::download(new P2PTracker, 'p2p_mnp_activation.xlsx');
    }
    //
    public function TestNumber(Request $request){

        // return "Chala ja BSDK";
        // $ManagerID = User::select('id')->whereIn('users.role', ['FloorManager'])
        // ->where('agent_code', 'CC3')
        // // ->where('email','')
        // ->first();
        // $checker  = main_data_manager_assigner::select('main_data_manager_assigners.number_id', 'main_data_user_assigners.status', 'main_data_manager_assigners.id')
        // ->Join(
        //     'main_data_user_assigners',
        //     'main_data_user_assigners.number_id',
        //     'main_data_manager_assigners.number_id'
        // )
        // ->Join(
        //     'users','users.id','main_data_user_assigners.user_id'
        // )
        // ->whereNull('main_data_user_assigners.status')
        // ->where('users.agent_code', 'CL1')
        // // ->whereIn('users.email', ['abdulwasay@cl1.com','zunaif@cl1.com', 'umair-saleem@cl1.com','sumera@cl1.com','asad@cl1.com','asadbaig@cl1.com','saad-ahmed@cl1.com', 'saraateeq@cl1.com', 'Farajahmed@CL1.com'])
        // // ->whereIn('users.email', ['uzair@cl1.com'])
        // ->get();
        // // $checker = main_data_manager_assigner::where('manager_id',$ManagerID->id)->whereNull('main_data_manager_assigners.status')->limit(1000)->get();
        // foreach ($checker as $k) {
        //     // $kk = WhatsAppMnpBank::where('id',$k->number_id)->first();
        //     $kkk = main_data_manager_assigner::where('id', $k->id)->first();
        //     // if($kk){
        //     //     $kk->is_status = 0;
        //     //     $kk->save();
        //     //     // $kk->delete();
        //     //     // $kk->is_status = NULL;
        //     // }
        //     if ($kkk) {
        //         $kkk->status = 3;
        //         $kkk->save();
        //     }
        //     $zk = main_data_user_assigner::where('number_id', $k->number_id)->whereNull('main_data_user_assigners.status')->first();
        //     if ($zk) {
        //         $zk->delete();
        //     }
        // }
        // return "Abdullah -  Reset";

        //         ini_set('max_execution_time', '3000'); //300 seconds = 5 minutes


        //         // <?php
        //         $data = 971581000000;
        //         $numberstart = MissionDU::orderBy('id', 'desc')->first();
        //         if (!$numberstart) {
        //             $numberstart = 971581000000;
        //         } else {
        //             $numberstart = $numberstart->last_num;
        //         }

        //         $end = $numberstart + 30;

        //         // $data = '971581000199,971581000200,971581000201,971581000202,971581000203,971581000204,971581000205,971581000206,971581000207,971581000208,971581000209,971581000210,971581000211,971581000212,971581000213,971581000214,971581000215,971581000216,971581000217,971581000218,971581000219,971581000220,971581000221,971581000222,971581000223,971581000224,971581000225,971581000226,971581000227,971581000228,971581000229,971581000230,971581000231,971581000232,971581000233,971581000234,971581000235,971581000236,971581000237,971581000238,971581000239,971581000240,971581000241,971581000242,971581000243,971581000244,971581000245,971581000246,971581000247';
        //         // $data = '971581000199,971581000200,971581000201,971581000202';

        // for ($d = $numberstart; $d <= $end; $d++) {
        // // foreach (explode(',', $data) as $d) {
        //     $curl = curl_init();

        //     curl_setopt_array($curl, array(
        //       CURLOPT_URL => 'https://myaccount.du.ae/servlet/ContentServer?pagename=MA_QuickPayRedirect&d=front&MSISDN='.$d.'&rechargeType=7&requestType=customerInfo&msisdnSource='.$d,
        //       CURLOPT_RETURNTRANSFER => true,
        //       CURLOPT_ENCODING => '',
        //       CURLOPT_MAXREDIRS => 10,
        //       CURLOPT_TIMEOUT => 0,
        //       CURLOPT_FOLLOWLOCATION => true,
        //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //       CURLOPT_CUSTOMREQUEST => 'POST',
        //       CURLOPT_HTTPHEADER => array(
        //         'Cookie: JSESSIONID="ENCAAAAAAXw+17ntYcaVfKUEnDkZnSLafaRTMNbNGVVuq4M1L6ZwfQLmhdGBj1iztYlVbBmdKUZwytPw6dWdKqC1NOM5zCQKOhjzCpW9mJl4ZtxWsrkpnc3bJkAXrzNOGqWkYEcp6AYVj45n6777eNBWlFXoHbO"; NSC_TFMGDBSF_TTM_443="ENCAAAAAAXp/fP8xKGonvjBYM11MVPwUVIRK3Qw+7Q1v2TWaWVKgeXFwitqXxC9VEbS/75HCeemX9GTmJmM0UJcVq5Mq6vBfclFdtDGFzDvVFuIqxhXIs6E/bjmjD9U9xcLmEaDYj+KkA8tzQY+/e50fsmPyxcQ"'
        //       ),
        //     ));

        //     $response = curl_exec($curl);
        //     curl_close($curl);
        //     $c[]['number'] = $d;
        //     $b[] = json_decode($response, true); //here the json string is decoded and returned as associative array
        //     // return $b[][1];
        //     $array = array_merge($b, $c);

        //     // $my =  $b[0];
        //     // $object = json_decode($response);
        //     // $object->role = 'Admin';
        //     // $b = json_encode($response);

        //     // $fl = $b['code'];
        //     // if($fl != '400'){
        //     // echo $response . '<br>';
        //     // if($b['PrePaid'] == 'true'){
        //     //     echo $d . '- PREPAID';
        //     // }
        //     // echo $b['customerType'] . '-' . $b['PrePaid']
        //     // }
        // }
        // return $array;
        // return "DUUDUDUUDUDUDUDU";
        // $yesterday = date("Y-m-d", strtotime('-1 days'));

        $data = User::whereIn('email', ['fozia@cl1.com'])->get();
        foreach($data as $d2){
             $zp = main_data_user_assigner::where('status','Not Interested')
            //  $zp = main_data_user_assigner::whereNull('status')
                // ->whereDate('updated_at', Carbon::yesterday())
                // ->whereBetween(
                //     'updated_at',
                //     [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                // )

            ->whereMonth('created_at', Carbon::now()->month)
            ->OrderBy('id','desc')->get();
            foreach($zp as $zp2){
                 $zp3 = main_data_manager_assigner::where('number_id',$zp2->number_id)->OrderBy('id', 'asc')->first();
                 if($zp3){
                    $zp3->status = NULL;
                    $zp3->save();
                 }
                //
                $zp2 = main_data_user_assigner::where('id',$zp2->id)->first();
                if($zp2){
                    $zp2->delete();
                }

            }
            // $zp->delete();
        }
        return "Zoom";

        $duplicates = \DB::table('main_data_user_assigners')
            ->select('id','status', 'number_id', \DB::raw('COUNT(*) as `count`'))
            ->groupBy('number_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();
        foreach($duplicates as $dd){
            $dz = main_data_user_assigner::whereNull('status')->where('number_id',$dd->number_id)->first();
            if($dz){
                $dz->delete();
            }
        }

        return "kuch nahi hga mat kr try";
        // $data = main_data_user_assigner::all();
        // $data = main_data_user_assigner::select('name',)
        // foreach($data as $d){
            // $z = main_data_user_assigner::whereNull('status')->where('id',$data->id)->first();
        // }
    }
    //
    public function TestWhatsApp(Request $request){
    {
            $token = env('FACEBOOK_TOKEN');

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v14.0/100519382920865/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                "messaging_product": "whatsapp",
                "recipient_type": "individual",
                "to": "923121337222",
                "type": "interactive",
                "interactive":{
                "type": "button",
                "header": {
                    "type": "text",
                    "text": "HOME WIFI PLUS PROMO"
                },
                "body": {
                    "text": "*Home Wireless Plus* \nActual Price Aed ~399~ \nPROMO OFFER AED 199 + VAT Per Month \n12 MONTHS CONTRACT \nUNLIMITED 5G Data \nWith 5G ROUTER"
                },
                "footer": {
                    "text": "AUTHORIZED DU CHANNEL PARTNER VOCUS DEMO"
                },
                "action": {
                    "buttons": [
                        {
                        "type": "reply",
                        "reply": {
                            "id": "un1",
                            "title": "Interested"
                        }
                        },
                        {
                        "type": "reply",
                        "reply": {
                            "id": "un2",
                            "title": "Not Interested"
                        }
                        }
                    ]
                    }
                }
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
    }
    }
}
