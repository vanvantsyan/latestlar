<table class="m-datatable__table" style="display: block; height: auto; overflow-x: auto;"
       id="m-datatable--387278780463">
    <thead class="m-datatable__head">
    <tr class="m-datatable__row">
        <th data-field="id"
            class="m-datatable__cell--center m-datatable__cell m-datatable__cell--sort"><span
                    style="width: 50px;">#ID</span></th>
        <th data-field="title" class="m-datatable__cell m-datatable__cell--sort"><span
                    style="width: 488px;">Заголовок</span></th>
        <th data-field="title" class="m-datatable__cell m-datatable__cell--sort"><span
                    style="width: 488px;">URL</span></th>
        <th data-field="Actions" class="m-datatable__cell m-datatable__cell--sort"><span
                    style="width: 110px;">Действие</span></th>
    </tr>
    </thead>
    <tbody class="m-datatable__body" style="">
    @foreach($points as $point)
        <tr data-row="0" class="m-datatable__row m-datatable__row--even">
            <td data-field="id" class="m-datatable__cell--center m-datatable__cell">
                <span style="width: 50px;">{{$point->id}}</span>
            </td>
            <td data-field="title" class="m-datatable__cell">
                <span style="width: 488px;">{{$point->title}}</span>
            </td>
            <td data-field="url" class="m-datatable__cell">
                <span style="width: 488px;">{{$point->url}}</span>
            </td>
            <td data-field="Actions" class="m-datatable__cell">
                <span style="overflow: visible; width: 110px;">
                    <div class="dropdown ">
                        <a href="#"
                           class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                           data-toggle="dropdown">
                            <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="/admin/points/{{$point->id}}/edit">
                                <i class="la la-edit"></i> Редактировать
                            </a>
                            <a class="dropdown-item" href="#" data-target="#m_modal" data-toggle="modal"
                               onclick="$('#m_modal form').attr('action', '/admin/points/' + '{{$point->id}}')">
                                <i class="la la-trash"></i> Удалить
                            </a>
                        </div>
                    </div>
                    <a href="/admin/points/{{$point->id}}/edit"
                       class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                       title="View ">
                        <i class="la la-edit"></i>
                    </a>
                </span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="m-datatable__pager m-datatable--paging-loaded clearfix">
    {{$points->appends(['text' => $text])->render()}}
</div>