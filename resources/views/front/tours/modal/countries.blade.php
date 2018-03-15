<div class="modal fade" id="countriesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Список стран</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($countries as $country)
                        <a class="col-xs-6 col-sm-4 items" href="/{{$country->slug}}">{{$country->country}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>