@extends('site.layouts.static')

@section('title', '<<< Title Here >>>')

@section('headerjs')
  <script>try { /* Source: https://www.jqueryscript.net/demo/jQuery-Plugin-For-Responsive-Hexagon-Grid-Layout-Honeycombs/homeycombs/js/jquery.homeycombs.js
Forked and changed by Anand Graves.
*/

(function($) {
  $.fn.honeycombs = function(options) {
    // Establish our default settings
    var settings = $.extend({
      combWidth: 180,
      margin: 20,
    }, options);

    function initialise(element) {
      var width = 0;
      var combWidth = 0;
      var combHeight = 0;
      var num = 0;
      var $wrapper = null;

      console.log(element);

      /**
       * Build the dom
       */
      function buildHtml() {
        // add the 2 other boxes
        $wrapper = $(element).find('.honeycombs-inner-wrapper');
        num = 0;

        $(element).find('.comb').each(function() {
          num = num + 1;

          if ($(this).find('span.comb-title').length > 0) {
            $(this)
              .find('.inner_span .inner-text-title')
              .html($(this).find('span.comb-title').html());
          }

          if ($(this).find('span.comb-description-short').length > 0) {
            $(this)
              .find('.inner_span .inner-text-description-short')
              .html($(this).find('span.comb-description-short').html());
          }
        });
      }

      /**
       * Update all scale values
       */
      function updateScales() {
        combWidth = settings.combWidth;
        combHeight = (Math.sqrt(3) * combWidth) / 2;
        edgeWidth = combWidth / 2;

        $(element).find('.comb').width(combWidth).height(combHeight);
        $(element).find('.hex_l, .hex_r').width(combWidth).height(combHeight);
        $(element).find('.hex_inner').width(combWidth).height(combHeight);
      }

      /**
       * update css classes
       */
      function reorder(animate) {

        updateScales();
        width = $(element).width();

        newWidth = (num / 1.5) * settings.combWidth;

        if (newWidth < width) {
          width = newWidth;
        }

        $wrapper.width(width);

        var row = 0; // current row
        var upDown = 1; // 1 is down
        var left = 0; // pos left
        var top = 0; // pos top
        var cols = 0;

        $(element).find('.comb').each(function(index) {
          top = (row * (combHeight + settings.margin)) + (upDown * (combHeight / 2 + (settings.margin / 2)));

          if (animate === true) {
            $(this).stop(true, false);
            $(this).animate({
              'left': left,
              'top': top
            });
          } else {
            $(this).css('left', left).css('top', top);
          }

          left = left + (combWidth - combWidth / 4 + settings.margin);
          upDown = (upDown + 1) % 2;

          if (row === 0) {
            cols = cols + 1;
          }

          if (left + combWidth > width) {
            left = 0;
            row = row + 1;
            upDown = 1;
          }
        });

        $wrapper
          .width(cols * (combWidth / 4 * 3 + settings.margin) + combWidth / 4)
          .innerHeight((row + 1) * (combHeight + settings.margin) + combHeight / 2);
      }

      function getTopInfoBlock(el) {
        return $(el).css('top');
      }

      /*
       * Return the left value as a number without the string 'px'
       */
      function getLeftInfoBlock(el) {
        return parseInt($(el).css('left').slice(0, -2), 10);
      }

      function calculateTopInfoBlock(top) {
        return 'calc(155px + ' + top + ')';
      }

      function setLeftInfoBlock(el, target) {
        var $infoBlock = $(el).find('.inner-text-description-long');
        var combWidth = parseInt(target.width(), 10);
        var infoBlockWidth = parseInt($infoBlock.width(), 10);
        var leftCalculated = getLeftInfoBlock(target) - (infoBlockWidth / 2) + (combWidth / 2) + 'px';

        $infoBlock.css('left', leftCalculated);
      }

      function setTopInfoBlock(el, target) {
        $(el).find('.inner-text-description-long').css('top', calculateTopInfoBlock(getTopInfoBlock(target)));
      }

      // Show info block with long description
      function setCurrElementActive(el) {
        $(el).find('.inner-text-description-long').addClass('active');
      }

      /*
       * Check if the currently active info block has a negative left position
       *
       */
      function CheckInfoBlockOutsideViewport(el) {
        var $infoBlock = $(el).find('.inner-text-description-long');
        var left = getLeftInfoBlock($infoBlock);

        // Get the left position of the parent relative to the document
        var $parentLeft = $(el).parent().offset().left;

        // Determine the position of the right side of the bouding box of the Info Block
        var right = Math.round($parentLeft + left + $infoBlock.outerWidth());
        var $viewport = $(window).width();

        if (left < 0) {
          $infoBlock.css('left', '0');
        }

        // Check if the info block is outisde the viewport
        if (right > $viewport) {
          var delta = right - $viewport;
          $infoBlock.css('left', (left - delta - 10) + 'px');
        }
      }

      // Remove all classes '.active'
      function removeActiveElements() {
        $('.comb-container .active').each(function() {
          $(this).removeClass('active');
        });
      }

      function clickInfoBlockHandler(event) {
        event.preventDefault();

        var comb = $(this).find('.comb');
        var $dataLink = $(this).find('.inner-text-description-long').attr('data-link');

        // If long description is empty and data-link attribute is available, then follow the link directly
        if (!$dataLink) {
          setLeftInfoBlock('.comb-container', comb);
          CheckInfoBlockOutsideViewport('.comb-container');
          setTopInfoBlock('.comb-container', comb);
          removeActiveElements();
          setCurrElementActive(event.currentTarget);
        } else {
          window.location = $dataLink;
        }
      }

      function closeBtnHandler(event) {
        event.stopImmediatePropagation();
        $(this).closest('.active').removeClass('active');
      }

      function infoBlockReadMoreHandler(event) {
        var $link = $(event.target).attr('href');
        window.location = $link;
      }

      function addEvents() {
        $('.honeycombs').on('click', '.comb-container', clickInfoBlockHandler);
        $('.close').on('click', closeBtnHandler);

        // TOFIX: don't let javascript hijack the click event, but that it can be opened in a new tab with keyboard/mouse
        $(".inner-text-description-long").on('click', 'a', infoBlockReadMoreHandler);
      }

      /* When the honeycomb is used in a tab interface, as used on the /uitdaging about pages,
       * the honeycomb needs to be initialized to calculate the css to position the honeycombs.
       */
      function reInitializeInTab() {
        // Assuming parent is .container and the next parent is #about
        if ($('.honeycombs').closest('.container').parent().attr('id') === 'about') {
          $('.challenge_menu a').on('click', function(event) {
            reorder(false);
          });
        }
      }

      $(window).resize(function() {
        reorder(true);
      });

      buildHtml();
      reorder(false);
      addEvents();
      reInitializeInTab();
    }

    return this.each(function() {
      console.log('test in each function');
      initialise(this);
    });
  };
}(jQuery));

jQuery(document).ready(function($) {
  $('.honeycombs').honeycombs();
});
 } catch (e) { console.error('Custom Theme JS Code: ', e); }</script>
