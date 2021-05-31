/*
|-------------------------------------------------------------------------
| version 1.0
| 
|--------------------------------------------------------------------------
| 
| -------------------------------------------------------------------------
*/

var ITCASE = {},
  $ = jQuery.noConflict();



!(function (f) {
  "use strict";

  var scroll = f(window).scrollTop(),
    scrollTop = f('#scrollTop');

  (ITCASE.toShow = {
    functions: function () {
      ITCASE.toShow.elementToShow();
    },
    elementToShow: function (element, elementToShow, showClass) {
      var showClass = showClass || 'active',
        elementToShow = elementToShow;

      if (element.length > 0) {
        f(element).on('click', function () {

          if (f(elementToShow).hasClass(showClass)) {
            f(elementToShow).removeClass(showClass)
          }
          else {
            f(elementToShow).addClass(showClass)
          }
        });
      }
    }
  }),

    (ITCASE.elements = {
      functions: function () {

        ITCASE.elements.tabs(),
          ITCASE.elements.slider(),
          ITCASE.elements.checkbox(),
          ITCASE.elements.modal()
      },


      slider: function () {
        var swiper = new Swiper('.carousel', {
          slidesPerView: 3.8,
          loop: true,
          speed: 1000,
          spaceBetween: 55,
          centeredSlides: true,
          autoplay: {
            delay: 5000,
          },

          breakpoints: {
            480: {
              slidesPerView: 1,
              touchRatio: 1,
              centeredSlides: false,
            },

            992: {
              slidesPerView: 1,
              touchRatio: 1,
              enteredSlides: false,
              spaceBetween: 0,
            },
          },

          navigation: {
            nextEl: '#next',
            prevEl: '#prev',
          },

          /*pagination: {
            el: '.scrollable-pagination',
            type: 'progressbar'
          },*/
        });


        var swiper = new Swiper('.slider', {
          slidesPerView: 1,
          loop: true,
          speed: 1000,
          autoplay: {
            delay: 4000,
          },
          pagination: {
            el: '.slider-pagination',
            clickable: true
          }
        });



        var swiper = new Swiper('.slider-vertical', {
          slidesPerView: 1,
          loop: true,

          pagination: {
            el: '.slider-vertical-pagination',
            clickable: true
          },
          direction: "vertical"
        });


        var swiper = new Swiper('.slider-blog', {
          slidesPerView: 2,
          loop: true,
          speed: 1000,
          spaceBetween: 120,
          autoplay: {
            delay: 5000,
          },

          breakpoints: {
            480: {
              slidesPerView: 1,
              touchRatio: 1,
              centeredSlides: false,
            },

            992: {
              slidesPerView: 1,
              touchRatio: 1,
              enteredSlides: false,
              spaceBetween: 0,
            },
          },

          pagination: {
            el: '.slider-pagination',
            clickable: true
          },

          /*pagination: {
            el: '.scrollable-pagination',
            type: 'progressbar'
          },*/
        });



        var swiper = new Swiper('.slider-soon', {
          slidesPerView: 3,
          loop: true,
          speed: 1000,
          spaceBetween: 85,
          autoplay: {
            delay: 5000,
          },

          breakpoints: {
            480: {
              slidesPerView: 1,
              touchRatio: 1,
              centeredSlides: false,
              spaceBetween: 0,
            },

            992: {
              slidesPerView: 1,
              touchRatio: 1,
              enteredSlides: false,
              spaceBetween: 0,
            },
          },

          pagination: {
            el: '.slider-pagination',
            clickable: true
          },

          /*pagination: {
            el: '.scrollable-pagination',
            type: 'progressbar'
          },*/
        });
      },


      checkbox: function () {
        f('input[type="checkbox"]').change(function (e) {
          var checked = f(this).prop("checked"),
            container = f(this).parent(),
            siblings = container.siblings();
          container.find('input[type="checkbox"]').prop({
            indeterminate: false,
            checked: checked
          });
          function checkSiblings(el) {
            var parent = el.parent().parent(),
              all = true;
            el.siblings().each(function () {
              let returnValue = all = (f(this).children('input[type="checkbox"]').prop("checked") === checked);
              return returnValue;
            });
            if (all && checked) {
              parent.children('input[type="checkbox"]').prop({
                indeterminate: false,
                checked: checked
              });
              checkSiblings(parent);
            } else if (all && !checked) {
              parent.children('input[type="checkbox"]').prop("checked", checked);
              parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
              checkSiblings(parent);
            } else {
              el.parents("li div").children('input[type="checkbox"]').prop({
                indeterminate: true,
                checked: false
              });

            }
          }
          checkSiblings(container);
        });

        f('.categories .arrow').on('click', function () {
          if (f(this).parent().hasClass('active')) {
            f(this).parent().removeClass('active');
            f(this).removeClass('active')
          }
          else {
            f(this).parent().addClass('active');
            f(this).addClass('active')
          }
        })

      },

      modal: function () {
        f('.button--full').on('click', function (e) {
          var modal = f(this).data('modal');
          e.preventDefault();

          if (modal.length > 0) {
            f('body').addClass('hidden');
            f('.cover').addClass('active');
            f(modal).addClass('active')
          }

          else {
            return false;
          }
        });

        function removeCl() {
          f('body').removeClass('hidden');
          f('.cover').removeClass('active');
          f(modal).removeClass('active')
        }


        f('.cover').on('click', function (e) {
          
          removeCl()
        })

        f('.close').on('click', function (e) {
          e.preventDefault();
          removeCl()
        })
      },



      accordeon: function () {
        var i = f(".accordeon__item");
        i.length &&
          (i.each(function () {
            var i = f(this);
            i.hasClass("active") ? i.addClass("active") : i.find(".accordeon__content").hide();
          }),

            f(document).on('click', ".accordeon__title", function () {
              var e = f(this),
                a = e.parents(".accordeon__item"),
                s = a.parents(".accordion");
              return (
                a.hasClass("active")
                  ? s.hasClass("toggle")
                    ? (a.removeClass("active"), a.find(".accordeon__content").slideUp())
                    : (s.find(".accordeon__item").removeClass("active"), s.find(".accordeon__content").slideUp())
                  : (s.hasClass("toggle") || (s.find(".accordeon__item").removeClass("active"), s.find(".accordeon__content").slideUp()), a.addClass("active"), a.find(".accordeon__content").slideToggle()),
                i.preventDefault(),
                !1
              );
            }));
      },



      tabs: function () {


        f('.tabs-stage .tab').hide();
        f('.tabs-stage .tab:first').show();
        f('.tabs-nav li:first a').addClass('router-link-active');


        f('.tabs-nav a').on('click', function (e) {
          e.preventDefault();
          f('.tabs-nav li a').removeClass('router-link-active');
          f(this).addClass('router-link-active');
          f('.tabs-stage .tab').hide();
          f(f(this).attr('href')).show();
        });


      },



    });


  /* INIT */
  f(document).ready(function () {
    ITCASE.elements.functions();
  });



  f(window).on('load', function () {
    ITCASE.elements.slider()
  })

})(jQuery);
