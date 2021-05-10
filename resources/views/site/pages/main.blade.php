<!doctype html>
<!--[if lte IE 9]>     <html lang="en" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-focus"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>ExpressInfo</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">


	<!-- Icons -->
	<!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
	<link rel="shortcut icon" href="{{ asset('assets/img/favicons/favicon.png') }}">
	<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/img/favicons/favicon-192x192.png') }}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon-180x180.png') }}">
	<!-- END Icons -->
	<link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.min.css')}}">
	<link rel="stylesheet" href="{{ asset('css/steps.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/third_party.css?')}}ver=73">
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
	<style>
		.mobile_main_item_outer svg{
			filter: drop-shadow(#4c4949 0px 6px 8px);
		}
		.mobile_main_item_outer:hover > svg{
			transition: 0.8s;
			filter: drop-shadow(#4c4949 0px 18px 19px) contrast(150%);
		}
		p.category-name {
			font-family: "Roboto-Bold";
			text-align: center;
			color: white;
		}
	</style>
	<noscript><div><img src="https://mc.yandex.ru/watch/54773344" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->
</head>
<body style="background-color: #ffffff;">
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
<div class="mobile_main_bg" style="background-image: url({{ asset('assets/img/mobile_main_bg.jpg') }})">
	<div class="mobile_main_bg_white">
		<div class="mobile_main_header">
			<!-- <img src="/uploads/mobile_logo.png" alt="" class="mobile_main_header_logo"> -->
			<div class="mobile_main_header_logo">
				<a href="http://tezinfo.uz/">
					<img src="{{ asset('assets/img/logo.png') }}" alt="">
				</a>
				<div class="mobile_main_header_logo_text" style="width:100%">
					<a href="http://porta.uz/" class="mobile_main_header_logo_text_title" style="text-transform: uppercase;">
						Tezinfo.uz
					</a>
					<h1 class="mobile_main_header_logo_text_small">
						<span style="letter-spacing: 2.2px;">ЭКСПРЕСС ИНФО ПОРТАЛ</span><br>
						<span style="letter-spacing: 3.7px;">EXPRESS INFO PORTAL</span>
					</h1>
				</div>
			</div>
			<div class="mobile_main_header_inner">
				<div class="mobile_main_header_list">
					<a href="#">RU</a>
					|
					<a href="#">EN</a>
					|
					<a href="#">UZ</a>
				</div>
				<!-- <div class="mobile_main_header_nav_btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </div> -->
				<div class="hidden_back" style="display: none;"></div>
				<ul class="nav header_nav main_nav" style="display: none;">
					<button class="mob_nav_close"></button>
					<li class="nav-item">
						<a class="nav-link" href="/"><h5 class="m-0">Главная</h5></a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="{{route('site.catalog.index')}}"><h5 class="m-0">Express Info</h5></a>
					</li>
				</ul>
			</div>
		</div>
		<div class="mobile_main">
			<div class="mobile_main_top">
				<p class="mobile_main_top_text pt-10">EXPRESS INFO PORTAL</p>
			</div>
			<div class="mobile_main_inner">
				<div class="mobile_main_item mobile_main_item_gap">
					<div class="mobile_main_item_outer">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="174" height="200" viewbox="0 0 173.20508075688772 200"><path fill="#8BC34A" d="M77.94228634059948 4.999999999999999Q86.60254037844386 0 95.26279441628824 4.999999999999999L164.54482671904333 45Q173.20508075688772 50 173.20508075688772 60L173.20508075688772 140Q173.20508075688772 150 164.54482671904333 155L95.26279441628824 195Q86.60254037844386 200 77.94228634059948 195L8.660254037844387 155Q0 150 0 140L0 60Q0 50 8.660254037844387 45Z"></path></svg>
						<div class="mobile_main_item_inner">
							<a href="{{route('site.catalog.index')}}" class="mobile_main_item_inner_link">
								<img src="{{ asset('assets/img/2.png') }}" alt="Bussines Info" class="mobile_main_item_icon">
								<!-- <img src="/uploads/mobile_item_logo_1.png" alt="" class="mobile_main_item_icon"> -->
							</a>
						</div>
					</div>
				</div>

				<div class="mobile_main_item">
					<div class="mobile_main_item_outer">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="174" height="200" viewbox="0 0 173.20508075688772 200"><path fill="#20C2CC" d="M77.94228634059948 4.999999999999999Q86.60254037844386 0 95.26279441628824 4.999999999999999L164.54482671904333 45Q173.20508075688772 50 173.20508075688772 60L173.20508075688772 140Q173.20508075688772 150 164.54482671904333 155L95.26279441628824 195Q86.60254037844386 200 77.94228634059948 195L8.660254037844387 155Q0 150 0 140L0 60Q0 50 8.660254037844387 45Z"></path></svg>
						<div class="mobile_main_item_inner">
							<a href="http://forb.uz/" class="mobile_main_item_inner_link">
								<img src="{{ asset('assets/img/forb.png') }}" alt="" class="mobile_main_item_icon">
							</a>
						</div>
					</div>
				</div>
				<div class="mobile_main_item">
					<div class="mobile_main_item_outer">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="174" height="200" viewbox="0 0 173.20508075688772 200"><path fill="#FF9800" d="M77.94228634059948 4.999999999999999Q86.60254037844386 0 95.26279441628824 4.999999999999999L164.54482671904333 45Q173.20508075688772 50 173.20508075688772 60L173.20508075688772 140Q173.20508075688772 150 164.54482671904333 155L95.26279441628824 195Q86.60254037844386 200 77.94228634059948 195L8.660254037844387 155Q0 150 0 140L0 60Q0 50 8.660254037844387 45Z"></path></svg>
						<div class="mobile_main_item_inner">
							<a href=" {{ route('home.cgu.info.category', 1) }}" class="mobile_main_item_inner_link">
								<img src="{{ asset('assets/img/mobile_item_logo_3.png') }}" alt="" class="mobile_main_item_icon">
							</a>
						</div>
					</div>
				</div>
				<div class="mobile_main_item mobile_main_item_center">
					<div class="mobile_main_item_inner">
						<img src="{{ asset('assets/img/center_icons.png') }}" alt="" class="mobile_main_item_icon">
					</div>
				</div>
				<div class="mobile_main_item">
					<div class="mobile_main_item_outer">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="174" height="200" viewbox="0 0 173.20508075688772 200"><path fill="#9C28B1" d="M77.94228634059948 4.999999999999999Q86.60254037844386 0 95.26279441628824 4.999999999999999L164.54482671904333 45Q173.20508075688772 50 173.20508075688772 60L173.20508075688772 140Q173.20508075688772 150 164.54482671904333 155L95.26279441628824 195Q86.60254037844386 200 77.94228634059948 195L8.660254037844387 155Q0 150 0 140L0 60Q0 50 8.660254037844387 45Z"></path></svg>
						<div class="mobile_main_item_inner">
							<a href="{{ route('home.cgu.info.category', 6) }}" class="mobile_main_item_inner_link">
								<img src="{{ asset('assets/img/logo-gerb.png?ver=2') }}" alt="" class="mobile_main_item_icon">
							</a>
						</div>
					</div>
				</div>
				<div class="mobile_main_item mobile_main_item_gap">
					<div class="mobile_main_item_outer">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="174" height="200" viewbox="0 0 173.20508075688772 200"><path fill="#0B72C6" d="M77.94228634059948 4.999999999999999Q86.60254037844386 0 95.26279441628824 4.999999999999999L164.54482671904333 45Q173.20508075688772 50 173.20508075688772 60L173.20508075688772 140Q173.20508075688772 150 164.54482671904333 155L95.26279441628824 195Q86.60254037844386 200 77.94228634059948 195L8.660254037844387 155Q0 150 0 140L0 60Q0 50 8.660254037844387 45Z"></path></svg>
						<div class="mobile_main_item_inner">
							<a href="{{ route('home.cgu.info.category', 30) }}" class="mobile_main_item_inner_link">
								<img src="{{ asset('assets/img/1.png') }}" alt="" class="mobile_main_item_icon">
							</a>
						</div>
					</div>
				</div>
				<div class="mobile_main_item">
					<div class="mobile_main_item_outer">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="174" height="200" viewbox="0 0 173.20508075688772 200"><path fill="#F9690E" d="M77.94228634059948 4.999999999999999Q86.60254037844386 0 95.26279441628824 4.999999999999999L164.54482671904333 45Q173.20508075688772 50 173.20508075688772 60L173.20508075688772 140Q173.20508075688772 150 164.54482671904333 155L95.26279441628824 195Q86.60254037844386 200 77.94228634059948 195L8.660254037844387 155Q0 150 0 140L0 60Q0 50 8.660254037844387 45Z"></path></svg>
						<div class="mobile_main_item_inner">
							<a href="{{ route('home.cgu.info.category', 31) }}" class="mobile_main_item_inner_link">
								<img src="{{ asset('assets/img/3.png') }}" alt="" class="mobile_main_item_icon">
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="mobile_main_bottom pb-20">
				<p class="mobile_main_top_text pt-10">ЭКСПРЕСС ИНФО ПОРТАЛ</p>
				<!-- <a href="{{route('site.catalog.index')}}" class="mobile_main_top_title">Publicservice.uz</a> -->
				<!-- <img src="/uploads/wifi-zone.png" alt="" class="mobile_main_bottom_img"> -->
			</div>
		</div>
	</div>

	<div class="mobile_main_links">
		<div class="mobile_main_links_inner d-flex justify-content-center">
			<a href="#" class="mobile_main_links_inner_btn mobile_main_links_inner_btn_contacts">
				Наши Контакты
			</a>
			<a href="#" class="mobile_main_links_inner_btn">
				Информация ЦГУ
			</a>
			<a href="#" class="mobile_main_links_inner_btn">
				Реклама в ЦГУ
			</a>
		</div>
	</div>
</div>
<div class="mobile_main_footer">
	<h1 class="mobile_main_footer_text"><a href="https://itcase.com">ITCASE.com</a></h1>
</div>

<script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.steps.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/third_party.js') }}?ver=6"></script>
<script>
    $(function(){
        var settings = {
            labels: {
                cancel: "Отмена",
                finish: "Отправить",
                next: "Следующее",
                previous: "Предедущее",
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
                $.ajax({
                    type: 'POST',
                    url: '/save/data',
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.form_button_send').text('РџРѕРґРѕР¶РґРёС‚Рµ...');
                        $('.form_button_send').attr('disabled', '');
                    },
                    success: function(data){
                        console.log(data);
                        if(data.success)
                        {
                            $('#wizard').remove();
                            $('.progress').remove();
                            $('.block-content2').append('<img src="/img/success.png">');
                            setTimeout(function(){
                                $('.contacts_popup2').fadeOut(600);
                                $('.form_popup').fadeOut(600);
                            }, 2000);
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
    });
</script>
</body>
</html>
