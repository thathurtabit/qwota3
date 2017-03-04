<?php


  
$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . '/qwota-3/wp-config.php';
include_once $path . '/qwota-3/wp-load.php';
include_once $path . '/qwota-3/wp-includes/wp-db.php';
include_once $path . '/qwota-3/wp-includes/pluggable.php';


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


