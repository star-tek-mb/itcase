<!doctype html>
<html lang="ru">
<head>
    <meta name="theme-color" content="#5933F2">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')


    <link rel="shortcut icon" type="image/png" href="https://via.placeholder.com/16x16">
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/flaticon-category.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/jquery.mCustomScrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap&subset=cyrillic"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap" rel="stylesheet">

@yield('css')
<!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/img/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon-180x180.png') }}">
    <link rel="canonical" href="{{ request()->fullUrl() }}">
    <!-- END Icons -->
    <title>
        @yield('title') | vid.uz
    </title>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let menuItems = document.querySelectorAll('.menu-item-li');
            menuItems.forEach(function (item) {
                item.addEventListener('click', function (event) {
                    if (!event.target.classList.contains('menu-item-link-arrow')
                        && !event.target.classList.contains('menu-item-link-arrow-image')) {
                        event.stopPropagation();
                    }
                }, true);
            });
        })
    </script>
    <script src="{{ asset('assets/js/uikit.js') }}"></script>
    <script src="{{ asset('assets/js/uikit-icons.min.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-138129426-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-138129426-3');
    </script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(60708610, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/60708610" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
</head>
<body @if (request()->path() == '/') class="home" @endif>
<div class="wrapper" id="wrapper">


    @yield('header')

    <div class="container">
        @include('site.components.alerts')
    </div>
    <main class="main-content">
        <div id="content">
            @yield('content')
        </div>
    </main>

    @include('site.layouts.partials.footer')
    @include('site.components.contractors')
</div>

<script src="/front/js/jquery.min.js"></script>
<script src="/front/js/popper.min.js"></script>
<script src="/front/js/bootstrap.min.js"></script>
<script src="/front/js/slick.js"></script>
<script src="/front/js/jquery-ui.js"></script>
<script src="/front/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/front/js/imagesloaded.pkgd.js"></script>
<script src="/front/js/isotope.pkgd.min.js"></script>
<script src="/front/js/jquery.magnific-popup.min.js"></script>
<script src="/front/js/main.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let menuItemArrows = document.querySelectorAll('.menu-item-link-arrow');
        menuItemArrows.forEach(function (arrow) {
            arrow.addEventListener('click', function () {
                console.log(this);
                this.children[0].classList.toggle('menu-item-link-arrow-rotate');
                let dropdown = this.parentNode.nextElementSibling;
                dropdown.parentNode.classList.toggle('uk-open');
                if (dropdown.hasAttribute('hidden')) {
                    dropdown.removeAttribute('hidden');
                } else {
                    dropdown.setAttribute('hidden', 'hidden');
                }
            })
        });
        let needItems = document.querySelectorAll('.need-item');
        needItems.forEach(function (item) {
            item.addEventListener('click', function (event) {
                if (!event.target.classList.contains('menu-item-link-arrow')) {
                    menuItemArrows.forEach(function (arrow) {
                        arrow.classList.remove('menu-item-link-arrow-rotate');
                    });
                }
            })
        });
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script>
    $(function() {
        $('.tender-item').on('click', function () {
            let url = $(this).data('target');
            window.location.href = url;
        });
        $('.notification-button').on('click', function () {
            $.get("{{ route('site.account.notifications.read') }}", function (data) {
                $('.numeric').addClass('d-none');
            });
        })
    });
</script>
</body>
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Store",
      "image": [
        "https://lh3.googleusercontent.com/proxy/RomJGetxyExSuPoNnZJKatWVJtl5XU3OFfcnpg57HN12QIQ9yG6uoK4gDm74Cu6OK088oxzsi_ls_IExxfZ5spEj5TZwR9oILWSPkR00SA9UF8GnntVLiLf-VWb5FSI2PdlfJg"
       ],
      "@id": "vid.uz",
      "name": "Каталог фриланс исполнителей и компаний для продвижения бизнеса",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Yunusobod 13",
        "addressLocality": "Tashkent",
        "addressRegion": "UZ",
        "postalCode": "100114",
        "addressCountry": "UZ"
      },
      "review": {
        "@type": "Review",
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "4",
          "bestRating": "5"
        },
        "author": {
          "@type": "Person",
          "name": "Murad Ikramhodjaev"
        }
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 41.2825125,
        "longitude": 69.1392828
      },
      "url": "https://www.vid.uz",
      "telephone": "+998909408196",
      "priceRange": "$$$",
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": [
            "Monday",
            "Tuesday"
          ],
          "opens": "9:00",
          "closes": "22:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": [
            "Wednesday",
            "Thursday",
            "Friday"
          ],
          "opens": "9:00",
          "closes": "23:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "Saturday",
          "opens": "9:00",
          "closes": "23:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "Sunday",
          "opens": "9:00",
          "closes": "22:00"
        }
      ]

    }

</script>
<script>
    $('.form-control').bind("change keyup input click", function () {
        if ($(this).val().length >= 2) {

            $.ajax({
                method: 'POST',
                url: "/live-search",
                data: {search:$(this).val(), _token: '{{csrf_token()}}'},
                success: function(data) {
                  //  $('.form-control').parents('.form-group').html(data).fadeIn();
                    $('#livesearch').attr('style','border: 1px solid rgb(165, 172, 178); background: lightgrey;');
                    $('#livesearch').html(data).fadeIn();
                    console.log(data);
                }
            });

        }
    });
</script>
@yield('js')
</html>
