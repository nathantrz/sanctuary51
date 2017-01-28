<?php // Functions

// Enqueue Styles and Scripts
if(!is_admin()) {
  // Theme Stylesheet
  wp_enqueue_style('theme_style', get_stylesheet_uri());
  // Theme Scripts
  wp_enqueue_script('theme_scripts', get_stylesheet_directory_uri() . '/assets/scripts/build.min.js', array('jquery'), false, false);
}

// Includes
// Standard
require('inc/functions/standard.php');
// Menus
require('inc/functions/menus.php');
