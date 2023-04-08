{{-- @extends('layouts.dashboard-app') --}}
    {{-- <x-header></x-header> --}}

<!DOCTYPE html>
<html>
<head>
    {{-- <title>{{ config('app.name', 'Dialup IT Services') }}</title> --}}
</head>

{{-- @php
    $lead = \App\lead_sale::findorfail($details);
    @endphp --}}
<body>
    <p>
        Dear Team,
    </p>
    <p>
        Please process below request.
    </p>
    <p>
        kindly find the attached documents.
    </p>
    <table class="" style="border:5px;margin:50px;">
    </thead>
            {{-- <tr colspan="2" style="background:#9bc2e6;padding-left:20px;border:2px solid black">
                <td colspan="2">
                    <h2 style="padding-left:20px;">

                            {{strtoupper($lead['lead_type'])}}
                    </h2>
                </td>
            </tr> --}}
            <thead>
        <tbody>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="background:#c75912;padding-left:20px;border:2px solid black">Field Name</td>
                <td style="background:#c75912;padding-left:20px;border:2px solid black;width:180px;">Value</td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Category</td>
                <td style="padding-left:20px;border:2px solid black">
                            {{strtoupper($lead['lead_type'])}}
                </td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Online Order Reference #</td>
                <td style="padding-left:20px;border:2px solid black">
                    {{$lead->reff_id}}
                </td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Partner Name</td>
                <td style="padding-left:20px;border:2px solid black">
                    Vocus Electronic Trading LLC
                </td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">CUSTOMER FULL NAME</td>
                <td style="padding-left:20px;border:2px solid black">{{strtoupper($lead['customer_name'])}}</td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Nationality</td>
                <td style="padding-left:20px;border:2px solid black">{{$lead['nationality']}}</td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Number to be ported</td>
                <td style="padding-left:20px;border:2px solid black">{{$lead['customer_number']}}</td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Alt Contact Number</td>
                <td style="padding-left:20px;border:2px solid black">{{$lead['customer_number']}}</td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Service provider</td>
                <td style="padding-left:20px;border:2px solid black">Etisalat</td>
            </tr>
            @if($lead['emirate_id'] != '')
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">EID Number</td>
                <td style="padding-left:20px;border:2px solid black">{{$lead->emirate_id}}</td>
            </tr>
            @endif
            @if($lead['dob'] == '1970-01-01')
            @else
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">EID Expiry date</td>
                <td style="padding-left:20px;border:2px solid black">
                    {{-- {{$lead['emirate_expiry']}} --}}
                    {{Carbon\Carbon::parse($lead['emirate_expiry'])->format('d-M-Y')}}
                </td>
            </tr>
            @endif

            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Email</td>
                <td style="padding-left:20px;border:2px solid black">{{$lead->email}}</td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Order ID</td>
                <td style="padding-left:20px;border:2px solid black">
                    {{$lead->reff_id}}
                </td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Dealer ID</td>
                <td style="padding-left:20px;border:2px solid black">TE151</td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Address</td>
                <td style="padding-left:20px;border:2px solid black">{{$lead->address}}</td>
            </tr>
            @if ($lead['sim_type'] == 'exist')
            @else
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Rate Plan</td>
                <td style="padding-left:20px;border:2px solid black">{{$lead->plan_name}}</td>
            </tr>

            @endif

            {{-- <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Attachments - EID and supporting doc in PDF format</td>
                <td style="padding-left:20px;border:2px solid black">shared in email</td>
            </tr>

            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Call Completion Time</td>
                <td style="padding-left:20px;border:2px solid black">{{Carbon\Carbon::parse($lead['call_completion_time'])->format('d-m-Y h:i a')}}</td>
            </tr>

            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Additional Benefits</td>
                <td style="padding-left:20px;border:2px solid black">{{$lead['additional_benefits']}}</td>
            </tr>
            <tr style="padding-left:20px;border:2px solid black">
                <td style="padding-left:20px;border:2px solid black">Remarks</td>
                <td style="padding-left:20px;border:2px solid black">{{$lead['remarks']}}</td>
            </tr> --}}



        </tbody>
    </table>
    {{-- @if($lead['device']) --}}

    <footer>
        <p>
            <b>Verification has been done from our side.</b>
        </p>
        <p>
            Best Regards,
        </p>
        <p>
            <strong>Processing Unit</strong>
        </p>
        <p>
            <strong>Vocus Electronics Trading LLC</strong>
        </p>
        <p>
            info@vocus.ae
        </p>
        <p>
            Tel:
        </p>
        <p>
            <i>This is system generated email.</i>
        </p>
    </footer>

</body>
</html>
