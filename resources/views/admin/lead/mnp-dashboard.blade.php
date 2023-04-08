@extends('layouts/contentLayoutMaster')

@section('title', 'MNP | P2P Leads')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('content')
<!-- Basic Horizontal form layout section start -->

<!-- Basic Horizontal form layout section end -->

<!-- Basic Vertical form layout section start -->
<section id="basic-vertical-layouts">
    <div class="row">

        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">MNP Dashboard Count -</h4>
                </div>
                <div class="form-container container">
                    <div class="row">


        </div>
    </div>
    {{-- <div class="card-header">
        <h4 class="card-title">Lead Information</h4>
    </div>
    <h2 class="text-left display-6">
                    MNP Dashboard Count -
                </h2> --}}
                {{-- 1st --}}
                <div class="container row mt-3">
                    <div class="col-lg-2">
                        <div class="card" id="rejected_div">
                            <div class="card-body text-center" onclick="LoadMNPReport('{{route('loadmnpdatacc')}}','daily','{{asset('images/loader/loader.gif')}}')">
                                <h4 class="white" style="color:#fff;">Daily Report</h4>
                                <h6 class="display-6 mt-4 white" style="color:#fff;" >
                                    {{-- {{$cp->count}} --}}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card" id="active_div">
                            <div class="card-body text-center" onclick="LoadMNPReport('{{route('loadmnpdatacc')}}','monthly','{{asset('images/loader/loader.gif')}}')">
                                <h4 class="white" style="color:#fff;">Monthly Report</h4>
                                <h6 class="display-6 mt-4 white" style="color:#fff;" >
                                    {{-- {{$cp->count}} --}}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="AdminDashboard" class="mr-5">
                    <img src="{{asset('images/loader/loader.gif')}}" alt="Loading....">
                </div>
                @if(auth()->user()->role == 'Admin' || auth()->user()->role =='SuperAdmin')
                <input type="hidden" name="cc" value="{{$call_center}}" id="cc">
                @endif
                <input type="hidden" name="link" value="{{route('loadmnpdatacc')}}" id="link">
                <input type="hidden" name="gif" value="{{asset('images/loader/loader.gif')}}" id="gif">
    </div>
    </div>

    </div>
</section>
<!-- Basic Vertical form layout section end -->

<!-- Basic multiple Column Form section start -->


@endsection<!-- Basic Floating Label Form section end -->
@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/custom.js')) }}"></script>
<!-- Page js files -->
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

<script>
    $(":input").inputmask();

</script>
<script>
    function MyData(){
        var link = $("#link").val();
        var gif = $("#gif").val();
        setTimeout(() => {
            LoadMNPReport(link,'daily',gif)
        }, 0);
    }
    setTimeout(() => {
        MyData();
    }, 3000);
</script>

@endsection



