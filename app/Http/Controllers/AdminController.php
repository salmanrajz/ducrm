<?php

namespace App\Http\Controllers;

use App\Models\call_center;
use App\Models\plan;
use App\Models\product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



class AdminController extends Controller
{
    //
    // Form Layouts
    public function product()
    {
        //
        $role = product::all();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Users Role"]
        ];
        return view('admin.role.view-product',compact('breadcrumbs','role'));
        // return view('/content/forms/form-layout', [
        //     'breadcrumbs' => $breadcrumbs
        // ]);
    }
    //
    public function product_edit(Request $request)
    {
        //
        $data = product::findorfail($request->id);
        $role = product::all();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Users Role"]
        ];
        return view('admin.role.edit-product',compact('breadcrumbs','role','data'));
        // return view('/content/forms/form-layout', [
        //     'breadcrumbs' => $breadcrumbs
        // ]);
    }
    //
    public function productadd(Request $request)
    {
        // return $request;
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }

        product::create(['name' => $request->name]);
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    public function productedit(Request $request)
    {
        // return $request;
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        $product = product::findorfail($request->id);
        $product->name = $request->name;
        $product->status = $request->status;
        $product->save();

        // product::create(['name' => $request->name]);
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    //
    // Form Layouts
    public function role()
    {
        //
        $role = Role::all();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Users Role"]
        ];
        return view('admin.role.view-role',compact('breadcrumbs','role'));
        // return view('/content/forms/form-layout', [
        //     'breadcrumbs' => $breadcrumbs
        // ]);
    }
    //
    public function roleadd(Request $request){
        // return $request;
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }

        Role::create(['name' => $request->name]);
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    //
    // Form Layouts
    public function users()
    {
        //
        $users = User::withTrashed()
            // ->where('role', '!=','Customer')
            // ->whereIn('users.role', ['NumberAdmin', 'Sale'])
            // ->where('jobtype','target')
            ->get();
        // $users = User::all();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Users"]
        ];
        $role = Role::all();
        $call_center = call_center::where('status',1)->get();
        return view('admin.users.view-users', compact('breadcrumbs','call_center','role','users'));
        // return view('/content/forms/form-layout', [
        //     'breadcrumbs' => $breadcrumbs
        // ]);
    }
    //
    public function users_edit(Request $request)
    {
        //
        $data = User::findorfail($request->id);
        $tl = User::where('role','TeamLeader')->get();
        // $call_center =
        $role = Role::all();
        $call_center = call_center::where('status', 1)->get();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Edit Users"]
        ];
        return view('admin.role.edit-users', compact('breadcrumbs', 'role', 'data', 'call_center','tl'));
        // return view('/content/forms/form-layout', [
        //     'breadcrumbs' => $breadcrumbs
        // ]);
    }
    //
    public function usersadd(Request $request)
    {
        // return $request;
        // $validatedData = Validator::make($request->all(), [
        //     'name' => 'required|string|unique:roles,name',
        // ]);
        // if ($validatedData->fails()) {
        //     return response()->json(['error' => $validatedData->errors()->all()]);
        // }

        $validatedData = Validator::make($request->all(), [ // <---
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required'],
            'call_center' => ['required'],
            'cnic_number' => ['required'],
            'phone' => ['required']
            // 'password' => 'required',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        // return implode(',', $request->multi_agentcode);
        // return $request->role;
        $data =   User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'agent_code' => $request->call_center,
            'role' => $request->role,
            'password' => Hash::make($request['password']),
            'sl' => $request->password,
            'phone' => $request->phone,
            'cnic_number' => $request->cnic_number,
            'jobtype' => 'fixed',
        ]);
        $data->assignRole($request->role);
        // if (!empty($request->permissions)) {

        //     foreach ($request->permissions as $key => $value) {
        //         # code...
        //         // auth()->user()->givePermissionTo('manage postpaid');
        //         $data->givePermissionTo($value);
        //         // return $value;
        //     }
        // }
        // return "Nice";
        // product::create(['name' => $request->name]);
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    public function usersedit(Request $request)
    {
        // return $request;
        $user = user::findorfail($request->id);
        $user->teamleader = $request->teamleader;
        $user->save();
        return "1";

        if ($file = $request->file('cnic_front')) {
            //convert image to base64
            $image = base64_encode(file_get_contents($request->file('cnic_front')));
            $image2 = file_get_contents($request->file('cnic_front'));
            // AzureCodeStart
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'user-cnic' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            //prepare request
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $cnic_front = $originalFileName;
            $file->move('user-cnic',
                $cnic_front
            );
        } else {
            $cnic_front =  $request->cnic_front_old;
        }
        if ($file = $request->file('img')) {
            //convert image to base64
            $image = base64_encode(file_get_contents($request->file('img')));
            $image2 = file_get_contents($request->file('img'));
            // AzureCodeStart
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'user-cnic' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            //prepare request
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $name = $originalFileName;
            $file->move('user-cnic',
                $name
            );
        } else {
            $name =  $request->img_old;
        }
        if ($file = $request->file('cnic_back')) {
            //convert image to base64
            $image = base64_encode(file_get_contents($request->file('cnic_back')));
            $image2 = file_get_contents($request->file('cnic_back'));
            // AzureCodeStart
            $originalFileName = time() . $file->getClientOriginalName();
            $multi_filePath = 'user-cnic' . '/' . $originalFileName;
            \Storage::disk('azure')->put($multi_filePath, $image2);
            // AzureCodeEnd
            //prepare request
            $mytime = Carbon::now();
            $ext =  $mytime->toDateTimeString();
            // $name = $ext . '-' . $file->getClientOriginalName();
            $cnic_back = $originalFileName;
            $file->move('user-cnic',
                $cnic_back
            );
        } else {
            $cnic_back = $request->cnic_back_old;
        }
        // return  $cnic_front . $cnic_back;
        if ($request->password == '') {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'agent_code' => $request->agent_group,
                'phone' => $request->phone,
                'call_center_ip' => $request->call_center_ip,
                'secondary_ip' => $request->secondary_ip,
                'jobtype' => $request->jobtype,
                'profile' => $name,
                // 'password' => Hash::make($request->password),
                'cnic_front' => $cnic_front,
                'cnic_back' => $cnic_back,
                'emirate' => implode(',', $request->emirates),
                'teamleader' => $request->teamleader,
                'is_mnp' => $request->is_mnp,
                // 'password' => Hash::make($request->password),
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'agent_code' => $request->agent_group,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'sl' => $request->password,
                'jobtype' => $request->jobtype,
                'profile' => $name,
                'call_center_ip' => $request->call_center_ip,
                'secondary_ip' => $request->secondary_ip,
                'cnic_front' => $cnic_front,
                'cnic_back' => $cnic_back,
                'teamleader' => $request->teamleader,
            ]);
        }
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    //
    public function DeleteUser(Request $request){
        // return $request->id;
        $d = user::withTrashed()->find($request->id);
        if (!is_null($d->deleted_at)) {
            $d->restore();
            // return 1;
            // return
            // notify()->info('User has been succesfully Enable');
        } else {
            $d->delete();
            // return 1;
            // notify()->info('User has been succesfully deleted');
        }
        return redirect(route('users'));

    }
    //
    // Form Layouts
    public function call_center()
    {
        //
        $role = call_center::all();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Call Center"]
        ];
        return view('admin.role.view-call-center', compact('breadcrumbs', 'role'));
        // return view('/content/forms/form-layout', [
        //     'breadcrumbs' => $breadcrumbs
        // ]);
    }
    //
    public function call_center_edit(Request $request)
    {
        //
        $data = call_center::findorfail($request->id);
        $role = call_center::all();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Edit Call Center"]
        ];
        return view('admin.role.edit-call-center', compact('breadcrumbs', 'role', 'data'));
        // return view('/content/forms/form-layout', [
        //     'breadcrumbs' => $breadcrumbs
        // ]);
    }
    //
    public function cc_add(Request $request)
    {
        // return $request;
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }

        call_center::create(
            [
                'call_center_name' => $request->name,
                'call_center_code' => $request->call_center_short_code,
                'numbers' => $request->numbers,
                'guest_number' => $request->guest_number,
                'status' => $request->status,
                'call_center_amount' => 0,
            ]
        );
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    public function cc_edit(Request $request)
    {
        // return $request;
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        $product = call_center::findorfail($request->id);
        $product->call_center_name = $request->name;
        $product->call_center_code = $request->call_center_short_code;
        $product->numbers = $request->numbers;
        $product->guest_number = $request->guest_number;
        $product->status = $request->status;
        $product->save();

        // product::create(['name' => $request->name]);
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    // // Form Layouts
    public function plans()
    {
        //
        $role = plan::where('status','1')->get();
        // $role = plan::all();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Users Role"]
        ];
        return view('admin.role.view-plans', compact('breadcrumbs', 'role'));
        // return view('/content/forms/form-layout', [
        //     'breadcrumbs' => $breadcrumbs
        // ]);
    }
    //
    public function plan_edit(Request $request)
    {
        //
        $data = plan::findorfail($request->id);
        $role = plan::all();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Edit Plans"]
        ];
        return view('admin.role.edit-plan', compact('breadcrumbs', 'role', 'data'));
        // return view('/content/forms/form-layout', [
        //     'breadcrumbs' => $breadcrumbs
        // ]);
    }
    //
    public function planadd(Request $request)
    {
        // return $request;
        $validatedData = Validator::make($request->all(), [
            'plan_name' => 'required|string|unique:plans,plan_name',
            'local_minutes' => 'required',
            'data' => 'required',
            'free_minutes' => 'required',
            'flexible_minutes' => 'required',
            'duration' => 'required',
            'status' => 'required',
            'monthly_payment' => 'required',
            'revenue' => 'required',
            'plan_names_du' => 'required',
            // 'revenue_port' => 'required'
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }

        plan::create(
            [
                'plan_name' => $request->plan_name,
                'local_minutes' => $request->local_minutes,
                'flexible_minutes' => $request->flexible_minutes,
                'data' => $request->data,
                'free_minutes' => $request->free_minutes,
                'duration' => $request->duration,
                'status' => $request->status,
                'monthly_payment' => $request->monthly_payment,
                'plan_names_du' => $request->plan_names_du
            ]
        );
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    public function planedit(Request $request)
    {
        // return $request;
        $validatedData = Validator::make($request->all(), [
            'plan_name' => [
                'required',
                Rule::unique('plans')->ignore($request->id),
            ],
            'local_minutes' => 'required',
            'data' => 'required',
            'free_minutes' => 'required',
            'flexible_minutes' => 'required',
            'duration' => 'required',
            'status' => 'required',
            'monthly_payment' => 'required',
            'revenue' => 'required',
            'revenue_port' => 'required',
            'plan_names_du' => 'required'
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->all()]);
        }
        $product = plan::findorfail($request->id);
        $product->plan_name = $request->plan_name;
        $product->local_minutes = $request->local_minutes;
        $product->data = $request->data;
        $product->free_minutes = $request->free_minutes;
        $product->duration = $request->duration;
        $product->monthly_payment = $request->monthly_payment;
        $product->revenue = $request->revenue;
        $product->revenue_port = $request->revenue_port;
        $product->status = $request->status;
        $product->plan_names_du = $request->plan_names_du;
        $product->save();

        // product::create(['name' => $request->name]);
        return response()->json(['success' => 'Added new records, please wait meanwhile we are redirecting you....!!!']);
    }
    //

}
