<!DOCTYPE html>
<html>
<head>
    <title>Documents Attached</title>
</head>
<body>
    <h1>Please find the attached documents for Approval</h1>
    {{-- {{$data_for_pdf['title']}} --}}
    {{-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidata_for_pdft non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p> --}}
        {{-- @foreach ($additional_documents as $item) --}}
        {{-- {{$data_for_pdf['back']}} --}}
        {{-- {{$data_for_pdf['front']}} --}}
        {{-- {{$data_for_pdf['additional_documents']}} --}}
        <h3>FRONT ID</h3>
        @if (!empty($data_for_pdf['front']))
        <img src="{{public_path('documents/'.$data_for_pdf['front'])}}" alt="" style="width:500px">
        @endif
        <h3>BACK ID</h3>
        @if (!empty($data_for_pdf['back']))
        <img src="{{public_path('documents/'.$data_for_pdf['back'])}}" alt="" style="width:500px;">
        @endif
        <h3>Additional Document</h3>
        @if (!empty($data_for_pdf['additional_documents']))
            <img src="{{public_path('documents/'.$data_for_pdf['additional_documents'])}}" alt="" style="width:700px;">
        @endif
    {{-- <img src="{{asset('documents/'.$decoded)}}" alt="" style="width:200px;"> --}}
        {{-- <img src="{{asset('document/'$front)}}" alt=""> --}}
        {{-- <img src="{{asset('document/'$back)}}" alt=""> --}}
    {{-- @endforeach --}}
    {{-- <br/>
    <strong>Public Folder:</strong>
    <img src="{{ public_path('dummy.jpg') }}" style="width: 200px; height: 200px">

    <br/>
    <strong>Storage Folder:</strong>
    <img src="{{ storage_path('app/public/dummy.jpg') }}" style="width: 200px; height: 200px"> --}}
</body>
</html>
