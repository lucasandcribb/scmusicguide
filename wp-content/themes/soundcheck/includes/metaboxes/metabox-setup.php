<?php
/**
 * Include metaboxes
 *
 * @since 1.0
 */
locate_template( 'includes/metaboxes/products.php', true );


/**
 * Enqueue CSS and JS
 *
 * @since 1.0
 */
function soundcheck_metabox_assets( $hook ) {
    $screen = get_current_screen();
    $screen = $screen->id;

    if( $screen != 'post' && $screen != 'edit-post' )
		return;
        
    wp_enqueue_style( 'soundcheck_metaboxes_css', get_template_directory_uri() . '/includes/metaboxes/css/metaboxes.css', false, '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'soundcheck_metabox_assets' );


/**
 * Update post meta shortcut
 *
 * @since 1.0
 */
function soundcheck_update_post_meta( $post_id, $fields_array = null, $type = 'text' ){
    if( is_array( $fields_array ) ):
        foreach( $fields_array as $field ){
             if ( isset( $_POST[$field] ) ):
             
                if( $type == 'url' ){
                    update_post_meta( $post_id, $field, esc_url( $_POST[$field], array( 'http', 'https' ) ) );
                } else {
                    update_post_meta( $post_id, $field, strip_tags( $_POST[$field] ) ); 
                }
             
            endif;
        }
    endif;
}

/**
 * Meta fields shortcut
 *
 * @since 1.0
 */
function soundcheck_meta_field( $post, $type = 'text', $field, $label = false, $desc = false ) { 
    $value = get_post_meta( $post->ID, $field, true ); ?>
    
    <p class="soundcheck-field">
        <?php if( $label ) { ?>
        	<label for="<?php echo $field; ?>"><?php echo $label; ?></label>
        <?php } ?>
        
		<?php if( $type == 'url' ) { ?>
            <input type="<?php echo $type; ?>" id="<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo esc_url( $value ); ?>" />
        <?php } elseif( $type == 'text' ) { ?>
            <input type="<?php echo $type; ?>" id="<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo esc_attr( $value ); ?>" />
        <?php } ?>
        
        <?php if( $desc ) { ?><span class="description"><?php echo $desc; ?></span><?php } ?>
    </p>
<?php }



?>