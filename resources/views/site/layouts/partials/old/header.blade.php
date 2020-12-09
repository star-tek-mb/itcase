
<!-- Header -->
<header class="main_header">
    <div class="mobile_search">
        <form class="mobile_search_from" action="#" method="POST" style="width: 100%;">
            @csrf
            <button class="mobile_search_btn mobile_search_close_btn" type="button">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 477.175 477.175" style="enable-background:new 0 0 477.175 477.175;" xml:space="preserve">
                    <path d="M145.188,238.575l215.5-215.5c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-225.1,225.1c-5.3,5.3-5.3,13.8,0,19.1l225.1,225 c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1L145.188,238.575z"/>
                </svg>
            </button>
            <div class="mobile_search_input">
                <input type="text" class="form-control mobile_search_input" id="search" name="search" placeholder="Найти компанию">
            </div>
            <button class="mobile_search_btn" type="submit">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 52.966 52.966" style="enable-background:new 0 0 52.966 52.966;" xml:space="preserve">
                    <path d="M51.704,51.273L36.845,35.82c3.79-3.801,6.138-9.041,6.138-14.82c0-11.58-9.42-21-21-21s-21,9.42-21,21s9.42,21,21,21 c5.083,0,9.748-1.817,13.384-4.832l14.895,15.491c0.196,0.205,0.458,0.307,0.721,0.307c0.25,0,0.499-0.093,0.693-0.279 C52.074,52.304,52.086,51.671,51.704,51.273z M21.983,40c-10.477,0-19-8.523-19-19s8.523-19,19-19s19,8.523,19,19 S32.459,40,21.983,40z"/>
                </svg>
            </button>
        </form>
    </div>
    <div class="contacts_popup" id="contacts_popup">
        <div class="contacts_popup_outer">
            <div class="contacts_popup_inner">
                <h1 class="contacts_popup_inner_title">
                    <i class="fa fa-phone fa-2x"></i>размещение <br> web сайтов и рекламы в цгу:
                </h1>
                <a href="tel:+998953411717" class="contacts_popup_inner_link">
                    +99895 341 17 17
                </a>
                <a href="tel:+998954781717" class="contacts_popup_inner_link">
                    +99895 478 17 17
                </a>
                <a href="tel:+998954761717" class="contacts_popup_inner_link">
                    +99895 476 17 17
                </a>
                <a href="tel:+998954791717" class="contacts_popup_inner_link">
                    +99895 479 17 17
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row main_header_inner">
            <a href="/" class="main_header_logo_outer">
                <div class="main_header_logo">
                    <img src="{{ asset('assets/img/various/logo.png') }}?ver=2" alt="">
                </div>
                <div class="main_header_logo_text">
                    <h1 class="main_header_logo_text_title">
                        Business Info
                    </h1>
                    <p class="main_header_logo_text_small">
                        Бизнес
                        портал
                    </p>
                </div>
            </a>

            <div class="mob_menu_wrapper">
                <button class="mob_menu_wrapper_btn mob_menu_search_btn">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 52.966 52.966" style="enable-background:new 0 0 52.966 52.966;" xml:space="preserve">
                        <path d="M51.704,51.273L36.845,35.82c3.79-3.801,6.138-9.041,6.138-14.82c0-11.58-9.42-21-21-21s-21,9.42-21,21s9.42,21,21,21 c5.083,0,9.748-1.817,13.384-4.832l14.895,15.491c0.196,0.205,0.458,0.307,0.721,0.307c0.25,0,0.499-0.093,0.693-0.279 C52.074,52.304,52.086,51.671,51.704,51.273z M21.983,40c-10.477,0-19-8.523-19-19s8.523-19,19-19s19,8.523,19,19 S32.459,40,21.983,40z"/>
                    </svg>
                </button>

                <button class="mob_menu_wrapper_btn mobile_main_links_inner_btn_contacts">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 29.731 29.731" style="enable-background:new 0 0 29.731 29.731;" xml:space="preserve">
                        <path d="M23.895,29.731c-1.237,0-2.731-0.31-4.374-0.93c-3.602-1.358-7.521-4.042-11.035-7.556 c-3.515-3.515-6.199-7.435-7.558-11.037C-0.307,6.933-0.31,4.245,0.921,3.015c0.177-0.177,0.357-0.367,0.543-0.563 c1.123-1.181,2.392-2.51,4.074-2.45C6.697,0.05,7.82,0.77,8.97,2.201c3.398,4.226,1.866,5.732,0.093,7.478l-0.313,0.31 c-0.29,0.29-0.838,1.633,4.26,6.731c1.664,1.664,3.083,2.882,4.217,3.619c0.714,0.464,1.991,1.166,2.515,0.642l0.315-0.318 c1.744-1.769,3.25-3.296,7.473,0.099c1.431,1.15,2.15,2.272,2.198,3.433c0.069,1.681-1.27,2.953-2.452,4.075 c-0.195,0.186-0.385,0.366-0.562,0.542C26.103,29.424,25.126,29.731,23.895,29.731z M5.418,1C4.223,1,3.144,2.136,2.189,3.141 C1.997,3.343,1.811,3.539,1.628,3.722C0.711,4.638,0.804,7.045,1.864,9.856c1.31,3.472,3.913,7.266,7.33,10.683 c3.416,3.415,7.208,6.018,10.681,7.327c2.811,1.062,5.218,1.152,6.133,0.237c0.183-0.183,0.379-0.369,0.581-0.56 c1.027-0.976,2.192-2.082,2.141-3.309c-0.035-0.843-0.649-1.75-1.825-2.695c-3.519-2.83-4.503-1.831-6.135-0.176l-0.32,0.323 c-0.78,0.781-2.047,0.608-3.767-0.51c-1.193-0.776-2.667-2.038-4.379-3.751c-4.231-4.23-5.584-6.819-4.26-8.146l0.319-0.315 c1.659-1.632,2.66-2.617-0.171-6.138C7.245,1.651,6.339,1.037,5.496,1.001C5.47,1,5.444,1,5.418,1z"/>
                    </svg>
                </button>

                <!--                 <div class="mob_menu_button">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div> -->
            </div>

            <div class="hidden_back" style="display: none;"></div>
            <ul class="nav header_nav main_nav">
                <button class="mob_nav_close"></button>
            </ul>
            <!--             <p class="main_header_number">
                            Отдел рекламы: <a href="tel:">(90) 940 36-66</a>
                        </p> -->

            <div class="main_header_inner_buttons">
                <button class="mobile_main_links_inner_btn_contacts">
                    Контакты
                </button>
                <a href="{{ route('home.cgu.ad') }}">
                    Реклама в ЦГУ
                </a>
            </div>
        </div>
    </div>
</header>
<!-- END Header -->
