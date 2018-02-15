<div class="tours-notes">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <h2>Заметки для путешественников по России</h2>
            <div class="tours-notes-items-wrap">
                <div class="tours-notes-items">
                    @foreach($articles as $article)
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="row">
                                <a href="#" class="tours-notes-item">
                                    @php
                                        $images = json_decode($article->images);
                                    @endphp
                                    <div class="tours-notes-item-img">
                                        @if(count($images))
                                            <img src="/img/articles/thumbs/{{head($images)}}"
                                                 alt=""></div>
                                    @endif
                                    <div class="tours-notes-item-cont">
                                        <b>{{$article->title}}</b>
                                        <p>{!! Str::words($article['description'], 10,'...') !!}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="#" class="btn-more-tours">Показать еще больше советов</a>
            </div>
        </div>
    </div>
</div>