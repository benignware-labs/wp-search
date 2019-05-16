<nav id="site-navigation" class="navbar navbar navbar-expand-md navbar-dark bg-dark" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'twentyseventeen' ); ?>">>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-top" aria-controls="navbar-top" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar-top">
        <?php
          // Primary navigation menu.
          wp_nav_menu(array(
            'theme_location' => 'top',
            'menu_id' => 'top-menu',
            'menu_class' => 'navbar-nav',
            'container' => false
          ));
        ?>
      </div>
</nav>
<!-- #site-navigation -->
