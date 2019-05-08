<?php

add_action( 'wp_enqueue_scripts', function() {
  $options = get_search_options();
  $plugin_dir = realpath(__DIR__ . '/../../');
  $dist_dir = $plugin_dir . '/dist';
  $dist_url = plugin_dir_url($plugin_dir . '/.') . 'dist';

	wp_register_script( 'search-xt-suggestions', $dist_url . '/suggestions.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', false );
  wp_localize_script( 'search-xt-suggestions', 'SearchXtSuggestions', array( 'url' => admin_url( 'admin-ajax.php' ) ) );

	wp_enqueue_script( 'search-xt-suggestions' );
  wp_enqueue_style( 'search-xt-suggestions', $dist_url . '/suggestions.css' );

  $options['theme'] = 'base';

  $theme = $options['theme'];
  $theme_path = 'themes/' . $theme;
  $theme_dir = realpath($dist_dir . '/' . $theme_path);

  if (is_dir($theme_dir)) {
    wp_enqueue_style('jquery-ui', $dist_url . '/' . $theme_path . '/jquery-ui.min.css');
    wp_enqueue_style('jquery-ui-' . $theme, $dist_url . '/' . $theme_path . '/theme.css', array( 'jquery-ui' ));
  }

  /*
  $custom_css = "
    .mycolor {
      background: {$color};
    }";
  wp_add_inline_style( 'custom-style', $custom_css );
  */
});

add_filter( 'get_search_form', function($html) {
  $options = get_search_options();
  $autocomplete_options = array_filter($options['suggestions'], function($key) {
    return !in_array($key, [ 'max_count' ]);
  }, ARRAY_FILTER_USE_KEY);

  $html.= '<div data-suggestions="' . urlencode(json_encode($autocomplete_options)) . '"></div>';

  return $html;
}, 99);

function my_search() {
  global $post;

  $options = get_search_options();
  $items_per_page = $options['suggestions']['max_count'];

	$term = strtolower( $_GET['term'] );
	$suggestions = array();
  $post_types = array_keys(
    array_filter($options['post_types'], function($enabled) {
      return $enabled;
    })
  );

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
      while( $wp_query->have_posts() ) {
    	  $wp_query->the_post();

    		$suggestion = array_merge(
          // (array) $post,
          array(
            'label' => get_the_title(),
            'href' => get_permalink(),
            'content' => get_the_excerpt(),
            'category' => __($post_type_object->label)
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
