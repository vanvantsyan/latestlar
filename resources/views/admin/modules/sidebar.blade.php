<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu"
         class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
         data-menu-vertical="true"
         data-menu-scrollable="false" data-menu-dropdown-timeout="500"
    >
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">

            <li class="m-menu__item" aria-haspopup="true">
                <a href="{{url('admin/pages')}}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-file-1"></i>
                    <span class="m-menu__link-text">Страницы</span>
                </a>
            </li>
            <li class="m-menu__item" aria-haspopup="true">
                <a href="{{url('admin/news')}}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-list-3"></i>
                    <span class="m-menu__link-text">Новости</span>
                </a>
            </li>
            <li class="m-menu__item" aria-haspopup="true">
                <a href="{{url('admin/articles')}}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-list-3"></i>
                    <span class="m-menu__link-text">Статьи</span>
                </a>
            </li>
            <li class="m-menu__item" aria-haspopup="true">
                <a href="{{url('admin/blog')}}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-profile"></i>
                    <span class="m-menu__link-text">Блог</span>
                </a>
            </li>
            <li class="m-menu__item" aria-haspopup="true">
                <a href="{{url('admin/geo')}}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-location"></i>
                    <span class="m-menu__link-text">ГЕО</span>
                </a>
            </li>

            <li class="m-menu__item" aria-haspopup="true">
                <a href="{{url('admin/visa')}}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-route"></i>
                    <span class="m-menu__link-text">Визы</span>
                </a>
            </li>

            <li class="m-menu__item m-menu__item--submenu m-menu__item--open" aria-haspopup="true"
                data-menu-submenu-toggle="hover">
                <a href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">
										Туры
									</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu " style="display: block;">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  " aria-haspopup="true">
                            <a href="{{url('admin/tours')}}" class="m-menu__link">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
													Список туров
												</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="{{url('admin/ways')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
													Направления
												</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="{{url('admin/points')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
													Точки маршрута
												</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="/admin/types" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
													Теги туров
												</span>
                            </a>
                        </li>
                        {{--<li class="m-menu__item " aria-haspopup="true">--}}
                            {{--<a href="components/base/stack.html" class="m-menu__link ">--}}
                                {{--<i class="m-menu__link-bullet m-menu__link-bullet--dot">--}}
                                    {{--<span></span>--}}
                                {{--</i>--}}
                                {{--<span class="m-menu__link-text">--}}
													{{--Страны--}}
												{{--</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </li>

        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>

@section('js')

    <script>
        $(document).ready(function () {
            var curUrl = window.location.protocol + "//{{Request::getHost()}}/{{Request::path()}}";
            $('.m-menu__nav a').each(function () {
                if ($(this).attr('href') == curUrl) {
                    $(this).closest('li').addClass('m-menu__item--active')
                        .closest('.m-menu__item--submenu').addClass('m-menu__item--open m-menu__item--expanded');
                }
            })
        })
    </script>

@endsection