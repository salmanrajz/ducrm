<?php

namespace App\Http\Controllers;

use App\Models\country_phone_code;
use App\Models\emirate;
use App\Models\HomeWifiPlan;
use App\Models\lead_sale;
use App\Models\plan;
use App\Models\remark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LeadController extends Controller
{
    //
    public function ViewWifiLead(Request $request){
        $role = auth()->user()->role;

if (auth()->user()->role == 'Verification') {
    $data = lead_sale::select('lead_sales.customer_name', 'lead_sales.id', 'lead_sales.email', 'lead_sales.customer_number', 'status_codes.status_name as status', 'home_wifi_plans.name as plan_name', 'lead_sales.lead_no')
    ->where('lead_type', 'HomeWifi')
    ->Join(
        'home_wifi_plans',
        'home_wifi_plans.id',
        'lead_sales.plans'
    )
    ->Join(
        'status_codes',
        'status_codes.status_code',
        'lead_sales.status'
    )
        ->when($role, function ($q) use ($role) {
            if ($role == 'Sale') {
                return $q->where('lead_sales.saler_id', auth()->user()->id);
            // return $q->where('numberdetails.identity', 'EidSpecial');
            } elseif ($role == 'Verification') {
                return $q->where('lead_sales.status', '1.01');
            }
        })
    ->get();
    $mnp = lead_sale::select('lead_sales.customer_name', 'lead_sales.id', 'lead_sales.email', 'lead_sales.customer_number', 'status_codes.status_name as status', 'plans.plan_name', 'lead_sales.lead_no')
    ->whereIn('lead_type', ['MNP','P2P'])
    // ->where('lead_type','HomeWifi')
    ->Join(
        'plans',
        'plans.id',
        'lead_sales.plans'
    )
    ->Join(
        'status_codes',
        'status_codes.status_code',
        'lead_sales.status'
    )
        ->when($role, function ($q) use ($role) {
            if ($role == 'Sale') {
                return $q->where('lead_sales.saler_id', auth()->user()->id);
            // return $q->where('numberdetails.identity', 'EidSpecial');
            } elseif ($role == 'Verification') {
                return $q->where('lead_sales.status', '1.01');
            }
        })
    ->get();

    // return json_encode($data);
        return view('admin.lead.view-verification-lead', compact('data', 'mnp'));
        }else{
            $data = lead_sale::select('lead_sales.customer_name', 'lead_sales.id', 'lead_sales.email', 'lead_sales.customer_number', 'status_codes.status_name as status', 'home_wifi_plans.name as plan_name', 'lead_sales.lead_no')
            ->where('lead_type', 'HomeWifi')
            ->Join(
                'home_wifi_plans',
                'home_wifi_plans.id',
                'lead_sales.plans'
            )
            ->Join(
                'status_codes',
                'status_codes.status_code',
                'lead_sales.status'
            )
            ->when($role, function ($q) use ($role) {
                if ($role == 'Sale') {
                    return $q->where('lead_sales.saler_id', auth()->user()->id);
                    // return $q->where('numberdetails.identity', 'EidSpecial');
                } elseif ($role == 'Verification') {
                    return $q->where('lead_sales.status', '1.01');
                }
            })
                ->get();
        return view('admin.lead.view-wifi-lead', compact('data'));

        }

    }
    public function ViewMNPLead(Request $request){
        $role = auth()->user()->role;

        $data = lead_sale::select('lead_sales.customer_name','lead_sales.id','lead_sales.email','lead_sales.customer_number','status_codes.status_name as status', 'plans.plan_name','lead_sales.lead_no','lead_sales.lead_type','status_codes.status_name as status_name','lead_sales.status')
        ->Join(
            'plans',
            'plans.id','lead_sales.plans'
        )
        ->Join(
            'status_codes',
            'status_codes.status_code','lead_sales.status'
        )
            ->when($role, function ($q) use ($role) {
                if ($role == 'Sale') {
                    return $q->where('lead_sales.saler_id',auth()->user()->id)
                            ->whereIn('lead_sales.lead_type',['MNP','P2P']);
                    // return $q->where('numberdetails.identity', 'EidSpecial');
                }
                elseif($role == 'Verification'){
                    return $q->where('lead_sales.status', '1.01');
                }
            })
        ->get();

        // return json_encode($data);
        return view('admin.lead.view-postpaid-lead',compact('data'));
    }
    //
    public function ViewLead(Request $request)
    {
        // $role =
        $data = lead_sale::findorfail($request->id);
        $plan = plan::where('status', '1')->get();
        $country = country_phone_code::select('name')->get();
        $emirate = emirate::select('name')->where('status', 1)->get();
        // $plan = \App\Models\plan
        $breadcrumbs = [
            [
                'link' => "/", 'name' => "Home"
            ], ['link' => "javascript:void(0)", 'name' => "New Lead Form"]
        ];

        return view('admin.lead.review-postpaid-lead', compact('data', 'plan', 'country', 'emirate', 'breadcrumbs'));
    }
    public function EditLead(Request $request)
    {
        // $role =
        $data = lead_sale::findorfail($request->id);
        $plan = plan::where('status', '1')->get();
        $country = country_phone_code::select('name')->get();
        $emirate = emirate::select('name')->where('status', 1)->get();
        // $plan = \App\Models\plan
        $breadcrumbs = [
            [
                'link' => "/", 'name' => "Home"
            ], ['link' => "javascript:void(0)", 'name' => "New Lead Form"]
        ];

        return view('admin.lead.edit-postpaid-lead', compact('data', 'plan', 'country', 'emirate', 'breadcrumbs'));
    }
    //
    public function HomeWifiForm(Request $request){
        // return $request;
        $plan = HomeWifiPlan::where('status','1')->get();
        $country = country_phone_code::select('name')->get();
        $emirate = emirate::select('name')->where('status',1)->get();
        // $plan = \App\Models\plan
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Home Wifi Lead Form"]
        ];
        $type = 'Vocus';
        $ptype = 'HomeWifi';
        $last = lead_sale::latest()->first();
        return view('admin.lead.add-wifi-lead',compact('plan','country','emirate','breadcrumbs','type','ptype', 'last'));
    }
    public function MNPForm(Request $request){
        // return $request;
        $plan = plan::where('status','1')->get();
        $country = country_phone_code::select('name')->get();
        $emirate = emirate::select('name')->where('status',1)->get();
        // $plan = \App\Models\plan
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "New Lead Form"]
        ];
        $type = 'Vocus';
        $ptype = 'HomeWifi';
        $last = lead_sale::latest()->first();

        return view('admin.lead.add-mnp-lead',compact('plan','country','emirate','breadcrumbs','type','ptype','last'));
    }
    //
    //
    public function HomeWifiSubmit(Request $request){

        $validatedData = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|string|email',
            'contact_number' => 'required',
            'emirate_id' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'address' => 'required',
            'language' => 'required',
            'emirate' => 'required',
            'remarks' => 'required',
            'plans' => 'required',
            'emirate_expiry' => 'required|date|after:tomorrow',
            'dob' => ['before:20 years ago']
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        // $data = Carbon::
        //
        // return $request->leadnumber;
        $data = lead_sale::create([
            'lead_no' => $request->leadnumber,
            'customer_name' => $request->full_name,
            'email' => $request->email,
            'customer_number' => $request->contact_number,
            'emirate_id' => $request->emirate_id,
            'gender' => $request->gender,
            'nationality' => $request->nationality,
            'address' => $request->address,
            'emirate' => $request->emirate,
            'plans' => $request->plans,
            'language' => $request->language,
            'emirate_expiry' => $request->emirate_expiry,
            'dob' => $request->dob,
            'status' => '1.01',
            'saler_name' => auth()->user()->name,
            'saler_id' => auth()->user()->id,
            'lead_type' => 'HomeWifi',
            'lead_date' => Carbon::now()->toDateTimeString(),
            'remarks' => $request->remarks,
        ]);
        remark::create([
            'remarks' => $request->remarks,
            'lead_status' => '1.01',
            'lead_id' => $data->id,
            'lead_no' => $data->id, 'date_time' => $current_date_time = Carbon::now()->toDateTimeString(), // Produces something like "2019-03-11 12:25:00"
            'user_agent' => 'Sale',
            'user_agent_id' => auth()->user()->id,
        ]);
        //
        $lead = lead_sale::select('lead_sales.id','lead_sales.lead_no','lead_sales.customer_name','lead_sales.customer_number','home_wifi_plans.name as plan_name','lead_sales.saler_name')
        ->Join(
            'home_wifi_plans','home_wifi_plans.id','lead_sales.plans'
        )
        ->where('lead_sales.id',$data->id)->first();
        //
        $link = route('view.lead', $lead->id);
        $details = [
            'lead_id' => $lead->id,
            'lead_no' => $lead->lead_no,
            'customer_name' => $lead->customer_name,
            'customer_number' => $lead->customer_number,
            'selected_number' => 'HomeWifi' .' '. $lead->plan_name,
            'remarks' => $request->remarks . ' ' . ' Remarks By ' . auth()->user()->name . ' (' .  auth()->user()->email . ')',
            'remarks_final' => $request->remarks . ' ' . ' Remarks By ' . auth()->user()->name . ' (' .  auth()->user()->email . ')' . ' => Agent Name: ' . $lead->saler_name,
            'saler_name' => $lead->saler_name,
            'link' => $link,
            'agent_code' => auth()->user()->agent_code,
            'number' => 923121337222,
            // 'Plan' => $number,
            // 'AlternativeNumber' => $alternativeNumber,
        ];
        return FunctionController::SendWhatsApp($details);


        //
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);

    }
    //
    public function LeadSubmitVerification(Request $request){

        $validatedData = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|string|email',
            'contact_number' => 'required',
            'emirate_id' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'address' => 'required',
            'language' => 'required',
            'emirate' => 'required',
            'remarks' => 'required',
            'plans' => 'required',
            'front_id' => 'required',
            'back_id' => 'required',
            'additional_docs_name' => 'required',
            'additional_docs_photo' => 'required',
            'lead_type' => 'required',
            'emirate_expiry' => 'required|date|after:tomorrow',
            'dob' => ['before:20 years ago']
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        // return "s";
        // $data = Carbon::
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
            return response()->json(['error' => ['Documents' => ['there is an issue in Front ID, Contact Team Leader']]], 200);
            // $cnic_front =  $request->cnic_front_old;
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
            return response()->json(['error' => ['Documents' => ['there is an issue in Additional Docs, Contact Team Leader']]], 200);
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
            return response()->json(['error' => ['Documents' => ['there is an issue in Back ID, Contact Team Leader']]], 200);
            // $back_id = $request->cnic_back_old;
        }
        //
        // return $request->leadnumber;
        $data = lead_sale::create([
            'lead_no' => $request->leadnumber,
            'customer_name' => $request->full_name,
            'email' => $request->email,
            'customer_number' => $request->contact_number,
            'emirate_id' => $request->emirate_id,
            'gender' => $request->gender,
            'nationality' => $request->nationality,
            'address' => $request->address,
            'emirate' => $request->emirate,
            'plans' => $request->plans,
            'language' => $request->language,
            'emirate_expiry' => $request->emirate_expiry,
            'dob' => $request->dob,
            'status' => '1.01',
            'saler_name' => auth()->user()->name,
            'saler_id' => auth()->user()->id,
            'lead_type' => $request->lead_type,
            'lead_date' => Carbon::now()->toDateTimeString(),
            'remarks' => $request->remarks,
            'front_id' => $front_id,
            'back_id' => $back_id,
            'additional_docs_photo' => $additional_docs_photo,
            'additional_docs_name' => $request->additional_docs_name,
        ]);
        remark::create([
            'remarks' => $request->remarks,
            'lead_status' => '1.01',
            'lead_id' => $data->id,
            'lead_no' => $data->id, 'date_time' => $current_date_time = Carbon::now()->toDateTimeString(), // Produces something like "2019-03-11 12:25:00"
            'user_agent' => 'Sale',
            'user_agent_id' => auth()->user()->id,
        ]);
        //
        $lead = lead_sale::select('lead_sales.id','lead_sales.lead_no','lead_sales.customer_name','lead_sales.customer_number','home_wifi_plans.name as plan_name','lead_sales.saler_name','lead_sales.lead_type')
        ->Join(
            'home_wifi_plans','home_wifi_plans.id','lead_sales.plans'
        )
        ->where('lead_sales.id',$data->id)->first();
        //
        $link = route('view.lead', $lead->id);
        $details = [
            'lead_id' => $lead->id,
            'lead_no' => $lead->lead_no,
            'customer_name' => $lead->customer_name,
            'customer_number' => $lead->customer_number,
            'selected_number' => $lead->lead_type .' '. $lead->plan_name,
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
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);

    }
    //
    //
    public function ReLeadSubmitVerification(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|string|email',
            'contact_number' => 'required',
            'emirate_id' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'address' => 'required',
            'language' => 'required',
            'emirate' => 'required',
            'remarks' => 'required',
            'plans' => 'required',
            // 'front_id' => 'required',
            // 'back_id' => 'required',
            'additional_docs_name' => 'required',
            // 'additional_docs_photo' => 'required',
            'lead_type' => 'required',
            'emirate_expiry' => 'required|date|after:tomorrow',
            'dob' => ['before:20 years ago']
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        // return "s";
        // $data = Carbon::
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
            $front_id = $request->old_front_id;
            // return response()->json(['error' => ['Documents' => ['there is an issue in Front ID, Contact Team Leader']]], 200);
            // $cnic_front =  $request->cnic_front_old;
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
        //
        // return $request->leadnumber;
        $data2 = lead_sale::findorfail($request->lead_id);
        $data2->customer_name = $request->full_name;
        $data2->email = $request->email;
        $data2->customer_number = $request->contact_number;
        $data2->emirate_id = $request->emirate_id;
        $data2->gender = $request->gender;
        $data2->nationality = $request->nationality;
        $data2->address = $request->address;
        $data2->emirate = $request->emirate;
        $data2->plans = $request->plans;
        $data2->language = $request->language;
        $data2->emirate_expiry = $request->emirate_expiry;
        $data2->dob = $request->dob;
        $data2->status = '1.01';
        $data2->remarks = $request->remarks;
        $data2->front_id = $front_id;
        $data2->back_id = $back_id;
        $data2->additional_docs_photo = $additional_docs_photo;
        $data2->additional_docs_name = $request->additional_documents;
        // $data2->verify_agent = auth()->user()->id;
        $data2->save();
        remark::create([
            'remarks' => $request->remarks,
            'lead_status' => '1.01',
            'lead_id' => $data2->id,
            'lead_no' => $data2->id, 'date_time' => $current_date_time = Carbon::now()->toDateTimeString(), // Produces something like "2019-03-11 12:25:00"
            'user_agent' => 'Sale',
            'user_agent_id' => auth()->user()->id,
        ]);
        //
        $lead = lead_sale::select('lead_sales.id', 'lead_sales.lead_no', 'lead_sales.customer_name', 'lead_sales.customer_number', 'plans.plan_name', 'lead_sales.saler_name', 'lead_sales.lead_type')
        ->Join(
            'plans',
            'plans.id',
            'lead_sales.plans'
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
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    //
    public function DesignerVerification(Request $request){

        $validatedData = Validator::make($request->all(), [
            'additional_docs_photo' => 'required',
            'remarks' => 'required',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        // return "s";
        // $data = Carbon::
        //

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
            return response()->json(['error' => ['Documents' => ['there is an issue in Additional Docs, Contact Team Leader']]], 200);
            // $additional_docs_photo =  $request->additional_docs_photo;
        }

        //
        // return $request->leadnumber;
        $data = lead_sale::findorfail($request->leadid);
        $data->additional_docs_photo = $additional_docs_photo;
        $data->status = '1.01';
        $data->save();
        remark::create([
            'remarks' => $request->remarks,
            'lead_status' => '1.01',
            'lead_id' => $data->id,
            'lead_no' => $data->id, 'date_time' => $current_date_time = Carbon::now()->toDateTimeString(), // Produces something like "2019-03-11 12:25:00"
            'user_agent' => 'Sale',
            'user_agent_id' => auth()->user()->id,
        ]);
        //
        $lead = lead_sale::select('lead_sales.id','lead_sales.lead_no','lead_sales.customer_name','lead_sales.customer_number','home_wifi_plans.name as plan_name','lead_sales.saler_name','lead_sales.lead_type')
        ->Join(
            'home_wifi_plans','home_wifi_plans.id','lead_sales.plans'
        )
        ->where('lead_sales.id',$data->id)->first();
        //
        $link = route('view.lead', $lead->id);
        $details = [
            'lead_id' => $lead->id,
            'lead_no' => $lead->lead_no,
            'customer_name' => $lead->customer_name,
            'customer_number' => $lead->customer_number,
            'selected_number' => $lead->lead_type .' '. $lead->plan_name,
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
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);

    }
    // LeadSubmitProceed
    public function LeadSubmitProceed(Request $request){

        $validatedData = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|string|email',
            'contact_number' => 'required',
            'emirate_id' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'address' => 'required',
            'language' => 'required',
            'emirate' => 'required',
            'remarks' => 'required',
            'plans' => 'required',
            'front_id' => 'required',
            'back_id' => 'required',
            'additional_docs_name' => 'required',
            // 'additional_docs_photo' => 'required',
            'lead_type' => 'required',
            'emirate_expiry' => 'required|date|after:tomorrow',
            'dob' => ['before:20 years ago']
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        // return "s";
        // $data = Carbon::
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
            return response()->json(['error' => ['Documents' => ['there is an issue in Front ID, Contact Team Leader']]], 200);
            // $cnic_front =  $request->cnic_front_old;
        }
        // if ($file = $request->file('additional_docs_photo')) {
        //     //convert image to base64
        //     $image = base64_encode(file_get_contents($request->file('additional_docs_photo')));
        //     $image2 = file_get_contents($request->file('additional_docs_photo'));
        //     // AzureCodeStart
        //     $originalFileName = time() . $file->getClientOriginalName();
        //     $multi_filePath = 'documents' . '/' . $originalFileName;
        //     \Storage::disk('azure')->put($multi_filePath, $image2);
        //     // AzureCodeEnd
        //     //prepare request
        //     $mytime = Carbon::now();
        //     $ext =  $mytime->toDateTimeString();
        //     // $name = $ext . '-' . $file->getClientOriginalName();
        //     $additional_docs_photo = $originalFileName;
        //     $file->move('documents', $additional_docs_photo);
        // } else {
        //     return response()->json(['error' => ['Documents' => ['there is an issue in Additional Docs, Contact Team Leader']]], 200);
        //     // $additional_docs_photo =  $request->additional_docs_photo;
        // }
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
            return response()->json(['error' => ['Documents' => ['there is an issue in Back ID, Contact Team Leader']]], 200);
            // $back_id = $request->cnic_back_old;
        }
        //
        // return $request->leadnumber;
        $data = lead_sale::create([
            'lead_no' => $request->leadnumber,
            'customer_name' => $request->full_name,
            'email' => $request->email,
            'customer_number' => $request->contact_number,
            'emirate_id' => $request->emirate_id,
            'gender' => $request->gender,
            'nationality' => $request->nationality,
            'address' => $request->address,
            'emirate' => $request->emirate,
            'plans' => $request->plans,
            'language' => $request->language,
            'emirate_expiry' => $request->emirate_expiry,
            'dob' => $request->dob,
            'status' => '1.13',
            'saler_name' => auth()->user()->name,
            'saler_id' => auth()->user()->id,
            'lead_type' => $request->lead_type,
            'lead_date' => Carbon::now()->toDateTimeString(),
            'remarks' => $request->remarks,
            'front_id' => $front_id,
            'back_id' => $back_id,
            // 'additional_docs_photo' => $additional_docs_photo,
            'additional_docs_name' => $request->additional_docs_name,
        ]);
        remark::create([
            'remarks' => $request->remarks,
            'lead_status' => '1.13',
            'lead_id' => $data->id,
            'lead_no' => $data->id, 'date_time' => $current_date_time = Carbon::now()->toDateTimeString(), // Produces something like "2019-03-11 12:25:00"
            'user_agent' => 'Sale',
            'user_agent_id' => auth()->user()->id,
        ]);
        //
        $lead = lead_sale::select('lead_sales.id','lead_sales.lead_no','lead_sales.customer_name','lead_sales.customer_number', 'plans.plan_name','lead_sales.saler_name','lead_sales.lead_type')
        ->Join(
            'plans','plans.id','lead_sales.plans'
        )
        ->where('lead_sales.id',$data->id)->first();
        //
        $link = route('view.lead', $lead->id);
        $details = [
            'lead_id' => $lead->id,
            'lead_no' => $lead->lead_no,
            'customer_name' => $lead->customer_name,
            'customer_number' => $lead->customer_number,
            'selected_number' => $lead->lead_type .' '. $lead->plan_name,
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
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);

    }
    public function ReLeadSubmitProceed(Request $request){

        $validatedData = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|string|email',
            'contact_number' => 'required',
            'emirate_id' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'address' => 'required',
            'language' => 'required',
            'emirate' => 'required',
            'remarks' => 'required',
            'plans' => 'required',
            // 'front_id' => 'required',
            // 'back_id' => 'required',
            'additional_docs_name' => 'required',
            // 'additional_docs_photo' => 'required',
            'lead_type' => 'required',
            'emirate_expiry' => 'required|date|after:tomorrow',
            'dob' => ['before:20 years ago']
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        // return "s";
        // $data = Carbon::
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
            $front_id = $request->old_front_id;

            // return response()->json(['error' => ['Documents' => ['there is an issue in Front ID, Contact Team Leader']]], 200);
            // $cnic_front =  $request->cnic_front_old;
        }
        // if ($file = $request->file('additional_docs_photo')) {
        //     //convert image to base64
        //     $image = base64_encode(file_get_contents($request->file('additional_docs_photo')));
        //     $image2 = file_get_contents($request->file('additional_docs_photo'));
        //     // AzureCodeStart
        //     $originalFileName = time() . $file->getClientOriginalName();
        //     $multi_filePath = 'documents' . '/' . $originalFileName;
        //     \Storage::disk('azure')->put($multi_filePath, $image2);
        //     // AzureCodeEnd
        //     //prepare request
        //     $mytime = Carbon::now();
        //     $ext =  $mytime->toDateTimeString();
        //     // $name = $ext . '-' . $file->getClientOriginalName();
        //     $additional_docs_photo = $originalFileName;
        //     $file->move('documents', $additional_docs_photo);
        // } else {
        //     return response()->json(['error' => ['Documents' => ['there is an issue in Additional Docs, Contact Team Leader']]], 200);
        //     // $additional_docs_photo =  $request->additional_docs_photo;
        // }
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
        //
        // return $request->leadnumber;
        $data2 = lead_sale::findorfail($request->lead_id);
        $data2->customer_name = $request->full_name;
        $data2->email = $request->email;
        $data2->customer_number = $request->contact_number;
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
        $data2->dob = $request->dob;
        $data2->status = '1.13';
        $data2->remarks = $request->remarks;
        $data2->front_id = $front_id;
        $data2->back_id = $back_id;
        // $data2->additional_docs_photo = $additional_docs_photo;
        $data2->additional_docs_name = $request->additional_docs_name;
        // $data2->verify_agent = auth()->user()->id;
        $data2->save();
        remark::create([
            'remarks' => $request->remarks,
            'lead_status' => '1.13',
            'lead_id' => $data2->id,
            'lead_no' => $data2->id, 'date_time' => $current_date_time = Carbon::now()->toDateTimeString(), // Produces something like "2019-03-11 12:25:00"
            'user_agent' => 'Sale',
            'user_agent_id' => auth()->user()->id,
        ]);
        //
        $lead = lead_sale::select('lead_sales.id','lead_sales.lead_no','lead_sales.customer_name','lead_sales.customer_number', 'plans.plan_name','lead_sales.saler_name','lead_sales.lead_type')
        ->Join(
            'plans','plans.id','lead_sales.plans'
        )
        ->where('lead_sales.id',$data2->id)->first();
        //
        $link = route('view.lead', $lead->id);
        $details = [
            'lead_id' => $lead->id,
            'lead_no' => $lead->lead_no,
            'customer_name' => $lead->customer_name,
            'customer_number' => $lead->customer_number,
            'selected_number' => $lead->lead_type .' '. $lead->plan_name,
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
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);

    }
}
