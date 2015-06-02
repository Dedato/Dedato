<?php
/**
 * Roots initial setup and constants
 */
function roots_setup() {
  // Make theme available for translation
  load_theme_textdomain('roots', get_template_directory() . '/lang');

  // Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'roots'),
  ));

  // Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
  add_theme_support('post-thumbnails');
  // set_post_thumbnail_size(150, 150, false);
  
  // Grid Sizes
  add_image_size('grid-small', 150, 9999); // 150px wide (and unlimited height)
  add_image_size('grid-normal', 315, 9999); // 300px wide (and unlimited height)
  add_image_size('grid-large', 480, 9999); // 450px wide (and unlimited height)
  
  // Slider Sizes
  //add_image_size('large', 760, 537); // A4 ratio
  add_image_size('x-large', 1024, 724); // A4 ratio
  add_image_size('xx-large', 1400, 990); // A4 ratio

  // Page Sizes
  add_image_size('page-large', 760, 9999);
  add_image_size('page-x-large', 1024, 9999);

  // Add post formats (http://codex.wordpress.org/Post_Formats)
  // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

  // Tell the TinyMCE editor to use a custom stylesheet
  add_editor_style('/assets/css/editor-style.css');
}
add_action('after_setup_theme', 'roots_setup');
