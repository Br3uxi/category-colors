<?php
/*
Plugin Name: Category Colors
Plugin URI: https://github.com/breuxi/category-colors
Description: Add Colors to Categories
Version: 1.0.0
Base: https://themehybrid.com/weblog/introduction-to-wordpress-term-meta
Author: Breuxi
Author URI: https://breuxi.de
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

add_action( 'init', 'catcolors_register_meta' );

function catcolors_register_meta() {

    register_meta( 'term', 'color', 'catcolors_sanitize_hex' );
}

function catcolors_sanitize_hex( $color ) {

    $color = ltrim( $color, '#' );

    return preg_match( '/([A-Fa-f0-9]{3}){1,2}$/', $color ) ? $color : '';
}

function catcolors_get_term_color( $term_id, $hash = false ) {

    $color = get_term_meta( $term_id, 'color', true );
    $color = catcolors_sanitize_hex( $color );

    return $hash && $color ? "#{$color}" : $color;
}

include(plugin_dir_path(__FILE__)  . 'inc/enqueue.php');
include(plugin_dir_path(__FILE__)  . 'inc/form-fields.php');