<?php
/**
 * Template Name: Top Quotes
 */
?>

<div class="row">
               
<article class="col-md-6">


	<h1>Popular Quotes</h1>


	<p>These are the most popular quotes on Qwota:</p>


	<ul class="top-list">

		<?php
		$args = array(
		   // args here
			'post_id' => 9,
			'status' => 'approve',
			'meta_key' => 'cld_like_count',
			'number' => '20',
			'orderby' => 'cld_like_count',
			'order' => 'DESC'
		);

		// The Query
		$comments_query = new WP_Comment_Query;
		$comments = $comments_query->query( $args );

		// Comment Loop
		if ( $comments ) {
		// set iteration variable
		$i = 0;

		foreach ( $comments as $comment ){

			$i++; // add one each time
		?>

		
		<li class="clearfix quote-<?php echo($i); ?>">
	    	<div class="quote-number"><?php echo($i); ?>.</div>
	    	<div class="quote-info-wrap">
	        	<blockquote><?php echo $comment->comment_content; ?></blockquote>
	            <cite>- <?php  echo get_comment_meta( $comment->comment_ID, 'quotee', true ); ?></cite>
	            <div class="added-by">
	                Added by:
	                    <?php if ($comment->comment_author_url) { ?>
	                    <a href="<?php echo $comment->comment_author_url; ?>" title="View <?php echo $comment->comment_author; ?>'s website" target="_blank"><?php echo $comment->comment_author; ?></a>
	                    <?php } else { ?>
	                        <?php echo $comment->comment_author; ?>
	                    <?php } ?>
	                | <a href="<?php  echo get_comment_meta( $comment->comment_ID, 'quote-link', true ); ?>" title="More infomation about the quote" target="_blank">More info &raquo;</a>
	                </div>
	                
	                
	        </div>
	        <div class="quote-votes">
	        	<?php  echo get_comment_meta( $comment->comment_ID, 'cld_like_count', true ); ?> votes
	        </div>
	    </li>



		<?php } } else {
			echo 'No comments found.';
		}
		?>

	</ul>


</article>


<article class="col-md-6">


	<h1>Top Contributors</h1>


	<p>These are the most quote-y people on Qwota:</p>


	<ul class="top-list">

		<?php // SQL calls
	global $wpdb;
	$contributors = $wpdb->get_results('SELECT *, COUNT(*) FROM wp_comments WHERE comment_approved = 1 AND comment_post_ID = 9 GROUP BY comment_author ORDER BY COUNT(*) DESC LIMIT 20');


		// Comment Loop
		if ( $contributors ) {
		// set iteration variable
		$i = 0;

		foreach ( $contributors as $contributor ){

			$i++; // add one each time
		?>

		
		<li class="clearfix quote-<?php echo($i); ?>">
        	<div class="contributor-number"><?php echo($i); ?>.</div>
        	<div class="contributor-info-wrap">
                
                 <?php if ($contributor->comment_author_url) { ?>
                 <div class="added-by">
                    <a href="<?php echo $contributor->comment_author_url; ?>" title="View <?php echo $contributor->comment_author; ?>'s website" target="_blank"><strong><?php echo $contributor->comment_author; ?></strong> <span class="ti-world"></span></a>
                    </div>
                    <?php } else { ?>       
                    	
                    	<strong><?php echo $contributor->comment_author; ?></strong>

                    <?php } ?>
            </div>
            
        </li>



		<?php } } else {
			echo 'No comments found.';
		}
		?>

	</ul>


</article>

        
</div><!-- / ROW -->

