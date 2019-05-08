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

  ?>
    <div class="wrap">
      <?php screen_icon(); ?>
      <h1><?= __('Settings'); ?> › <?= __('Search', 'search'); ?></h1>
      <form method="post" action="options.php">
        <?php settings_fields( 'search-options-group' ); ?>
        <?php do_settings_sections( 'search-options-group' ); ?>
        <h3>Post Types</h3>
        <p class="description">Pick post types that should be included in search</p>
        <table class="form-table">
          <?php foreach ($options['post_types'] as $post_type => $post_type_enabled): ?>
    				<tr>
              <td>
      					<?php $data = get_post_type_object($post_type); ?>
      					<label>
      						<input type="checkbox" name="search_options[post_types][<?= $post_type; ?>]" value="1" <?php checked( $post_type_enabled, 1 ); ?> />
      						<?= __($data->label); ?>
      					</label>
              </td>
    				</tr>
    			<?php endforeach; ?>
        </table>
        <h3>Suggestions</h3>
        <table class="form-table">
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
