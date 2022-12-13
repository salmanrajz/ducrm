@extends('layouts/contentLayoutMaster')

@section('title', 'Users')

@section('content')
<!-- Basic Horizontal form layout section start -->

<!-- Basic Horizontal form layout section end -->

<!-- Basic Vertical form layout section start -->
<section id="basic-vertical-layouts">
    <div class="row">

        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Users</h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical" id="MyRoleForm">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-icon">Users Name</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" id="first-name-icon" class="form-control" name="name"
                                            placeholder="Role Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-icon">Users Email</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" id="first-name-icon" class="form-control" name="email"
                                            placeholder="Role Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-icon">Users Phone</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" id="first-name-icon" class="form-control" name="phone"
                                            placeholder="Role Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-icon">Users CNIC/Adhar #</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" id="first-name-icon" class="form-control" name="cnic_number"
                                            placeholder="Role Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-icon">Call Center</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="box"></i></span>
                                        <select name="call_center" id="call_center" class="is_mnp form-control">
                                            @foreach($call_center as $item)
                                                <option value="{{ $item->call_center_name }}">
                                                    {{ $item->call_center_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-icon">Role</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <select name="role" id="role" class="is_mnp form-control">
                                            @foreach($role as $item)
                                                <option value="{{ $item->name }}">
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- IMO --}}
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-icon">Password</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="********" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-icon">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="password" id="password" class="form-control" name="password_confirmation"
                                            placeholder="**********" />
                                    </div>
                                </div>
                            </div>
                            {{-- IMO END --}}
                            <div class="col-12">

                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>

                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary me-1"
                                    onclick="SavingActivationLead('{{ route('user.add') }}', 'MyRoleForm','{{ route('role') }}')">Submit</button>
                                {{-- <button type="reset" class="btn btn-outline-secondary">Reset</button> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Existing Products</h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical">
                        <div class="row">
                            <div class="col-12">
                            @foreach($users as $key => $item)

                                <div class="mb-1">
                                    <label class="form-label" for="first-name-icon">{{ ++$key }} -
                                        {{ $item->email }} - {{$item->role}}
                                    </label>
                                    <i data-feather='edit' class="float-right right"
                                        onclick="window.location.href='{{ route('user.edit',$item->id) }}'"></i>
                                    <i data-feather='eye' class="float-right right"
                                        onclick="window.location.href='{{ route('user.edit',$item->id) }}'"></i>
                                </div>
                            @endforeach
                        </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Basic Vertical form layout section end -->

<!-- Basic multiple Column Form section start -->


@endsection<!-- Basic Floating Label Form section end -->
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/custom.js')) }}"></script>
<!-- Page js files -->
@endsection
