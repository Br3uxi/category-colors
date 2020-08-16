<?php


add_action( 'category_add_form_fields', 'ccp_new_term_color_field' );

function ccp_new_term_color_field() {

    wp_nonce_field( basename( __FILE__ ), 'catcolors_term_color_nonce' ); ?>

    <div class="form-field catcolors-term-color-wrap">
        <label for="catcolors-term-color"><?php _e( 'Color', 'catcolors' ); ?></label>
        <input type="color" name="catcolors_term_color" id="catcolors-term-color" value="" class="catcolors-color-field" data-default-color="#ffffff" />
    </div>
<?php }

add_action( 'category_edit_form_fields', 'ccp_edit_term_color_field' );

function ccp_edit_term_color_field( $term ) {

    $default = '#ffffff';
    $color   = catcolors_get_term_color( $term->term_id, true );

    if ( ! $color )
        $color = $default; ?>

    <tr class="form-field catcolors-term-color-wrap">
        <th scope="row"><label for="catcolors-term-color"><?php _e( 'Color', 'catcolors' ); ?></label></th>
        <td>
            <?php wp_nonce_field( basename( __FILE__ ), 'catcolors_term_color_nonce' ); ?>
            <input type="color" name="catcolors_term_color" id="catcolors-term-color" value="<?php echo esc_attr( $color ); ?>" class="catcolors-color-field" data-default-color="<?php echo esc_attr( $default ); ?>" />
        </td>
    </tr>
<?php }


add_action( 'edit_category',   'catcolors_save_term_color' );
add_action( 'create_category', 'catcolors_save_term_color' );

function catcolors_save_term_color( $term_id ) {

    if ( ! isset( $_POST['catcolors_term_color_nonce'] ) || ! wp_verify_nonce( $_POST['catcolors_term_color_nonce'], basename( __FILE__ ) ) )
        return;

    $old_color = catcolors_get_term_color( $term_id );
    $new_color = isset( $_POST['catcolors_term_color'] ) ? catcolors_sanitize_hex( $_POST['catcolors_term_color'] ) : '';

    if ( $old_color && '' === $new_color )
        delete_term_meta( $term_id, 'color' );

    else if ( $old_color !== $new_color )
        update_term_meta( $term_id, 'color', $new_color );
}

add_filter( 'manage_edit-category_columns', 'catcolors_edit_term_columns' );

function catcolors_edit_term_columns( $columns ) {

    $columns['color'] = __( 'Color', 'catcolors' );

    return $columns;
}

add_filter( 'manage_category_custom_column', 'catcolors_manage_term_custom_column', 10, 3 );

function catcolors_manage_term_custom_column( $out, $column, $term_id ) {

    if ( 'color' === $column ) {

        $color = catcolors_get_term_color( $term_id, true );

        if ( ! $color )
            $color = '#ffffff';

        $out = sprintf( '<span class="color-block" style="background:%s;">&nbsp;</span>', esc_attr( $color ) );
    }

    return $out;
}