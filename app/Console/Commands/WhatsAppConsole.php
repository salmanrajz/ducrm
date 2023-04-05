<?php

namespace App\Console\Commands;

use App\Models\WhatsAppScan;
use Illuminate\Console\Command;

class WhatsAppConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'WhatsAppConsole';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CommandHelptoUtalizeWhatsApp';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
        // return 0;
        // ini_set('memory_limit', '1024M'); // or you could use 1G
        // // ini_set('max_execution_time', '30000'); //300 seconds = 5 minutes
        // //
        // $numberstart = WhatsAppScan::orderBy('id', 'desc')->where('prefix','54')->first();
        // if (!$numberstart) {
        //     $numberstart = 971541000000;
        // } else {
        //     $numberstart = $numberstart->wapnumber;
        // }
        // if ($numberstart === 971549999999 || $numberstart > 971549999999) {
        //     return "Game Over";
        // }
        // // $end = $numberstart + 5;
        // $end = $numberstart + 1000000;
        // // for ($v = $numberstart; $v <= '971583999999'; $v++) {
        // for ($v = $numberstart; $v <= $end; $v++) {
        //     // for($i='971581000000';$i<= '971581001000';$i++){
        //     //     // return $i;
        //     //     // echo $i . '</br>';
        //     //     // $d=
        //     //         if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
        //     //             $d = WhatsAppScan::create([
        //     //                 'wapnumber' => $i,
        //     //             ]);
        //     //         }
        //     // }
        //     // $regex = “\\b([a-zA-Z0-9])\\1\\1+\\b”;
        //     // for($i='971581000000';$i<= '971581002000';$i++){
        //     // \Log::info($i);
        //     if (preg_match('/(.)\\1{6}/', $v)) {
        //         $data[] = [
        //             'start' => '0',
        //             'end' => '0',
        //             'wapnumber' => $v,
        //             'count_digit' => 7,
        //             'prefix' => '54',
        //         ];
        //     } elseif (preg_match('/(.)\\1{5}/', $v)) {
        //         // echo '###' . $i . '<br> => 5 Times Number';
        //         $data[] = [
        //             'start' => '0',
        //             'end' => '0',
        //             'wapnumber' => $v,
        //             'count_digit' => 6,
        //             'prefix' => '54',
        //         ];
        //     } elseif (preg_match('/(.)\\1{4}/', $v)) {
        //         // echo '###' . $i . '<br> => 5 Times Number';
        //         $data[] = [
        //             'start' => '0',
        //             'end' => '0',
        //             'wapnumber' => $v,
        //             'count_digit' => 5,
        //             'prefix' => '54',

        //         ];
        //     } else if (preg_match('/(.)\\1{3}/', $v)) {
        //         // echo '###' . $i . '<br> => 4 Times Number';
        //         $data[] = [
        //             'start' => '0',
        //             'end' => '0',
        //             'wapnumber' => $v,
        //             'count_digit' => 4,
        //             'prefix' => '54',

        //         ];
        //     } else if (preg_match('/(.)\\1{2}/', $v)) {
        //         // echo '###' . $i . '<br> => 3 Times Number';
        //         $data[] = [
        //             'start' => '0',
        //             'end' => '0',
        //             'wapnumber' => $v,
        //             'count_digit' => 3,
        //             'prefix' => '54',

        //         ];
        //     } else if (preg_match('/(.)\\1{1}/', $v)) {
        //         // echo '###' . $i . '<br> => 2 Times Number';
        //         $data[] = [
        //             'start' => '0',
        //             'end' => '0',
        //             'wapnumber' => $v,
        //             'count_digit' => 2,
        //             'prefix' => '54',

        //         ];
        //     }
        //     // else if (preg_match('/(.)\\1{1}/', $i)) {
        //     //     // echo '###' . $i . '<br> => 2 Times Number';
        //     //     if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
        //     //         $d = WhatsAppScan::create([
        //     //             'wapnumber' => $i,
        //     //         ]);
        //     //     }
        //     // }
        //     else {
        //         // echo $i . ' => <br>' . '=> No 3 Times';
        //         $data[] = [
        //             'start' => '0',
        //             'end' => '0',
        //             'wapnumber' => $v,
        //             'count_digit' => 'random',
        //             'prefix' => '54',
        //         ];
        //     }
        // }
        // $chunks = array_chunk($data, 5000);
        // foreach ($chunks as $chunk) {
        //     WhatsAppScan::query()->insert($chunk);
        // }
        // $numberstart = WhatsAppScan::orderBy('id', 'desc')->first()->wapnumber;
        // if(!$numberstart){
        //     $numberstart = 971581000000;
        // }
        // return $numberstart;
        // $numberstart = WhatsAppScan::orderBy('id', 'desc')->first();
        // if (!$numberstart) {
        //     $numberstart = 971581000000;
        // } else {
        //     $numberstart = $numberstart->wapnumber;
        // }
        // if($numberstart === 971581999999){
        //     return "Game Over";
        // }
        // // $end = $numberstart + 5;
        // $end = $numberstart + 10000;
        // // for ($i = $numberstart; $i <= '971581999999'; $i++) {
        // for ($i = $numberstart; $i <= $end; $i++) {
        //     // for($i='971581000000';$i<= '971581001000';$i++){
        //     //     // return $i;
        //     //     // echo $i . '</br>';
        //     //     // $d=
        //     //         if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
        //     //             $d = WhatsAppScan::create([
        //     //                 'wapnumber' => $i,
        //     //             ]);
        //     //         }
        //     // }
        //     // $regex = “\\b([a-zA-Z0-9])\\1\\1+\\b”;
        //     // for($i='971581000000';$i<= '971581002000';$i++){
        //     // \Log::info($i);
        //     if (preg_match('/(.)\\1{6}/', $i)) {
        //         // echo '###' . $i . '<br> => 5 Times Number';
        //         if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
        //             $d = WhatsAppScan::create([
        //                 'wapnumber' => $i,
        //                 'count_digit' => '7',
        //             ]);
        //         }
        //     } elseif (preg_match('/(.)\\1{5}/', $i)) {
        //         // echo '###' . $i . '<br> => 5 Times Number';
        //         if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
        //             $d = WhatsAppScan::create([
        //                 'wapnumber' => $i,
        //                 'count_digit' => '6',

        //             ]);
        //         }
        //     } elseif (preg_match('/(.)\\1{4}/', $i)) {
        //         // echo '###' . $i . '<br> => 5 Times Number';
        //         if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
        //             $d = WhatsAppScan::create([
        //                 'wapnumber' => $i,
        //                 'count_digit' => '5',

        //             ]);
        //         }
        //     } else if (preg_match('/(.)\\1{3}/', $i)) {
        //         // echo '###' . $i . '<br> => 4 Times Number';
        //         if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
        //             $d = WhatsAppScan::create([
        //                 'wapnumber' => $i,
        //                 'count_digit' => '4',

        //             ]);
        //         }
        //     } else if (preg_match('/(.)\\1{2}/', $i)) {
        //         // echo '###' . $i . '<br> => 3 Times Number';
        //         if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
        //             $d = WhatsAppScan::create([
        //                 'wapnumber' => $i,
        //                 'count_digit' => '3',

        //             ]);
        //         }
        //     } else if (preg_match('/(.)\\1{1}/', $i)) {
        //         // echo '###' . $i . '<br> => 2 Times Number';
        //         if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
        //             $d = WhatsAppScan::create([
        //                 'wapnumber' => $i,
        //                 'count_digit' => '2',

        //             ]);
        //         }
        //     }
        //     // else if (preg_match('/(.)\\1{1}/', $i)) {
        //     //     // echo '###' . $i . '<br> => 2 Times Number';
        //     //     if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
        //     //         $d = WhatsAppScan::create([
        //     //             'wapnumber' => $i,
        //     //         ]);
        //     //     }
        //     // }
        //     else {
        //         // echo $i . ' => <br>' . '=> No 3 Times';
        //         if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
        //             $d = WhatsAppScan::create([
        //                 'wapnumber' => $i,
        //                 'count_digit' => 'random',

        //             ]);
        //         }
        //     }
        // }
    }
}
