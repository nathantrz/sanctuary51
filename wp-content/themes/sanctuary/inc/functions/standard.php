<?php // Standard Functions

// Hide Version
remove_action('wp_head', 'wp_generator');

// Enable Featured Images
add_theme_support('post-thumbnails');

// Disable Emoji
function disable_wp_emojicons() {
  // all actions related to emojis
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  // filter to remove TinyMCE emojis
  add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}
add_action('init', 'disable_wp_emojicons');

// Kill TinyMCE Emoji
function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

// Hide Custom Fields by Default
add_action('admin_init','customize_meta_boxes');
function customize_meta_boxes() { remove_meta_box('postcustom','page','normal'); }

// Browser body class
function browser_body_class($classes) {
  global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
  if($is_lynx) $classes[] = 'lynx';
  elseif($is_gecko) $classes[] = 'gecko';
  elseif($is_opera) $classes[] = 'opera';
  elseif($is_NS4) $classes[] = 'ns4';
  elseif($is_safari) $classes[] = 'safari';
  elseif($is_chrome) $classes[] = 'chrome';
  elseif($is_IE) {
    $classes[] = 'ie';
    if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
    $classes[] = 'ie'.$browser_version[1];
  } else $classes[] = 'unknown';
  if($is_iphone) $classes[] = 'iphone';
  if ( stristr( $_SERVER['HTTP_USER_AGENT'],"mac") ) {
    $classes[] = 'osx';
   } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"linux") ) {
    $classes[] = 'linux';
   } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"windows") ) {
    $classes[] = 'windows';
   }
  return $classes;
} add_filter('body_class','browser_body_class');

// Prevent auto-<p> on <iframe>
function filter_ptags_on_iframes($content){
   return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}
add_filter('the_content', 'filter_ptags_on_iframes');

// Wrap Default WP Video Embeds in Container
function wrap_iframe( $content ) {
  $pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
  preg_match_all($pattern, $content, $matches);
  foreach ($matches[0] as $match) {
    $wrappedframe = '<div class="iframe-container">' . $match . '</div>';
    $content = str_replace($match, $wrappedframe, $content);
  }
  return $content;
}
add_filter('the_content', 'wrap_iframe');

// Convert Content (iframes, imgs) SRC to DATA-SRC to Defer Loading
function defer_content_src( $content ) {
  $pattern = '~src=".*"~';
  preg_match_all($pattern, $content, $matches);
  foreach ($matches[0] as $match) {
    $data_src = 'src="" data-behavior="content-defer" data-' . $match;
    $content = str_replace($match, $data_src, $content);
  }
  return $content;
}
add_filter('the_content', 'defer_content_src');
?>
