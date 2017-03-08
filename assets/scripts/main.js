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

        // Enable BS tooltips (if not touchscreen)
        if(!('ontouchstart' in window)) {
          $(function () {
            $('[data-toggle="tooltip"]').tooltip();
          });
        }

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


        // SET VARS
        var $grid = $('.quote-list').isotope();



        // Make sure Like / Dislike is running
          function runLikeDislike() {

            // All taken from plugin - https://wordpress.org/plugins/comments-like-dislike/
            // 1.0.2

            function cld_setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + "; " + expires;
            }

            function cld_getCookie(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }

            // Add class to once a vote has been cast
            $(".cld-like-trigger").click(function(){
              $(this).parent().addClass('voted');
              $(this).attr("disabled", true);
            });

            jQuery(document).ready(function ($) {
                var ajax_flag = 0;
                $('.cld-like-dislike-trigger').click(function () {
                    if (ajax_flag == 0) {
                        var restriction = $(this).data('restriction');
                        var comment_id = $(this).data('comment-id');
                        var trigger_type = $(this).data('trigger-type');
                        var selector = $(this);
                        var cld_cookie = cld_getCookie('cld_' + comment_id);
                        var current_count = selector.closest('.cld-common-wrap').find('.cld-count-wrap').html();
                        var new_count = parseInt(current_count) + 1;
                        var user_ip = $(this).data('user-ip');
                        var ip_check = $(this).data('ip-check');
                        var like_dislike_flag = 1;
                        if (restriction == 'cookie' && cld_cookie != '') {
                            like_dislike_flag = 0;
                            
                        }
                        if (restriction == 'ip' && ip_check == '1') {
                            like_dislike_flag = 0;
                            
                        }
                        if (like_dislike_flag == 1) {
                            $.ajax({
                                type: 'post',
                                url: cld_js_object.admin_ajax_url,
                                data: {
                                    comment_id: comment_id,
                                    action: 'cld_comment_ajax_action',
                                    type: trigger_type,
                                    _wpnonce: cld_js_object.admin_ajax_nonce,
                                    user_ip: user_ip
                                },
                                beforeSend: function (xhr) {
                                    ajax_flag = 1;
                                    selector.closest('.cld-common-wrap').find('.cld-count-wrap').html(new_count);
                                },
                                success: function (res) {
                                    ajax_flag = 0;
                                    res = $.parseJSON(res);
                                    if (res.success) {
                                        if(restriction == 'ip'){
                                            selector.data('ip-check',1);
                                        }
                                        var cookie_name = 'cld_' + comment_id;
                                        cld_setCookie(cookie_name, 1, 365);
                                        var latest_count = res.latest_count;
                                        selector.closest('.cld-common-wrap').find('.cld-count-wrap').html(latest_count);
                                    }
                                }

                            });
                        }
                    }
                });


                $('.cld-like-dislike-wrap br,.cld-like-dislike-wrap p').remove();


            });



          } // End runLikeDislike()



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
               

          // Update info
          $(".quote-count__current").text(curQuoteCount);
          $(".quote-filter-info__current").text(curQuoteFilter);
         } // end updateQuoteCount()


         //Run Isotope
         function runIsotope() {        

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

        } // end runIsotope()


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
                //debug: true,
                state: {
                  currPage: currCommentPage
                },
                pixelsFromNavToBottom: 0,
                pathParse: function(path,nextPage){
                     path = ['comment-page-','#comments'];
                     return path;
                   }
                },

                // call isotope as a callback
                function myNewElements(newElements) {

                  runIsotope();
                  $grid.isotope('appended', $(newElements));
                  runLikeDislike();
                  
              });                
              

          } // end runInfiniteScroll


          





        // LOAD WEB FONTS
        WebFont.load({
          google: {
            families: ['Open Sans', 'Pathway Gothic One']
          },
          active: function () {
              
              // FIRE FUNCTIONS AFTER FONT HAS LOADED

              // Run Isotope
              runIsotope();

              // Call quote count function
              updateQuoteCount();

              // RunInfiniteScroll on page load
              runInfiniteScroll();
              
          }
        });


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
        
        // Get the URL
        var myURL = window.location.href;

        // Typeahead - try to prevent people from inputting duplicate quotes

          // http://jsfiddle.net/ZGmyp/ - Taken from here
          var $comment = $( ".quote-enter" ).autocomplete({
            source: myURL + "wp-content/themes/qwota3/lib/listcomments.php",
            minLength: 4,
            select: function(event, ui) {
                return false;
            },

            html: true // optional (jquery.ui.autocomplete.html.js required)
          });

               
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS

         
        

         


        
      }
    },
    // Thank you page, note the change from about-us to about_us.
    'thank_you': {
      init: function() {
        // JavaScript to be fired on the about us page

        WebFont.load({
          google: {
            families: ['Open Sans', 'Pathway Gothic One']
          }
        });


      }
    },
    // Popular quotes page, note the change from about-us to about_us.
    'popular_quotes': {
      init: function() {
        // JavaScript to be fired on the about us page

        WebFont.load({
          google: {
            families: ['Open Sans', 'Pathway Gothic One']
          }
        });


      }
    },
    // About us page, note the change from about-us to about_us.
    'about_qwota': {
      init: function() {
        // JavaScript to be fired on the about us page

        WebFont.load({
          google: {
            families: ['Open Sans', 'Pathway Gothic One']
          }
        });


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
