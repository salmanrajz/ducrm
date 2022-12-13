<?php

namespace App\Http\Controllers;

use App\Models\call_center;
use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;


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
        $users = User::all();
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
        $data = product::findorfail($request->id);
        $role = product::all();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Users Role"]
        ];
        return view('admin.role.edit-product', compact('breadcrumbs', 'role', 'data'));
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
}
