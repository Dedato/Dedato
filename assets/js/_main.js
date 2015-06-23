/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can 
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function($) {

// Use this variable to set up the common and page specific functions. If you 
// rename this variable, you will also need to rename the namespace below.
var Dedato = {
  // All pages
  common: {
    init: function() {
      // Minimize Header
      var headertop = $('.banner').offset().top;
      var headerhmax = $('.banner').outerHeight();
      var headerhmin = 60;
      var offset = headerhmax - headerhmin;
      $(window).scroll(function() {
        if( $(window).scrollTop() > headertop ) {
          $('.banner, .wrap').addClass('minimized');
        } else if( $(document).height() <= $(window).scrollTop() + $(window).height() ) {
          // don't do anything
        } else {
          $('.banner, .wrap').removeClass('minimized');
        }
      });
      // FitVids
      $('.entry-video').fitVids({customSelector: "iframe[src^='http://www.at5.nl/video/']"});
      // Social media icon hover effect on touch devices
      $('.banner .social-media .box.taphover').on('touchstart', function (e) {
        var link = $(this);
        if (link.hasClass('hover')) {
          return true;
        } else {
          link.addClass('hover');
          $('.box.taphover').not(this).removeClass('hover');
          e.preventDefault();
          return false;
        }
      });
      // Sharrre
      $('#shareme').sharrre({
         share: {
            twitter: true,
            facebook: true,
            linkedin: true,
            googlePlus: true
         },
         template: '<div class="box"><div class="left">Deel deze pagina</div><div class="middle"><a href="#" class="facebook"><i class="icon-facebook"></i></a><a href="#" class="twitter"><i class="icon-twitter"></i></a><a href="#" class="linkedin"><i class="icon-linkedin"></i></a><a href="#" class="googleplus"><i class="icon-google-plus"></i></a></div><div class="right">{total}</div></div>',
         urlCurl: '/wp-content/themes/dedato/lib/sharrre.php',
         enableHover: false,
         enableTracking: true,
         render: function(api, options){
            $(api.element).on('click', '.twitter', function() {
               api.openPopup('twitter');
            });
            $(api.element).on('click', '.facebook', function() {
               api.openPopup('facebook');
            });
            $(api.element).on('click', '.linkedin', function() {
               api.openPopup('linkedin');
            });
            $(api.element).on('click', '.googleplus', function() {
               api.openPopup('googlePlus');
            });
         }
      });
    }
  },
  // Homepage
  maintenance: {
    init: function() {
     // Flexslider
     $('.flexslider').flexslider({
        animation:        "fade",
        animationLoop:    true,
        smoothHeight:     true,
        slideshowSpeed:   4000,
        animationSpeed:   600,
        touch:            true,
        controlNav:       false
     });
    }
  },
  // Single Project
  single_project: {
    init: function() {
      // Flexslider
      $('.flexslider').flexslider({
        animation:        "fade",
        animationLoop:    true,
        keyboard:         true,
        smoothHeight:     true,
        slideshow:        true, // auto start
        slideshowSpeed:   5000,
        animationSpeed:   600,
        touch:            true,
        controlNav:       false
      });
    }
  },
  // Isotope
  isotope: {
    init: function() {
      // Isotope
      var $container = $('.grid');
      $container.isotope({
        itemSelector:  '.hentry',
        stamp:         '.stamp',
        masonry: {
          columnWidth: 150,
          gutter:      15
        }
      });
      // Reset filters
      $('.side-nav .filters .reset').on('click', function(event) {
        event.preventDefault();
        var filterValue = '*';
        $container.isotope({ filter: filterValue });
        $('.dropdown-menu li a').removeClass('active');
      });
      // Filter items on button click
      $('.side-nav .filters .dropdown-menu li a').on('click', function(event) {
        event.preventDefault();
        var filterValue = '.' + $(this).attr('title');
        $container.isotope({ filter: filterValue });
        $('.grid .post-nav').hide();
        $(this).parent().siblings('li').find('a').removeClass('active');
        $(this).toggleClass('active');
        // Retrieve infinite scroll to force scrolling for more content
        //$('.grid').infinitescroll('retrieve');
        $.ias().next();
      });
    }
  },
  // Infinite Ajax Scroll
  infinitescroll: {
    init: function() {
      // Variables
      var $container = $('.grid');
      var loadingmessage;
      var lastitemmessage;
      if( $('body').is('.page-template-template-home-php, .post-type-archive-project, .tax-discipline') ) {
        if( $('body').is('.nl') ) {
          loadingmessage  = 'Volgende projecten aan het laden';
          lastitemmessage = 'Geen projecten meer om te laden';
          loadprevmessage = 'Laad vorige projecten';
        } else if ( $('body').is('.en') ) {
          loadingmessage  = 'Loading next projects';
          lastitemmessage = 'No more projects to load';
          loadprevmessage = 'Load previous projects';
        }
      } else if( $('body').is('.post-type-archive-publication') ) {
        if( $('body').is('.nl') ) {
          loadingmessage  = 'Volgende publicaties aan het laden';
          lastitemmessage = 'Geen publicaties meer om te laden';
          loadprevmessage = 'Laad vorige publicaties';
        } else if ( $('body').is('.en') ) {
          loadingmessage  = 'Loading next publications';
          lastitemmessage = 'No more publications to load';
          loadprevmessage = 'Load previous publications';
        }
      } else if ( $('body').is('.post-type-archive-client') ) {
        if( $('body').is('.nl') ) {
          loadingmessage  = 'Volgende klanten aan het laden';
          lastitemmessage = 'Geen klanten meer om te laden';
          loadprevmessage = 'Laad vorige klanten';
        } else if ( $('body').is('.en') ) {
          loadingmessage  = 'Loading next clients';
          lastitemmessage = 'No more clients to load';
          loadprevmessage = 'Load previous clients';
        }
      } else {
        if( $('body').is('.nl') ) {
          loadingmessage  = 'Volgende items aan het laden';
          lastitemmessage = 'Geen items meer om te laden';
          loadprevmessage = 'Laad vorige items';
        } else if ( $('body').is('.en') ) {
          loadingmessage  = 'Loading next items';
          lastitemmessage = 'No more items to load';
          loadprevmessage = 'Load previous items';
        }
      }
      /* InfiniteScroll
      var pagesNr = 1;
      $container.infinitescroll({
        loading: {
          msgText:        loadingmessage,
          finishedMsg:    lastitemmessage,
          img:            "/wp-content/themes/dedato/assets/img/dedato/loading-icon.gif",
          speed:          'fast'
        },
        nextSelector:     ".post-nav li.next a",
        navSelector:      ".post-nav",
        itemSelector:     ".grid .hentry",
        },
        // Isotope callback
        function(newElements) {
          pagesNr = pagesNr + 1;
          //var $newElems = $(newElements).hide();
          $('.entry-video').fitVids();
          window.respimage();
          $container.isotope('appended', $(newElements));
        }
      );*/
      
      // Infinite Ajax Scroll 
      var cururl;
      var target;
      var preapp;
      var ias = $.ias({
        container:      ".grid",
        item:           ".hentry",
        pagination:     ".post-nav",
        next:           ".next a",
        delay:          500,
        negativeMargin: 50
      });
      
      // Jump to hashtag and remove it afterwards
      if (window.location.href.indexOf('#') > -1) {
        var url    = window.location.href;
        var hash   = window.location.hash;
        var n      = url.indexOf('#');
        var newurl = url.substring(0, n !== -1 ? n : url.length);
        newurl    += '/';
        target     = newurl.replace(/\/$/, ''); // remove last slash if present
        // unbind scroll function to prevent scrolling to newly added pages
        $(document).scroll( function() {
          $(document).unbind('scroll');
        });
        // if element has this id then scroll to it
        var element  = $('.grid .hentry');
        if ($(hash).length !== 0) {
          element = $(hash);
        }
        // if we have a target then go to it
        if (element !== undefined) {
          $(document).ready(function() {
            window.scrollTo(0, element.position().top);
            window.history.replaceState(null, 'remove hashtag', newurl); // Remove hashtag
          });
        }
        // Update correct page nr on click
        if (!$('html').hasClass('lt-ie9')) {
          $('.entry-content a.permalink').on('click', function(event) {
            event.preventDefault();
            var permalink = $(this).attr('href');
            var hentryid  = $(this).closest('.hentry').attr('name');
            var pagenr    = $(this).closest('.hentry').attr('data-page');
            var pageurl   = target.substring(0, target.lastIndexOf('/') + 1); // store value before last slash
            var orgpagenr = target.substring(target.lastIndexOf('/') + 1, target.length); // store value after last slash
            pageurl      += pagenr + '#' + hentryid; // construct new value
            // Update url and go to permalink
            window.history.replaceState(null, 'updated page nr', pageurl);
            window.location.href = permalink;
          });
        }
      }
      // Infinite Ajax Scroll Extensions
      ias.extension(new IASSpinnerExtension({
        src: "/wp-content/themes/dedato/assets/img/dedato/loading-icon.gif",
        html: "<div class='ias-spinner'><img src='{src}'/><div>"+loadingmessage+"</div></div>"
      }));
      ias.extension(new IASTriggerExtension({
        offset:   50,
        htmlPrev: "<div class='ias-trigger ias-trigger-prev'><a class='btn btn-block btn-sm btn-primary' title='{text}'><i class='icon-chevron-up'></i><span class='text'>"+loadprevmessage+"</span></a></div>",
        textPrev: loadprevmessage
      }));
      ias.extension(new IASPagingExtension());
      ias.extension(new IASHistoryExtension({ prev: '.previous a' }));
      ias.extension(new IASNoneLeftExtension({ text: lastitemmessage }));
      
      // Infinite Ajax Scroll Events
      // Triggered when a new page is about to be loaded from the server
      ias.on('load', function(event) {
        cururl = event.url;
        target = cururl.replace(/\/$/, ''); // remove last slash if present
      });
      // Triggered after new items have rendered.
      ias.on('rendered', function(newElements) {
        var $newElements = $(newElements);
        window.respimage();
        $newElements.each(function() {
          $('.entry-video', this).fitVids();
          // Update correct page nr on click
          if (!$('html').hasClass('lt-ie9') && target) {
            $('.entry-content a.permalink', this).on('click', function(event) {
              event.preventDefault();
              var permalink = $(this).attr('href');
              var hentryid  = $(this).closest('.hentry').attr('name');
              var pagenr    = $(this).closest('.hentry').attr('data-page');
              var pageurl   = target.substring(0, target.lastIndexOf('/') + 1); // store value before last slash
              var orgpagenr = target.substring(target.lastIndexOf('/') + 1, target.length); // store value after last slash
              pageurl      += pagenr + '#' + hentryid; // construct new value
              // Update url and go to permalink
              window.history.replaceState(null, 'updated page nr', pageurl);
              window.location.href = permalink;
            });
          }
        });
        $container.isotope(preapp, $newElements);
      });
      // Triggered when there are no more pages left
      ias.on('noneLeft', function() {
        setTimeout(function() {
          $('.grid .ias-noneleft').hide('slow');
        }, 1000);
      });
      // Triggered when the next page should be loaded
      ias.on('next', function(url) {
        preapp = 'appended';
      });
      // Triggered when the previous page should be loaded
      ias.on('prev', function(url) {
        preapp = 'prepended';
      });
    }
  }
};


// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = Dedato;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {
    UTIL.fire('common');
    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });
  }
};

$(document).ready(UTIL.loadEvents);


})(jQuery); // Fully reference jQuery after this point.
