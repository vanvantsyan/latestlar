<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="h1">Загаловок H1</label>
        <input type="text" class="form-control m-input m-input--square" id="h1" name="h1_title" placeholder="Загаловок H1" value="{{$data->h1_title or ''}}">
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="seo_title">Meta Title</label>
        <input type="text" class="form-control m-input m-input--square" id="seo_title" name="seo_title" placeholder="Meta Title" value="{{$data->seo_title or ''}}">
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="seo_desc">Meta Description</label>
        <textarea class="form-control m-input m-input--square" id="seo_desc" name="seo_desc" rows="5" placeholder="Meta Description">{{$data->seo_desc or ''}}</textarea>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="seo_keys">Meta Keywords</label>
        <textarea class="form-control m-input m-input--square" id="seo_keys" name="seo_keys" rows="5" placeholder="Meta Keywords">{{$data->seo_keys or ''}}</textarea>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-6 col-xs-12">
        <label for="slug">Slug</label>
        <input type="text" class="form-control m-input m-input--square" id="slug" name="slug" placeholder="Введите URL" value="{{$data->slug or ''}}">
    </div>
</div>