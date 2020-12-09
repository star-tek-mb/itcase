<!doctype html>
<!--[if lte IE 9]>     <html lang="en" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-focus"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/img/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon-180x180.png') }}">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Codebase framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.min.css') }}?ver=1">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}?ver=1">
    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/third_party.css') }}?ver=107">
<!-- <link rel="stylesheet" href="{{ asset('css/steps.css')}}"> -->
    <style>
        fadethis{
            display: none !important;
        }
        .wizard>.content{
            min-height: 300px !important;
            max-height: 300px !important;
            padding: 17px;
            overflow-y: scroll !important;
        }
        .wizard>.actions a, .wizard>.actions a:hover, .wizard>.actions a:active{
            background: #2184be;
            color: #fff;
            display: block;
            padding: .5em 1em;
            text-decoration: none;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }
        .wizard>.actions .disabled a, .wizard>.actions .disabled a:hover, .wizard>.actions .disabled a:active {
            background: #eee;
            color: #aaa;
        }
        .wizard>.actions ul{
            padding: 0;
            margin: 10px 0 0 0;
        }
        .wizard>.actions li{
            list-style: none;
        }
        .wizard>.content {
            background: #eee;
            display: block;
            margin: 0;
            margin-bottom: 5px;
            min-height: 35em;
            overflow: auto;
            position: relative;
            width: auto;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }
        .wizard .css-control{
            margin: 0 0 7px 0;
        }
        .contacts_popup_wrappper{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .contacts_popup_inner{
            margin: auto;
        }
    </style>
    <!-- END Stylesheets -->
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(54773344, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/54773344" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <meta name="google-site-verification" content="GtV-aJ0pWrb9jGIRoJfHg0X6uL9K53BwD7UWklghfzg" />

</head>
<body>
@include('site.layouts.partials.old.header')

<!-- Main Container -->
<main class="main_container">

    @yield('content')

</main>
<!-- END Main Container -->

@include('site.layouts.partials.old.footer')

<!-- Codebase Core JS -->
<script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/lazyload.min.js"') }}"></script>
<script src="{{ asset('assets/js/third_party.js') }}?ver=17"></script>
<script>
    $(function(){
        var lazyLoadInstance = new LazyLoad({
            elements_selector: ".lazy"
            // ... more custom settings?
        });
        if (lazyLoadInstance) {
            lazyLoadInstance.update();
        }
        var settings = {
            stepsContainerTag: 'fadeThis',
            labels: {
                cancel: "Отмена",
                finish: "Отправить",
                next: "Следующее",
                previous: "Предыдущее",
                loading: "Загрузка ..."
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                if($("input[name='status']:checked").val() != null)
                {
                    return true;
                }else if($("input[name='age']:checked").val() != null)
                {
                    return true;
                }else if($("input[name='sex']:checked").val() != null)
                {
                    return true;
                }else if($("input[name='region']:checked").val() != null)
                {
                    return true;
                }else{
                    return false;
                }
            },
            onStepChanged: function (event, currentIndex, priorIndex) {
                var all = $(".wizard>.content>.body").length;
                var n = (100 / all) * currentIndex;
                if (currentIndex == 0) {
                    $(".progress-bar").css("width", "0%");
                }else{
                    $(".progress-bar").css("width", ""+n+"%");
                }
            },
            onFinished: function (event, currentIndex) {
                $(".progress-bar").css("width", "100%");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var formData = new FormData();
                formData.append('age', $("input[name='age']:checked").val());
                formData.append('status', $("input[name='status']:checked").val());
                formData.append('sex', $("input[name='sex']:checked").val());
                formData.append('region', $("input[name='region']:checked").val());
                $.ajax({
                    type: 'POST',
                    url: '/save/data',
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data){
                        console.log(data);
                        if(data.success)
                        {
                            $('.contacts_popup2').remove();
                            $('.form_popup').remove();
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                console.log('finished');
            },
        };
        $('#wizard').steps(settings);
    })
</script>
@yield('js')
</body>
</html>
