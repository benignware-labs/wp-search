<?php

function dom_mutations_is_admin() {
    //Ajax request are always identified as administrative interface page
    //so let's check if we are calling the data for the frontend or backend
    if (wp_doing_ajax()) {
      $admin_url = get_admin_url();
      //If the referer is an admin url we are requesting the data for the backend
      return (substr($_SERVER['HTTP_REFERER'], 0, strlen($admin_url)) === $admin_url);
    }

    // No ajax request just use the normal function
    return is_admin();
}

add_action('after_setup_theme', function() {

  if (!dom_mutations_is_admin()) {
    // Start observing buffer
    ob_start(function($html) {
      // Parse DOM
      $document = new DOMDocument();
      @$document->loadHTML('<?xml encoding="utf-8" ?>' . $html );

      $xpath = new DOMXpath($document);

      $document = apply_filters('dom_mutations', $document, $xpath, $html);

      $html = $document->saveHTML();
      $html = str_replace('<?xml encoding="utf-8" ?>', '', $html);

      return $html;
    });
  }
});

add_action('shutdown', function() {
  if (!dom_mutations_is_admin()) {
    // Flush buffer
    ob_end_flush();
  }
});
