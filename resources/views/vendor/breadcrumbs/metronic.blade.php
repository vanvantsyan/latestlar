<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">

    <?php $i = 1; ?>
    @foreach($data as $d)

        @if($i != count($data))
            <li class="m-nav__item {{$d['class']}}">
                <a class="m-nav__link" href="{{$d['link']}}">
                    <span class="m-nav__link-text">{!! $d['title'] !!}</span>
                </a>
            </li>
            @if($separator['enable'] === true)
                <li class="{{$separator['class']}}">{!! $separator['content'] !!}</li>
            @endif
        @else
            <li class="m-nav__item">
                <a class="m-nav__link active">
                    <span class="m-nav__link-text">{!! $d['title'] !!}</span>
                </a>
            </li>
        @endif

        <?php $i++; ?>
    @endforeach

</ul>