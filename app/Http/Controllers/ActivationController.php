<?php

namespace App\Http\Controllers;

use App\Models\ActivationForm;
use App\Models\country_phone_code;
use App\Models\emirate;
use App\Models\lead_sale;
use App\Models\plan;
use App\Models\remark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivationController extends Controller
{
    //
    //
    public function inprocesslead(Request $request)
    {
        // $role =
        $breadcrumbs = [
            [
                'link' => "/", 'name' => "Home"
            ], ['link' => "javascript:void(0)", 'name' => "In Process Lead Data"]
        ];
        //
        $data = lead_sale::select('lead_sales.customer_name', 'lead_sales.id', 'lead_sales.email', 'lead_sales.customer_number', 'status_codes.status_name as status', 'plans.plan_name', 'lead_sales.lead_no', 'lead_sales.work_order_num')
            ->whereIn('lead_type', ['MNP', 'P2P'])
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
            ->where('lead_sales.status', '1.08')
            ->get();

        return view('admin.lead.all-activator-lead', compact('data','breadcrumbs'));
    }
    //
    //
    public function inprocessleadhomewifi(Request $request)
    {
        // $role =
        $breadcrumbs = [
            [
                'link' => "/", 'name' => "Home"
            ], ['link' => "javascript:void(0)", 'name' => "In Process Lead Data"]
        ];
        //
        $data = lead_sale::select('lead_sales.customer_name', 'lead_sales.id', 'lead_sales.email', 'lead_sales.customer_number', 'status_codes.status_name as status', 'home_wifi_plans.name as plan_name', 'lead_sales.lead_no','lead_sales.reff_id as work_order_num')
            ->whereIn('lead_type', ['HomeWifi'])
            // ->where('lead_type','HomeWifi')
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
            ->where('lead_sales.status', '1.08')
            ->get();

        return view('admin.lead.all-activator-lead-hw', compact('data','breadcrumbs'));
    }
    //
    //
    public function mnpprocesslead(Request $request)
    {
        // $role =
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"
            ], ['link' => "javascript:void(0)", 'name' => "MNP Pre Process Data"]
        ];
        //
        $data = lead_sale::select('lead_sales.customer_name', 'lead_sales.id', 'lead_sales.email', 'lead_sales.customer_number', 'status_codes.status_name as status', 'plans.plan_name', 'lead_sales.lead_no')
            ->whereIn('lead_type', ['MNP'])
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
            ->where('lead_sales.status', '1.11')
            ->get();

        return view('admin.lead.all-pre-activator-lead', compact('data', 'breadcrumbs'));
    }
    //
    //
    public function inprocessleadview(Request $request)
    {
        // $role =
        $data = lead_sale::select('lead_sales.customer_name', 'lead_sales.id', 'lead_sales.email', 'lead_sales.customer_number', 'status_codes.status_name as status', 'plans.plan_name', 'lead_sales.lead_no', 'lead_sales.emirate_id', 'lead_sales.nationality', 'lead_sales.dob', 'lead_sales.emirate_expiry', 'lead_sales.emirate', 'lead_sales.additional_docs_name', 'lead_sales.front_id', 'lead_sales.back_id','lead_sales.lead_type','lead_sales.plans')
            ->whereIn('lead_type', ['MNP', 'P2P'])
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
            ->where('lead_sales.status', '1.08')
            ->where('lead_sales.id', $request->id)
            ->first();
        if (empty($data)) {
            return redirect(route('home'));
        }
        $plan = plan::where('status', '1')->get();
        $country = country_phone_code::select('name')->get();
        $emirate = emirate::select('name')->where('status', 1)->get();
        // $plan = \App\Models\plan
        $breadcrumbs = [
            [
                'link' => "/", 'name' => "Home"
            ], ['link' => "javascript:void(0)", 'name' => "New Lead Form"]
        ];
        $remarks = remark::where('lead_no', $request->id)->get();

        return view('admin.lead.view-activator-lead', compact('data', 'plan', 'country', 'emirate', 'breadcrumbs','remarks'));
    }
    //
    //
    public function inprocessleadviewhw(Request $request)
    {
        // $role =
        $data = lead_sale::select('lead_sales.customer_name', 'lead_sales.id', 'lead_sales.email', 'lead_sales.customer_number', 'status_codes.status_name as status', 'home_wifi_plans.name as plan_name', 'lead_sales.lead_no', 'lead_sales.emirate_id', 'lead_sales.nationality', 'lead_sales.dob', 'lead_sales.emirate_expiry', 'lead_sales.emirate', 'lead_sales.additional_docs_name', 'lead_sales.front_id', 'lead_sales.back_id','lead_sales.lead_type', 'lead_sales.reff_id as work_order_num')
            ->whereIn('lead_type', ['HomeWifi'])
            // ->where('lead_type','HomeWifi')
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
            ->where('lead_sales.status', '1.08')
            ->where('lead_sales.id', $request->id)
            ->first();
        if (empty($data)) {
            return redirect(route('home'));
        }
        $plan = plan::where('status', '1')->get();
        $country = country_phone_code::select('name')->get();
        $emirate = emirate::select('name')->where('status', 1)->get();
        // $plan = \App\Models\plan
        $breadcrumbs = [
            [
                'link' => "/", 'name' => "Home"
            ], ['link' => "javascript:void(0)", 'name' => "New Lead Form"]
        ];
        $remarks = remark::where('lead_no', $request->id)->get();

        return view('admin.lead.view-activator-lead-hw', compact('data', 'plan', 'country', 'emirate', 'breadcrumbs','remarks'));
    }
    //
    //
    public function preprocessleadview(Request $request)
    {
        // $role =
        $data = lead_sale::select('lead_sales.customer_name', 'lead_sales.id', 'lead_sales.email', 'lead_sales.customer_number', 'status_codes.status_name as status', 'plans.plan_name', 'lead_sales.lead_no', 'lead_sales.emirate_id', 'lead_sales.nationality', 'lead_sales.dob', 'lead_sales.emirate_expiry', 'lead_sales.emirate', 'lead_sales.additional_docs_name', 'lead_sales.front_id', 'lead_sales.back_id','lead_sales.lead_type','lead_sales.omid','lead_sales.shipment','lead_sales.remarks')
            ->whereIn('lead_type', ['MNP', 'P2P'])
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
            ->where('lead_sales.status', '1.11')
            ->where('lead_sales.id', $request->id)
            ->first();
        if (empty($data)) {
            return redirect(route('home'));
        }
        $plan = plan::where('status', '1')->get();
        $country = country_phone_code::select('name')->get();
        $emirate = emirate::select('name')->where('status', 1)->get();
        // $plan = \App\Models\plan
        $breadcrumbs = [
            [
                'link' => "/", 'name' => "Home"
            ], ['link' => "javascript:void(0)", 'name' => "New Lead Form"]
        ];
        $remarks = remark::where('lead_no', $request->id)->get();

        return view('admin.lead.view-pre-activator-lead', compact('data', 'plan', 'country', 'emirate', 'breadcrumbs','remarks'));
    }
    //
    public function ProceedMNP(Request $request){
        // return $request;
        $validatedData = Validator::make($request->all(), [
            'shipment' => 'required',
            'omid' => 'required',
            'process_screenshot' => 'required',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        if ($file = $request->file('process_screenshot')
        ) {
            //convert image to base64
            $image = base64_encode(file_get_contents($request->file('process_screenshot')));
            $image2 = file_get_contents($request->file('process_screenshot'));
            // AzureCodeStart
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'documents' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            //prepare request
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $activation_screenshot = $originalFileName;
            $file->move('documents', $activation_screenshot);
        } else {
            // $additional_docs_photo = $request->old_additional_docs_name;
            return response()->json(['error' => ['Documents' => ['there is an issue in Additional Docs, Contact Team Leader']]], 200);
            // $additional_docs_photo =  $request->additional_docs_photo;
        }
        //
        // return response()->json(['error' => ['Documents' => [$request->leadid]]], 200);

        //
        $ld = lead_sale::findorfail($request->leadid);
        //
        $ld->shipment = $request->shipment;
        $ld->omid = $request->omid;
        $ld->process_screenshot = $activation_screenshot;
        $ld->status = '1.11';
        $ld->save();
        //
        $lead = lead_sale::select('lead_sales.id', 'lead_sales.lead_no', 'lead_sales.customer_name', 'lead_sales.customer_number', 'plans.plan_name', 'lead_sales.saler_name', 'lead_sales.lead_type', 'call_centers.numbers')
        ->Join(
            'plans',
            'plans.id',
            'lead_sales.plans'
        )
        ->Join(
            'users',
            'users.id',
            'lead_sales.saler_id'
        )
        ->Join(
            'call_centers',
            'call_centers.call_center_code',
            'users.agent_code'
        )
        ->where('lead_sales.id', $ld->id)->first();
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
            'number' => $lead->numbers,
            'plan' => $lead->plan_name,
            'sim_type' => $lead->lead_type,
            // 'Plan' => $number,
            // 'AlternativeNumber' => $alternativeNumber,
        ];
        FunctionController::SendMNPWhatsApp($details);


        //
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
        // $data = ActivationForm::create([

        // ])
    }
    //
    public function ProceedP2P(Request $request){
        // return $request;
        $validatedData = Validator::make($request->all(), [
            // 'shipment' => 'required',
            'omid' => 'required',
            'activation_screenshot' => 'required',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        if ($file = $request->file('activation_screenshot')
        ) {
            //convert image to base64
            $image = base64_encode(file_get_contents($request->file('activation_screenshot')));
            $image2 = file_get_contents($request->file('activation_screenshot'));
            // AzureCodeStart
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'documents' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            //prepare request
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $activation_screenshot = $originalFileName;
            $file->move('documents', $activation_screenshot);
        } else {
            // $additional_docs_photo = $request->old_additional_docs_name;
            return response()->json(['error' => ['Documents' => ['there is an issue in Additional Docs, Contact Team Leader']]], 200);
            // $additional_docs_photo =  $request->additional_docs_photo;
        }
        //
        $ld = lead_sale::findorfail($request->leadid);
        //
        $ld->customer_number = $request->contact_number;
        $ld->plans = $request->plans;
        $ld->shipment = $request->shipment;
        $ld->omid = $request->omid;
        $ld->activation_screenshot = $activation_screenshot;
        $ld->status = '1.02';
        $ld->channel_partner = $request->channel_partner;
        $ld->save();
        //
        $data = ActivationForm::create(['lead_id' => $request->lead_id,
            'lead_no' => $ld->lead_no,
            'lead_id' => $ld->id,
            'customer_name' => $ld->customer_name,
            'email' => $ld->email,
            'customer_number' => $ld->customer_number,
            'emirate_id' => $ld->emirate_id,
            'gender' => $ld->gender,
            'nationality' => $ld->nationality,
            'address' => $ld->address,
            'emirate' => $ld->emirate,
            'work_order_num' => $ld->work_order_num,
            'reff_id' => $ld->refference_id,
            'plans' => $request->plans,
            'language' => $ld->language,
            'emirate_expiry' => $ld->emirate_expiry,
            // 'dob' => $request->dob,
            'status' => '1.02',
            'saler_name' => auth()->user()->name,
            'saler_id' => auth()->user()->id,
            'lead_type' => 'P2P',
            'lead_date' => Carbon::now()->toDateTimeString(),
            'remarks' => $ld->remarks,
            'verify_agent' => auth()->user()->id,
            'front_id' => $ld->front_id,
            'back_id' => $ld->back_id,
            'additional_docs_photo' => $ld->additional_docs_photo,
            'additional_docs_name' => $ld->additional_docs_name,
            'activation_screenshot' => $ld->activation_screenshot,
            'omid' => $ld->omid,
            'status' => '1.02',
            'channel_partner' => $request->channel_partner,
        ]);
        $lead = lead_sale::select('lead_sales.id', 'lead_sales.lead_no', 'lead_sales.customer_name', 'lead_sales.customer_number', 'plans.plan_name', 'lead_sales.saler_name', 'lead_sales.lead_type', 'call_centers.numbers')
        ->Join(
            'plans',
            'plans.id',
            'lead_sales.plans'
        )
        ->Join(
            'users',
            'users.id',
            'lead_sales.saler_id'
        )
        ->Join(
            'call_centers',
            'call_centers.call_center_code',
            'users.agent_code'
        )
        ->where('lead_sales.id', $ld->id)->first();
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
            'number' => $lead->numbers,
            'plan' => $lead->plan_name,
            'sim_type' => $lead->lead_type,
            // 'Plan' => $number,
            // 'AlternativeNumber' => $alternativeNumber,
        ];
        FunctionController::SendActiveWhatsApp($details);


        //
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
        // FunctionController::SendWhatsApp($details);

    }
    //
    public function ProceedHW(Request $request){
        // return $request;
        $validatedData = Validator::make($request->all(), [
            // 'shipment' => 'required',
            // 'omid' => 'required',
            'activation_screenshot' => 'required',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        if ($file = $request->file('activation_screenshot')
        ) {
            //convert image to base64
            $image = base64_encode(file_get_contents($request->file('activation_screenshot')));
            $image2 = file_get_contents($request->file('activation_screenshot'));
            // AzureCodeStart
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'documents' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            //prepare request
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $activation_screenshot = $originalFileName;
            $file->move('documents', $activation_screenshot);
        } else {
            // $additional_docs_photo = $request->old_additional_docs_name;
            return response()->json(['error' => ['Documents' => ['there is an issue in Additional Docs, Contact Team Leader']]], 200);
            // $additional_docs_photo =  $request->additional_docs_photo;
        }
        //
        $ld = lead_sale::findorfail($request->leadid);
        //
        // $ld->shipment = $request->shipment;
        // $ld->omid = $request->omid;
        $ld->activation_screenshot = $activation_screenshot;
        $ld->status = '1.02';
        $ld->save();
        //
        $data = ActivationForm::create(['lead_id' => $request->lead_id,
            'lead_no' => $ld->lead_no,
            'lead_id' => $ld->id,
            'customer_name' => $ld->customer_name,
            'email' => $ld->email,
            'customer_number' => $ld->customer_number,
            'emirate_id' => $ld->emirate_id,
            'gender' => $ld->gender,
            'nationality' => $ld->nationality,
            'address' => $ld->address,
            'emirate' => $ld->emirate,
            'work_order_num' => $ld->work_order_num,
            'reff_id' => $ld->refference_id,
            'plans' => $ld->plans,
            'language' => $ld->language,
            'emirate_expiry' => $ld->emirate_expiry,
            // 'dob' => $request->dob,
            'status' => '1.02',
            'saler_name' => auth()->user()->name,
            'saler_id' => auth()->user()->id,
            'lead_type' => 'P2P',
            'lead_date' => Carbon::now()->toDateTimeString(),
            'remarks' => $ld->remarks,
            'verify_agent' => auth()->user()->id,
            'front_id' => $ld->front_id,
            'back_id' => $ld->back_id,
            'additional_docs_photo' => $ld->additional_docs_photo,
            'additional_docs_name' => $ld->additional_docs_name,
            'activation_screenshot' => $ld->activation_screenshot,
            // 'omid' => $ld->omid,
            'status' => '1.02',
        ]);
        $lead = lead_sale::select('lead_sales.id', 'lead_sales.lead_no', 'lead_sales.customer_name', 'lead_sales.customer_number', 'plans.plan_name', 'lead_sales.saler_name', 'lead_sales.lead_type', 'call_centers.numbers')
        ->Join(
            'plans',
            'plans.id',
            'lead_sales.plans'
        )
        ->Join(
            'users',
            'users.id',
            'lead_sales.saler_id'
        )
        ->Join(
            'call_centers',
            'call_centers.call_center_code',
            'users.agent_code'
        )
        ->where('lead_sales.id', $ld->id)->first();
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
            'number' => $lead->numbers,
            'plan' => $lead->plan_name,
            'sim_type' => $lead->lead_type,
            // 'Plan' => $number,
            // 'AlternativeNumber' => $alternativeNumber,
        ];
        FunctionController::SendActiveWhatsApp($details);


        //
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
        // FunctionController::SendWhatsApp($details);

    }
    //
    public function ActiveMNP(Request $request){
        // return $request;
        $validatedData = Validator::make($request->all(), [
            // 'shipment' => 'required',
            'omid' => 'required',
            'activation_screenshot' => 'required',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        //
        if ($file = $request->file('activation_screenshot')
        ) {
            //convert image to base64
            $image = base64_encode(file_get_contents($request->file('activation_screenshot')));
            $image2 = file_get_contents($request->file('activation_screenshot'));
            // AzureCodeStart
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'documents' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            //prepare request
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $activation_screenshot = $originalFileName;
            $file->move('documents', $activation_screenshot);
        } else {
            // $additional_docs_photo = $request->old_additional_docs_name;
            return response()->json(['error' => ['Documents' => ['there is an issue in Additional Docs, Contact Team Leader']]], 200);
            // $additional_docs_photo =  $request->additional_docs_photo;
        }
        //
        $ld = lead_sale::findorfail($request->leadid);
        //
        $ld->shipment = $request->shipment;
        $ld->omid = $request->omid;
        $ld->activation_screenshot = $activation_screenshot;
        $ld->status = '1.02';
        $ld->save();
        //
        $data = ActivationForm::create(['lead_id' => $request->lead_id,
            'lead_no' => $ld->lead_no,
            'lead_id' => $ld->id,
            'customer_name' => $ld->customer_name,
            'email' => $ld->email,
            'customer_number' => $ld->customer_number,
            'emirate_id' => $ld->emirate_id,
            'gender' => $ld->gender,
            'nationality' => $ld->nationality,
            'address' => $ld->address,
            'emirate' => $ld->emirate,
            'work_order_num' => $ld->work_order_num,
            'reff_id' => $ld->refference_id,
            'plans' => $ld->plans,
            'language' => $ld->language,
            'emirate_expiry' => $ld->emirate_expiry,
            // 'dob' => $request->dob,
            'status' => '1.02',
            'saler_name' => auth()->user()->name,
            'saler_id' => auth()->user()->id,
            'lead_type' => 'P2P',
            'lead_date' => Carbon::now()->toDateTimeString(),
            'remarks' => $ld->remarks,
            'verify_agent' => auth()->user()->id,
            'front_id' => $ld->front_id,
            'back_id' => $ld->back_id,
            'additional_docs_photo' => $ld->additional_docs_photo,
            'additional_docs_name' => $ld->additional_docs_name,
            'activation_screenshot' => $ld->activation_screenshot,
            'omid' => $ld->omid,
            'status' => '1.02',
        ]);
        $lead = lead_sale::select('lead_sales.id', 'lead_sales.lead_no', 'lead_sales.customer_name', 'lead_sales.customer_number', 'plans.plan_name', 'lead_sales.saler_name', 'lead_sales.lead_type', 'call_centers.numbers')
        ->Join(
            'plans',
            'plans.id',
            'lead_sales.plans'
        )
        ->Join(
            'users',
            'users.id',
            'lead_sales.saler_id'
        )
        ->Join(
            'call_centers',
            'call_centers.call_center_code',
            'users.agent_code'
        )
        ->where('lead_sales.id', $ld->id)->first();
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
            'number' => $lead->numbers,
            'plan' => $lead->plan_name,
            'sim_type' => $lead->lead_type,
            // 'Plan' => $number,
            // 'AlternativeNumber' => $alternativeNumber,
        ];
        FunctionController::SendActiveWhatsApp($details);


        //
        // $remarks = remark::create
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
        // FunctionController::SendWhatsApp($details);

    }
}
