<?php


  
// http://stackoverflow.com/questions/5306612/using-wpdb-in-standalone-script/9479868#comment22010629_9479868

$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$url = $_SERVER['REQUEST_URI'];
$my_url = explode('wp-content' , $url); 
$path = $_SERVER['DOCUMENT_ROOT']."/".$my_url[0];

include_once $path . '/wp-config.php';
include_once $path . '/wp-includes/wp-db.php';
//include_once $path . '/wp-includes/pluggable.php';

global $wpdb;


// http://www.pontikis.net/blog/jquery-ui-autocomplete-step-by-step
// get what user typed in autocomplete input
$term = trim($_GET['term']);
 
// NOTE: The below commented out code causes problems when users input characers such as quote marks

//$a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
//$json_invalid = json_encode($a_json_invalid);
 
// replace multiple spaces with one
//$term = preg_replace('/\s+/', ' ', $term);
 
// SECURITY HOLE ***************************************************************
// allow space, any unicode letter and digit, underscore and dash
//if(preg_match("/[^\040\pL\pN_-]/u", $term)) {
// if(preg_match("/[^\040\p{L}\p{N}_-]/u", $term)) {
  
//   print $json_invalid;
//   exit;
// }
// *****************************************************************************


	// USE THE 'TERM' FROM THE USER TO SELECT STUFF
	$comments = $wpdb->get_results( 
	"
		SELECT comment_content FROM wp_comments WHERE comment_content LIKE '%".$term."%' AND comment_approved = '1' ORDER BY comment_content ASC LIMIT 8
	"
	);


    // Comment Loop
    if ( $comments ) {

    foreach ( $comments as $comment ){

      //$quotes[] = array( 'quote' => $comment->comment_content );
      $quotes[] = $comment->comment_content;

     } 
     header('Content-Type: application/json');
      echo wp_json_encode( $quotes ); 

     }
     else // Else if no comments found
      {
        echo 'No comments found.';
      }?>


