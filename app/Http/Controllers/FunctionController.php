<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
// ImageAnn
use AhmadMayahi\Vision\Vision;
use AhmadMayahi\Vision\Config;
use App\Models\lead_sale;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;




class FunctionController extends Controller
{
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
        "to": "' . $nm . '",
        "type": "template",
        "template": {
            "name": "lead_update_not",
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
                            "text": "' . $details['selected_number'] . '"
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
        return $data = lead_sale::where('status',$status)->get()->count();
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
            })
        ->where('lead_sales.lead_type',$name)
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
        ->where('lead_sales.lead_type',$name)
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
}
