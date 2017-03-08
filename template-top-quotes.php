<?php
/**
 * Template Name: Top Quotes
 */
?>

<div class="row">
               
<article class="popular-quotes-section col-xl-8">


	<h1>Popular Quotes</h1>


	<p class="p-intro">These are the most popular quotes on Qwota:</p>


	<ul class="top-list">

		<?php
		$args = array(
		   // args here
			'post_id' => 9,
			'status' => 'approve',
			'meta_key' => 'cld_like_count',
			'number' => '10',
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

		
		<li class="top-list__quote-li quote-<?php echo($i); ?>">
			<span class="top-list__quote-number"><?php echo($i); ?></span>
			<div class="top-list__quote">
		    	
		    	<blockquote><?php echo $comment->comment_content; ?></blockquote>
		        <cite>- <?php  echo get_comment_meta( $comment->comment_ID, 'quotee', true ); ?></cite>

		        <div class="top-list__quote-info-wrap">

		    		<span class="top-list__quote-votes">
			        	<?php  echo get_comment_meta( $comment->comment_ID, 'cld_like_count', true ); ?> votes | 
			        </span>
		        	
		            <span class="top-list__added-by">
		                Added by:
		                    <?php if ($comment->comment_author_url) { ?>
		                    <a href="<?php echo $comment->comment_author_url; ?>" title="View <?php echo $comment->comment_author; ?>'s website" target="_blank"><?php echo $comment->comment_author; ?></a>
		                    <?php } else { ?>
		                        <?php echo $comment->comment_author; ?>
		                    <?php } ?>
		                    <?php if(get_comment_meta( $comment->comment_ID, 'quote-link', true )) { ?>
		                | <a href="<?php  echo get_comment_meta( $comment->comment_ID, 'quote-link', true ); ?>" title="More infomation about the quote" target="_blank">More info &raquo;</a>
		                <? } ?>
		            </span>
		                
			        
		        </div>
	        </div>
	    	
	        
	    </li>



		<?php } } else {
			echo 'No comments found.';
		}
		?>

	</ul>

	<p class="back-to-quotes--inline hidden-xl-down">
		<a href="<?php bloginfo('url'); ?>" class="btn--underline-none" title="View 'dem quotes">
			<span class="ti-eye"></span> View more quotes! And maybe add your own. 
		</a>
	</p>


	<div class="back-to-quotes">
		<a href="<?php bloginfo('url'); ?>" class="btn--underline-none" title="View 'dem quotes">
			<h3>Have an awesome quote to add?</h3>
			<p>Head to the Quotes page and find the <span class="ti-plus"></span> button</p>
		</a>
	</div>

</article>




<article class="top-contrib-section col-xl-4">


	<h1>Top Contributors</h1>


	<p class="p-intro">These are the most quote-y people on Qwota:</p>


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

		
		<li class="quote-<?php echo($i); ?>">
        	<span class="top-list__quote-number"><?php echo($i); ?></span>
             <?php if ($contributor->comment_author_url) { ?>
             <span class="top-list__contributor">
                <a href="<?php echo $contributor->comment_author_url; ?>" title="View <?php echo $contributor->comment_author; ?>'s website" target="_blank"><strong><?php echo $contributor->comment_author; ?></strong> <span class="ti-world"></span></a>
                </span>
                <?php } else { ?>       
                <span class="top-list__contributor">
                	<strong><?php echo $contributor->comment_author; ?></strong>
                </span>
                <?php } ?>            
        </li>



		<?php } } else {
			echo 'No comments found.';
		}
		?>

	</ul>

	<p class="back-to-quotes--inline">
		<a href="<?php bloginfo('url'); ?>" class="btn--underline-none" title="View 'dem quotes">
			<span class="ti-eye"></span> View more quotes! And maybe add your own. 
		</a>
	</p>


</article>

        
</div><!-- / ROW -->

