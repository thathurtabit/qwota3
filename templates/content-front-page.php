<nav class="nav-sorting">
	<ul class="filter-button-group nav flex-column">
    	<li class="all nav-item"><button class="nav-link is-checked" data-filter="*" data-toggle="tooltip" data-placement="right" title="All"><span class="sr-only">All</span><span class="ti-layout-grid3-alt"></span></buttton></li>
        <li class="film nav-item"><button class="nav-link" data-filter=".film" data-toggle="tooltip" data-placement="right" title="Film"><span class="sr-only">Film</span><span class="ti-video-clapper"></span></buttton></li>
        <li class="music nav-item"><button class="nav-link" data-filter=".music" data-toggle="tooltip" data-placement="right" title="Music"><span class="sr-only">Music</span><span class="ti-music-alt"></span></buttton></li>
        <li class="tv nav-item"><button class="nav-link" data-filter=".tv" data-toggle="tooltip" data-placement="right" title="TV"><span class="sr-only">TV</span><span class="ti-desktop"></span></buttton></li>
        <li class="design nav-item"><button class="nav-link"  data-filter=".design" data-toggle="tooltip" data-placement="right" title="Design"><span class="sr-only">Design</span><span class="ti-paint-bucket"></span></buttton></li>
    	<li class="history nav-item"><button class="nav-link" data-filter=".history" data-toggle="tooltip" data-placement="right" title="History"><span class="sr-only">History</span><span class="ti-bookmark-alt"></span></buttton></li>
        <li class="media nav-item"><button class="nav-link" data-filter=".media" data-toggle="tooltip" data-placement="right" title="Media"><span class="sr-only">Media</span><span class="ti-announcement"></span></buttton></li>
        <li class="literary nav-item"><button class="nav-link" data-filter=".literary" data-toggle="tooltip" data-placement="right" title="Literary"><span class="sr-only">Literary</span> <span class="ti-book"></span></buttton></li>
        <li class="politics nav-item"><button class="nav-link" data-filter=".politics" data-toggle="tooltip" data-placement="right" title="Politics"><span class="sr-only">Politics</span> <span class="ti-briefcase"></span></buttton></li>
        <li class="science nav-item"><button class="nav-link" data-filter=".science" data-toggle="tooltip" data-placement="right" title="Science"><span class="sr-only">Science</span><span class="ti-pulse"></span></buttton></li>
        <li class="sport nav-item"><button class="nav-link" data-filter=".sports" data-toggle="tooltip" data-placement="right" title="Sport"><span class="sr-only">Sport</span><span class="ti-basketball"></span></buttton></li>
	</ul>
</nav>

<?php the_content(); ?>

<button class="btn quote-form-open-close add-quote__open--lg" data-toggle="tooltip" data-placement="left" title="Add a Quote"><span class="sr-only">Add Quote</span> <span class="ti-plus"></span></button>

<div class="row">
  <?php if (comments_open()) { ?>
    
    <section id="add-quote" class="">
    	<button class="btn quote-form-open-close add-quote__close"><span class="sr-only">Close</span><span class="ti-close"></span></button>
        <div class="add-quote__inner">
        	<?php comment_form(); ?>
        </div>
    </section>
    
  <?php } ?>

  <?php comments_template('/templates/comments.php'); ?>
</div>