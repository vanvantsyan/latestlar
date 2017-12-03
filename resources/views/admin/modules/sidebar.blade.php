<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div    id="m_ver_menu"
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

        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>

@section('js')

    <script>
        $(document).ready(function(){
            var curUrl = window.location.protocol + "//{{Request::getHost()}}/{{Request::path()}}";
            $('.m-menu__nav a').each(function(){
                if($(this).attr('href') == curUrl){
                    $(this).closest('li').addClass('m-menu__item--active')
                        .closest('.m-menu__item--submenu').addClass('m-menu__item--open m-menu__item--expanded');
                }
            })
        })
    </script>

@endsection