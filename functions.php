<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);


// Custom functions
// ADDED FROM ORIGINGAL QWOTA


// remove HTML from comments
  add_filter('comment_text', __NAMESPACE__ .  '\\wp_filter_nohtml_kses');
  add_filter('comment_text_rss', __NAMESPACE__ .  '\\wp_filter_nohtml_kses');
  add_filter('comment_excerpt', __NAMESPACE__ .  '\\wp_filter_nohtml_kses');
    
  
  // My custom Qwtoa - Comment Forms - http://ottopress.com/2010/wordpress-3-0-theme-tip-the-comment-form/comment-page-2/#comment-5302
  
  function qwota_comment_form($form_options) {
    
    
    // Fields Array
    $fields = array(
    
      'wrap-start' =>
      '<div class="respond-right col-xl-6">',
      
      'quotee' =>
      '<p class="form-quote-quotee">' .
      '<label for="quotee">' . __( 'Who said it?' ) . '</label> ' .
      '<input id="quotee" class="validate" data-validation="required" data-validation-length="max30" name="quotee" type="text"  value="' . esc_attr( $commenter['quotee'] ) . $aria_req . '" required></p>',
      
      'quote-from' =>
      '<p class="form-quote-from">' .
      '<label for="quote-from">' . __( 'Where is it taken from?' ) . '</label> ' .
      '<input id="quote-from" class="validate" name="quote-from" data-validation-length="max30" data-validation="required" type="text" value="' . esc_attr( $commenter['quote-from'] ) . $aria_req . '" required></p>',
      
      'quote-when' =>
      '<p class="form-quote-when">' .
      '<label for="quote-when">' . __( 'What year was it said? (approx.)' ) . '</label> ' .
      '<input id="quote-when" class="validate" data-validation="required number" data-validation-allowing="range[-5000;2050],negative" name="quote-when" type="number" max="'. date("Y") .'" min="-5000" value="' . esc_attr( $commenter['quote-when'] ) . '" size="4" ' . $aria_req . '" required></p>',
      
      'quote-link' =>
      '<p class="form-quote-link">' .
      '<label for="quote-link">' . __( 'A nice link about the quote' ) . '</label> ' .
      '<input id="quote-link" class="validate" data-validation-length="max40" data-validation="required url" name="quote-link" type="url" value="' . esc_attr( $commenter['quote-link'] ) . '" placeholder="http://" ' . $aria_req . ' required></p>',
      
      'quote-category' =>
      '<p class="form-quote-category">' .
      '<label for="quote-category">' . __( 'Select quote category' ) . '</label> ' .
      ( $req ? '<span class="required">*</span>' : '' ) .
        '<select name="quote-category" id="quote-category" data-validation="required" class="validate">
            <option value="">-- Please select</option>
            <option value ="design">Design</option>
            <option value ="film">Film</option>
            <option value ="history">History</option>
            <option value ="literary">Literary</option>
            <option value ="media">Media</option>
            <option value ="music">Music</option>
            <option value ="politics">Politics</option>
            <option value ="science">Science</option>
            <option value ="sports">Sports</option>
            <option value ="tv">TV</option>         
        </select></p>',
        
      'author' =>
        '<p class="form-quote-author">' .
        '<label for="author">' . __( 'Your name' ) . '</label> ' .
        ( $req ? '<span class="required">*</span>' : '' ) .
        '<input id="author" class="validate" data-validation="required" data-validation-length="max50" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . $aria_req . '" required>' .
        '</p>',
        
      'email' =>
        '<p class="form-quote-email">' .
        '<label for="email">' . __( 'Your email' ) . '</label> ' .
        ( $req ? '<span class="required">*</span>' : '' ) .
        '<input id="email" class="validate" data-validation="required email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . $aria_req . '" required>' .
        '</p>',
        
      'url' =>
        '<p class="form-quote-url">' .
        '<label for="url">' . __( 'Your website' ) . '</label>' .
        '<input id="url" name="url" data-validation="url" type="url" data-validation-length="max40" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="http://" >' .
        '</p>',
        
      'wrap-end' =>
      '</div>',
      
      
    );

    // Form Options Array
    $form_options = array(
      
      // Template Options
      'comment_field' =>
      '<p class="quote-form-quote col-xl-6">' .
      '<label for="comment">' . _x( 'Enter your quote', 'noun' ) . '</label>' .
     
            '<textarea id="comment" class="quote-enter" name="comment" data-validation="required" data-validation-length="1-300"  cols="" rows="" aria-required="true" class="validate" placeholder="Enter your quote here." autocomplete="off" required></textarea>' .                         
      '</p>',
      
      // Include Fields Array
      'fields' => apply_filters( 'comment_form_default_fields', $fields ),
      
      'must_log_in' =>
      '<p class="must-log-in">' .
      sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
      wp_login_url( apply_filters( 'the_permalink', get_permalink($post_id) ) ) ) .
      '</p>',
      
      'logged_in_as' =>
      '<p class="logged-in-as">' .
      sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
      admin_url('profile.php'), $user_identity, wp_logout_url( apply_filters('the_permalink', get_permalink($post_id)) ) ) .
      '</p>',
      
      'comment_notes_before' =>
      '<a href="#" class="add-quote-o-c"></a>',
      
      'comment_notes_after' =>
      '<p class="form-allowed-tags">' .
      sprintf( __( 'Sorry, all HTML will be eaten.' )) .
      '</p>',
            
      // Rest of Options
      'id_form' => 'form-comment',
      'class_form' => 'comment-form row',
      'id_submit' => 'submit',
      'title_reply' => __( 'Add a quote' ),
      'title_reply_to' => __( 'Leave a Reply to %s' ),
      'cancel_reply_link' => __( 'Cancel reply' ),
      'label_submit' => __( 'Add Quote' ),
    );

  return $form_options;
  } add_filter('comment_form_defaults', __NAMESPACE__ .  '\\qwota_comment_form');


    
    // Post comment meta on submit
    function qwota_add_comment_meta($comment_ID) {
        add_comment_meta( $comment_ID, 'quotee', $_POST['quotee'], true );
        add_comment_meta( $comment_ID, 'quote-from', $_POST['quote-from'], true );
        add_comment_meta( $comment_ID, 'quote-when', $_POST['quote-when'], true );
        add_comment_meta( $comment_ID, 'quote-link', $_POST['quote-link'], true );
        add_comment_meta( $comment_ID, 'quote-category', $_POST['quote-category'], true );
      }
      
      add_action( 'comment_post', __NAMESPACE__ .  '\\qwota_add_comment_meta', 1 );

  


    

  /**
 * Qwota Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * 
 */
