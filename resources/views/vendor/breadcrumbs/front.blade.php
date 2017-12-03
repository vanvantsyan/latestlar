<div class="breadcrumbs-wr breadcrumbs_article">
    <div class="container">
        <ol class="breadcrumbs">
            <?php $i = 1; ?>
            @foreach($data as $d)
                @if ($i == 1)
                    <li>
                        <a href="/">Авиабилеты</a>
                    </li>
                @elseif ($i != count($data))
                    <li class="{{$d['class']}}">
                        <a href="{{$d['link']}}">{!! $d['title'] !!}</a>
                    </li>
                @else
                    <li class="current">
                        {!! $d['title'] !!}
                    </li>
                @endif

                <?php $i++; ?>
            @endforeach
        </ol>
    </div>
</div>