@endsection

@section('content')
  <div class="uk-section-muted uk-section uk-section-xlarge">
            <div class="uk-container">
              <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">
                <div class="uk-width-1-1@m uk-first-column">
                  <div class="uk-text-muted uk-margin">Hire Me</div>
                  <div class="uk-heading-small uk-margin-remove-top">
                    Для размещения вашей компании<br class="uk-visible@l">в справочнике TezInfo, свяжитесь<br class="uk-visible@l">с нами по номеру, <span id="cloakf881cf6bae2a20b8839750fe77dd6007"><a href="tel:+998953411717">+99895 341 1717</a></span>
                  </div>
            </div>
          </div>
        </div>    
      </div>
      <div class="uk-section-default" tm-header-transparent="dark" tm-header-transparent-placeholder="">
        <div data-src="/pub/images/yootheme/home-bg.svg" uk-img="" class="uk-background-norepeat uk-background-cover uk-background-top-center uk-section uk-section-large uk-padding-remove-top" style="background-image: url(&quot;http://localhost/pub/images/yootheme/home-bg.svg&quot;);">
          <div class="uk-container">
            <div class="tm-header-placeholder uk-margin-remove-adjacent" style="height: 160px;"></div>
            <div class="uk-grid-large uk-grid-margin-large uk-grid uk-grid-stack" uk-grid="">
              <div class="uk-width-expand@s uk-flex-first@s uk-first-column">
                <h1 class="uk-heading-xlarge">Центр Государственных Услуг</h1>
                <div class="uk-text-lead uk-margin-large">
                  <p class="uk-margin-medium-bottom">Вы так же можете ознакомиться с информацией, о размещении рекламы в центре госсударственных услуг. </p>
                </div>
              </div>
            </div>
            <div class="uk-margin-xlarge uk-grid" uk-grid="">
              <div class="uk-width-expand@s uk-first-column">
                <h2 class="uk-h4 uk-heading-bullet uk-margin-medium">Реклама в гос-услугах</h2>
                <ul class="uk-list uk-list-large">        
                  <li class="el-item">
                    <div class="el-content uk-panel">
                      <a href="http://localhost/pub/#" uk-scroll="" class="el-link uk-link-text">Реклама на стойках для баннеров</a>
                    </div>
                  </li>
                  <li class="el-item">
                    <div class="el-content uk-panel">
                      <a href="http://localhost/pub/#" uk-scroll="" class="el-link uk-link-text">Флаера на инфо стендах и реклама на флаерах</a>
                    </div>
                  </li>
                  <li class="el-item">
                    <div class="el-content uk-panel">
                      <a href="http://localhost/pub/#" uk-scroll="" class="el-link uk-link-text">Реклама на планшете
                      </a>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="uk-width-expand@s">
                <h2 class="uk-h4 uk-heading-bullet uk-margin-medium">Upcoming Talks</h2>
                <ul class="uk-list uk-list-large">        
                  <li class="el-item">
                    <div class="el-content uk-panel">
                      <a href="http://localhost/pub/#" uk-scroll="" class="el-link uk-link-text">Ролики на ТВ</a>
                    </div>
                  </li>
                  <li class="el-item">
                    <div class="el-content uk-panel">
                      <a href="http://localhost/pub/#" uk-scroll="" class="el-link uk-link-text">Реклама на пакетах
                      </a>
                    </div>
                  </li>
                  <li class="el-item">
                    <div class="el-content uk-panel">
                      <a href="http://localhost/pub/#" uk-scroll="" class="el-link uk-link-text">Проведение промо-акции
                      </a>
                    </div>
                  </li>
                </ul>
                <div class="uk-margin-medium">
                
                </div>
              </div>
              <div class="uk-width-expand@s">              
                <h2 class="uk-h4 uk-heading-bullet uk-margin-medium">Latest Posts</h2>
                <ul class="uk-list uk-list-large uk-width-medium">        
                  <li class="el-item">
                    <div class="el-content uk-panel">
                      <a href="http://localhost/pub/index.php/blog/10-how-to-create-web-animations-with-only-html-and-css" class="el-link uk-link-text">Визитки
                      </a>
                    </div>
                  </li>
                  <li class="el-item">
                    <div class="el-content uk-panel">
                      <a href="http://localhost/pub/index.php/blog/11-a-guide-to-using-filters-in-vue-js" class="el-link uk-link-text">Реклама на кулерах
                      </a>
                    </div>
                  </li>
                  <li class="el-item">
                    <div class="el-content uk-panel"></div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
