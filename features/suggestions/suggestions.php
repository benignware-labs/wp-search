<?php

add_action( 'wp_enqueue_scripts', function() {
  $dist_dir_url = plugin_dir_url(realpath(__DIR__ . '/../')) . 'dist';

	wp_register_script( 'search-xt-suggestions', $dist_dir_url . '/suggestions.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', false );
  wp_localize_script( 'search-xt-suggestions', 'SearchXtSuggestions', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'search-xt-suggestions' );

  wp_enqueue_style( 'search-xt-suggestions', $dist_dir_url . '/suggestions.css' );

  wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );

});

add_filter( 'get_search_form', function($html) {
  $html = <<<EOT
$html
<div data-suggestions></div>
EOT;
  return $html;
}, 99);


add_filter('pre_get_posts', function( $query ) {
  /*if ( $query->is_search ) {
    $query->set( 'post_type', array('post', 'page') );
  }*/

  return $query;
});


function my_search() {
	$term = strtolower( $_GET['term'] );
	$suggestions = array();
  global $post;

  $items_per_page = 5;

  // Add user-defined post-types
	$post_types = array_merge([], get_post_types([
    'public'   => true,
    '_builtin' => true
  ], 'names', 'and'));

  $query_args = array(
    's' => $term,
    'suppress_filters' => false,
    'posts_per_page' => $items_per_page
  );

  foreach ($post_types as $post_type) {

    $post_type_object = get_post_type_object($post_type);

    $post_type_label = $post_type_object->labels->name;

    $wp_query = new WP_Query(array_merge(
      $query_args,
      array(
        'post_type' => $post_type
      )
    ));

    if ($wp_query->have_posts()) {
      $suggestions[] = array(
        'label' => $post_type_label
      );

      while( $wp_query->have_posts() ) {
    	  $wp_query->the_post();

    		$suggestion = array_merge(
          (array) $post,
          array(
            'label' => get_the_title(),
            'link' => get_permalink(),
            'content' => get_the_excerpt()
          )
        );
    		$suggestion['label'] = get_the_title();
    		$suggestion['link'] = get_permalink();
        $suggestion['excerpt'] = get_the_excerpt();

    		$suggestions[] = $suggestion;
    	}
    }

  	wp_reset_query();
  }

  $json = json_encode( $suggestions );

	echo $json;

  // echo 'HELLO';
	exit();
}

add_action( 'wp_ajax_my_search', 'my_search' );
add_action( 'wp_ajax_nopriv_my_search', 'my_search' );
