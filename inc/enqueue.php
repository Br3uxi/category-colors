<?php

add_action( 'admin_enqueue_scripts', 'catcolors_admin_enqueue_scripts' );

function catcolors_admin_enqueue_scripts( $hook_suffix ) {

    if ( 'edit-tags.php' !== $hook_suffix || 'category' !== get_current_screen()->taxonomy )
        return;

    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );

    add_action( 'admin_head',   'catcolors_term_colors_print_styles' );
    add_action( 'admin_footer', 'catcolors_term_colors_print_scripts' );
}

function catcolors_term_colors_print_styles() { ?>

    <style type="text/css">
        .column-color { width: 50px; }
        .column-color .color-block { display: inline-block; width: 28px; height: 28px; border: 1px solid #ddd; }
    </style>
<?php }

function catcolors_term_colors_print_scripts() { ?>

    <script type="text/javascript">
        jQuery( document ).ready( function( $ ) {
            $( '.catcolors-color-field' ).wpColorPicker();
        } );
    </script>
<?php }