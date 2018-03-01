<div class="info-company">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
            <div class="row">
                <div class="about-company">
                    <div class="info-company-title">Информация о компании</div>
                    <p>"STARTOUR" - одно из популярных туристических агенств, ежедневно помогающее людям в
                        подборе и бронировании туров, авиабилетов, трансферов, экскурсий и круизов. В месяц мы
                        обслуживаем свыше 4000 клиентов.</p>
                    <p>Наша главная задача - сэкономить ваши деньги и обеспечить вас наилучшим отдыхом.</p>
                    <p><b>За 14 лет плодотворной работы мы смогли:</b></p>
                    <ul>
                        <li>Накопить свыше 500 корпоративных клиентов;</li>
                        <li>Принять в штат 40 сотрудников;</li>
                        <li>Заполучить более сотни партнеров в России и Европе.</li>
                    </ul>
                    <p>Мы с первого дня совершенствуемся, накапливаем опыт и принимаем активное участие в
                        различных мероприятиях. Наши дипломы и награды говорят о наших достижениях и высоком
                        качестве предоставлямых услуг.</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
            <div class="row">
                <div class="news-company">
                    <div class="info-company-title">Новости компании</div>
                    <div class="news-company-items">
                        @foreach($news as $new)
                            <a href="#" class="news-company-item">
                                <b>12.12.2017</b>
                                <span>{{$new->title}}</span>
                            </a>
                        @endforeach
                    </div>
                    <a href="#">Посмотреть все новости</a>
                </div>
            </div>
        </div>
    </div>
</div>