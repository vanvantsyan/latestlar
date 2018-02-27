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

        @isset($fields['tourName'])
            <p style="font-size:16px;font-family:'Arial';padding:10px;">
                Название тура: {{$fields['tourName']}}
            </p>
        @endif
        @isset($fields['tourDate'])
            <p style="font-size:16px;font-family:'Arial';padding:10px;">
                Выбранная дата: {{$fields['tourDate']}}
            </p>
        @endif
        @isset($fields['route'])
            <p style="font-size:16px;font-family:'Arial';padding:10px;">
                {!!  $fields['route']  !!}
            </p>
        @endif
        @isset($fields['source'])
            <p style="font-size:16px;font-family:'Arial';padding:10px;">
                Источник: {{$fields['source']}}
            </p>
        @endif
        @isset($fields['href'])
            <p style="font-size:16px;font-family:'Arial';padding:10px;">
                Ссылка на тур: {{$fields['href']}}
            </p>
        @endif
    @endif

@endsection