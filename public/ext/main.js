$.fn.andSelf = function() {
  return this.addBack.apply(this, arguments);
}
jQuery(document).ready(function ($) {
  "use strict";
  $('#services-carousel').owlCarousel({
    loop: true,
    center: true,
    items: 3,
    margin: 20,
    dots: false,
    nav: true,
    navText: [
      "<div class='nav-btn'><div class='prev-slide'></div></div>",
      "<div class='nav-btn'><div class='next-slide'></div></div>"
    ],
    autoplay: true,
    smartSpeed: 450,
    autoplayTimeout: 8500,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 2
      },
      1170: {
        items: 4
      }
    }
  });
});



jQuery(document).ready(function ($) {
  "use strict";
  $('.offer-carousel').owlCarousel({
    loop: true,
    center: true,
    items: 1,
    margin: 20,
    dots: true,
    nav: false,
    autoplay: true,
    smartSpeed: 450,
    autoplayTimeout: 8500,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 1
      },
      1170: {
        items: 1
      }
    }
  });
});
