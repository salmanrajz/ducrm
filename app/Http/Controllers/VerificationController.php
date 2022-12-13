<?php

namespace App\Http\Controllers;

use App\Models\audio_recording;
use App\Models\country_phone_code;
use App\Models\emirate;
use App\Models\HomeWifiPlan;
use App\Models\lead_sale;
use App\Models\plan;
use App\Models\remark;
use App\Models\VerificationForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;


class VerificationController extends Controller
{
    //
    public function VerificationLead(Request $request){
        // return $request->id;
        $operation = lead_sale::findorfail($request->id);
        $emirates = emirate::all();
        $countries = country_phone_code::all();
        $remarks = remark::where('lead_no',$request->id)->get();
        $plan = HomeWifiPlan::where('status',1)->get();
        $mnpplan = plan::where('status',1)->get();
        // $countries = country_phone_code::all();
        return view('admin.verification.manage-operation-lead',compact('operation', 'emirates', 'countries', 'remarks','plan', 'mnpplan'));
    }
    //
    public function verifyLead(Request $request){
        // return $request;

        $validatedData = Validator::make($request->all(), [
            'cname' => 'required|string',
            'email' => 'required|string|email',
            'cnumber' => 'required',
            'emirate_id' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'address' => 'required',
            'language' => 'required',
            'emirate' => 'required',
            'remarks' => 'required',
            'plans' => 'required',
            'refference_id' => 'required',
            'audio' => 'required',
            'emirate_expiry' => 'required|date|after:tomorrow',
            'dob' => ['before:20 years ago']
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        // return "Ok";


        // $data = Carbon::
        //
        // return $request->leadnumber;
        $data = VerificationForm::create([
            'lead_id' => $request->lead_id,
            'lead_no' => $request->lead_no,
            'customer_name' => $request->cname,
            'email' => $request->email,
            'customer_number' => $request->cnumber,
            'emirate_id' => $request->emirate_id,
            'gender' => $request->gender,
            'nationality' => $request->nationality,
            'address' => $request->address,
            'emirate' => $request->emirate,
            'plans' => $request->plans,
            'language' => $request->language,
            'emirate_expiry' => $request->emirate_expiry,
            'dob' => $request->dob,
            'status' => '1.09',
            'saler_name' => auth()->user()->name,
            'saler_id' => auth()->user()->id,
            'lead_type' => 'HomeWifi',
            'lead_date' => Carbon::now()->toDateTimeString(),
            'remarks' => $request->remarks,
            'verify_agent' => auth()->user()->id,
        ]);
        $data2 = lead_sale::findorfail($request->lead_id);
        $data2->customer_name = $request->cname;
        $data2->email = $request->email;
        $data2->customer_number = $request->cnumber;
        $data2->emirate_id = $request->emirate_id;
        $data2->gender = $request->gender;
        $data2->nationality = $request->nationality;
        $data2->address = $request->address;
        $data2->emirate = $request->emirate;
        $data2->plans = $request->plans;
        $data2->language = $request->language;
        $data2->emirate_expiry = $request->emirate_expiry;
        $data2->dob = $request->dob;
        $data2->status = '1.08';
        $data2->remarks = $request->remarks;
        // $data2->verify_agent = auth()->user()->id;
        $data2->save();

        if ($file = $request->file('audio')) {
            // AzureCodeStart
            $image2 = file_get_contents($file);
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'audio' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            // LocalStorageCodeStart
            $ext = date('d-m-Y-H-i');
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $name = $originalFileName;

            $file->move('audio', $name);
            $input['path'] = $name;
            // LocalStorageCodeEnd
        }
        //     $data2 = meeting_std::create([
        //         'meeting_id' => $meeting_id,
        //         'meeting_title' => $request->course_title,
        //         'std_id' => $val,
        //         'status' => 1,
        //     ]);
        // } else {
        //     echo "boom";
        // }
        $data = audio_recording::create([
            // 'resource_name' => $request->resource_name,
            'audio_file' => $name,
            'username' => auth()->user()->name,
            'lead_no' => $request->lead_id,
            // 'teacher_id' => $request->teacher_id,
            'status' => 1,
        ]);

        remark::create([
            'remarks' => $request->remarks,
            'lead_status' => '1.09',
            'lead_id' => $data->id,
            'lead_no' => $data->id, 'date_time' => $current_date_time = Carbon::now()->toDateTimeString(), // Produces something like "2019-03-11 12:25:00"
            'user_agent' => 'Sale',
            'user_agent_id' => auth()->user()->id,
        ]);
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    //
    public function VerifyPostPaidLeads(Request $request){
        // return $request;

        $validatedData = Validator::make($request->all(), [
            'cname' => 'required|string',
            'email' => 'required|string|email',
            'cnumber' => 'required',
            'emirate_id' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'address' => 'required',
            'language' => 'required',
            'emirate' => 'required',
            'remarks' => 'required',
            'plans' => 'required',
            'refference_id' => 'required_if:sim_type,==,MNP',
            'audio' => 'required',
            'additional_documents' => 'required',
            'emirate_expiry' => 'required|date|after:tomorrow',
            'dob' => ['before:20 years ago']
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        // return "Ok";
        $val = $request->lead_id;
        $du_id =  str_pad($val, 4, "0", STR_PAD_LEFT); // 0001
        //
        $name = count(explode(' ',$request->cname));
        if($name > 2){
            $name = explode(' ',$request->cname);
            $name_final = $name[0] . ' ' . $name[1];
        }
        else{
            $name_final = $request->cname;
        }
        $du_final_code = 'VS-' . $du_id .'-'. $request->sim_type . '-' . $name_final;
        //
        if ($file = $request->file('front_id')) {
            //convert image to base64
            $image = base64_encode(file_get_contents($request->file('front_id')));
            $image2 = file_get_contents($request->file('front_id'));
            // AzureCodeStart
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'documents/' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            //prepare request
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $front_id = $originalFileName;
            $file->move('documents', $front_id);
        } else {
            // return response()->json(['error' => ['Documents' => ['there is an issue in Front ID, Contact Team Leader']]], 200);
            $front_id =  $request->old_front_id;
        }
        if ($file = $request->file('additional_docs_photo')) {
            //convert image to base64
            $image = base64_encode(file_get_contents($request->file('additional_docs_photo')));
            $image2 = file_get_contents($request->file('additional_docs_photo'));
            // AzureCodeStart
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'documents' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            //prepare request
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $additional_docs_photo = $originalFileName;
            $file->move('documents', $additional_docs_photo);
        } else {
            $additional_docs_photo = $request->old_additional_docs_name;
            // return response()->json(['error' => ['Documents' => ['there is an issue in Additional Docs, Contact Team Leader']]], 200);
            // $additional_docs_photo =  $request->additional_docs_photo;
        }
        if ($file = $request->file('back_id')) {
            //convert image to base64
            $image = base64_encode(file_get_contents($request->file('back_id')));
            $image2 = file_get_contents($request->file('back_id'));
            // AzureCodeStart
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'documents' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            //prepare request
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $back_id = $originalFileName;
            $file->move('documents', $back_id);
        } else {
            $back_id = $request->old_back_id;

            // return response()->json(['error' => ['Documents' => ['there is an issue in Back ID, Contact Team Leader']]], 200);
            // $back_id = $request->cnic_back_old;
        }
        // $data = Carbon::
        //
        // return $request->leadnumber;
        $data = VerificationForm::create([
            'lead_id' => $request->lead_id,
            'lead_no' => $request->lead_no,
            'customer_name' => $request->cname,
            'email' => $request->email,
            'customer_number' => $request->cnumber,
            'emirate_id' => $request->emirate_id,
            'gender' => $request->gender,
            'nationality' => $request->nationality,
            'address' => $request->address,
            'emirate' => $request->emirate,
            'work_order_num' => $request->work_order_num,
            'reff_id' => $request->refference_id,
            'plans' => $request->plans,
            'language' => $request->language,
            'emirate_expiry' => $request->emirate_expiry,
            // 'dob' => $request->dob,
            'status' => '1.09',
            'saler_name' => auth()->user()->name,
            'saler_id' => auth()->user()->id,
            'lead_type' => 'HomeWifi',
            'lead_date' => Carbon::now()->toDateTimeString(),
            'remarks' => $request->remarks,
            'verify_agent' => auth()->user()->id,
            'front_id' => $front_id,
            'back_id' => $back_id,
            'additional_docs_photo' => $additional_docs_photo,
            'additional_docs_name' => $request->additional_docs_name,
        ]);
        $data2 = lead_sale::findorfail($request->lead_id);
        $data2->customer_name = $request->cname;
        $data2->email = $request->email;
        $data2->customer_number = $request->cnumber;
        $data2->emirate_id = $request->emirate_id;
        $data2->gender = $request->gender;
        $data2->nationality = $request->nationality;
        $data2->address = $request->address;
        $data2->emirate = $request->emirate;
        $data2->work_order_num = $request->work_order_num;
        $data2->reff_id = $request->refference_id;
        $data2->plans = $request->plans;
        $data2->language = $request->language;
        $data2->emirate_expiry = $request->emirate_expiry;
        // $data2->dob = $request->dob;
        $data2->status = '1.08';
        $data2->remarks = $request->remarks;
        $data2->front_id = $front_id;
        $data2->back_id = $back_id;
        $data2->additional_docs_photo = $additional_docs_photo;
        $data2->additional_docs_name = $request->additional_documents;
        $data2->du_lead_no = $du_id;
        // $data2->verify_agent = auth()->user()->id;
        $data2->save();

        if ($file = $request->file('audio')) {
            // AzureCodeStart
            $image2 = file_get_contents($file);
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'audio' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            // LocalStorageCodeStart
            $ext = date('d-m-Y-H-i');
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $name = $originalFileName;

            $file->move('audio', $name);
            $input['path'] = $name;
            // LocalStorageCodeEnd
        }
        //     $data2 = meeting_std::create([
        //         'meeting_id' => $meeting_id,
        //         'meeting_title' => $request->course_title,
        //         'std_id' => $val,
        //         'status' => 1,
        //     ]);
        // } else {
        //     echo "boom";
        // }
        audio_recording::create([
            // 'resource_name' => $request->resource_name,
            'audio_file' => $name,
            'username' => auth()->user()->name,
            'lead_no' => $request->lead_id,
            // 'teacher_id' => $request->teacher_id,
            'status' => 1,
        ]);

        remark::create([
            'remarks' => $request->remarks,
            'lead_status' => '1.09',
            'lead_id' => $data->id,
            'lead_no' => $data->id, 'date_time' => $current_date_time = Carbon::now()->toDateTimeString(), // Produces something like "2019-03-11 12:25:00"
            'user_agent' => 'Sale',
            'user_agent_id' => auth()->user()->id,
        ]);
        //
        $lead = lead_sale::select('lead_sales.id', 'lead_sales.lead_no', 'lead_sales.customer_name', 'lead_sales.customer_number', 'plans.plan_name', 'lead_sales.saler_name', 'lead_sales.lead_type','lead_sales.front_id','lead_sales.back_id', 'lead_sales.additional_docs_photo','lead_sales.nationality','lead_sales.emirate_id','lead_sales.emirate_expiry','lead_sales.email','users.name as agent_name','lead_sales.reff_id','lead_sales.work_order_num','lead_sales.address')
        ->Join(
            'plans',
            'plans.id',
            'lead_sales.plans'
        )
        ->Join(
            'users','users.id','lead_sales.saler_id'
        )
        ->where('lead_sales.id', $data2->id)->first();
        //
        $link = route('view.lead', $lead->id);
        $details = [
            'lead_id' => $lead->id,
            'lead_no' => $lead->lead_no,
            'customer_name' => $lead->customer_name,
            'customer_number' => $lead->customer_number,
            'selected_number' => $lead->lead_type . ' ' . $lead->plan_name,
            'remarks' => $request->remarks . ' ' . ' Remarks By ' . auth()->user()->name . ' (' .  auth()->user()->email . ')',
            'remarks_final' => $request->remarks . ' ' . ' Remarks By ' . auth()->user()->name . ' (' .  auth()->user()->email . ')' . ' => Agent Name: ' . $lead->saler_name,
            'saler_name' => $lead->saler_name,
            'link' => $link,
            'agent_code' => auth()->user()->agent_code,
            'number' => 923121337222,
            // 'Plan' => $number,
            // 'AlternativeNumber' => $alternativeNumber,
        ];
        FunctionController::SendWhatsApp($details);
        //
        $data_for_pdf = [
            'title' => $du_final_code,
            'front' => $lead->front_id,
            'back' => $lead->back_id,
            'lead_id' => $lead->lead_no,
            'reff_id' => $lead->reff_id,
            'work_order_num' => $lead->work_order_num,
            'customer_name' => $lead->customer_name,
            'address' => $lead->address,
            // 'audio' => $app->audio,
            'additional_documents' => $lead->additional_docs_photo,
        ];
        //
        if($lead->lead_type == 'P2P'){
            Mail::send(
                'email.p2p-table',
                compact('data_for_pdf', 'lead'),
                function ($message) use ($data_for_pdf, $lead) {
                    $pdf = PDF::loadView('email.MyPdf', compact('data_for_pdf'));
                    // $pdf2 = PDF::loadView('pdf.AdditionalDocument', compact('additional_documents'));
                    // $message->to(['parhakooo@gmail.com', 'salmanahmed334@gmail.com'])
                    $message->to('parhakooo@gmail.com', 'Parhakooo')
                        ->cc(['salman@vocus.ae'])
                        // ->bcc(['iftekhar@vocus.ae'])
                        // ->cc(['sujatha.chakravarthy@du.ae','leads@callmax.ae', 'anwar@callmax.ae','arif@callmax.ae'])
                        // ->cc(['kashif@callmax.ae', 'isqintl@gmail.com', 'kkashifs@gmail.com', 'device@callmax.ae'])
                        // $message->to('isqintl@gmail.com','Iftekhar Saeed')
                        // ->cc(['sujatha.chakravarthy@du.ae','device@callmax.ae'])
                        ->subject($data_for_pdf['title']);
                    $message->from('sales@vocus.ae', 'Vocus Sales');
                    $message->attachData($pdf->output(), 'leadsdocument.pdf');
            });
        }
        else{
            Mail::send(
                'email.du-table',
                compact('data_for_pdf', 'lead'),
                function ($message) use ($data_for_pdf, $lead) {
                    $pdf = PDF::loadView('email.MyPdf', compact('data_for_pdf'));
                    // $pdf2 = PDF::loadView('pdf.AdditionalDocument', compact('additional_documents'));
                    // $message->to(['parhakooo@gmail.com', 'salmanahmed334@gmail.com'])
                    $message->to('parhakooo@gmail.com', 'Parhakooo')
                        ->cc(['salman@vocus.ae'])
                        // ->bcc(['iftekhar@vocus.ae'])
                        // ->cc(['sujatha.chakravarthy@du.ae','leads@callmax.ae', 'anwar@callmax.ae','arif@callmax.ae'])
                        // ->cc(['kashif@callmax.ae', 'isqintl@gmail.com', 'kkashifs@gmail.com', 'device@callmax.ae'])
                        // $message->to('isqintl@gmail.com','Iftekhar Saeed')
                        // ->cc(['sujatha.chakravarthy@du.ae','device@callmax.ae'])
                    ->subject($data_for_pdf['title']);
                    $message->from('sales@vocus.ae', 'Vocus Sales');
                    $message->attachData($pdf->output(), 'leadsdocument.pdf');
                }
            );
        }

            // $message->attachData($pdf2->output(), 'additionalDocument.pdf');
            // $pdf = PDF::loadView('pdf.myPDF', compact('data_for_pdf','additional_documents'));
            // // $message->to(['parhakooo@gmail.com', 'salmanahmed334@gmail.com'])
            // // ->cc(['kashif@callmax.ae', 'isqintl@gmail.com', 'kkashifs@gmail.com', 'device@callmax.ae'])
            // $message->to('isqintl@gmail.com','Iftekhar Saeed')
            // ->cc(['sujatha.chakravarthy@du.ae','device@callmax.ae'])
            // ->subject($data_for_pdf['lead_id'] . ' ' . $data_for_pdf['customer_name']);
            // $message->from('sales@vocus.ae', 'Callmax Backoffice');
            // $message->attachData($pdf->output(), 'leadsdocument.pdf');
            // $message->to('parhakooo@gmail.com', 'Salman Ahmed')
            // ->cc(['kashif@callmax.ae', 'isqintl@gmail.com', 'kkashifs@gmail.com', 'device@callmax.ae'])
            // // ->subject($data['device_lead_no'] . ' ' . $data['customer_name']);
            // ->subject($data_for_pdf['lead_id'] . ' ' . $data_for_pdf['customer_name']);
            // $message->from('sales@vocus.ae', 'Callmax Backoffice');
            // $message->attachData($pdf->output(), 'devicesdocument.pdf');
        // FunctionController::SendWhatsAppDocs($details);
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    //
    public function RejectLeads(Request $request){
        // return $request;
        $validatedData = Validator::make($request->all(), [
            'remarks' => 'required|string',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        // return
        $data = lead_sale::findorfail($request->lead_id);
        $data->status='1.15';
        $data->remarks=$request->remarks;
        $data->save();
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);

    }
    //
    public function followupleads(Request $request){
        // return $request;
        $validatedData = Validator::make($request->all(), [
            'remarks' => 'required|string',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        // return
        $data = lead_sale::findorfail($request->lead_id);
        $data->status='1.19';
        $data->remarks=$request->remarks;
        $data->save();
        remark::create([
            'remarks' => $request->remarks,
            'lead_status' => 1.19,
            'lead_id' => $data->id,
            'lead_no' => $data->id, 'date_time' => $current_date_time = Carbon::now()->toDateTimeString(), // Produces something like "2019-03-11 12:25:00"
            'user_agent' => 'Sale',
            'user_agent_id' => auth()->user()->id,
        ]);
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);

    }
}
