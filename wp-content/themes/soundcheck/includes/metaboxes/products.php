<?php
/**
 * Add Metabox
 *
 * @since 1.0
 */
function soundcheck_add_product_meta(){
    
    add_meta_box( 
        'soundcheck-product-meta', 
        __( 'Product Details', 'soundcheck' ), 
        'soundcheck_product_meta_cb', 
        'post', 
        'side', 
        'high'
    );
    
}
add_action( 'add_meta_boxes', 'soundcheck_add_product_meta' );

/**
 * Metabox Callback
 *
 * @since 1.0
 */
function soundcheck_product_meta_cb( $post ) {
	
	// Nonce to verify intention later
	wp_nonce_field( 'save_soundcheck_product_meta', 'soundcheck_product_nonce' ); ?>
	
	<?php if ( soundcheck_cart66_installed() ) : ?>

		<?php
		$product = new Cart66Product();
		$products = $product->getModels( 'where id>0', 'order by name' );

		$field = '_product';
		$label = 'Product';
		
		$value = get_post_meta( $post->ID, $field, true ); 
		?>
    	
		<?php if ( count( $products ) ) : ?>
    		
    		<p class="soundcheck-field">
    		    <label for="<?php echo $field; ?>"><?php echo $label; ?></label>
			    
			    <select class="widefat" name="<?php echo $field; ?>">
			    	<option value=""><?php _e( 'Select a product...', 'soundcheck' ) ?></option>
	  		  	  	
	  		  	  	<?php foreach( $products as $p ) : // loop through available products ?>
	  		  	  		<option value="<?php echo $p->id ?>"<?php echo $value == $p->id ? ' selected="selected"' : '' ?>>
	  		  	  	    <?php
						printf( __( '%1$s &mdash; %2$s %3$s', 'soundcheck' ),
						    esc_html( $p->name ),
						    esc_html( CART66_CURRENCY_SYMBOL ),
						    esc_html( $p->gravityFormId == true ? 'Linked to Gravity Forms' : $p->price )
						)
						?>
	  		  	  		</option>
	  		  	  	<?php endforeach; ?>
			    </select>
			</p>
		
		<?php else : ?>
		
			<p>
				<?php
				printf( '%1$s <br /><a href="%2$s" title="%3$s">%4$s</a>',
					esc_html( 'There are not any Cart66 products setup.', 'soundcheck' ),
					esc_url( admin_url( 'admin.php?page=cart66-products' ) ),
					esc_attr__( 'Setup a product.', 'soundcheck' ),
					esc_html__( 'Setup a product &rarr;', 'soundcheck' )
				);			
				?>
			</p>
		
		<?php endif; // end products check ?>
		
	<?php else : ?>
    	<p><?php _e( 'The Cart66 plugin needs to be installed and activated in order to setup products.', 'themeit' ) ?></p>
	<?php endif; // end cart66 class check ?>	
<?php
}

/**
 * Save Metabox Values
 *
 * @since 1.0
 */
function soundcheck_product_save( $post_id ) {
	
	// Let's not auto save the data
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 

	// Check our nonce
	if( ! isset( $_POST['soundcheck_product_nonce'] ) || ! wp_verify_nonce( $_POST['soundcheck_product_nonce'], 'save_soundcheck_product_meta' ) ) return;

	// Make sure the current user can edit the post
	if( ! current_user_can( 'edit_post' ) ) return;
	
	// Save metadata
	soundcheck_update_post_meta( $post_id, array( '_product' ), 'select' );

}
add_action( 'save_post', 'soundcheck_product_save' );

?>