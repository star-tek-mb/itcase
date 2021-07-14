<footer class="footer-site" id="footer">
    <div class="container">
        <div class="footer-top">
            <div class="row align-items-center text-center text-lg-left">
                <div class="col-lg-4 mb-2 mb-lg-0"><img src="/front/images/VID.png" alt="VID"></div>
                <div class="col-lg-8">
                    <ul class="nav-footer">

                        <li><a href="{{ route('site.page', 'terms-of-service') }}">Правила сервиса</a></li>
                        <li><a href="{{ route('site.page', 'offerta') }}"> Оферта</a></li>
                        <li><a href="{{ route('site.page', 'privacy-policy') }}">Политика конфиденциальности</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-middle">
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col">
                            <span class="title-footer">{{ __('Аккаунт') }}</span>
                            <ul class="links-footer">
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
                            <span class="title-footer">{{ __('Компания') }}</span>
                            <ul class="links-footer">
                                <li><a href="{{ route('site.page', 'about') }}">О
                                        компании</a></li>
                                <li>
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
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row text-center">
                        <div class="col-6">
                            <span class="title-footer font-size-increase">Скоро в Play market и App store</span>

                            <ul class="links-footer mt-2">
                                <li>

                                    <img src="/resources/images/appstore-black.svg" alt="">

                                </li>

                                <li>
                                    <img src="/resources/images/googleplay-black.svg" alt="">

                                </li>
                            </ul>
                        </div>

                        <div class="col-6">
                            <ul class="links-footer" style="margin-left: 10px; text-align: center;">
                                <span class="title-footer">А пока вы можете скачать приложение с нашего сайта</span>
                                <li class="mt-4">
                                    <a href="/itcase.apk">
                                        <img src="/resources/images/download-android.png" alt="" style="vertical-align: middle;"> Скачать
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-md-flex text-center justify-content-between">
            <div class="copyright">© {{ now()->year }} itcase.com
                {{ __('Все права защищены.') }}
            </div>
            <ul class="social-footer">
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
</footer>
