<div class="modal fade" id="tourOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Заказать тур 
                    <span id="tourName">
                    @isset($tour) 
                        "<strong>{{$tour['title']}}</strong>" 
                    @endif
                    </span>
                    <span id="tourDateOrder">
                        
                    </span>
                </h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group" id="name">
                        <label for="name">Ваше имя</label>
                        <span></span>
                        <input type="name" name="name" class="form-control" placeholder="Иван Иванов">
                    </div>
                    <div class="form-group" id="email">
                        <label for="email">Email</label>
                        <span></span>
                        <input type="email" name="email" class="form-control" placeholder="ivanov@mail.ru">
                    </div>
                    <div class="form-group" id="phone">
                        <label for="phone">Телефон<i class="red">*</i></label>
                        <span></span>
                        <input type="text" name="phone" class="form-control" placeholder="8 920 888 88 88">
                    </div>

                    @isset($tour)
                        <input type="hidden" name="source" value=""/>
                        <input type="hidden" name="route" value="<span>Маршрут тура:</span>
                    @if((is_array($tour['par_points']) || is_object($tour['par_points'])) && count($tour['par_points']))
                        @php
                            $i = 1;
                        @endphp

                        @foreach($tour['par_points'] as $point)
                        @if($i < count($tour['par_points']))
                        {{array_get($point,'points_par.title')}},
                    @else
                        {{array_get($point,'points_par.title')}}
                        @endif
                        @php $i++ @endphp
                        @endforeach

                        @else
                            @if((is_array($tour['par_points']) || is_object($tour['par_points'])) && count($tour['par_ways']))
                            {{$tour['par_ways'][0]['ways_par']['title']}}
                            @endif
                        @endif
                                "/>
                        <input type="hidden" name="tourName" value="{{$tour['title']}}"/>
                        <input type="hidden" name="tourDate" value=""/>
                        <input type="hidden" name="href" value="http://russia.startour.ru{{Gliss::tourLink($tour)}}"/>
                    @else
                        <input type="hidden" name="source" value=""/>
                        <input type="hidden" name="route" value=""/>
                        <input type="hidden" name="tourName" value=""/>
                        <input type="hidden" name="tourDate" value=""/>
                        <input type="hidden" name="href" value=""/>
                    @endif

                    <div class="form-group">
                        <textarea class="form-control" name="comment" id="comment"></textarea>
                    </div>
                    <div class="text-success">* — поле обязательно для заполнения</div>
                </form>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-default" data-dismiss="modal">Закрыть</a>
                <a type="button" class="btn btn-yellow">Отправить</a>
            </div>
        </div>
    </div>
</div>