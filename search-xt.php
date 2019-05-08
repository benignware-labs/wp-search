<?php

/**
 Plugin Name: Search XT
 Plugin URI: http://github.com/benignware/wp-search-xt
 Description: Wordpress Search Extensions
 Version: 0.0.3
 Author: Rafael Nowrotek, Benignware
 Author URI: http://benignware.com
 License: MIT
*/

require_once 'lib/options.php';
require_once 'features/suggestions/suggestions.php';

add_filter('search_options', function($options = []) {
  $search_options = get_option('search_options');

  return array_merge(
    $options,
    $search_options,
    array(
      'post_types' => array_merge(
        array_map(
          function($item) {
            return 0;
          },
          get_post_types([
            'public'   => true,
            '_builtin' => true
          ], 'names', 'and')
        ),
        $search_options['post_types']
      ),
      'suggestions' => array_merge(
        array(
          'max_count' => 5,
          'min_length' => 1,
          'delay' => 500
        ),
        $search_options['suggestions']
      )
    )
  );
}, 10);
