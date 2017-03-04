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
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages

        // Enable BS tooltips
        $(function () {
          $('[data-toggle="tooltip"]').tooltip();
        });

        // Add class to body when items have loaded is ready
        $(window).load(function() {
            $('body').addClass('page-ready');
            $('#loading-cover').delay(250).queue(function(next) { $(this).addClass("hello-app"); next(); }).delay(250).fadeOut('500',function(){$(this).remove();});
        });

      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired


        // SHOW & HIDE SEARCH BOX
        $(".quote-form-open-close").click(function(){

          if ($("#add-quote").hasClass("open")) {
            $("#add-quote").removeClass("open").delay(250).hide(10);
          } else {
            $("#add-quote").show(1).addClass("open");
          }
          
        });
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page

        // Make sure the Quote form fits on screen
        $(window).resize(function() {
          $('#add-quote').css('height', window.innerHeight);
        });

        // Validate form
        $.validate({
          form : '#form-comment'
        });


        // Add class to once a vote has been cast
        $(".cld-like-trigger").click(function(){
          $(this).parent().addClass('voted');
          $(this).attr("disabled", true);
        });
        


        // Typeahead - try to prevent people from inputting duplicate quotes

          // http://jsfiddle.net/ZGmyp/ - Taken from here
          var $comment = $( ".quote-enter" ).autocomplete({
            source: "http://localhost/qwota-3/wp-content/themes/qwota3/lib/listcomments.php",
            minLength: 4,
            select: function(event, ui) {
                return false;
            },

            html: true // optional (jquery.ui.autocomplete.html.js required)
          });

               
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS

         
        // Count the number of quotes on display
         function updateQuoteCount() {
          var curQuoteCount = $('.quote:not([style*="display: none"])').length;
          var curQuoteFilter = $('.nav-link.is-checked').data("original-title");
          
          // If there's no quotes to display, then add a class (to display a message)
          if ( !$('.quote-list li:visible').length) {
            $('.quote-list').addClass('no-quotes');
          }

          // Afer IS happens, check how many quotes are visible
          if (curQuoteCount >= 1) {
            $('.quote-list').removeClass('no-quotes');
          }

          console.log(curQuoteCount);
          console.log("Arrange Complete.");        

          // Update info
          $(".quote-count__current").text(curQuoteCount);
          $(".quote-filter-info__current").text(curQuoteFilter);
         }

         // Call quote count function
         updateQuoteCount();
        

        // ISOTOPE INIT
        var $grid = $('.quote-list').isotope({
          // options...
          itemSelector: '.quote',
          masonry: {
            columnWidth: 300
          }
        });


        // Because the below doesn't seem to work...
        //$grid.on( 'arrangeComplete', updateQuoteCount);

        $grid.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
             updateQuoteCount();
        });
        

          // INFINITE SCROLL
          
          function runInfiniteScroll() {

            // if the element exisits on the page, then...
          if ($('#quote-pager .previous a')) {
            var nextCommentNum = $('#quote-pager .previous a').attr("href").match(/\d+/);
            var nextCommentPage = parseInt(nextCommentNum);
            var currCommentPage = ((nextCommentPage + 1));
          }


            // NOTE: You had to change the plugin file jquery.infinitescroll.js to make this work, see:
            // http://stackoverflow.com/questions/11397648/infinite-scroll-pathparse-for-reverse-wordpress-comments

            $('ul.quote-list').infinitescroll({              

                navSelector  : "#quote-pager",  // selector for the paged navigation (it will be hidden)
                nextSelector : "#quote-pager .previous a", // selector for the NEXT link (to page 2)
                itemSelector : "li.quote", // selector for all items you'll retrieve
                loading: {
                  //img: "#",
                  msg: $('<span class="logo-full loading"></span>'),
                  msgText: "Loading",
                  finishedMsg: "The End."
                },
                debug: true,
                state: {
                  currPage: currCommentPage
                },
                extraScrollPx: 200,
                pathParse: function(path,nextPage){
                     path = ['comment-page-','#comments'];
                     return path;
                   }
                },

                // call isotope as a callback
                function myNewElements(newElements) {
                  $grid.isotope('appended', $(newElements));

                  // WHEN DONE
                  // $.when(myNewElements).done(function() {
                  //   console.log("Items appended.");
                  //   updateQuoteCount();
                  // });


              });
                  
              

          } // end runInfiniteScroll


        // RunInfiniteScroll on page load
        runInfiniteScroll();

        // WHEN ARRANGING COMPLETE

        //  ISOTOPE FILTER
        $('.filter-button-group').on( 'click', 'button', function() {
          $("html, body").animate({ scrollTop: 0 }, "slow");  // Scroll to the top of page
          var filterValue = $(this).attr('data-filter');
          $grid.isotope({ filter: filterValue }, updateQuoteCount);
        });

        // ISOTOPE ADD ACTIVE CLASS WHEN FILTERED
        $('.filter-button-group').each( function( i, buttonGroup ) {
          var $buttonGroup = $( buttonGroup );
          $buttonGroup.on( 'click', 'button', function() {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            $( this ).addClass('is-checked');
          });
        });
        
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
