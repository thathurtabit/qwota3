<?php
if (post_password_required()) {
  return;
}
?>


<section id="comments" class="comments">
  <?php if (have_comments()) : ?>

  <div class="quote-filter-info">
    <div class="quote-filter-info__col">
      <span class="ti-eye quote-filter-info__icon"></span>
        <p><span class="quote-filter-info__current">All</span> quotes</p>
    </div>

    <div class="quote-filter-info__col border hidden-xs-down">
      <p>Showing <span class="quote-count__current">-</span> of <span class="quote-count__total"><?php $comments_count = wp_count_comments(); echo  $comments_count->approved; ?></span> total quotes
      </p>
    </div>
  </div>
    

    <ul class="quote-list">
      <?php
      /* Loop through and list the comments. Tell wp_list_comments()
       * to use qwota_comment() to format the comments.
       */
      //wp_list_comments( array( 'callback' => 'qwota_comment' ) ); - working, but without reverse order
      wp_list_comments( array( 'callback' => 'qwota_comment' ) )
      
    ?>
    </ul>


    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <ul id="quote-pager" class="pager">
          <?php if (get_previous_comments_link()) : ?>
            <li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'sage')); ?></li>
          <?php endif; ?>
          <?php if (get_next_comments_link()) : ?>
            <li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'sage')); ?></li>
          <?php endif; ?>
        </ul>
    <?php endif; ?>
  <?php endif; // have_comments() ?>

  <?php if (!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments')) : ?>
    <div class="alert alert-warning">
      <?php _e('Comments are closed.', 'sage'); ?>
    </div>
  <?php endif; ?>

  

</section>






