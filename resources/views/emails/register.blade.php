@extends('emails.mail')

@section('content')

    <p style="font-size:14px;font-family:'Arial';">
        Hello {{$name}}! <br><br>
        You are granted access to the site Letsfly.ru <br>
        To enter the site, go to <a href="{{url('login')}}">link</a> and use the login information below: <br>
    </p><br>
    <p style="font-size:18px;font-family:'Arial';padding:10px;background:#ececec;font-weight:bold;">
        Email: {{$email}} <br>
        Password: {{$passw}} <br>
    </p><br><br>
    <p style="font-size:14px;font-family:'Arial';">
        We strongly recommend that you change your password after the first login!
    </p><br><br>
    <p style="font-size:14px;font-family:'Arial';">
    ------------------- <br>
        Regards, the administration <a href="{{url('/')}}">letsfly.ru</a>
    </p>


@endsection