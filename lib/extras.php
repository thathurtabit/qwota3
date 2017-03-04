<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');



add_action('comment_post_redirect', __NAMESPACE__ .  '\\wpsites_redirect_after_comment');
/**
 * @author    Brad Dalton
 * @example   http://wpsites.net/wordpress-admin/redirect-comment-authors-to-a-thank-you-landing-page/
 * @copyright 2014 WP Sites
 */
function wpsites_redirect_after_comment() {
wp_safe_redirect('thank-you');
      exit();
}


