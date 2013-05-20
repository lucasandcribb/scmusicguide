<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Soundcheck
 * @since 1.0
 */
?><!doctype html>  

<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>
  
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Cabin:r,b,i,bi|Oswald:r,b,i,bi' type='text/css' media='all' />
  
<!--
**********************************************************************************************
	
Soundcheck (<?php echo VERSION ?>) - Designed and Built by Luke McDonald
	
**********************************************************************************************
-->

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,<?php bloginfo( 'html_type' ); ?>">
	
	<title><?php wp_title() ?></title>
	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	

	
	<?php wp_head(); ?>
	
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
	
</head>

<body id="top" <?php body_class(); ?> >
	<div id="header-container">
		<header id="header" class="hfeed">
  			<div id="header-content">
				<div class="top-border"><!-- nothing to see here --></div>
				<div id="site-info" role="banner">
	    			<?php
	    			$blog_info = get_bloginfo( 'name' );
	    			$logo_url = soundcheck_option( 'logo_url' );
	    			$site_title_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
					
	    			<<?php echo $site_title_tag; ?> id="site-title">
	    				<a class="<?php echo ( $logo_url ) ? 'image-logo' : 'text-logo' ?>" href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( $blog_info ); ?>" >
	    					<?php if ( $logo_url ) : ?>
	    						<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_attr_e( 'Logo', 'themeit') ?>" />
	    					<?php else : ?>
	    						<?php echo esc_html( $blog_info ) ?>
	    					<?php endif; // end text logo check ?>
	    				</a>
	    			</<?php echo $site_title_tag; ?>><!-- #site-title -->
					
	    			<?php if( soundcheck_option( 'text_logo_desc' ) ) : ?>
						<p id="site-description"><?php bloginfo( 'description' ); ?></p>
	    			<?php endif; ?>
				</div><!-- .site-info -->
				<div class="bottom-border clearfix"><!-- nothing to see here --></div>
			</div><!-- .#header-content -->
			
			
			<?php 
			/**
			 * Hero Slider
			 *
			 */
			get_template_part( 'content', 'hero' ) ?>
			
			
			<?php 
			/**
			 * Primary Nav
			 *
			 */
			?>
			<nav id="primary-nav" role="navigation">
			    <ul class="menu">
			    	<?php 
			    	if ( has_nav_menu( 'primary' ) ) : // Check if primary menu has been set in WP menu options
			    		wp_nav_menu( array(
			    			'theme_location' => 'primary',
			    			'container'      => '',
			    			'items_wrap'     => '%3$s',
			    			'sort_column'    => 'menu_order' 
			    		));
			    	else :
			    		wp_list_pages( array( 
			    			'title_li'	=>	'' 
			    		));
			    	endif;
			    	?>
			    	
			    	<?php  
			    	if( soundcheck_cart66_installed() ) {
			    		printf( '<li class="menu-item cart"></li>'
			    		
			    		);
			    	}
			    	?>
			    </ul>
			</nav><!-- #primary-nav -->
			
			<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
			
		</header><!-- #header -->
	</div><!-- #header-container -->

	<div id="main" role="main">
		<?php 
		/**
		 * Primary Sidebar Widgets
		 *
		 */
		if( soundcheck_product_type_page() ) 
			get_sidebar( 'primary-products' );
		elseif( ! is_home() && ! is_page_template( 'template-full.php' ) )
			get_sidebar( 'primary' ); 
		?>
		
		<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" />