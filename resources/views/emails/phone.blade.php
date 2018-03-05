@extends('emails.mail')
@section('subject',"Заказ звонка")
@section('content')
    @if(count($fields))
        @isset(($fields['phone']))
            <p style="font-size:18px;font-family:'Arial';padding:10px;background:#ececec;font-weight:bold;">
                Телефон: {{ $fields['phone'] }}
            </p>
        @endif
    @endif
@endsection