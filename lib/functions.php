<?php

function get_search_options() {
  $search_options = get_option('search_options') ?: array(
    'theme' => '',
    'suggestions' => [],
    'post_types' => []
  );

  $options = apply_filters('search_options', array_merge(
    $search_options,
    array(
      'post_types' => array_merge(
        array_map(
          function($item) {
            return 0;
          },
          get_post_types([
            'public'   => true,
            // '_builtin' => true
          ], 'names', 'and')
        ),
        $search_options['post_types']
      ),
      'suggestions' => array_merge(
        array(
          'max_count' => 5,
          'autocomplete' => array(
            'minLength' => 1,
            'delay' => 500
          )
        ),
        $search_options['suggestions']
      )
    )
  ));

  return $options;
}
