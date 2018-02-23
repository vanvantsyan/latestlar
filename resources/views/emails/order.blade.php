@extends('emails.mail')
@section('subject',"Заявка на тур")
@section('content')
    @if(count($fields))
        @isset($fields['name'])
            <p style="font-size:14px;font-family:'Arial';">
                Имя клиента: {{$fields['name']}}
            </p><br>
        @endif
        @isset(($fields['phone']))
            <p style="font-size:18px;font-family:'Arial';padding:10px;background:#ececec;font-weight:bold;">
                Телефон: {{$fields['phone']}}
            </p>
        @endif
        @isset($fields['email'])
            <p style="font-size:18px;font-family:'Arial';padding:10px;background:#ececec;font-weight:bold;">
                Е-мейл: {{$fields['email']}}
            </p>
        @endif
        @isset($fields['comment'])
            <hr>
            <p style="font-size:16px;font-family:'Arial';padding:10px;">
                Комментарий: {{$fields['comment']}}
            </p>
        @endif
    @endif

@endsection