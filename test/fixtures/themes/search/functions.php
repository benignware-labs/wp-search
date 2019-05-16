<?php

require_once 'inc/dom-mutations.php';

add_action('wp_enqueue_scripts', function() {

  wp_dequeue_style( 'twentyseventeen-style' );
  wp_deregister_style( 'twentyseventeen-style' );

  /*
  wp_register_style('twentyseventeen-style', get_template_directory_uri(). '/style.css');
  wp_enqueue_style('twentyseventeen-style', get_template_directory_uri(). '/style.css');
  */
  wp_enqueue_style( 'search-demo-style', get_stylesheet_directory_uri().'/style.css');


  wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
  wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ), '', true);
  wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array( 'jquery' ), '', true);
  wp_enqueue_script('turbolinks', 'https://cdn.jsdelivr.net/npm/turbolinks@5.2.0/dist/turbolinks.min.js', null, '', false);

});

// Init bootstrap hooks
if (function_exists('wp_bootstrap_hooks')) {
  wp_bootstrap_hooks();
}

add_filter('dom_mutations', function($document, $xpath) {
  $body = $document->getElementsByTagName('body')[0];
  $body->setAttribute('data-fuck-it', 'body');


  $class_mutations = array(
    'wrap' => 'container'
  );

  foreach ($class_mutations as $search => $replace) {
    $expression = "//*[contains(concat(' ', normalize-space(@class), ' '), ' " . $search . " ')]";
    $result = $xpath->query($expression);

    // $debug = 'count' . count($result);

    foreach ($result as $node) {

      $classes = preg_split('/\s+/', $node->getAttribute('class'));

      $classes = array_filter($classes, function($class) use ($search) {
        return $search !== $class;
      });

      $classes[] = $replace;

      $node->setAttribute('class', implode(' ', $classes));

      $node->setAttribute('data-node', 'node');
    }
  }

  // $body->setAttribute('data-count', $debug);

  return $document;
}, 10, 2);

add_filter('search_options', function($options = array()) {
	$options = array_merge($options, array(
    // Custom options
    'suggestions' => array_merge($options['suggestions'], array(
      'autocomplete' => array_merge($options['suggestions']['autocomplete'], array(
        'classes' => array(
          'ui-autocomplete' => 'hello',
          'ui-autocomplete-input' => 'nevermind',
          'ui-menu' => 'border-success',
          'ui-widget-header' => 'lead'
        )
      ))
    ))
	));

	return $options;
});
