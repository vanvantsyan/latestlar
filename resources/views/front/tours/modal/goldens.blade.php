<div class="modal fade" id="tourGoldensModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Города золотого кольца России</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    @foreach($cities as $city)
                        @if($countTours = Gliss::countTours("/tury/tury-" . $city->url))
                            <a class="col-xs-6 col-sm-4 items" href="/russia/tury-{{$city->url}}">{{$city->title}} ({{$countTours}})</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>