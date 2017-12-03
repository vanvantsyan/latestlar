@extends('emails.mail')

@section('content')

    <p style="font-size:14px;font-family:'Arial';">
        Вы или кто то другой запросили сброс пароля на сайте http://glissmedia.ru <br>
        Для того чтобы задать новый пароль, нажмите кнопку ниже. <br>
        <br>
        Если Вы не запрашивали сброс пароля, просто проигнорируйте данное письмо!
    </p><br>
    <p style="font-size:20px;font-family:'Arial';">
        <a href="{{url('password/reset/'.$token)}}" style="text-decoration:none;text-align:center;color:#fff;">
            <span style="display:block;width:300px;padding:10px 20px;margin:0 auto;background:#ff6052;color: #ffffff;">
            Восстановить пароль
        </span>
        </a>
    </p>
    <br><br><br><br>
    <p style="font-size:14px;font-family:'Arial';">
        Если кнопка не работает, скопируйте ссылку ниже и вставьте в адресную строку браузера.
        <br>
        http://glissmedia.ru/password/reset/{{$token}}
    </p>

@endsection