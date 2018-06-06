<footer class="footer">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="copyright">
                    &#169; {{date('Y')}} ООО "STARTOUR". Все права защищены.
                    <div id="glissmedia-url"></div>
                </div>
                <div class="letsfly">
                    <div class="letsfly-img"><img src="/img/letsfly-img.png" alt=""></div>
                    <div class="letsfly-desc">LetsFly - авиа и Ж/Д билеты, услуги, корпоративное обслучивание</div>
                </div>
                <div class="footer-logo">
                    <div class="logo"><img src="/img/logo.png" alt=""></div>
                    <div class="letsfly-desc">Туристические услуги</div>
                </div>
            </div>
        </div>
    </div>
</footer>

@push('js')
    <script>
        // Append Glissmedia url after page load.
        $(function () {
            setTimeout(function () {
                $('#glissmedia-url').html(`
                    <a href="https://glissmedia.ru/" title="glissmedia" alt="техническая поддержка сайта">glissmedia.ru</a>
                    — техническая поддержка сайта
                `);
            }, 2000);
        });
    </script>

@endpush