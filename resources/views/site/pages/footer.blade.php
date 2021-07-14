{{--<link rel="stylesheet" href="/resources/css/style.css">--}}
<footer class="footer">
    <div class="container">
        <div class="row footer__row">
            <div class="col">
                <h4>Аккаунт</h4>

                <ul>
                    <li>
                        <a href="{{ route('site.tenders.index') }}">Каталог заданий</a>
                    </li>

                    <li>
                        <a href="{{ route('site.page', 'how-to-contractor') }}">Как стать исполнителем</a>
                    </li>

                    <li>
                        <a href="{{ route('site.page', 'how-to-customer') }}">Как стать заказчиком</a>
                    </li>

                    <li>
                        <a href="{{ route('site.page', 'faq') }}">Частые вопросы</a>
                    </li>
                </ul>
            </div>

            <div class="col">
                <h4>Компания</h4>

                <ul>
                    <li><a href="{{ route('site.page', 'about') }}">О
                            компании</a></li>
                    <li>
                        <a href="{{ route('site.blog.index') }}">Наш блог</a>
                    </li>

                    <li>
                        <a href="{{ route('site.page', 'contacts') }}">Контакты</a>
                    </li>

                    <li>
                        <a href="{{ route('site.page', 'support') }}">Служба поддержки</a>
                    </li>
                </ul>
            </div>

            {{--<div class="col">
              <h4>Скоро в itcase.com</h4>

              <ul>
                <li>
                  <a href="#">ittaxi - сервис агрегатор такси</a>
                </li>

                <li>
                  <a href="#">itmoney - универсальная
                    платежная система</a>
                </li>

                <li>
                  <a href="#">itcar - краткосрочная аренда, прокат машины</a>
                </li>
              </ul>
            </div>--}}


            <div class="col">
                <h4 class="text-center">Скоро в Play market и App store</h4>

                <div class="app-info">
                    <ul class="app-info__list">
                        <li>

                            <img src="/resources/images/appstore-black.svg" alt="">

                        </li>

                        <li>

                            <img src="/resources/images/googleplay-black.svg" alt="">

                        </li>
                    </ul>

                                        <ul class="app-info__list" style="margin-left: 10px; text-align: center;">
                                            <p style="text-align: center; font-size: 15px; margin-top: 20px; margin-bottom: 20px;">А пока вы
                                                можете скачать приложение с нашего сайта</p>
                                            <li style="margin-bottom: 5px;">
                                                <a href="/itcase.apk">
                                                    <img src="/resources/images/download-android.png" alt=""
                                                         style="vertical-align: middle;"> Скачать
                                                </a>
                                            </li>
                                        </ul>

                </div>
            </div>
        </div>
    </div>


    <hr>

    <div class="container footer__bottom">
        <div class="row align-items-center">
            <div class="col col--25">
                <p>© 2021 itcase.com</p>
            </div>

            <div class="col text-center">
                <p id="hover_remove_decoration">
                    <a href="{{ route('site.page', 'terms-of-service') }}">Правила сервиса</a>
                    <a href="{{ route('site.page', 'offerta') }}"> Оферта</a>
                    <a href="{{ route('site.page', 'privacy-policy') }}">Политика конфиденциальности</a>
                </p>
            </div>

            <div class="col col--25 d-flex justify-content-end align-items-center">
                <ul>
                    <li>
                        <a href="https://www.facebook.com/Itcasecom-104128105147920">
                            <img src="/resources/images/facebook.svg" alt="">
                        </a>
                    </li>

                    <li>
                        <a href="https://instagram.com/itcasecom">
                            <img src="/resources/images/instagram.svg" alt="">
                        </a>
                    </li>

                    <li>
                        <a href="https://www.youtube.com/channel/UCfxBExrj8M7H9aW5RCa-Jmw/about">
                            <img src="/resources/images/youtube.svg" alt="">
                        </a>
                    </li>


                    <li>
                        <a href="https://t.me/itcase_com">
                            <img src="/resources/images/telegram.svg" alt="">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="/resources/js/jquery.min.js"></script>

<script src="/front/js/slick.js"></script>
<script src="/resources/js/swiper.min.js"></script>
<script src="/resources/js/wow.min.js"></script>
<script src="/resources/js/isotope.pkgd.js"></script>
<script src="/resources/js/jquery.magnific-popup.min.js"></script>
<script src="/front/js/popper.min.js"></script>
<script src="/front/js/bootstrap.min.js"></script>
<script src="/front/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/front/js/jquery-ui.js"></script>
<script src="/front/js/imagesloaded.pkgd.js"></script>
<script src="/front/js/main.js"></script>

