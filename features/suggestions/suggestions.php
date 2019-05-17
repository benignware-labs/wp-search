<?php

add_action( 'wp_enqueue_scripts', function() {
  $options = get_search_options();
  $plugin_dir = realpath(__DIR__ . '/../../');
  $dist_dir = $plugin_dir . '/dist';
  $dist_url = plugin_dir_url($plugin_dir . '/.') . 'dist';

  // Deregister first, then register again with new source, and enqueue
  /*
  wp_deregister_script('jquery-ui');
  wp_register_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array( 'jquery' ));
  wp_enqueue_script('jquery-ui');
  */

  /*
  wp_dequeue_script('jquery-ui');
  wp_enqueue_script('jquery-ui', $dist_url . '/jquery-ui/build/release.js', '1.12.1');
  */

	wp_register_script( 'search-xt-suggestions', $dist_url . '/suggestions.js', array( 'jquery-ui-autocomplete' ), '1.0', true );
  wp_localize_script( 'search-xt-suggestions', 'SearchXtSuggestions',
    array(
      'url' => admin_url('admin-ajax.php?action=my_search'),
      'options' => urlencode(json_encode($options))
    )
  );

	wp_enqueue_script( 'search-xt-suggestions' );
  // wp_enqueue_style( 'search-xt-suggestions', $dist_url . '/suggestions.css' );

  $theme = $options['ui']['theme'];

  if ($theme && $theme !== 'none') {
    wp_enqueue_style('jquery-ui', $dist_url . '/themes/base/jquery-ui.min.css');
    wp_enqueue_style('jquery-ui-' . $theme, $dist_url . '/themes/' . $theme . '/theme.css', array( 'jquery-ui' ));
  }
});

add_filter( 'get_search_form', function($html) {
  $document = new DOMDocument();
  @$document->loadHTML('<?xml encoding="utf-8" ?>' . $html);

  $xpath = new DOMXpath($document);
  $input_element = $xpath->query("//input[@name='s']")->item(0);

  if ($input_element) {
    $input_element->setAttribute('data-search-input', '');
    $html = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $document->saveHTML());

    return $html;
  }

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
