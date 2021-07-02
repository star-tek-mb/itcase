window.log = function(param){
    console.log(param);
};

$(function(){
    console.log("ASdasd");
    var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
        isApple = /iPod|iPad|iPhone/i.test(navigator.userAgent),
        $doc = $(document),
        $win = $(window),
        $html = $(document.documentElement);

    $('table').wrap('<div class="table-wrapper"></div>');

    if (isMobile) {
        $('.services-subtitles__item, .services__body').removeClass('wow').removeClass('bounceInLeft').removeClass('slideInDown');
    }

    $win.on('scroll', function(){
        var scrollTop = $(window).scrollTop();
        var headerHeight = $('.header').outerHeight();

        if (scrollTop>90) {
            $('.top-block').addClass('change-bg');
            $()
        } else {
            $('.top-block').removeClass('change-bg');
        }

        if (scrollTop>1) {
            $('.site-container').css('margin-top', headerHeight);
            $('.header').addClass('fixed');
            $()
        } else {
            $('.site-container').removeAttr('style');
            $('.header').removeClass('fixed');
        }
    });

    $('.burger-btn').on('click', function(){
        $('.top-menu').addClass('active');
        $('.menu-default').removeClass('remove_burger');
        $('.burger-btn').addClass('remove_burger');
    });

    $('.top-menu__close').on('click', function(){
        $('.top-menu').removeClass('active');
        $('.menu-default').addClass('remove_burger');
        $('.burger-btn').removeClass('remove_burger');
    });

    $('.top-contacts__address, .footer-contacts__address, .contacts-mob-btn, .contacts-top-btn').on('click', function(){
        var offset = $('.map-block').offset().top;
        $('html, body').animate({
            scrollTop: offset - 90
        });
    });

    if ($(window).width()<768) {
        $('.services-subtitles').click({
            infinite: false,
            speed: 800,
            dots: true,
            arrows: true,
            autoplay: false
        });

        $('.services-subtitles').on('afterChange', function(slick, currentSlide){
            var index = $('.services-subtitles .slick-active').data('slick-index');
            $('.services__body').slideUp();
            $('.services-subtitles__item').removeClass('active');
            $('.services-subtitles .slick-active .services-subtitles__item').addClass('active');
            var activeBody = document.querySelectorAll('.services__body')[index];
            $(activeBody).slideDown();
        });
    }


    $('.services-subtitles__item').on('click', function(){
        if (!$(this).hasClass('active')){
            $('.services-subtitles__item').removeClass('active');
            $('.services__body').slideUp();
            var index = $(this).index();
            var activeBody = document.querySelectorAll('.services__body')[index];
            $(this).addClass('active');
            $(activeBody).slideDown();
        };
    });

    $('.map-contacts__btn').on('click', function(){
        $('.map-contacts__btn').removeClass('active');
        $('.contacts-item').hide();
        var index = $(this).index();
        var activeBody = document.querySelectorAll('.contacts-item')[index];
        $(this).addClass('active');
        $(activeBody).show();
    });

    $('.card-form .form-fields input[type="text"], .card-form .form-fields input[type="password"], .card-form .form-fields input[type="email"], .card-form .form-fields input[type="number"]').focusin(function(event) {
        $(this).addClass('focus');
    });


    $('.card-form .form-fields input[type="text"], .card-form .form-fields input[type="password"], .card-form .form-fields input[type="email"], .card-form .form-fields input[type="number"]').focusout(function(event) {
        $(this).removeClass('focus');
    });

    $('.partners-item__btn a').on('click', function(e){
        e.preventDefault();
        var parent = $(this).parents('.partners-item');
        var index = parent.index();
        var popup = document.querySelectorAll('.partners-popup')[index];

        $('.partners-popup').removeClass('active');
        $(popup).addClass('active');
    });

    $('.partners-popup__close').on('click',function() {
        $('.partners-popup').removeClass('active');
    });

    $(document).on('click', function(event){
        if( $(event.target).closest('.burger-btn, .top-menu').length )
            return;
        $('.top-menu').removeClass('active');
    });

    /*WOW animations*/
    new WOW().init();
    /*WOW animations*/

});