<?php

add_action( 'admin_init', function() {
  register_setting( 'search-options-group', 'search_options', array(
    'default' => array(
      'post_types' => array(
        'post' => 1
      ),
      'suggestions' => array(
        'max_count' => 5
      )
    )
  ));
});

add_action('admin_menu', function() {
  add_options_page( __('Search', 'search'), __('Search', 'search'), 'manage_options', 'search', 'search_options_page');
});

function search_options_page() {
  $options = get_option('search_options');

  $post_types = array_map(
    function($post_type) {
      return get_post_type_object($post_type);
    },
    get_post_types([
      'public'   => true,
      // '_builtin' => true
    ], 'names', 'and')
  );

  // List post-types alphabetically
  usort($post_types, function($a, $b) {
    if ($a->label === $b->label) {
      return 0;
    }
    return ($a->label < $b->label) ? -1 : 1;
  });

  ?>
    <div class="wrap">
      <?php screen_icon(); ?>
      <h1><?= __('Settings'); ?> › <?= __('Search', 'search'); ?></h1>
      <form method="post" action="options.php">
        <?php settings_fields( 'search-options-group' ); ?>
        <?php do_settings_sections( 'search-options-group' ); ?>
        <table class="form-table">
          <tr>
            <th>Post Types</th>
            <td>
              <?php foreach ($post_types as $post_type_object): ?>
                <div>
        					<label>
        						<input type="checkbox" name="search_options[post_types][<?= $post_type_object->name; ?>]" value="1" <?php checked( $options['post_types'][$post_type_object->name], 1 ); ?> />
        						<?= __($post_type_object->label); ?>
        					</label>
                </div>
    			    <?php endforeach; ?>
            </td>
          </tr>
          <tr>
            <th>Max suggestions</th>
            <td><input type="number" name="search_options[suggestions][max_count]" value="<?= $options['suggestions']['max_count']; ?>"/></td>
          </tr>
        </table>
        <?php submit_button(); ?>
      </form>
    </div>
  <?php
}
