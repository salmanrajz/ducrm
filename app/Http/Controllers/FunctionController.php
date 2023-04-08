<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
// ImageAnn
use AhmadMayahi\Vision\Vision;
use AhmadMayahi\Vision\Config;
use App\Models\lead_sale;
use App\Models\WhatsAppScan;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;




class FunctionController extends Controller
{
    //
    // public function userwise_target(R)
    public static function userwise_target($id, $month,$wise)
    {
        // return $month;
        return $active = lead_sale::select('lead_sales.id')
        ->LeftJoin(
            'users',
            'users.id',
            'lead_sales.saler_id'
        )
            ->whereIn('lead_sales.status', ['1.02'])
            // ->where('lead_sales.lead_type', $status)
            // ->whereIn('lead_sales.channel_type', ['TTF','ExpressDial','MWH','Ideacorp'])
            ->where('users.id', $id)
            ->when($wise, function ($query) use ($wise, $month) {
                if ($wise == 'daily') {
                    $query->whereDate('lead_sales.updated_at', Carbon::today());
                    // ->whereYear('lead_sales.created_at', Carbon::now()->year)
                } else {
                    $query->whereMonth('lead_sales.updated_at', Carbon::now()->month)
                            ->whereYear('lead_sales.created_at', Carbon::now()->year);
                    // return $query->where('users.agent_code', $id);
                }
            })
            ->get()
            ->count();
        // ->whereIn('lead_sales.channel_type', ['TTF','ExpressDial','MWH','Ideacorp'])
        // ->whereBetween('date_time', [$today->startOfMonth(), $today->endOfMonth])
        // ->where('users.id', $id)
    }
    //
    public static function userwise_targetBatch($ld,$id, $month,$wise)
    {
        // return $id;
        return $active = lead_sale::select('lead_sales.id')
        ->LeftJoin(
            'users',
            'users.id',
            'lead_sales.saler_id'
        )
            ->whereIn('lead_sales.status', ['1.02'])
            ->where('lead_sales.lead_type',$ld)
            // ->where('lead_sales.lead_type', $status)
            // ->whereIn('lead_sales.channel_type', ['TTF','ExpressDial','MWH','Ideacorp'])
            ->where('users.id', $id)
            ->when($wise, function ($query) use ($wise, $month) {
            if ($wise == 'daily') {
                $query->whereDate('lead_sales.updated_at', Carbon::today());
                // ->whereYear('lead_sales.created_at', Carbon::now()->year)
            } else {
                $query->whereMonth('lead_sales.updated_at', Carbon::now()->month)
                    ->whereYear('lead_sales.created_at', Carbon::now()->year);
                // return $query->where('users.agent_code', $id);
            }
            })
            // ->whereMonth('lead_sales.updated_at', $month)
            // ->whereYear('lead_sales.created_at', Carbon::now()->year)
            ->get()
            ->count();
        // ->whereIn('lead_sales.channel_type', ['TTF','ExpressDial','MWH','Ideacorp'])
        // ->whereBetween('date_time', [$today->startOfMonth(), $today->endOfMonth])
        // ->where('users.id', $id)
    }
    //
    public static function TLVeri($id,$month,$status){
        return $active = lead_sale::select('lead_sales.id')
            ->LeftJoin(
                'users',
                'users.id',
                'lead_sales.saler_id'
            )
            ->whereIn('lead_sales.status', ['1.05','1.08','1.11'])
            // ->where('lead_sales.lead_type', $status)
            // ->whereIn('lead_sales.channel_type', ['TTF','ExpressDial','MWH','Ideacorp'])
            ->where('users.id', $id)
            ->whereDate('lead_sales.updated_at', $month)
            // ->whereYear('lead_sales.created_at', Carbon::now()->year)
            ->get()
            ->count();
    }
    //
    public static function inprocesslead($id, $month,$status)
    {
        // return $id;
        return $active = lead_sale::select('lead_sales.id')
        ->LeftJoin(
            'users',
            'users.id',
            'lead_sales.saler_id'
        )
            ->whereIn('lead_sales.status', [$status])
            // ->where('lead_sales.lead_type', $status)
            // ->whereIn('lead_sales.channel_type', ['TTF','ExpressDial','MWH','Ideacorp'])
            ->where('users.id', $id)
            ->whereMonth('lead_sales.updated_at', $month)
            ->whereYear('lead_sales.created_at', Carbon::now()->year)
            ->get()
            ->count();
        // ->whereIn('lead_sales.channel_type', ['TTF','ExpressDial','MWH','Ideacorp'])
        // ->whereBetween('date_time', [$today->startOfMonth(), $today->endOfMonth])
        // ->where('users.id', $id)
    }
    //
    public static function cctotal($id, $month,$wise)
    {
        // return $id;
        return $active = lead_sale::select('lead_sales.id')
        ->LeftJoin(
            'users',
            'users.id',
            'lead_sales.saler_id'
        )
            ->whereIn('lead_sales.status', ['1.02'])
            // ->where('lead_sales.lead_type', $status)
            // ->whereIn('lead_sales.channel_type', ['TTF','ExpressDial','MWH','Ideacorp'])
            ->where('users.agent_code', $id)
            ->when($wise, function ($query) use ($wise, $month) {
            if ($wise == 'daily') {
                $query->whereDate('lead_sales.updated_at', Carbon::today());
                // ->whereYear('lead_sales.created_at', Carbon::now()->year)
            } else {
                $query->whereMonth('lead_sales.updated_at', Carbon::now()->month)
                    ->whereYear('lead_sales.created_at', Carbon::now()->year);
                // return $query->where('users.agent_code', $id);
            }
            })
            // ->whereMonth('lead_sales.updated_at', $month)
            // ->whereYear('lead_sales.created_at', Carbon::now()->year)
            ->get()
            ->count();
        // ->whereIn('lead_sales.channel_type', ['TTF','ExpressDial','MWH','Ideacorp'])
        // ->whereBetween('date_time', [$today->startOfMonth(), $today->endOfMonth])
        // ->where('users.id', $id)
    }
    public static function cctotaltl($id, $month,$wise)
    {
        // return $id;
        return $active = lead_sale::select('lead_sales.id')
        ->LeftJoin(
            'users',
            'users.id',
            'lead_sales.saler_id'
        )
            ->whereIn('lead_sales.status', ['1.02'])
            // ->where('lead_sales.lead_type', $status)
            // ->whereIn('lead_sales.channel_type', ['TTF','ExpressDial','MWH','Ideacorp'])
            ->where('users.teamleader', $id)
            ->when($wise, function ($query) use ($wise, $month) {
            if ($wise == 'daily') {
                $query->whereDate('lead_sales.updated_at', Carbon::today());
                // ->whereYear('lead_sales.created_at', Carbon::now()->year)
            } else {
                $query->whereMonth('lead_sales.updated_at', Carbon::now()->month)
                    ->whereYear('lead_sales.created_at', Carbon::now()->year);
                // return $query->where('users.agent_code', $id);
            }
            })
            // ->whereMonth('lead_sales.updated_at', $month)
            // ->whereYear('lead_sales.created_at', Carbon::now()->year)
            ->get()
            ->count();
        // ->whereIn('lead_sales.channel_type', ['TTF','ExpressDial','MWH','Ideacorp'])
        // ->whereBetween('date_time', [$today->startOfMonth(), $today->endOfMonth])
        // ->where('users.id', $id)
    }
    //
    public static function DNCWhatsApp($details)
    {
        // return $details;
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
                    "text": "*DNC Number* \n'.$details['dnc_number'].'"
                },
                "footer": {
                    "text": "Vocus Authorized Channel Partner of DU"
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
        $response;

        // return "zoom";
        return back()->with('success', 'Add successfully.');
        // return redirect(route('add.dnc.number.agent'));
    }
    // /
    //
    public static function SendWhatsApp($details){
        // Instantiate the WhatsAppCloudApi super class.
        //
        $token = env('FACEBOOK_TOKEN');
        // $details['']

        // return $details['lead_no'];
        // if($details['agent_code'] == 'CC1'){
        //     $number = '923460854541,923487602506';
        // }
        // elseif($details['agent_code'] == 'CC2'){
        //     $number = '917827250250';
        // }
        // elseif($details['agent_code'] == 'CC4'){
        //     $number = '923102939111,923121337222';
        // }
        // elseif($details['agent_code'] == 'CC5'){
        //     $number = '923333135199,971503658599';
        // }
        // elseif($details['agent_code'] == 'CC6'){
        //     $number = '923058874773,923121337222';
        // }
        // elseif($details['agent_code'] == 'CC7'){
        //     $number = '923453627686,923121337222';
        // }
        // elseif($details['agent_code'] == 'CC8'){
        //     $number = '923352920757,971503658599';
        // }
        // elseif($details['agent_code'] == 'CC9'){
        //     $number = '97143032128';
        //     // $number = '923121337222';
        // }else{
        //     $number = '923121337222';
        // }
        foreach (explode(',', $details['number']) as $nm) {


            //

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
        "to": "' . $nm . '",
        "type": "template",
        "template": {
            "name": "lead_update",
            "language": {
                "code": "en_US"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "' . $details['lead_no'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['customer_name'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['customer_number'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['sim_type'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['plan'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['remarks_final'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['link'] . '"
                        }

                    ]
                }
            ]
        }
        }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
        }
        //

    }
    //
    //
    public static function SendWhatsAppVerification($details){
        // Instantiate the WhatsAppCloudApi super class.
        //
        $token = env('FACEBOOK_TOKEN');
        // $details['']

        // return $details['lead_no'];
        // if($details['agent_code'] == 'CC1'){
        //     $number = '923460854541,923487602506';
        // }
        // elseif($details['agent_code'] == 'CC2'){
        //     $number = '917827250250';
        // }
        // elseif($details['agent_code'] == 'CC4'){
        //     $number = '923102939111,923121337222';
        // }
        // elseif($details['agent_code'] == 'CC5'){
        //     $number = '923333135199,971503658599';
        // }
        // elseif($details['agent_code'] == 'CC6'){
        //     $number = '923058874773,923121337222';
        // }
        // elseif($details['agent_code'] == 'CC7'){
        //     $number = '923453627686,923121337222';
        // }
        // elseif($details['agent_code'] == 'CC8'){
        //     $number = '923352920757,971503658599';
        // }
        // elseif($details['agent_code'] == 'CC9'){
        //     $number = '97143032128';
        //     // $number = '923121337222';
        // }else{
        //     $number = '923121337222';
        // }
        foreach (explode(',', $details['number']) as $nm) {


            //

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
        "to": "' . $nm . '",
        "type": "template",
        "template": {
            "name": "new_lead_for_verification",
            "language": {
                "code": "en_US"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "' . $details['lead_no'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['customer_name'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['customer_number'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['sim_type'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['plan'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['remarks_final'] . '"
                        }
                    ]
                }
            ]
        }
        }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
        }
        //

    }
    //
    //
    public static function SendActiveWhatsApp($details){
        // Instantiate the WhatsAppCloudApi super class.
        //
        $token = env('FACEBOOK_TOKEN');
        // $details['']


        foreach (explode(',', $details['number']) as $nm) {


            //

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
        "to": "' . $nm . '",
        "type": "template",
        "template": {
            "name": "active_du",
            "language": {
                "code": "en_US"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "' . $details['lead_no'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['customer_name'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['customer_number'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['sim_type'] . '"
                        },
                    ]
                }
            ]
        }
        }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
        }
        //

    }
    //
    //
    public static function SendMNPWhatsApp($details){
        // Instantiate the WhatsAppCloudApi super class.
        //
        $token = env('FACEBOOK_TOKEN');
        // $details['']


        foreach (explode(',', $details['number']) as $nm) {


            //

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
        "to": "' . $nm . '",
        "type": "template",
        "template": {
            "name": "mnp_proceed",
            "language": {
                "code": "en_US"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "' . $details['lead_no'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['customer_name'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['customer_number'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['sim_type'] . '"
                        },
                    ]
                }
            ]
        }
        }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
        }
        //

    }
    //
    //
    public static function SendWhatsAppDesigner($details){
        // Instantiate the WhatsAppCloudApi super class.
        //
        $token = env('FACEBOOK_TOKEN');
        // $details['']


        foreach (explode(',', $details['number']) as $nm) {


            //

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
        "to": "' . $nm . '",
        "type": "template",
        "template": {
            "name": "notifications_for_designer",
            "language": {
                "code": "en_US"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "' . $details['customer_name'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['customer_number'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['emirate_id'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['nationality'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['emirate'] . '"
                        }
                    ]
                }
            ]
        }
        }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
        }
        //

    }
    //
    public function ocr_name_new(Request $request)
    {
        $config = (new Config())
            // Required: path to your google service account.
            ->setCredentials('js/google-vision.json');

            // Optional: defaults to `sys_get_temp_dir()`
            // ->setTempDirPath('/my/tmp');
        // return env('GOOGLE_APPLICATION_CREDENTIALS');

         $response = Vision::init($config)
            ->file('images/emirate-id/emirate-id.jpeg')
            ->imageTextDetection()
            ->plain();


        if ($response) {
            $response->locale; // locale, for example "en"
             $response->text;   // Image text
            // return
            $string = preg_replace('/\s+/', ' ', $response->text) . '<br>';
            $regex2 = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';
            $regex = '/^784-[0-9]{4}-[0-9]{7}-[0-9]{1}$/';
            $regexJs = '#\\{Name:\\}(.+)\\{/المتحدة\\}#s';
            // dd($string);
            // if (preg_match($regexJs, $string, $matches)) {
            //                 // print_r($matches);
            // }
            // $data[]
            $data =array();
            foreach (explode(' ', $string) as $id) {
                preg_match($regex, $id, $matches);
                // echo $id . '<br>';

                // if match, show VALID
                if (count($matches) == 1) {
                    // echo '###'."{$id}";
                    $data['emirate_id'] = $id;
                } else {
                    // echo "{$id} INVALID</br>";
                }
            }
            //
            if (preg_match('/Issuing Date(.*?)تاريخ/', $string, $match) == 1) {
                // echo '###' . $match[1] . '<br>';
                // $data['dates'] = trim($match[1]);
                $dbx = explode(' ', trim($match[1]));
                $data['dob'] = trim($dbx[0]);
                $data['expiry'] = trim($dbx[1]);

            }
            if (preg_match('/Name:(.*?)Date/', $string, $match) == 1) {
                // echo '###' . $match[1] . '<br>';
                $data['name'] = $match[1];

            }
            return $data['name'] . '###' . $data['emirate_id'] . '###' . $data['expiry'] . '###' . $data['dob'];
            //     // echo $string = preg_replace("/[^a-zA-Z\s]/", "", $match[1]);
            //     // $re = '/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/';
            //     // $str = '09/08/2026';
            //     // $subst = '';
            //     // echo $string = preg_replace($re, "", $match[1]);
            //     $expiry_date = preg_replace('/[^0-9\s\.\-\/]/', "", $match3[1]);
            //     echo '###' . $replace = str_replace('/4 ', '', $expiry_date);


            //     // $result = preg_replace($re, $subst, $match, 1);

            //     // echo "The result of the substitution is " . $result;
            // } else {
            //     echo "failed";
            // }

        }
        // return $response;
        // try {
        //     $imageAnnotatorClient = new ImageAnnotatorClient();

        //     $image_path = 'https://i3.ytimg.com/vi/oeVPsNBTWqU/hqdefault.jpg';
        //     $imageContent = file_get_contents($image_path);
        //     $response = $imageAnnotatorClient->textDetection($imageContent);
        //     $text = $response->getTextAnnotations();
        //     echo $text[0]->getDescription();

        //     if ($error = $response->getError()) {
        //         print('API Error: ' . $error->getMessage() . PHP_EOL);
        //     }

        //     $imageAnnotatorClient->close();
        // } catch (Exception $e) {
        //     echo $e->getMessage();
        // }
        // if ($file = $request->file('front_img')) {
        //     //convert image to base64
        //     $image = base64_encode(file_get_contents($request->file('front_img')));
        //     $image2 = file_get_contents($request->file('front_img'));
        //     // AzureCodeStart
        //     $originalFileName = time() . $file->getClientOriginalName();
        //     $multi_filePath = 'documents' . '/' . $originalFileName;
        //     \Storage::disk('azure')->put($multi_filePath, $image2);
        //     // AzureCodeEnd
        //     //prepare request
        //     $mytime = Carbon::now();
        //     $ext =  $mytime->toDateTimeString();
        //     // $name = $ext . '-' . $file->getClientOriginalName();
        //     $name = $originalFileName;
        //     // $file->move('documents', $name);
        //     Session::put('front_image', $name);
        //     //to put the session value

        //     $request = new AnnotateImageRequest();
        //     $request->setImage($image);
        //     $request->setFeature("TEXT_DETECTION");
        //     $gcvRequest = new GoogleCloudVision([$request],  'AIzaSyBMeil9pvJHiW-1nxYU54BKyN9I3xM6aYQ');
        //     //send annotation request
        //     $response = $gcvRequest->annotate();
        //     // dd($response);
        //     $string =  json_encode(["description" => $response->responses[0]->textAnnotations[0]->description]);
        //     // ech
        //     if (!empty($response)) {
        //         $string = $response->responses[0]->textAnnotations[0]->description;
        //         $string = preg_replace('/\s+/', ' ', $string) . '<br>';
        //         $regex2 = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';
        //         $regex = '/^784-[0-9]{4}-[0-9]{7}-[0-9]{1}$/';
        //         $regexJs = '#\\{Name:\\}(.+)\\{/المتحدة\\}#s';
        //         // dd($string);
        //         // foreach (explode(' ', $string) as $id) {
        //         //     // echo $id . '<br>';
        //         //     // if (preg_match_all($regex2, $id, $matches, PREG_PATTERN_ORDER)) {
        //         //     // print_r($matches);
        //         //     // }
        //         //     preg_match($regex2, $id, $matches2);

        //         //     // if match, show VALID
        //         //     if (count($matches2) == 1) {
        //         //         echo '###' . $id;
        //         //     } else {
        //         //         echo "{$id} INVALID</br>";
        //         //     }
        //         // }
        //         // // echo $string['description'];
        //         // if (preg_match('/ame:(.*?)ation/', $string, $match) == 1) {
        //         //     echo '###' . $match[1] . '<br>';
        //         // }

        //         // Emirate ID Fetching Succesfully
        //         foreach (explode(' ', $string) as $id) {
        //             // echo $id . '<br>';
        //             preg_match($regex, $id, $matches);

        //             // // if match, show VALID
        //             if (count($matches) == 1) {
        //                 // echo "SSS";
        //                 // echo $matches['0'];
        //                 echo '###' . "{$id}";
        //             }
        //             // else {
        //             // echo "{$string} INVALID</br>";
        //             // }
        //         }
        //         // // Emirate ID Fetching End
        //         // //// ZOOOM
        //         // // Name Fetch Done
        //         if (preg_match('/Name:(.*?)المتحدة/', $string, $match) == 1) {
        //             // echo '###' . $match[1] . '<br>';
        //             echo '###' . $string_name = preg_replace("/[^a-zA-Z\s]/", "", $match[1]);
        //         }
        //         // Name Fetch Done END
        //         // Emirate Expiry Done
        //         if (preg_match('/Expiry(.*?)Signature/', $string, $match3) == 1) {
        //             // echo '###' . $match[1] . '<br>';
        //             // echo $string = preg_replace("/[^a-zA-Z\s]/", "", $match[1]);
        //             // $re = '/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/';
        //             // $str = '09/08/2026';
        //             // $subst = '';
        //             // echo $string = preg_replace($re, "", $match[1]);
        //             $expiry_date = preg_replace('/[^0-9\s\.\-\/]/', "", $match3[1]);
        //             echo '###' . $replace = str_replace('/4 ', '', $expiry_date);


        //             // $result = preg_replace($re, $subst, $match, 1);

        //             // echo "The result of the substitution is " . $result;
        //         } else {
        //             echo "failed";
        //         }
        //         // Emirate Expiry  Done END
        //         //// ZOOM END
        //         // foreach (explode(' ', $string) as $id) {
        //         //     // echo $id . '<br>';
        //         //     preg_match($regexJs, $id, $matches);

        //         //     // // if match, show VALID
        //         //     if (count($matches) == 1) {
        //         //         // echo "SSS";
        //         //         // echo $matches['0'];
        //         //         echo '###' . "{$id}";
        //         //     }
        //         //     // else {
        //         //     // echo "{$string} INVALID</br>";
        //         //     // }
        //         // }
        //         echo '###' . "{$name}";
        //     }
        // }
        // return $request;
        // $fileName = time() . '_' . $request->file->getClientOriginalName();
        // if ($file = $request->file('front_img')) {
        //     // $ext = date('d-m-Y-H-i');
        //     $mytime = Carbon::now();
        //     $ext =  $mytime->toDateTimeString();
        //     $name = $ext . '-' . $file->getClientOriginalName();
        //     // $name = Str::slug($name, '-');

        //     // $name1 = $ext . '-' . $file1->getClientOriginalName();
        //     // $name1 = Str::slug($name, '-');

        //     // $name2 = $ext . '-' . $file2->getClientOriginalName();
        //     // $name2 = Str::slug($name, '-');

        //     // $name = str_replace($ext, date('d-m-Y-H-i') . $ext, $request->image->getClientOriginalName());
        //     $file->move('img', $name);
        //     $input['path'] = $name;
        //     $k = (new TesseractOCR('img/'.$name))
        //         // ->digits()
        //         // ->hocr()
        //         // ->quiet()
        //         //
        //         // ->tsv()

        //         // ->pdf()

        //         // ->lang('eng', 'jpn', 'spa')
        //         // ->whitelist(range('A', 'Z'))
        //         // ->whitelist(range(0,9,'-'))
        //         // ->whitelist(range(0,9), '-/@')

        //     ->run();
        //       $string = rtrim($k);
        //      echo $string = preg_replace('/\s+/', ' ', $k);

        //     // echo $l = str_replace(" ","@",$k);
        //     // echo $l['0'];
        //     // echo $k .'<br> ' . 'Sa';
        //     $regex = '/^784-[0-9]{4}-[0-9]{7}-[0-9]{1}$/';
        //     $regex2 = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';
        //     // const str = 'The first sentence. Some second sentence. Third sentence and the names are John, Jane, Jen. Here is the fourth sentence about other stuff.'

        //     // $regexJs = '/Name: ([^.]+)*(\1)/';
        //     $regexJs = '#\\{Name:\\}(.+)\\{/Nationality\\}#s';
        //     // $str = 'United Arab Emirates ay ‘ doa‘Lal Ann Resident Identity Card ID Number / 42 gli a8) 784-1974-6574140-8 Coa) apls URGAS tame aul! Name: Muhammad Kashif Saleem Uddin Nationality: Pakistan ARAELLLLL';
        //     // if (preg_match('/Name:(.*?)Nationality/', $string, $match) == 1) {
        //     if (preg_match('/Name:(.*?)Nation/', $string, $match) == 1) {
        //         echo '###'.$match[1];
        //     }
        //     // if (preg_match('/Nationality(.*?)/', $string, $match) == 1) {
        //     //     echo 'Nationality: ' . $match[1] . '<br>';
        //     // }


        //     foreach (explode(' ', $string) as $id) {
        //         preg_match($regex, $id, $matches);

        //         // if match, show VALID
        //         if (count($matches) == 1) {
        //             echo '###'."{$id}";
        //         } else {
        //             // echo "{$id} INVALID</br>";
        //         }
        //     }
        //     // foreach (explode(' ', $string) as $id) {
        //     //     // echo $id . '<br>';
        //     //     // if (preg_match_all($regex2, $id, $matches, PREG_PATTERN_ORDER)) {
        //     //     // print_r($matches);
        //     //     // }
        //     //     preg_match($regex2, $id, $matches2);

        //     //     // if match, show VALID
        //     //     if (count($matches2) == 1) {
        //     //         echo '###' . $id;
        //     //     } else {
        //     //         // echo "{$id} INVALID</br>";
        //     //     }
        //     // }
        //     // preg_match('#\\{FINDME\\}(.+)\\{/FINDME\\}#s', $out, $matches);
        //     // //
        //     //             if(preg_match($regexJs, $string, $matches)){
        //     //                 print_r($matches);
        //     //             }
        //     // if (preg_match("/Name:\s(.*)\Nationality/", $string, $matches1)) {
        //     //     // echo $matches1[1] . "<br />";
        //     //                     print_r($matches);
        //     // }
        //     // $code = preg_quote($string);
        //     //     $k = "United Arab Emirates ay ‘ doa‘Lal Ann Resident Identity Card ID Number / 42 gli a8) 784-1974-6574140-8 Coa) apls URGAS tame aul! Name: Muhammad Kashif Saleem Uddin Nationality: Pakistan ARAELLLLLMuhammad Kashif Saleem Uddin";
        //     // if (preg_match("/Name:\s(.*)\sNationality/",$string,$matches1)) {
        //     //     echo $matches1[1] . "<br />";
        //     //                     print_r($matches1);
        //     //                     echo "1";
        //     // }
        //     // return preg_match('/Name:\s(.*)/', $string);


        //     // $startsAt = strpos($string, "{Name:}") + strlen("{Nationality}");
        //     // $endsAt = strpos($string, "{/Nationality}", $startsAt);
        //     // $result = substr($string, $startsAt, $endsAt - $startsAt);

        //     // names = str.match(regex)[1],
        //     //     array = names.split(/,\s*/)

        //     // console.log(array)
        //     // $pattern = '#(?:\G(?!\A)|Name:(?:\s+F)?)\s*\K[\w.]+#';
        //     // // print_r($matches);
        //     // // $txt = "calculated F 15 513 153135 155 125 156 155";
        //     // $txt = "calculated F 15 16 United Arab Emirates ay ‘ doa‘Lal Ann Resident Identity Card ID Number: / 42 gli a8) 784-1974-6574140-8 Coa) apls URGAS tame aul! Name: Muhammad Kashif Saleem Uddin Nationality: Pakistan ARAELLLLL";
        //     // echo preg_match_all("/(?:\bName\b|\G(?!^))[^:]*:\K./", $txt, $matches);
        //     // print_r($matches);
        //     // foreach(explode('@', $string) as $info)
        //     // {
        //     // // $str = "http://www.youtube.com/ytscreeningroom?v=NRHVzbJVx8I";
        //     // foreach (explode('@', $string) as $id) {
        //     //     // echo $id;
        //     //     // $pattern = '#(?:\G(?!\A)|Name:(?:\s+F)?)\s*\K[\w.]+#';
        //     //     // preg_match($pattern, $id, $matches);
        //     //     // print_r($matches);

        //     // }
        //     //     // $string = "SALMAN";
        //     //     // preg_match("/^[a-zA-Z-'\s]+$/", $value);

        //     //     // $rexSafety = "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i";
        //     //     // $rexSafety = "/^[^<,\"@/{}()*$%?=>:|;#]*$/i";
        //     //     if (preg_match('#(?:\G(?!\A)|salmanahmed(?:\s+F)?)\s*\K[\w.]+', $id)) {
        //     //         // var_dump('bad name');
        //     //         echo $id . '<br>';
        //     //     } else {
        //     //         // var_dump('ok');
        //     //     }
        //     // }

        //     //
        // }
        // return $fileName = time() . '.' . $request->file->extension();
        // return view('number.vision');
        // echo (new TesseractOCR('mixed-languages.png'))
        // ->lang('eng', 'jpn', 'spa')
        // ->run();
        // echo (new TesseractOCR('img/text.png'))
        // ->lang('eng', 'jpn', 'spa')
        // ->run();
        // $ocr = new TesseractOCR();
        // $ocr->image('img/text.png');
        // $ocr->run();
        // return "s";
        // echo $ocr;
        // return $ocr;
        // return IdentityDocuments::parse($request);
    }
    //
    public static function PendingVerification($status){
        //Verify
        // return $status;
        return $data = lead_sale::select('lead_sales.id')
        ->when($status, function ($q) use ($status) {
            if ($status == 'Verify') {
                return $q->whereIn('lead_sales.status', ['1.02','1.13','1.19','1.08']);
            } else {
                return $q->where('lead_sales.status', $status);
            }
        })
        // ->where('lead_sales.saler_id',auth()->user()->id)
        ->get()->count();
    }
    //
    public static function PendingVerificationActivator($status,$product){
        //Verify
        // return $product;
        return $data = lead_sale::select('lead_sales.id')
        // ->where('lead_sales.lead_type',$product)
        ->when($product, function ($q) use ($product) {
            if ($product == 'Postpaid') {
                return $q->whereIn('lead_sales.lead_type', ['P2P','MNP']);
            } else {
                return $q->where('lead_sales.lead_type', $product);
            }
        })
        ->when($status, function ($q) use ($status) {
            if ($status == 'Verify') {
                return $q->whereIn('lead_sales.status', ['1.02','1.13','1.19','1.08']);
            } else {
                return $q->where('lead_sales.status', $status);
            }
        })
        // ->where('lead_sales.saler_id',auth()->user()->id)
        ->get()->count();
    }
    public static function DailyActivationCount($status, $agent_code,$lead_type,$day){
        if ($lead_type == 'HomeWifi5g199') {
            // return "199";
            return $data = lead_sale::where('lead_sales.status', $status)
                ->Join(
                    'users',
                    'users.id',
                    'lead_sales.saler_id'
                )
                ->Join(
                    'home_wifi_plans',
                    'home_wifi_plans.id',
                    'lead_sales.plans'
                )
                ->when($agent_code, function ($q) use ($agent_code) {
                    if ($agent_code == 'All') {
                    } else {
                        return $q->where('users.agent_code', $agent_code);
                    }
                })

                ->when($day, function ($q) use ($day) {
                    if ($day == 'Daily') {
                        return $q->whereDate('lead_sales.updated_at', Carbon::today())
                            ->whereYear('lead_sales.updated_at', Carbon::now()->year);
                        // return $q->where('numberdetails.identity', 'EidSpecial');
                    } elseif ($day == 'Monthly') {
                        return $q->whereMonth('lead_sales.updated_at', Carbon::now()->month)
                            ->whereYear('lead_sales.updated_at', Carbon::now()->year);
                    }
                })
                ->where('home_wifi_plans.id', 1)
                ->get()->count();
        } elseif ($lead_type == 'HomeWifi5g') {
            return $data = lead_sale::where('lead_sales.status', $status)
                ->Join(
                    'users',
                    'users.id',
                    'lead_sales.saler_id'
                )
                ->Join(
                    'home_wifi_plans',
                    'home_wifi_plans.id',
                    'lead_sales.plans'
                )
                ->when($agent_code, function ($q) use ($agent_code) {
                    if ($agent_code == 'All') {
                    } else {
                        return $q->where('users.agent_code', $agent_code);
                    }
                })

                ->when($day, function ($q) use ($day) {
                    if ($day == 'Daily') {
                        return $q->whereDate('lead_sales.updated_at', Carbon::today())
                            ->whereYear('lead_sales.updated_at', Carbon::now()->year);
                        // return $q->where('numberdetails.identity', 'EidSpecial');
                    } elseif ($day == 'Monthly') {
                        return $q->whereMonth('lead_sales.updated_at', Carbon::now()->month)
                            ->whereYear('lead_sales.updated_at', Carbon::now()->year);
                    }
                })
                ->where('home_wifi_plans.id', 2)
                ->get()->count();
        } elseif ($lead_type == 'HomeWifiUpgrade') {
            return $data = lead_sale::where('lead_sales.status', $status)
                ->Join(
                    'users',
                    'users.id',
                    'lead_sales.saler_id'
                )
                ->Join(
                    'home_wifi_plans',
                    'home_wifi_plans.id',
                    'lead_sales.plans'
                )
                ->when($agent_code, function ($q) use ($agent_code) {
                    if ($agent_code == 'All') {
                    } else {
                        return $q->where('users.agent_code', $agent_code);
                    }
                })

                ->when($day, function ($q) use ($day) {
                    if ($day == 'Daily') {
                        return $q->whereDate('lead_sales.updated_at', Carbon::today())
                            ->whereYear('lead_sales.updated_at', Carbon::now()->year);
                        // return $q->where('numberdetails.identity', 'EidSpecial');
                    } elseif ($day == 'Monthly') {
                        return $q->whereMonth('lead_sales.updated_at', Carbon::now()->month)
                            ->whereYear('lead_sales.updated_at', Carbon::now()->year);
                    }
                })
                ->where('home_wifi_plans.id', 3)
                ->get()->count();
        }
        else{

        return $data = lead_sale::where('activation_forms.status',$status)
        ->Join(
            'activation_forms',
            'activation_forms.lead_id','lead_sales.id'
        )
        ->Join(
            'users','users.id','lead_sales.saler_id'
        )
        ->where('lead_sales.lead_type', $lead_type)
            // ->where('users.agent_code',$agent_code)
            ->when($agent_code, function ($q) use ($agent_code) {
                if ($agent_code == 'All') {
                } else {
                    return $q->where('users.agent_code', $agent_code);
                }
            })
        ->when($day, function ($q) use ($day) {
            if ($day == 'Daily') {
                return $q->whereDate('activation_forms.created_at', Carbon::today())
                ->whereYear('activation_forms.created_at', Carbon::now()->year);
                // return $q->where('numberdetails.identity', 'EidSpecial');
            } elseif ($day == 'Monthly') {
                return $q->whereMonth('activation_forms.created_at', Carbon::now()->month)
                ->whereYear('activation_forms.created_at', Carbon::now()->year);
            }
        })
        ->get()->count();
        }

    }
    //
    //
    public static function DailyPoint($status, $agent_code, $lead_type, $day)
    {

 $hw = lead_sale::select(
            'home_wifi_plans.revenue_points'
        )
        // ->where('activation_forms.status', $status)
        // ->Join(
        //     'activation_forms',
        //     'activation_forms.lead_id',
        //     'lead_sales.id'
        // )
            ->Join(
                'users',
                'users.id',
                'lead_sales.saler_id'
            )
            ->Join(
                'home_wifi_plans',
            'home_wifi_plans.id',
                'lead_sales.plans'
            )
            // ->where('plans.revenue')
            ->where('lead_sales.lead_type', 'HomeWifi')
            ->where('lead_sales.status','1.02')
            // ->where('users.agent_code',$agent_code)
            ->when($agent_code, function ($q) use ($agent_code) {
                if ($agent_code == 'All') {
                } else {
                    return $q->where('users.agent_code', $agent_code);
                }
            })
            ->when($day, function ($q) use ($day) {
                if ($day == 'Daily') {
                    return $q->whereDate('lead_sales.created_at', Carbon::today())
                        ->whereYear('lead_sales.created_at', Carbon::now()->year);
                    // return $q->where('numberdetails.identity', 'EidSpecial');
                } elseif ($day == 'Monthly') {
                    return $q->whereMonth('lead_sales.updated_at', Carbon::now()->month)
                        ->whereYear('lead_sales.updated_at', Carbon::now()->year);
                }
            })
            // ->get()->count();
            ->sum('home_wifi_plans.revenue_points');

        $p2p = lead_sale::select(
            'plans.revenue'
        )->where('activation_forms.status', $status)
        ->Join(
            'activation_forms',
            'activation_forms.lead_id',
            'lead_sales.id'
        )
        ->Join(
            'users',
            'users.id',
            'lead_sales.saler_id'
        )
        ->Join(
            'plans','plans.id','lead_sales.plans'
        )
        // ->where('plans.revenue')
        ->where('lead_sales.lead_type', 'P2P')
        // ->where('users.agent_code',$agent_code)
        ->when($agent_code, function ($q) use ($agent_code) {
            if ($agent_code == 'All') {
            } else {
                return $q->where('users.agent_code', $agent_code);
            }
        })
            ->when($day, function ($q) use ($day) {
                if ($day == 'Daily') {
                    return $q->whereDate('activation_forms.created_at', Carbon::today())
                        ->whereYear('activation_forms.created_at', Carbon::now()->year);
                    // return $q->where('numberdetails.identity', 'EidSpecial');
                } elseif ($day == 'Monthly') {
                    return $q->whereMonth('activation_forms.created_at', Carbon::now()->month)
                        ->whereYear('activation_forms.created_at', Carbon::now()->year);
                }
            })
            ->sum('plans.revenue');
        $mnp = lead_sale::select('plans.revenue_port')->where('activation_forms.status', $status)
        ->Join(
            'activation_forms',
            'activation_forms.lead_id',
            'lead_sales.id'
        )
        ->Join(
            'users',
            'users.id',
            'lead_sales.saler_id'
        )
        ->Join(
            'plans','plans.id','lead_sales.plans'
        )
        // ->where('plans.revenue')
        ->where('lead_sales.lead_type', 'MNP')
        // ->where('users.agent_code',$agent_code)
        ->when($agent_code, function ($q) use ($agent_code) {
            if ($agent_code == 'All') {
            } else {
                return $q->where('users.agent_code', $agent_code);
            }
        })
            ->when($day, function ($q) use ($day) {
                if ($day == 'Daily') {
                    return $q->whereDate('activation_forms.created_at', Carbon::today())
                        ->whereYear('activation_forms.created_at', Carbon::now()->year);
                    // return $q->where('numberdetails.identity', 'EidSpecial');
                } elseif ($day == 'Monthly') {
                    return $q->whereMonth('activation_forms.created_at', Carbon::now()->month)
                        ->whereYear('activation_forms.created_at', Carbon::now()->year);
                }
            })
            // ->get()->count();
            // return "ZZ";
            ->sum('plans.revenue_port');
            return $p2p + $mnp + $hw;
    }
    //
    public static function DailyLeadProcessCount($status, $agent_code,$lead_type,$day){
        // return "98"

        if($lead_type == 'HomeWifi5g199'){
            // return "199";
            return $data = lead_sale::where('lead_sales.status', $status)
                ->Join(
                    'users',
                    'users.id',
                    'lead_sales.saler_id'
                )
                        ->Join(
                            'home_wifi_plans',
                            'home_wifi_plans.id',
                            'lead_sales.plans'
                        )
                ->when($agent_code, function ($q) use ($agent_code) {
                    if ($agent_code == 'All') {
                    } else {
                        return $q->where('users.agent_code', $agent_code);
                    }
                })

                ->when($day, function ($q) use ($day) {
                    if ($day == 'Daily') {
                        return $q->whereDate('lead_sales.created_at', Carbon::today())
                            ->whereYear('lead_sales.created_at', Carbon::now()->year);
                        // return $q->where('numberdetails.identity', 'EidSpecial');
                    } elseif ($day == 'Monthly') {
                        return $q->whereMonth('lead_sales.created_at', Carbon::now()->month)
                            ->whereYear('lead_sales.created_at', Carbon::now()->year);
                    }
                })
                ->where('home_wifi_plans.id', 1)
                ->get()->count();
        }elseif($lead_type == 'HomeWifi5g'){
            return $data = lead_sale::where('lead_sales.status', $status)
            ->Join(
                'users',
                'users.id',
                'lead_sales.saler_id'
            )
                ->Join(
                    'home_wifi_plans',
                    'home_wifi_plans.id',
                    'lead_sales.plans'
                )
                ->when($agent_code, function ($q) use ($agent_code) {
                    if ($agent_code == 'All') {
                    } else {
                        return $q->where('users.agent_code', $agent_code);
                    }
                })

                ->when($day, function ($q) use ($day) {
                    if ($day == 'Daily') {
                        return $q->whereDate('lead_sales.created_at', Carbon::today())
                            ->whereYear('lead_sales.created_at', Carbon::now()->year);
                        // return $q->where('numberdetails.identity', 'EidSpecial');
                    } elseif ($day == 'Monthly') {
                        return $q->whereMonth('lead_sales.created_at', Carbon::now()->month)
                            ->whereYear('lead_sales.created_at', Carbon::now()->year);
                    }
                })
                ->where('home_wifi_plans.id', 2)
                ->get()->count();
        }elseif($lead_type == 'HomeWifiUpgrade'){
            return $data = lead_sale::where('lead_sales.status', $status)
            ->Join(
                'users',
                'users.id',
                'lead_sales.saler_id'
            )
                ->Join(
                    'home_wifi_plans',
                    'home_wifi_plans.id',
                    'lead_sales.plans'
                )
                ->when($agent_code, function ($q) use ($agent_code) {
                    if ($agent_code == 'All') {
                    } else {
                        return $q->where('users.agent_code', $agent_code);
                    }
                })

                ->when($day, function ($q) use ($day) {
                    if ($day == 'Daily') {
                        return $q->whereDate('lead_sales.created_at', Carbon::today())
                            ->whereYear('lead_sales.created_at', Carbon::now()->year);
                        // return $q->where('numberdetails.identity', 'EidSpecial');
                    } elseif ($day == 'Monthly') {
                        return $q->whereMonth('lead_sales.created_at', Carbon::now()->month)
                            ->whereYear('lead_sales.created_at', Carbon::now()->year);
                    }
                })
                ->where('home_wifi_plans.id', 3)
                ->get()->count();
        }else{
            return $data = lead_sale::where('lead_sales.status', $status)
                ->Join(
                    'users',
                    'users.id',
                    'lead_sales.saler_id'
                )
                ->where('lead_sales.lead_type', $lead_type)
                // ->where('users.agent_code', $agent_code)


                ->when($agent_code, function ($q) use ($agent_code) {
                    if ($agent_code == 'All') {
                    } else {
                        return $q->where('users.agent_code', $agent_code);
                    }
                })
                ->when($day, function ($q) use ($day) {
                    if ($day == 'Daily') {
                        return $q->whereDate('lead_sales.created_at', Carbon::today())
                            ->whereYear('lead_sales.created_at', Carbon::now()->year);
                        // return $q->where('numberdetails.identity', 'EidSpecial');
                    } elseif ($day == 'Monthly') {
                        return $q->whereMonth('lead_sales.created_at', Carbon::now()->month)
                            ->whereYear('lead_sales.created_at', Carbon::now()->year);
                    }
                })
                ->get()->count();
        }

    }
    public static function PendingSaleAgent($status,$name){
        return $data = lead_sale::select('id')
            // ->when($name, function($q) use ())
            ->when($name, function ($q) use ($name) {
                if ($name == 'P2P') {
                    return $q->whereIn('lead_sales.lead_type', ['P2P']);
                    // return $q->where('numberdetails.identity', 'EidSpecial');
                }
                else if ($name == 'MNP') {
                    return $q->whereIn('lead_sales.lead_type', ['MNP']);
                    // return $q->where('numberdetails.identity', 'EidSpecial');
                }
                else{
                    return $q->whereIn('lead_sales.lead_type', ['HomeWifi']);
                }
            })
            ->when($status, function ($q) use ($status) {
                if ($status == '1.01') {
                    return $q->whereIn('lead_sales.status', ['1.01','1.19','1.13']);
                    // return $q->where('numberdetails.identity', 'EidSpecial');
                }
                else{
                    return $q->where('lead_sales.status', $status);
                }
            })
            -> where('lead_sales.saler_id', auth()->user()->id)

        // ->where('lead_sales.lead_type',$name)
        ->get()->count();
    }
    public static function InProcessSaleAgent($status,$name){
        return $data = lead_sale::select('id')
            // ->when($name, function($q) use ())
            ->when($name, function ($q) use ($name) {
                if ($name == 'P2P') {
                    return $q->whereIn('lead_sales.lead_type', ['P2P']);
                    // return $q->where('numberdetails.identity', 'EidSpecial');
                }
                else if ($name == 'MNP') {
                    return $q->whereIn('lead_sales.lead_type', ['MNP']);
                    // return $q->where('numberdetails.identity', 'EidSpecial');
                }
                else{
                    return $q->whereIn('lead_sales.lead_type', ['HomeWifi']);
                }
            })
            ->when($status, function ($q) use ($status) {
                if ($status == '1.01') {
                    return $q->whereIn('lead_sales.status', ['1.01','1.19','1.13']);
                    // return $q->where('numberdetails.identity', 'EidSpecial');
                }
            })
        -> where('lead_sales.saler_id', auth()->user()->id)

        // ->where('lead_sales.lead_type',$name)
        ->get()->count();
    }
    //
    public static function SendWhatsAppDocs($details)
    {
        $token = env('FACEBOOK_TOKEN');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v14.0/112632378357432/messages',
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
                "type": "document",
                "document": {
                    "link": "https://prts-mppolice.nic.in/e-Courses/Content%20of%20English%20Typing.pdf",
                    "caption": "' . $details['lead_no'] . '\nCustomer Name: ' . $details['customer_name'] . '\n' . '\nFind Attachment ☝️ : ' . '\nUrl: ' . $details['link'] . '"
                    }
                }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response;
    }
    //
    public function ScanWhatsApp(Request $request)
    {
        // $key = '971522221220';
        //
        //  $duplicates =\DB::table('whats_app_scans') // replace table by the table name where you want to search for duplicated values
        // ->select('id', 'wapnumber') // name is the column name with duplicated values
        //     ->whereIn('wapnumber', function ($q) {
        //         $q->select('wapnumber')
        //         ->from('whats_app_scans')
        //         ->groupBy('wapnumber')
        //         ->havingRaw('COUNT(*) > 1');
        //     })
        //     ->orderBy('wapnumber')
        //     ->orderBy('id') // keep smaller id (older), to keep biggest id (younger) replace with this ->orderBy('id', 'desc')
        //     ->get();
        // // //
        // $value = "";

        // // loop throuht results and keep first duplicated value
        // foreach ($duplicates as $duplicate) {
        //     if ($duplicate->wapnumber === $value) {
        //         \DB::table('whats_app_scans')->where('id', $duplicate->id)->delete(); // comment out this line the first time to check what will be deleted and keeped
        //         echo "$duplicate->wapnumber with id $duplicate->id deleted! \n";
        //     } else
        //     echo "$duplicate->wapnumber with id $duplicate->id keeped \n";
        //     $value = $duplicate->wapnumber;
        // }
        // return "Mission Complete";

        //
        $da = WhatsAppScan::select('id', 'wapnumber')->where('count_digit', '=', 2)
        // ->OrWhere('count_digit', 'random')
        ->where('is_whatsapp', 0)
        ->limit(1000)->get();
        foreach ($da as $d) {

            $data[] = array(

                'receiver' => trim($d->wapnumber),
                'message' => $d->id,
                // 'status' => $d->is_whatsapp

            );
        }
       $data_string = json_encode($data);
        // // // $data = '923121337222,923442708646';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://20.84.63.80:4000/chats/TestBulkTest?id=DXB',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data_string,
            // CURLOPT_POSTFIELDS =>'[
            //     {
            //         "receiver": "923121337222",
            //         "message": "Hi bro, how are you?"
            //     },
            //     {
            //         "receiver": "9234227086461",
            //         "message": "I\'m fine, thank you."
            //     }
            // ]',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $b = json_decode($response, true); //here the json string is decoded and returned as associative array
        // return $b;
        $not_available = $b['data']['not_available'];
        $available = $b['data']['available'];
        //
        // foreach ($available as $k) {
        //     // return $k;
        //     $an[] = preg_replace('/@s.whatsapp.net/', ',', $k);
        //     //  $z = explode('@',$k);
        //     //  foreach($z as $k){
        //     //      echo $k . '<br>';
        //     //  }
        //     // $l =  preg_replace('/971/', '0', $k, 3);
        // }
        // foreach ($not_available as $nk) {
        //     // return $k;
        //     $nan[] = preg_replace('/@s.whatsapp.net/', ',', $nk);
        //     //  $z = explode('@',$k);
        //     //  foreach($z as $k){
        //     //      echo $k . '<br>';
        //     //  }
        //     // $l =  preg_replace('/971/', '0', $k, 3);
        // }
        // // return $pr;
        // foreach ($an as $p) {
        //     // echo $p . '<br>';
        //     $z = str_replace(',', ' ', $p);
        //     $data = WhatsAppScan::where('wapnumber', '=', $z)->first();
        //     if($data){
        //         $data->is_whatsapp = 1;
        //         $data->save();
        //     }
        // }
        // foreach ($nan as $np) {
        //     // echo $p . '<br>';
        //     $z = str_replace(',', ' ', $np);
        //     $data = WhatsAppScan::where('wapnumber', '=', $z)->first();
        //     if($data){
        //         $data->is_whatsapp = 2;
        //         $data->save();
        //     }
        // }
        return "Clear and OUT";
        return redirect()->route('ScanWhatsApp');
        // return $z;
    }
    //
    //
    public static function SendWhatsAppDailyUpdate($details)
    {
        // Instantiate the WhatsAppCloudApi super class.
        //
        $token = env('FACEBOOK_TOKEN');

        foreach (explode(',', $details['number']) as $nm) {


            //

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
        "to": "' . $nm . '",
        "type": "template",
        "template": {
            "name": "vocus_update",
            "language": {
                "code": "en_US"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "' . $details['date'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['p2p_count'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['wifi_count'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['mnp_count'] . '"
                        },
                    ]
                }
            ]
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
        //

    }
    //
    //
    public static function SendWhatsAppDailyUpdateCCWise($details)
    {
        // Instantiate the WhatsAppCloudApi super class.
        //
        $token = env('FACEBOOK_TOKEN');

        foreach (explode(',', $details['number']) as $nm) {


            //

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
        "to": "' . $nm . '",
        "type": "template",
        "template": {
            "name": "cc_update_daily",
            "language": {
                "code": "en_US"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "' . $details['date'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['p2p_count'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['wifi_count'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['mnp_count'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['cc_name'] . '"
                        },
                    ]
                }
            ]
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
        //

    }
    //
    //
    public static function SendWhatsAppDailyUpdateCCWiseBoss($details)
    {
        // Instantiate the WhatsAppCloudApi super class.
        //
        $token = env('FACEBOOK_TOKEN');

        foreach (explode(',', $details['number']) as $nm) {


            //

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
        "to": "' . $nm . '",
        "type": "template",
        "template": {
            "name": "boss_update_final",
            "language": {
                "code": "en_US"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "' . $details['date'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['cc_name'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['p2p_count_daily'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['wifi_count_daily'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['mnp_count_daily'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['p2p_count_monthly'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['wifi_count_monthly'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['mnp_count_monthly'] . '"
                        },
                    ]
                }
            ]
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
        //

    }
    //
    //
    public static function MissionDU($details)
    {
        // Instantiate the WhatsAppCloudApi super class.
        //
        $token = env('FACEBOOK_TOKEN');

        foreach (explode(',', $details['number']) as $nm) {


            //

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
        "to": "' . $nm . '",
        "type": "template",
        "template": {
            "name": "trackmission",
            "language": {
                "code": "en_US"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "' . $details['data'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['link'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['time'] . '"
                        },

                    ]
                }
            ]
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
        //

    }
    //
    public static function SendWhatsAppTrackingCode($details)
    {
        // Instantiate the WhatsAppCloudApi super class.
        //
        $token = env('FACEBOOK_TOKEN');

        foreach (explode(',', $details['number']) as $nm) {


            //

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
        "to": "' . $nm . '",
        "type": "template",
        "template": {
            "name": "trackingtemp",
            "language": {
                "code": "en_US"
            },
            "components": [
                {
                    "type": "body",
                    "parameters": [
                        {
                            "type": "text",
                            "text": "' . $details['trackingID'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['trackingUrl'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['AgentName'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['CustomerName'] . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $details['LeadNo'] . '"
                        },

                    ]
                }
            ]
        }
        }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response;
        }
        //

    }
    //
}
