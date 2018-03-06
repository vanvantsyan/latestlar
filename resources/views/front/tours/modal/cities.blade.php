<div class="modal fade" id="tourCitiesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Список городов</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($cities as $city)
                        <a class="col-xs-6 col-sm-4 items" href="/russia/tury-{{$city->url}}">{{$city->title}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>