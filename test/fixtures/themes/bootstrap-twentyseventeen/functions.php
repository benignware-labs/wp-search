<?php

require_once 'inc/customizer.php';

add_action( 'after_setup_theme', function() {
  add_theme_support( 'custom-logo', array(
    'height'      => 40,
    'width'       => 80,
    'flex-height' => false,
    'flex-width'  => true,
    'header-text' => array(
      'site-title',
      'site-description'
    ),
  ));
}, 11);

add_action('wp_enqueue_scripts', function() {

  wp_dequeue_style( 'twentyseventeen-style' );
  wp_deregister_style( 'twentyseventeen-style' );


  wp_dequeue_script( 'twentyseventeen-navigation' );
  wp_deregister_script( 'twentyseventeen-navigation' );

  /*
  wp_dequeue_script( 'twentyseventeen-global' );
  wp_deregister_script( 'twentyseventeen-global' );
  */


  wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
  wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ), '', true);
  wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array( 'jquery' ), '', true);
  wp_enqueue_script('turbolinks', 'https://cdn.jsdelivr.net/npm/turbolinks@5.2.0/dist/turbolinks.min.js', null, '', false);

  //wp_register_style('bootstrap-twentyseventeen-parent-style', get_template_directory_uri(). '/style.css');
  //wp_enqueue_style('bootstrap-twentyseventeen-parent-style', get_template_directory_uri(). '/style.css');

  wp_enqueue_style( 'bootstrap-twentyseventeen-style', get_stylesheet_directory_uri() . '/style.css');

  // Load the dark colorscheme.
	/* if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'bootstrap-twentyseventeen-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'twentyseventeen-style' ), '1.0' );
	} */

}, 11);

if (function_exists( 'wp_bootstrap_hooks' )) {
	wp_bootstrap_hooks();
}

add_filter( 'bootstrap_options', function($options) {
  return array_merge($options, array(
    /*
    'search_submit_label' => '<i class="fa fa-search"></i>', // Show font-awesome search icon in searchform
    'submit_button_class' => 'btn',
		'post_tag_class' => 'badge badge-primary text-light mb-1',
		'next_posts_link_class' => 'btn btn-primary btn-lg btn-block btn-progress mb-4 mb-lg-0',
    */
  ));
});

/*
add_action('after_setup_theme', function() {
  $last_included_file = array_pop((array_slice(get_included_files(), -1)));
  // echo $last_included_file;


  // exit;
});

global $current_slug;

$current_slug = null;

function my_template_part_action($slug) {
  global $current_slug;

  $last_included_file = array_pop((array_slice(get_included_files(), -1)));
  $template_directory = get_template_directory();
  $page_template = get_page_template();

  // if (strpos($template_directory, $last_included_file) === 0) {
    echo '<!-- CURRENT: ' . $page_template . ' -->';
    echo '<!-- INCLUDED PARENT TEMPLATE ' . $last_included_file . ' -->';
  // }
  echo "<!-- INCLUDE $slug -->";

  $current_slug = $slug;
}

add_action( 'get_template_part_template-parts/post/content', 'my_template_part_action', 10, 2 );
add_action( 'get_template_part_template-parts/navigation/navigation', 'my_template_part_action', 10, 2 );
add_action( 'get_template_part_template-parts/navigation', 'my_template_part_action', 10, 2 );
*/

add_filter('search_options', function($options = array()) {
  $ui = isset($options['ui']) && is_array($options['ui']) ? $options['ui'] : array();

	$options = array_merge($options, array(
    // Custom options
    'ui' => array_merge($ui, array(
      'theme' => 'none',
      'classes' => array(
        'ui-autocomplete' => 'dropdown-menu',
        'ui-autocomplete-input' => 'form-control',
        'ui-menu' => 'dropdown-menu',
        'ui-menu-item' => 'dropdown-item',
        'ui-widget-header' => 'dropdown-header'
      )
    ))
	));

	return $options;
});


/**
 * Display custom color CSS.
 */
add_action('wp_head', function() {
  $theme_colors = [
    'primary',
    'secondary',
    'success',
    'info',
    'danger',
    'warning',
    'light',
    'dark'
  ];
	?>
		<style type="text/css" id="custom-theme-colors">
      :root {
        <?php foreach($theme_colors as $color_slug): ?>
    			--<?= $color_slug; ?>: <?= esc_attr(get_theme_mod($color_slug)); ?>;
        <?php endforeach; ?>
      }
		</style>
	<?php
}, 11);
