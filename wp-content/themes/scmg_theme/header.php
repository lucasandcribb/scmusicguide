<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<script>
  var $ = jQuery.noConflict();    
</script>
<link rel="stylesheet" type="text/css" media="all" href="/wp-content/css/scmg.css" />
<link rel="stylesheet" type="text/css" media="all" href="/wp-content/css/scmg-mobile.css" />
<script src="/wp-content/js/scmg.js"></script>

<script type="text/javascript">
  	(function() {
   		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
   		po.src = 'https://apis.google.com/js/plusone.js';
   		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  	})();
</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</head>

<body <?php body_class(); ?>>

<div id="bg"></div>


<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<hgroup>
			<a href="/"><img id="logo" src="/wp-content/images/logo/logo.png" /></a>

		</hgroup>
		<div id="header-title">
			<a href="/">
				South Carolina
				<span class="music-red">Music</span> Guide
			</a>
		</div>
		<div id="header-top-links">
			<a class="header-top-links" href="/contact">Contact</a>
			<a class="header-top-links" href="/about-us">About Us</a>
			<a class="header-top-links" href="/artist-index-page">Artists</a>
			<a class="header-top-links" href="/album-reviews">Reviews</a>
		</div>
		<div id="social-links">
			<a href="http://www.facebook.com/sharer.php?u=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?> " target="_blank"><img class="social-link" src="/wp-content/images/social-icons/fb.jpg" /></a>
			<a href="http://www.twitter.com/share?text=<?php echo bloginfo('name'); ?>&url=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" target="_blank"><img class="social-link" src="/wp-content/images/social-icons/twitter.jpg" /></a>
			<a href="https://plus.google.com/share?url=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" target="_blank"><img class="social-link" src="/wp-content/images/social-icons/g.jpg" /></a>
			<a href="http://www.tumblr.com/share/link?url=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>&name=<?php echo bloginfo('name'); ?>" target="_blank"><img class="social-link" src="/wp-content/images/social-icons/tumblr.jpg" /></a>
			<!-- <a href="http://pinterest.com/pin/create/button/?url=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>&description=<?php echo bloginfo('name'); ?>" target="_blank"><img class="social-link" src="/wp-content/images/social-icons/pinterest.jpg" /></a> -->
			<!-- <img class="social-link" src="/wp-content/images/social-icons/vimeo.jpg" />
			<img class="social-link" src="/wp-content/images/social-icons/youtube.jpg" /> -->
		</div>

		<?php get_search_form(); ?>

		<div id="f-login"><?php echo do_shortcode('[flexible-frontend-login-modal]'); ?></div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			<!-- <div id="header-nav-divider"></div> -->
		</nav><!-- #site-navigation -->
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
		<?php endif; ?>

		

		
	</header><!-- #masthead -->

	<div id="main" class="wrapper">