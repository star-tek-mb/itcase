/*
|-------------------------------------------------------------------------
| version 1.0
| 
|--------------------------------------------------------------------------
| 
| -------------------------------------------------------------------------
*/

var DIDIT = {},
  $ = jQuery.noConflict();



!(function (f) {
  "use strict";

  var scroll = f(window).scrollTop(),
    scrollTop = f('#scrollTop');

  (DIDIT.toShow = {
    functions: function () {
      DIDIT.toShow.elementToShow();
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

    (DIDIT.elements = {
      functions: function () {
        DIDIT.elements.preloader(),
          DIDIT.elements.modal(),
          DIDIT.elements.tabs(),
          DIDIT.elements.menu(),
          DIDIT.elements.scrolling(),
          DIDIT.elements.filter(),
          DIDIT.elements.popup(),
          DIDIT.elements.gallery();
      },


      preloader: function () {
        if (f('#preloader').length > 0) {
          f('body').addClass('no-scroll');


          setTimeout(function () {
            setTimeout(function () {
              f('#preloader').fadeOut();
              f('body').removeClass('no-scroll');
            }, 500);
          }, 1500);



        }
      },


      modal: function () {

        if (localStorage['modal'] !== 'no') {

          var cover = f('.cover');

          if (cover.length > 0) {
            f('body').css({
              overflow: "hidden"
            });

            f('.cover').addClass('active');
            f('.wrap').addClass('active');
            f('.close').on('click', function () {
              f(this).parents('.wrap').removeClass('active');
              f('.cover').removeClass('active');


              localStorage.setItem('modal', 'no');


              f('body').css({
                overflow: "visible"
              });
            })
          }

        }

      },

      check: function () {

        /* var ww = f(window).width();
 
 
         if (ww > 768) {
           (scroll > 150) ? f('.menu-holder').addClass('fixed') : f('.menu-holder').removeClass('fixed')
         }*/


        var slides = f('.slider .slide-caption');
        if (slides.length > 0) {
          slides.each(function () {
            var clazz = f(this).find('.d-flex p');

            if (clazz.length == 0) {

              f(this).find('.d-flex .badge').addClass('badge--new');
            }
          })
        }

        var pattern = /\b(Didit)/gi;
        var replaceWith = '<span>$1</span>';
        f('.content p').each(function () {
          f(this).html(f(this).html().replace(pattern, replaceWith));
        });

        f('.cover').on('click', function () {
          f(this).removeClass('active');
          f('.wrap').removeClass('active')
        });




      },

      fix: function () {
        f('.active').removeClass('active')
      },

      preventDefault: function (elem) {
        f(elem).on('click', function (e) {
          e.preventDefault()
        })
      },

      menu: function () {
        f(window).on('scroll', function () {
          var scroll = f(window).scrollTop(),
            ww = f(window).width();


          if (ww > 768) {
            (scroll > 150) ? f('.menu-holder').addClass('fixed') : f('.menu-holder').removeClass('fixed')
          }
        })

        f('.toggle-button').on('click', function (e) {
          e.preventDefault();
          if (f(this).hasClass('active')) {
            f('.menu').removeClass('active');
            f('.toggle-button').removeClass('active')
          }

          else {
            f('.menu').addClass('active');
            f('.toggle-button').addClass('active')
          }
        });

   
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


      filter: function () {
        var $grid = f('.gallery__row').isotope({
          itemSelector: '.gallery__item',
        });


        f('.filter').on('click', '.filter-link', function (e) {
          e.preventDefault();


          var filterValue = f(this).attr('data-filter');
          $grid.isotope({ filter: filterValue });

          f('.gallery__item').removeClass('sorted');
          f(filterValue).addClass('sorted');

          DIDIT.elements.gallery();

        });
      },

      gallery: function () {

        var ww = f(window).width(),
          ic = f('.sorted');



        if (ww > 992) {
          f('.sorted').magnificPopup({
            type: 'image',
            gallery: {
              enabled: true
            }
          });
        }

        else {
          f('.sorted').on('click', function (e) {
            e.preventDefault()
          })
        }

        if (ic.length <= 3) {
          f('.gallery__row').addClass('noborder');
        }

        else {
          f('.gallery__row').removeClass('noborder');
        }

      },


      scrolling: function () {

        f('.menu__list a').click(function (event) {

         
        
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {

              var target = f(this.hash);
              target = target.length ? target : f('[id=' + this.hash.slice(1) + ']');
              if (target.length) {
         
                f('.menu__list a').removeClass('active');
                f(this).addClass('active');
  
                f('html, body').animate({
                  scrollTop: target.offset().top
                }, 1000, function () {
                  var $target = f(target);
                  $target.focus();
                  if ($target.is(":focus")) {
                    return false;
                  } else {
                    $target.attr('tabindex', '-1');
                    $target.focus();
                  };
                });
              }
            }


        
       

         

        
        });



        f('.feature-slide__inner a').on('click', function(e) {
          e.preventDefault()
        })

        /* ANCHOR LINKS */
        f('.scrollTo').on('click', function () {
          var target = f(this.hash);
          target = target.length ? target : f('[id=' + this.hash.slice(1) + ']');

          f("html, body").animate({ scrollTop: target.offset().top }, 800);
          return false;
        })

        /* SCROLL TO TOP BUTTON */
        if (scrollTop.length > 0) {
          f("#scrollTop").click(function () {
            f(this).addClass('active');

            function fly() {
              f("html, body").animate({ scrollTop: 0 }, 800);
            }
            setTimeout(fly, 500);

            function removeclass() {
              f("#scrollTop").removeClass('active');
            }

            setTimeout(removeclass, 1200);

            return false;
          });
        }
      },


      activate: function () {
        var scrollPosition = f(window).scrollTop(),
          ww = f(window).width();


       /* f('.section').each(function () {
          var offsetTop = f(this).offset().top - 50;

          if (scrollPosition >= offsetTop) {
            var attribute = f(this).attr('id');
            f('.menu-list a').removeClass('active');
            f('.menu-list').find('a[href="#' + attribute + '"]').addClass('active');
          }
        });*/


        var menu = f('.menu');


        if (!menu.hasClass('active')) {
          if (scrollPosition >= 150) {
            scrollTop.show();
            f('.header').addClass('active');
            f('body').addClass('header-active');
            f('.menu__list').addClass('active')
          }

          else {
            scrollTop.hide();
            f('.header').removeClass('active');
            f('body').removeClass('header-active');
            f('.menu__list').removeClass('active')
          }
        }
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
        var next_step = f('.tab').find('.next-step');

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

        next_step.on('click', function () {
          f(this).parents('.tabs').find('.tabs-nav a.router-link-activ').removeClass('router-link-active').next('li a').addClass('router-link-active');
          f(this).parents('.tab').hide();
          f(this).parents('.tab').next().show();
        })
      },

      popup: function () {
        f(".video-holder a").magnificPopup({
          type: 'iframe',
          mainClass: 'mfp-fade',
          removalDelay: 160,
          preloader: true,
        });
      },


      parallax: function () {
        var scroll = f(window).scrollTop();
        f(".parallax").css({
          'background-position': "0%" + ((scroll / 15)) + "%"
        });
      }
    });


  /* INIT */
  f(document).ready(function () {
    f('.gallery__item').addClass('sorted');
    DIDIT.elements.check();
    /* DIDIT.toShow.elementToShow('.toggle-button', '.menu-holder', 'active');
     DIDIT.toShow.elementToShow('.close-menu', '.menu-holder', 'active');
     DIDIT.toShow.elementToShow('.toggle-button', '.overlay', 'active');
     DIDIT.toShow.elementToShow('.close-menu', '.overlay', 'active');
     
    
       DIDIT.elements.preventDefault('.close-menu'),
       DIDIT.elements.preventDefault('.toggle-button'),*/


      DIDIT.elements.activate(),
      DIDIT.elements.functions();

    var wow = new WOW(
      /*{
        mobile: false
      }*/
    );
    wow.init();
  });

  /*var posX = 0,
  posY = 0,
  mouseX = 0,
  mouseY = 0;
 
  TweenMax.to({}, 0.016, {
    repeat: -1,
    onRepeat: function() {
      posX += (mouseX - posX) / 9;
      posY += (mouseY - posY) / 9;
      TweenMax.set(cursor, {
        left: mouseX,
        top: mouseY
      } )
    }
  })
 
 
  f(document).on("mousemove", function(e) {
    mouseX = e.pageX;
    mouseY = e.pageY;
    console.log(e.pageX, e.pageY);
    cursor.addClass('active')
  });
 
 */


  /*var cursor = f("#cursor");

  f(document).bind('mousemove', function (e) {
    var offset = f(window).scrollTop();
    /*TweenLite.to(cursor, 0, {left: e.pageX - 0, top: e.pageY - offset - 0});
  // -20 = half of your cursor width & height
  //Offset calculation to prevent position on scroll*/

  /* cursor.css({
     left: e.pageX + 20,
     top: e.pageY - offset - 15,
     pointerEvents: 'none'
   });
 });*/




  /*f('.gallery__item').on("mouseenter", function (e) {
    var h3 = f(this).find('h3').text(),
      span = f(this).find('span').text();


    function addclass() {
      cursor.addClass('active');
      cursor.find('h3').text(h3).addClass('active');
      cursor.find('span').text(span).addClass('active');
    }


    setTimeout(addclass, 50);

  });

  function remove() {
    cursor.find('h3').removeClass('active');
    cursor.find('span').removeClass('active');
    cursor.removeClass('active');
  }

  f('.gallery__item').on("mouseleave", function (e) {
    remove()
  });*/



  f(function () {
    f('.gallery__item').each(function (b) {

      var h3 = f(this).find('h3').text(),
        span = f(this).find('span').text();
      var x = 0;
      var y = 35;


      f(this).mouseover(function (e) {

        var offset = f(window).scrollTop();
        f("body").append('<div class="gallery__item-caption" id="cursor"><h3>' + h3 + '</h3><div><span>' + span + '</span></div></div>');

        function addclass() {
          f('#cursor').find('h3').addClass('active');
          f('#cursor').find('span').addClass('active');
        }

        setTimeout(addclass, 30);


        f('#cursor').css({
          left: e.pageX + 20,
          top: e.pageY - offset - 15,

        }).addClass('active');


      }).mouseout(function () {
        f('#cursor').remove()

      }).mousemove(function (e) {
        var offset = f(window).scrollTop();

        f('#cursor').css({
          left: e.pageX + 20,
          top: e.pageY - offset - 15,
        });
      });
    })

  });




  f(window).on('load', function () {
    DIDIT.elements.slider(),
      DIDIT.elements.filter();
  })



  f(window).on("scroll", function () {
    DIDIT.elements.activate();
    DIDIT.elements.parallax();

  });

  f(window).resize(function () {
    //DIDIT.elements.fix();
    DIDIT.elements.gallery();
  })

})(jQuery);