function qwota_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case '' :
  ?>

<li data-id="<?php comment_ID(); ?>" <?php /*?>data-filter="<?php echo get_comment_meta( $comment->comment_ID, 'quote-category', true ); ?>"<?php */?> class="quote <?php echo get_comment_meta( $comment->comment_ID, 'quote-category', true ); ?>"> 
  
  <!--QUOTE JUMP-->
  <div class="quote-inner"> 
    
    <!--SLIDE NAV-->
    <div class="slide-nav"> <a href="#" class="next"><i class="icon-arrow-right"></i></a></div>
    <!--/SLIDE NAV--> 
    
    <!--CAROUSEL CYCLE-->
    <div class="carousel-cycle"> 
      
      <!--SLIDE-->
      <div class="slide-item quote-text">
        <blockquote>
        <?php comment_text(); ?>
        </blockquote>
      </div>
      <!--/SLIDE--> 
      
      <!--SLIDE-->
      <div class="slide-item the-info"> 
        
        <!--QUOTE INFO-->
        <div class="quote-info"> 
          <!--QUOTE INFO INNER-->
          <div class="quote-info-inner"> <cite class="who quote-stuffz "><span class="title">Who: </span>
            <span class="data"><?php  echo get_comment_meta( $comment->comment_ID, 'quotee', true );  ?></span>
            </cite> <cite class="from quote-stuffz "><span class="title">From: </span>
            <span class="data"><?php  echo get_comment_meta( $comment->comment_ID, 'quote-from', true ); ?></span>
            </cite> <cite class="when quote-stuffz "><span class="title">When: </span>
            <span class="data"><?php  echo get_comment_meta( $comment->comment_ID, 'quote-when', true );  ?></span>
            </cite>
            <?php if(get_comment_meta( $comment->comment_ID, 'quote-link', true )) { ?>
            <p class="link quote-stuffz "><span class="title">More:</span> <a href="<?php echo get_comment_meta( $comment->comment_ID, 'quote-link', true ); ?>" title="More info about this quote." class="data" target="_blank">click here</a></p>
            <?php } ?>
          </div>
          <!--/QUOTE INFO INNER--> 
        
        <!--QUOTE CONTRIBUTOR-->
        <div class="quote-contributor vcard"> <?php echo get_avatar( $comment, 15 ); ?> <span>Added by: </span>
          <?php if(!get_comment_author_url()) : ?>
          <?php comment_author(); ?>
          <?php else : ?>
          <a href="<?php comment_author_url(); ?>" target="_blank" title="Visit <?php comment_author(); ?>'s website.">
          <?php comment_author(); ?>
          </a>
          <?php endif; ?>
        </div>
        <!--/QUOTE CONTRIBUTOR--> 
        
        </div>
        <!--/QUOTE INFO--> 
        
        <!-- QUOTE CATEGORY -->
        <div class="quote-category"> <?php echo get_comment_meta( $comment->comment_ID, 'quote-category', true ); ?> </div>
        <!-- / QUOTE CATEGORY -->    
        
      </div>
      <!--/SLIDE--> 
      
    </div>
    <!--/CAROUSEL CYCLE-->     
    
    
       
    
    <?php if ( $comment->comment_approved == '0' ) : ?>
    <div class="quote-moderation">
      <p class="quote-awaiting-moderation">
        <?php _e( 'Your quote is awaiting approval.'); ?>
      </p>
    </div>
    <?php endif; ?>
  </div>
  <!--QUOTE JUMP--> 
  
</li>
<?php
      break;
    case 'pingback'  :
    case 'trackback' :
  ?>
<li class="post pingback">
  <p>
    <?php _e( 'Pingback:', 'twentyten' ); ?>
    <?php comment_author_link(); ?>
    <?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' ); ?>
  </p>
  <?php
      break;
    endswitch;
  }
  //endif;
  
// END OF ADDED FROM ORIGINGAL QWOTA

