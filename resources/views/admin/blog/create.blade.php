@extends('layouts.admin')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Создание / Редактирование нового поста
                </h3>
                {!! Breadcrumbs::generate(['Админ панель', 'Блог', 'Создать/Редактировать пост'], 'metronic') !!}
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body">

                @php
                    $link = isset($post) ? url("admin/blog/".$post->id) : url("admin/blog");
                @endphp
                <form action="{{ $link }}" method="POST" class="form-horizontal">

                    {{ csrf_field() }}
                    @if(isset($post))
                        <input type="hidden" name="_method" value="PUT">
                    @endif

                    <div class="col-lg-6 col-md-6 col-sm-9 col-xs-12 form-group">
                        <label for="cat">Выбор категории</label>
                        <select name="category_id" id="cat" class="form-control" required>
                            <option value="" disabled="" selected>Выберите категорию</option>
                            @forelse($categories as $category)
                                <option value="{{$category->id}}" @if(isset($post) && $post->category_id == $category->id) selected @endif>{{$category->title}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <label for="">Загаловок</label>
                        <input type="text" class="form-control" name="title" value="{{$post->title or ''}}">
                    </div>
                    <br>

                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <label class="">
                            Превью
                        </label>
                        <div class="m-dropzone dropzone dz-clickable" action="{{url('admin/upload-images')}}" id="m-dropzone-one">
                            <div class="m-dropzone__msg dz-message needsclick" @if(isset($post) && !empty($post->preview)) style="display: none;" @endif>
                                <h3 class="m-dropzone__msg-title">
                                    Перетащите файл изображения сюда или кликните для загрузки с компьютера
                                </h3>
                                <span class="m-dropzone__msg-desc">
                                    Только одно изображение
                                </span>
                            </div>
                            @if(isset($post) && !empty($post->preview))
                                <input type="hidden" name="preview" value="{{$post->preview}}">
                                @php $preview = str_replace('/uploads/blog/', '', $post->preview) @endphp
                                <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                    <div class="dz-image">
                                        <img data-dz-thumbnail="" alt="" src="{{asset('uploads/blog/medium/'.$preview)}}" style="height:120px;min-width:120px;">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <br>

                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <label for="">Краткое описание</label>
                        <textarea class="summernote" name="description">{{$post->description or ''}}</textarea>
                    </div>
                    <br><br>

                    <div class="col-md-12">
                        <h5>Содержание поста</h5>
                    </div>
                    <hr>

                    @if(isset($post))
                        @php $post->text = isset($post) ? json_decode($post->text) : ''; @endphp
                    @endif


                    <div class="blog_step">
                        @if(isset($post))
                            @php $i = 0; @endphp
                            @foreach($post->text as $text)
                                <div class="step">
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <label for="">Загаловок</label>
                                        <input type="text" name="step[]" class="form-control" value="{{$text->title or ''}}">
                                    </div>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <label for="">Контент</label>
                                        <textarea class="summernote" name="text[]">{{$text->text or ''}}</textarea>
                                    </div>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <br>
                                        <div class="m-dropzone dropzone m-dropzone--primary dz-clickable" action="{{url('admin/upload-images')}}" id="m-dropzone-{{$i+1}}">
                                            <div class="m-dropzone__msg dz-message needsclick">
                                                <h3 class="m-dropzone__msg-title">
                                                    Перетащите файлы изображений сюда, или кликните для загрузки с компьютера
                                                </h3>
                                                <span class="m-dropzone__msg-desc">
                                                    Не более 10 файлов
                                                </span>
                                            </div>
                                            @if(!empty($text->images))
                                                @foreach($text->images as $image)
                                                    <input type="hidden" name="images_{{$i+1}}[]" value="{{$image}}">
                                                    @php $image = str_replace('/uploads/blog/', '', $image) @endphp

                                                    <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                                        <div class="dz-image">
                                                            <img data-dz-thumbnail="" alt="" src="{{asset('uploads/blog/medium/'.$image)}}" style="height:120px;min-width:120px;">
                                                        </div>
                                                        <a class="dz-remove" href="javascript:;" data-dz-remove="">Remove file</a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        @else
                            <div class="step">
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <label for="">Загаловок</label>
                                    <input type="text" name="step[]" class="form-control">
                                </div>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <label for="">Контент</label>
                                    <textarea class="summernote" name="text[]">{{$post->text or ''}}</textarea>
                                </div>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <br>
                                    <div class="m-dropzone dropzone m-dropzone--primary dz-clickable" action="{{url('admin/upload-images')}}" id="m-dropzone-1">
                                        <div class="m-dropzone__msg dz-message needsclick">
                                            <h3 class="m-dropzone__msg-title">
                                                Перетащите файлы изображений сюда, или кликните для загрузки с компьютера
                                            </h3>
                                            <span class="m-dropzone__msg-desc">
                                                Не более 10 файлов
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endif
                    </div>
                    <br>
                    <a href="javascript:;" class="btn btn-link" onclick="return gliss.blog.addStep();">Добавить описание</a>
                    <hr>

                    <div class="form-group m-form__group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="seo_keys">Тэги</label>
                            <textarea class="form-control m-input m-input--square" id="seo_keys" name="tags" rows="5" placeholder="Meta Keywords">{{$post->tags or ''}}</textarea>
                        </div>
                    </div>

                    <br><br>
                    <div class="col-md-12">
                        <h5>SEO содержание</h5>
                    </div>
                    <hr>

                    <div class="col-md-12">
                        @if(isset($post))
                            @include('admin.blog.seo', ['data' => $post])
                        @else
                            @include('admin.blog.seo')
                        @endif
                    </div>

                    <div class="images-input"></div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{url('admin/blog')}}" class="btn btn-danger">Отмена</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{asset('assets/demo/default/custom/components/forms/widgets/summernote.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/gliss.blog.js')}}"></script>
    <script>
        Dropzone.options.mDropzoneOne = {
            addRemoveLinks: true,
            success: function( file, response ){
                obj = JSON.parse(response);
                $('.images-input').append('<input type="hidden" name="preview" value="'+obj.filename+'">');
                if($('input[name="preview"]').length === 2) {
                    $('input[name="preview"]').first().remove();
                }
                if($('#m-dropzone-one').find('.dz-preview').length === 2) {
                    $('#m-dropzone-one').find('.dz-preview').first().remove();
                }
            }
        };
        Dropzone.options.mDropzone1 = {
            addRemoveLinks: true,
            success: function( file, response ){
                obj = JSON.parse(response);
                $('.images-input').append('<input type="hidden" name="images_1[]" value="'+obj.filename+'">')
            }
        };
        Dropzone.options.mDropzone2 = {
            addRemoveLinks: true,
            success: function( file, response ){
                obj = JSON.parse(response);
                $('.images-input').append('<input type="hidden" name="images_2[]" value="'+obj.filename+'">')
            }
        };
        Dropzone.options.mDropzone3 = {
            addRemoveLinks: true,
            success: function( file, response ){
                obj = JSON.parse(response);
                $('.images-input').append('<input type="hidden" name="images_3[]" value="'+obj.filename+'">')
            }
        };
        Dropzone.options.mDropzone4 = {
            addRemoveLinks: true,
            success: function( file, response ){
                obj = JSON.parse(response);
                $('.images-input').append('<input type="hidden" name="images_4[]" value="'+obj.filename+'">')
            }
        };
        Dropzone.options.mDropzone5 = {
            addRemoveLinks: true,
            success: function( file, response ){
                obj = JSON.parse(response);
                $('.images-input').append('<input type="hidden" name="images_5[]" value="'+obj.filename+'">')
            }
        };
    </script>
@endsection