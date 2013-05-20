<?php
/**
 * Functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, soundcheck_setup_debut(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Soundcheck
 * @since 1.0
 */
 
define( 'VERSION', '2.0.3' );

function soundcheck_version_id() {
	if ( WP_DEBUG )
		return time();
	return VERSION;
}


/**
 * Theme Setup
 *
 * If you would like to customize the theme setup you
 * are encouraged to adopt the following process.
 *
 * <ol>
 * <li>Create a child theme with a functions.php file.</li>
 * <li>Create a new function named mythemesoundcheck_setup_soundcheck().</li>
 * <li>Hook this function into the 'after_setup_theme' action at or after 11.</li>
 * <li>call remove_filter(), remove_action() and/or remove_theme_support() as needed.</li>
 * </ol>
 *
 * @return    void
 *
 * @since 1.0
 */
function soundcheck_setup_theme() {

	global $content_width;
	if ( ! isset( $content_width ) )
		$content_width = 680;
	
	// Text domain setup
	load_theme_textdomain( 'soundcheck', get_template_directory() . '/languages' );
	
	// Add editor styles
	add_editor_style( 'style-editor.css' );
	
	// Add page excrpt
	add_post_type_support( 'page', 'excerpt' );
	
	// Add automatic feed links in header
	add_theme_support( 'automatic-feed-links' );
	
	// Add custom background support
	add_custom_background( 'soundcheck_custom_background_callback' );
		
	// Add support for post formats
	add_theme_support( 'post-formats', array( 'audio', 'gallery', 'image', 'video' ) );
	
	// Post Thumbnail Image sizes and support
	add_theme_support( 'post-thumbnails' );
	
	// Set post thumbnail size
	set_post_thumbnail_size(        220,  220, true );
	
	// Add themes custom image sizes
	add_image_size( 'theme-medium',   440,  248, true );
	add_image_size( 'theme-large',    680,  383, true );
	add_image_size( 'theme-hero',     1600, 440, true );
	add_image_size( 'theme-icon',     100, 100, true );
	add_image_size( 'theme-carousel', 120, 66,  true );
	
	// Add support for navigation menus
	add_theme_support( 'menus' );

	// Register navigation menus.
	register_nav_menus( array( 'primary' => 'Primary', 'products' => 'Products' ) );
	
	/** 
	 * Load custom post scrpts
	 * 
	 * Not used in Soundcheck 2.0
	 * Uncomment to show them for reference.
	 * Use the Soundcheck Theme Converter plugin to convert
	 */
	//locate_template( 'includes/post-types/hero.php', true );
	//locate_template( 'includes/post-types/discography.php', true );
	
	// Load custom metaboxes
	locate_template( 'includes/metaboxes/metabox-setup.php', true );
	
	// Load custom shortcodes
	locate_template( 'includes/shortcodes/audio-player.php', true );
	
	// Load custom widgets
	locate_template( 'includes/widgets/audio-player.php', true );
	locate_template( 'includes/widgets/featured-category.php', true );
	locate_template( 'includes/widgets/featured-post.php', true );
	locate_template( 'includes/widgets/latest-tweets.php', true );
	locate_template( 'includes/widgets/post-meta.php', true );
	locate_template( 'includes/widgets/social-sharing.php', true );
	
	// Video Hooks
	add_filter( 'embed_defaults',          'soundcheck_embed_defaults' );
	add_filter( 'embed_googlevideo',       'soundcheck_video_embed_html' ); 
	add_filter( 'oembed_result',           'soundcheck_check_video_embeds', 10, 2 );
	add_filter( 'embed_oembed_html',       'soundcheck_oembed_wmode_transparent' );
	add_filter( 'video_embed_html',        'soundcheck_video_embed_html' );	
										    
	// Other WordPress hooks			    
	add_filter( 'body_class',              'soundcheck_product_body_class' );
	add_filter( 'body_class',              'soundcheck_sidebar_body_class' );
	add_filter( 'comment_form_defaults',   'soundcheck_comment_form_defaults' );
	add_filter( 'excerpt_more',            'soundcheck_excerpt_more_auto' );
	add_filter( 'post_gallery',            'soundcheck_gallery_display', 10, 2 ); // Filter [gallery] display
	add_action( 'widgets_init',            'soundcheck_register_sidebars' );
	add_action( 'widgets_init',            'soundcheck_unregister_widgets', 1 );
	add_action( 'wp_enqueue_scripts',      'soundcheck_theme_scripts' );
	add_action( 'wp_enqueue_scripts',      'soundcheck_theme_styles' );
	add_action( 'wp_enqueue_scripts',      'soundcheck_localize_jplayer' );
	add_action( 'wp_enqueue_scripts',      'soundcheck_localize_hero' );
	add_action( 'wp_enqueue_scripts',      'soundcheck_localize_view' ); // Get images for view.js lightbox
	add_filter( 'wp_title',                'soundcheck_wp_title' );
	
	// Custom hooks
	add_filter( 'soundcheck_gallery_image','soundcheck_gallery_image', 10, 4 );
	
	// Initialize theme options
	locate_template( 'includes/options/options-setup.php', true );
	soundcheck_options_init();	
}
add_action( 'after_setup_theme', 'soundcheck_setup_theme' );


/**
 * Include additional admin files
 *
 * @since 1.0
 */
locate_template( 'admin.php', true );
locate_template( 'style-custom.php', true );
	

/**
 * Cart66 Install Check
 *
 * @since 2.0
 */
function soundcheck_cart66_installed() {
	if( class_exists( 'Cart66' ) )
		return true;
	
	return false;
}


/**
 * Gravity Forms Install Check
 *
 * @since 2.0
 */
function soundcheck_gravity_forms_installed() {
	if( class_exists( 'RGForms' ) )
		return true;
	
	return false;
}


/**
 * GigPress Install Check
 *
 * @since 2.0
 */
function soundcheck_gigpress_installed() {
	if( function_exists( 'gigpress_admin_menu' ) )
		return true;
	
	return false;
}


/**
 * Activate Product Functions
 *
 * @since 2.0
 */
if( soundcheck_cart66_installed() ) :
	locate_template( 'cart66/functions.php', true );
endif;


/**
 * Load Required Theme Styles
 *
 * @since 1.0
 */
if( ! function_exists( 'soundcheck_theme_styles' ) ) :
function soundcheck_theme_styles() {
	wp_enqueue_style( 'soundcheck_style', get_stylesheet_uri(), array(), soundcheck_version_id() );
	
	wp_enqueue_style( 'soundcheck_gfont_oswald', 'http://fonts.googleapis.com/css?family=Oswald', false, soundcheck_version_id() );
	
	if( soundcheck_cart66_installed() ) {
		wp_enqueue_style( 'soundcheck_cart66', get_template_directory_uri() . '/stylesheets/style-cart66.css', false, soundcheck_version_id() );
	}
	
	if( soundcheck_gravity_forms_installed() ) {
		wp_enqueue_style( 'soundcheck_gravity_forms', get_template_directory_uri() . '/stylesheets/style-gravity-forms.css', array( 'gforms_css' ), soundcheck_version_id() );
	}
	
	if( soundcheck_gigpress_installed() ) {
		wp_enqueue_style( 'soundcheck_gigpress', get_template_directory_uri() . '/stylesheets/style-gigpress.css', false, soundcheck_version_id() );
	}
}
endif;


/**
 * Load Required Theme Scripts
 *
 * @since 1.0
 */
if( ! function_exists( 'soundcheck_theme_scripts' ) ) :
function soundcheck_theme_scripts() {
	
	wp_enqueue_script( 'soundcheck_modernizr', get_template_directory_uri() . '/js/modernizr.js' );				   
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'soundcheck_theme', get_template_directory_uri() . '/js/theme.js', 'jquery', soundcheck_version_id(), true );
	
	wp_enqueue_script( 'soundcheck_view', get_template_directory_uri() . '/js/view.js', array( 'jquery' ), soundcheck_version_id() . '&view', true );

	if ( is_singular() ) {
		if ( comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
endif;


/**
 * Fileter WP Title 
 *
 * Filter the title depending upon the page.
 *
 * @since 1.0
 * @updated 2.0
 */
if( ! function_exists( 'soundcheck_wp_title' ) ) :
function soundcheck_wp_title() {
	$sep = '&nbsp;&mdash;&nbsp;';
	$title = '%1$s' . $sep . '%2$s';

	if ( is_home() )
		printf( $title, get_bloginfo( 'name' ), get_bloginfo( 'description' ) );
	elseif ( is_search() )
		printf( $title, get_bloginfo( 'name' ), __( 'Search Results', 'soundcheck' ) );
	elseif ( is_author() )
		printf( $title, get_bloginfo( 'name' ), __( 'Author Archives', 'soundcheck' ) );
	elseif ( is_single() )
		printf( $title, the_title( '', '', false ), get_bloginfo( 'name' ) );
	elseif ( is_page() )
		printf( $title, get_bloginfo( 'name' ), the_title( '', '', false ) );
	elseif ( is_category() )
		printf( $title, get_bloginfo( 'name' ), __( 'Archive', 'soundcheck' ) . $sep . single_cat_title( '', false ) );
	elseif ( is_month() )
		printf( $title, get_bloginfo( 'name' ), __( 'Archive', 'soundcheck' ) . $sep . the_time( 'F' ) );
	elseif ( is_tag() )
		printf( $title, get_bloginfo( 'name' ), __( 'Tag Archive', 'soundcheck' ) . $sep . single_tag_title( '', false ) );
	else 
		print '';
}
endif;


/**
 * Callback function for add_custom_background().
 * This function fixes the issue where the theme
 * declares a background image via style.css and
 * the color set in the add_custom_background()
 * option does not show.
 *
 * @since 2.0
 */
function soundcheck_custom_background_callback() {
	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( ! empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) )
		return;

	/* Set body background css */
	$body_bg = sprintf( 'body { background: #%s; }', esc_html( $color ) );

	/* Print style tag and css to page */
	printf( '<style type="text/css">%1$s</style>', trim( $body_bg ) );
}


/**
 * Archives title
 *
 * @since 1.0
 * @updated 2.0
 */
function soundcheck_archives_title() {
	if ( is_category() ) { /* If this is a category archive */
		printf( __( '<span>Category:</span> %s', 'soundcheck' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) { /* If this is a tag archive */
		printf( __( '<span>Tag:</span> %s', 'soundcheck' ), single_tag_title( '', false ) );
	} elseif ( is_day() ) { /* If this is a daily archive */
		printf( __( '<span>Archive For</span> %s', 'soundcheck' ), get_the_time(  'F jS, Y', 'soundcheck' ) );
	} elseif ( is_month() ) { /* If this is a monthly archive */
		printf( __( '<span>Archive For</span> %s', 'soundcheck' ), get_the_time(  'F, Y', 'soundcheck' ) );
	} elseif ( is_year() ) { /* If this is a yearly archive */
		printf( __( '<span>Archive For</span> %s', 'soundcheck' ), get_the_time(  'Y', 'soundcheck' ) );
	} elseif ( is_search() ) { /* If this is a search archive */
		printf( __( '<span>Search For</span> "%s"', 'soundcheck' ), get_search_query() );
	} elseif ( is_author() ) { /* If this is an author archive */
		printf( __( '<span>Posts By</span> %s', 'soundcheck' ), get_the_author() );
	} elseif ( is_paged() ) { /* If this is a paged archive */
		_e( '<span>Browsing</span> Blog Archives', 'soundcheck' );
	} elseif ( is_404() ) {
		_e( '<span>404:</span> Page Not Found', 'soundcheck' );
	} 
}


/**
 * Page Query Var
 *
 * The below functionality is used because the query is set
 * in a page template, the "paged" variable is available. However,
 * if the query is on a page template that is set as the websites
 * static posts page, "paged" is always set at 0. In this case, we
 * have another variable to work with called "page", which increments
 * the pagination properly.
 * 
 * Hat Tip: @nathanrice
 * 
 * @link http://wordpress.org/support/topic/wp-30-bug-with-pagination-when-using-static-page-as-homepage-1
 * @since 1.0
 */
if ( ! function_exists( 'soundcheck_get_paged_query_var' ) ) :
function soundcheck_get_paged_query_var() {
	if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	} else {
		$paged = 1;
	}
	return $paged;
}
endif;


/**
 * Video Embed HTML
 *
 * Add extra markup to VideoPress embeds.
 *
 * @param string html Video content from VideoPress plugin.
 * @return string Updated content with extra markup.
 * @since 1.0
 */
function soundcheck_video_embed_html( $html ) {
	$html = sprintf( '<div class="wp-embed"><div class="player">%1$s</div></div>', $html );
	return $html;
}


/**
 * Add extra markup to auto-embedded videos.
 *
 * @param string html Content from the auto-embed plugin.
 * @param string url Link embedded in the post, used to determine if this is a video we want to filter.
 * @return string Updated content with extra markup.
 * @since 1.0
 */
function soundcheck_check_video_embeds( $html, $url ) {
	$players = array( 'youtube', 'vimeo', 'dailymotion', 'hulu', 'blip.tv', 'wordpress.tv', 'viddler', 'revision3' );

	foreach( $players as $player ) {
		if( false !== ( strstr( $url, $player ) ) ) {
			$html = soundcheck_video_embed_html( $html );
		}
		
		if( 'youtube' !== ( strstr( $url, $player ) ) ) {
			$html = soundcheck_add_wmode_transparency( $html );
		}
	}
	
	return $html;
}


/**
 * Add Transparency URL Parameter.
 *
 * @param string html Content from the oEmbed result.
 * @return string Updated content with extra wmode=transparent url param.
 * @since 1.0
 */
function soundcheck_add_wmode_transparency( $html ) {
	if ( strpos( $html, "<iframe" ) !== false) {
		$search = array( '" frameborder="0"');
		$replace = array( '&wmode=transparent" frameborder="0"' );
		$html = str_replace( $search, $replace, $html ) ;
   		return $html;
   } else {
        return $html;
   }
}


/**
 * Set oEmbed WMode Transparency
 *
 * Menus Behind Embedded Video Fix. Adds wmode=transparent to embed objects
 *
 * @return string
 * @since 1.0
 */
function soundcheck_oembed_wmode_transparent( $oembedvideo ) {
	$patterns = array();
	$patterns[] = '/<\/param><embed/';
	$patterns[] = '/allowscriptaccess="always"/';
	
	$replacements = array();
	$replacements[] = '</param><param name="wmode" value="transparent"></param><embed';
	$replacements[] = 'wmode="transparent" allowscriptaccess="always"';
	
	return preg_replace( $patterns, $replacements, $oembedvideo );
	
	return $oembedvideo;
}


/**
 * Embded Default Size
 * 
 * Set the defalut size for embed options
 *
 * @return array
 * @since 1.0
 */
function soundcheck_embed_defaults( $embed_size ) {
	$embed_size['width'] = 480;
	$embed_size['height'] = 270;
	
	return $embed_size;
}



/**
 * Title Attribute.
 *
 * @since 1.0
 */
if( ! function_exists( 'soundcheck_the_title_attribute' ) ) :
function soundcheck_the_title_attribute( $echo = false ) {
    return sprintf( esc_attr__( 'Permalink to %s', 'soundcheck' ), the_title_attribute( 'echo=0' ) );
}
endif;


/**
 * Comment Form Defaults
 *
 * @since 1.0
 */
function soundcheck_comment_form_defaults() {

	$req = get_option( 'require_name_email' );
	
	$field = '<p class="comment-form-%1$s"><label for="%1$s" class="comment-field">%2$s</label><input class="text-input" type="text" name="%1$s" id="%1$s" size="22" tabindex="%4$d"/><span class="field-note">%3$s</span></p>';
	
	$fields = array(
		'author' => sprintf(
			$field,
			'author',
			( $req ? __( 'Name <span>*</span>', 'soundcheck' ) : __( 'Name', 'soundcheck' ) ),
			'',
			5
		),
		'email' => sprintf(
			$field,
			'email',
			( $req ? __( 'Email <span>*</span>', 'soundcheck' ) : __( 'Email', 'soundcheck' ) ),
			__( '(Never published)', 'soundcheck' ),
			6
		),
		'url' => sprintf(
			$field,
			'url',
			__( 'Website', 'soundcheck' ),
			'',
			7
		),
	);

	$defaults = array(
		'id_form' => 'commentform',
		'id_submit' => 'submit',
		'label_submit' => __( 'Post Comment', 'soundcheck' ),
		'comment_field' => sprintf( 
			'<p class="comment-form-comment"><textarea id="comment" name="comment" rows="10" aria-required="true" tabindex="8"></textarea><label for="comment" class="comment-field">%1$s</label></p>',
			_x( 'Comment:', 'noun', 'soundcheck' )
		),
		'comment_notes_before' => '',
		'comment_notes_after' => sprintf(
			'<p class="comments-rss"><a href="%1$s"><span>%3$s</span> %2$s</a></p>',
			esc_attr( get_post_comments_feed_link() ),
			__( 'Subscribe To Comment Feed', 'soundcheck' ),
			__( 'RSS', 'soundcheck' )
			
		),
		'logged_in_as' => '',
		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		'cancel_reply_link' => '<div class="cancel-comment-reply">' . __( 'Cancel Reply', 'soundcheck' ) . '</div>',
		'title_reply' => __( 'Leave a Reply', 'soundcheck' ),
		'title_reply_to' => __( 'Leave a comment to %s', 'soundcheck' ),
	);

	return $defaults;
}


/**
 * Comment Callback Setup
 *
 * @since 1.0
 */
if ( ! function_exists( 'soundcheck_comment_callback' ) ) :
function soundcheck_comment_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;	?>
	
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>">
		
			<div class="seperation-border"></div>
		
			<div class="comment-head">
				<figure class="comment-author-avatar">
					<?php 
					$comment_author_url = get_comment_author_url(); 
					if( ! empty( $comment_author_url ) ) {
						printf( 
							'<a href="%1$s" title="%2$s" target="_blank" rel="external nofollow">%3$s</a>',
							esc_url( $comment_author_url ),
							esc_attr( sprintf(
								'%1$s %2$s',
								__( 'Link to', 'soundcheck' ),
								get_comment_author()
							) ),
							get_avatar( $comment, '35' )
						);
					} else {
						echo get_avatar( $comment, '35' );
					}
					?>
	       			<?php  ?>
				</figure>
				<div class="comment-meta">
	       			<cite class="comment-author-name"><?php echo get_comment_author_link() ?></cite>
					<time class="comment-date" pubdate="<?php echo esc_attr( get_comment_date( 'Y-m-d' ) ) ?>"><?php echo get_comment_date() ?></time>
					<?php 
					comment_reply_link( array_merge( $args, 
						array( 
							'depth' => $depth, 
							'max_depth' => $args['max_depth'],
							'before' => __( ' &middot; ', 'soundcheck' ),
							'reply_text' => __( ' Reply ', 'soundcheck' ),
						) 
					) );
					?>
					<?php echo edit_comment_link( ' Edit ', ' &middot; ' ); ?>
				</div>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="comment-moderation"><em><?php _e( 'Your comment is awaiting moderation.', 'soundcheck' ) ?></em></p>
				<?php endif; ?>
			</div>

			<div class="comment-body">
				<?php comment_text(); ?>
				<?php comment_type( ( '' ), ( 'Trackback' ), ( 'Pingback' ) ); ?>
			</div>
		</div>
<?php
}
endif;


/**
 * Pings Callback Setup
 *
 * @since 1.0
 */
if ( ! function_exists( 'soundcheck_pings_callback' ) ) :
function soundcheck_pings_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li class="ping" id="li-comment-<?php comment_ID(); ?>">
		<div class="seperation-border"></div>
		<?php comment_author_link(); ?>
	<?php
}
endif; // soundcheck_pings_callback



/**
 * Generate random number
 *
 * Creates a 4 digit random number for used
 * mostly for unique ID creation. 
 *
 * @since 1.0
 */
function soundcheck_get_random_number() {
	return substr( md5( uniqid( rand(), true) ), 0, 4 );
}



/**
 * Limit String
 *
 * @since 1.0
 */
if( ! function_exists( 'soundcheck_limit_string' ) ) :
function soundcheck_limit_string( $phrase, $max_characters ) {

	$phrase = trim( $phrase );

	if ( strlen( $phrase ) > $max_characters ) {

		// Truncate $phrase to $max_characters + 1
		$phrase = substr( $phrase, 0, $max_characters + 1 );

		// Truncate to the last space in the truncated string.
		$phrase = trim( substr( $phrase, 0, strrpos( $phrase, ' ' ) ) );
		
		$phrase .= '&hellip;';
	}

	return $phrase;
}
endif;


/**
 * Right Sidebar Check
 *
 * Check to see if sidebars are active. If a sidebar is active
 * return (bool). Used by soundcheck_sidebar_body_class() to apply a body
 * class of has-sidebar or no-sidebar. Used in page templates to
 * check if sidebar should be shown.
 *
 * @return bool
 * @since 2.0
 */
if( ! function_exists( 'soundcheck_has_right_sidebar' ) ) :
function soundcheck_has_right_sidebar() {
	global $post;
	
	if( is_single() )
		$has_sidebar = is_active_sidebar( 'sidebar-secondary-single' ) ? true : false;
	elseif( soundcheck_page_template( 'gallery' ) )
		$has_sidebar = false;
	elseif( soundcheck_product_type_page() ) 
		$has_sidebar = false;
	elseif( is_page_template( 'template-blog.php' ) )
		$has_sidebar = is_active_sidebar( 'sidebar-secondary-multiple' ) ? true : false;
	elseif( is_page() && ! soundcheck_page_template() )
		$has_sidebar = is_active_sidebar( 'sidebar-secondary-page' ) ? true : false;
	elseif( ! is_singular() )
		$has_sidebar = is_active_sidebar( 'sidebar-secondary-multiple' ) ? true : false;
	else 
		$has_sidebar = false;
	
	return $has_sidebar;
}
endif;


/**
 * Left Sidebar Check
 *
 * Checks to see if the left sidebar is showing. This sidebar is known 
 * as the Primary sidebar or the left most Home page sidebar.
 *
 * @return bool
 * @since 2.0
 */
if( ! function_exists( 'soundcheck_has_left_sidebar' ) ) :
function soundcheck_has_left_sidebar() {
	global $post;
	
	if( is_home() )
		$has_sidebar = is_active_sidebar( 'home-column-1' ) ? true : false;
	elseif( is_page_template( 'template-full.php' ) )
		$has_sidebar = false;
	elseif( is_active_sidebar( 'sidebar-primary-products' ) )
		$has_sidebar = true;
	else 
		$has_sidebar = is_active_sidebar( 'sidebar-primary' ) ? true : false;
	
	return $has_sidebar;
}
endif;


/**
 * Product Page Type Check
 *
 * Basically this allows the theme to check if the page being viewed
 * is associated with any products (store) functioanlity. This can be
 * a page template or category that displays products.
 *
 * @return array
 * @since 2.0
 */
if( ! function_exists( 'soundcheck_product_type_page' ) ) :
function soundcheck_product_type_page() {
	// Return early if Cart66 is not installed
	if( ! soundcheck_cart66_installed() )
		return false;
	
	// If one of these page templates is being display, retrun true
	if( soundcheck_page_template( 'products' ) ) {
		return true;
	}
	
	// If the products_category Theme Option is set, we may consider
	if( ( $products_category = soundcheck_option( 'products_category' ) ) ) {
		if( is_single() && in_category( $products_category ) ) {
			return true;
		}
		
		if( is_category( $products_category ) || soundcheck_is_subcategory( $products_category ) ) {
			return true;
		}
	}
	
	// Not a product type page
	return false;
}
endif;


/**
 * Page Template Check
 *
 * Checks to see if a current page template is being used.
 *
 * @return bool
 * @since 1.8
 */
if( ! function_exists( 'soundcheck_page_template' ) ) :
function soundcheck_page_template( $type = '' ) {
	$template_files = soundcheck_page_template_files( $type );
	
	foreach( $template_files as $template ) {
		if( is_page_template( $template ) ) {
			return true;
		}
	}
	
	return false;
}
endif;


/**
 * Page Tempalte Files
 *
 * Returns a list of page template files inlcuded with the theme.
 * Each file has a "type" associated with it. This allows the theme to
 * check and display content based on an intended type of content that
 * should be displayed by the theme.
 *
 * The $type here is mainly in reference to layout.
 *
 * @return array
 * @since 1.8
 */
if( ! function_exists( 'soundcheck_page_template_files' ) ) :
function soundcheck_page_template_files( $type = '' ) {
	$gallery = array(
		'template-cart.php',
		'template-discography.php',
		'template-products.php'
	);
	
	$products = array(
		'template-cart.php',
		'template-checkout.php',
		'template-products.php'
	);
	
	$standard = array(
		'template-full.php',
		'template-gigpress.php'
	);
	
	if( 'gallery' == $type ) {
		return $gallery;
	}
	
	if( 'products' == $type ) {
		return $products;
	}
	
	if( 'standard' == $type ) {
		return $standard;
	}
	
	$template_files = wp_parse_args( $gallery, $standard );
	
	return $template_files;
}
endif;


/**
 * Page Template Name
 *
 * Gets a list of page template files, checks if page
 * is one of the current page templates available,
 * and then returns or echos the template name.
 *
 * @param $echo Echo or return result
 * @return String
 * @since 2.0
 */
if( ! function_exists( 'soundcheck_page_template_name' ) ) :
function soundcheck_page_template_name( $echo = false ) {
	$template_files = soundcheck_page_template_files();
	
	foreach( $template_files as $template ) {
		if( is_page_template( $template ) ) {
			if( $echo )
				echo $template;
			else
				return $template;
		}
	}
	
	return;
}
endif;


/**
 * Multiple Post Page
 *
 * Checking to see if page type may contain multiple posts
 *
 * @since 1.8
 */
if( ! function_exists( 'soundcheck_is_multiple' ) ) :
function soundcheck_is_multiple() {
	global $wp_query;

	if( is_category() || is_search() || is_archive() || is_home() || $wp_query->is_posts_page  )
		return true;
	
	return false;
}
endif;


/**
 * Thumbnail Size
 *
 * Returns the post thumbnail size depending on page type or sidebar
 *
 * @since 1.8
 */
if( ! function_exists( 'soundcheck_thumbnail_size' ) ) :
function soundcheck_thumbnail_size() {
	if( soundcheck_has_right_sidebar() ) {
		return 'theme-medium';
	}
	
	if( soundcheck_product_type_page() ) {
		return 'post-thumbnail';
	}
	
	return 'theme-large';
}
endif;




/**
 * Localize hero slider. 
 * 
 * Localize values from theme options for use in javascript
 *
 * @since 2.0
 */
if( ! function_exists( 'soundcheck_localize_hero' ) ) :
function soundcheck_localize_hero() {
	
	$hero_fx = soundcheck_option( 'hero_fx', 'scrollVert' );
	$hero_speed = soundcheck_option( 'hero_speed', 1 );
	$hero_timeout = soundcheck_option( 'hero_timeout' );
	
	$hero_options = array(
		'hero_fx'      => esc_html( $hero_fx ),
		'hero_speed'   => absint( $hero_speed ) * 1000,
		'hero_timeout' => ( 0 == $hero_timeout || empty( $hero_timeout ) ) ? 0 : absint( soundcheck_option( 'hero_timeout', 6 ) ) * 1000
	);
	
	wp_localize_script( 'soundcheck_theme', 'hero_options', $hero_options );
}
endif;


/**
 * Localize jPlayer (audio)
 * 
 * Localize audio files found in post's gallery
 *
 * @return void
 * @since 1.0
 */
function soundcheck_localize_jplayer() {
	/**
	 * Audio Player Options
	 * 
	 * The next few tid bits get and set audio options from Theme Options 
	 */
	$options = array();
	
	/* Default options */
	$defaults = array(
		'enable_autoplay' => is_single() ? ( soundcheck_option( 'audio_single_autoplay' ) ? 1 : 0 ) : 0,
		'enable_playlist' => is_single() ? ( soundcheck_option( 'audio_single_playlist' ) ? 1 : 0 ) : 0
	);

	/* Set different options for Template: Audio */
	if( is_page_template( 'template-audio.php' ) ) {
		$options = array(
			'enable_autoplay' => soundcheck_option( 'audio_gallery_autoplay' ) ? 1 : 0,
			'enable_playlist' => soundcheck_option( 'audio_gallery_playlist' ) ? 1 : 0
		);
	}
	
	/* Merge audio options */
	$options = wp_parse_args( $options, $defaults );
	
	$tracks = soundcheck_discography_query();
	
	/* Set up param object for localization */
	$params = array(
	    'get_template_directory_uri' => get_template_directory_uri(),
	    'options' => $options,
        'format_audio' => $tracks
	);
	    
	/* Localize params to be used in JS */
	wp_localize_script(	'soundcheck_theme', 'jplayer_params', $params );
}


function soundcheck_discography_query() {
	/**
	 * Set Playlist
	 *
	 * Here we will query the audio post format posts.
	 * Before we do that, we'll check to see if we have
	 * done this previously by checking if a particular
	 * transient has been set. If not, we'll run the query
	 * and set the $tracks for the audio players.
	 */
	if ( false === ( $tracks = get_transient( 'soundcheck_audio_tracks' ) ) ) {
		/* Create playlist object array */
		$playlist = array();
		
		/* Set arguements to query audio post formats */
		$args = array(
		    'posts_per_page' => -1,
		    'post_status' => 'publish',
		    'tax_query' => array(
		    	array (
		    		'taxonomy' => 'post_format',
		    		'field' => 'slug',
		    		'terms' => 'post-format-audio'
		    	)
		  	)
		);
		
		/* Create new query from $args */
		$audio_query = new WP_Query( $args );
		
		/* Include audio class used to create and setup tracks */
		locate_template( 'includes/class-audio-tracks.php', true );
		
		/* Loop through posts and add tracks to the $playlist array */
		while ( $audio_query->have_posts() ) : 
			$audio_query->the_post();
			$post_id = get_the_ID();
			$audio = new Soundcheck_Audio( $post_id );
			$playlist['playlist'][$post_id] = $audio->tracks();
		endwhile;
		
		/* As it says… */
		wp_reset_query();
				
		/* JSON encode playlist */
		$tracks = json_encode( $playlist );
		
		/* Set transient with the $tracks data! */
		set_transient( 'soundcheck_audio_tracks', $tracks );
	}
	
	return $tracks;
}

/**
 * Delete Audio Tracks Transient
 *
 * Deletes audio tracks transient option when a post
 * is updated, edited, or published. This ensures that
 * if a new post was created or was updated
 * to be an Audio Post Format, it will be included in
 * in the results.
 *
 * @see soundcheck_localize_jplayer()
 * @return void
 * @since 1.0
 */
function soundcheck_audio_tracks_flusher() {
    delete_transient( 'soundcheck_audio_tracks' );
}
add_action( 'publish_post', 'soundcheck_audio_tracks_flusher' );
add_action( 'edit_post', 'soundcheck_audio_tracks_flusher' );


/**
 * Delete Gallery Format Query Transient
 *
 * Deletes the gallery sets transient option when a post
 * is updated, edited, or published. This ensures that
 * if a new post was created or was updated
 * to be an Gallery Post Format, it will be included in
 * in the results.
 *
 * @see soundcheck_localize_view()
 * @return void
 * @since 1.0
 */
function soundcheck_gallery_format_query_flusher() {
    delete_transient( 'soundcheck_gallery_format_query' );
}
add_action( 'publish_post', 'soundcheck_gallery_format_query_flusher' );
add_action( 'edit_post', 'soundcheck_gallery_format_query_flusher' );


/**
 * Excerpt More (auto).
 *
 * In cases where a post does not have an excerpt defined
 * WordPress will append the string "[...]" to a shortened
 * version of the post_content field. Soundcheck will replace
 * this string with an ellipsis followed by a link to the
 * full post.
 *
 * This filter is attached to the 'excerpt_more' hook
 * in the soundcheck_setup_soundcheck() function.
 *
 * @return string An ellipsis followed by a link to the single post.
 * @since 1.0
 */
if( ! function_exists( 'soundcheck_excerpt_more_auto' ) ) :
function soundcheck_excerpt_more_auto( $more ) {
	return ' &hellip;';
}
endif;


/**
 * Product Body Class
 *
 * Adds class to body if post has a format selected.
 *
 * @param array All classes for the body element.
 * @return array Modified classes for the body element.
 * @since 1.0
 */
if( ! function_exists( 'soundcheck_product_body_class' ) ) :
function soundcheck_product_body_class( $classes ) {
	global $post;
	
	$product_category = soundcheck_option( 'products_category' );
	
	if( $product_category && ( is_category( $product_category ) || soundcheck_is_subcategory( $product_category ) ) )
		$classes[] = 'gallery-layout';
		
	if( is_home() && soundcheck_option( 'featured_primary_home_sidebar' ) )
		$classes[] = 'featured-sidebar one';
	elseif( soundcheck_product_type_page() && soundcheck_option( 'featured_primary_product_sidebar' ) )
		$classes[] = 'featured-sidebar';
	elseif( ! soundcheck_product_type_page() && soundcheck_option( 'featured_primary_sidebar' ) )
		$classes[] = 'featured-sidebar';
		
	return array_unique( $classes );
}
endif;


/**
 * Sidebar Class
 *
 * @param array All classes for the body element.
 * @return array Modified classes for the body element.
 * @since 1.0
 */
if( ! function_exists( 'soundcheck_sidebar_body_class' ) ) :
function soundcheck_sidebar_body_class( $classes ) {
	global $post;
	
	$classes[] = soundcheck_has_right_sidebar() ? 'right-sidebar' : '';
	$classes[] = soundcheck_has_left_sidebar() ? 'left-sidebar' : '';
	
	return array_unique( $classes );
}
endif;


/**
 * Get Image Carousel
 *
 * Determine if image carousel should be displayed.
 *
 * @param string
 * @return contents
 *
 * @since 1.8
 */
if( ! function_exists( 'soundcheck_get_image_carousel' ) ) :
function soundcheck_get_image_carousel( $page = '' ) {
	
	// Always display on home page to maintain layout. Return early.
	if( 'home' == $page ) {
		get_template_part( 'content', 'carousel' );
		return;
	}
	
	// Get theme options for image carousel
	$image_carousel_enable = soundcheck_option( 'carousel_' . $page );
	
	// Display carousel if the option checked matches the current page type
	if( 1 == $image_carousel_enable ) {
		get_template_part( 'content', 'carousel' );
		return;
	}
	
	return false;
}
endif;


/**
 * Unregister Widgets
 *
 * @since 1.0
 */
if( ! function_exists( 'soundcheck_unregister_widgets' ) ) :
function soundcheck_unregister_widgets() {
	unregister_widget( 'WP_Widget_Akismet' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
}
endif;


/**
 * Create select options from array.
 *
 * This function takes an array and returns a set of options
 * to be used inside a select box.
 *
 * Used in the creation of some widget options.
 *
 * @return Array
 * @since 2.0
 */
function soundcheck_array_to_select( $option = array(), $selected = '', $optgroup = NULL ) {
	$select_options = '';

	$option_markup = '<option value="%1$s" %3$s>%2$s</option>';
	
	if ( $selected == '' ) {
		$select_options .= sprintf( $option_markup,	'', __( 'Select one...', 'soundcheck' ), 'selected="selected"' );
	}
	
	foreach ( $option as $key => $value ) {
	    if ( $key == $selected ) {
	    	$select_options .= sprintf( $option_markup,	esc_attr( $key ), sprintf( esc_html__( '%s', 'soundcheck' ), $value ), 'selected="selected"' );
	    } else {
	    	$select_options .= sprintf( $option_markup,	esc_attr( $key ), sprintf( esc_html__( '%s', 'soundcheck' ), $value ), '' );
	    }
	}
	
    return $select_options;
}


/**
 * Is Subcategory
 *
 * Check if current category is a decendent of a parent category.
 * Currently used to check if category is in the store category tree.
 *
 * @param $parent_cat_id ID of category parent to check current category against.
 * @since 2.0
 */
function soundcheck_is_subcategory( $parent_cat_id = null ) {
	if( ! is_category() )
	 	return;
	
	$cat = get_query_var( 'cat' );
    $category = get_category( $cat );
	
	if( null === $parent_cat_id ) {
		return ( $category->parent == '0' ) ? false : true;
	} else {
		return ( $category->parent != $parent_cat_id ) ? false : true;
	}
}


/**
 * Post In Descendant Category
 *
 * Check if post is a decendent of the parent category
 */
function soundcheck_post_in_descendant_category( $cats, $_post = null ) {
	foreach( (array) $cats as $cat ) {
		$descendants = get_term_children( (int) $cat, 'category');
		if( $descendants && in_category( $descendants, $_post ) )
			return true;
	}
	return false;
}


/**
 * Localize View.js (gallery lightbox). 
 * 
 * Localize gallery images for use in view.js
 *
 * @return void
 * @since 1.0
 */
function soundcheck_localize_view() {
	$gallery_sets = array();
	
	if( has_post_format( 'gallery' ) ) {
		if ( false === ( $galleries = get_transient( 'soundcheck_gallery_format_query' ) ) ) {
			$args = array(
			    'posts_per_page' => -1,
			    'tax_query' => array(
			    	array (
			    		'taxonomy' => 'post_format',
			    		'field' => 'slug',
			    		'terms' => 'post-format-gallery'
			    	)
			  	)
			);
			
    		$galleries = get_posts( $args );
    		
			/* Set transient with the $tracks data! */
			set_transient( 'soundcheck_gallery_format_query', $galleries );
    	} // end transient check

		global $post;
		
		
    	foreach( $galleries as $post ) : 
    	    setup_postdata( $post );    	
		    /** Get images for post and add theme to $gallery */
		    if( $images = get_children( array(
		    	'post_parent'    => get_the_ID(),
		    	'post_type'      => 'attachment',
		    	'numberposts'    => -1,
		    	'post_status'    => null,
		    	'post_mime_type' => 'image',
		    	'order'          => 'ASC',
		    	'orderby'        => 'menu_order'
		    ) ) ) {
		    	$gallery = array();
		    	foreach( (array) $images as $image ) {
		    		$image_src = wp_get_attachment_image_src( $image->ID, 'large' );
		    		$gallery[] = array(
		    			'src' => $image_src[0],
		    			'caption' => apply_filters( 'the_title', $image->post_title )
		    		);
		    	}
		    	$gallery_sets[get_the_ID()] = $gallery;
		    }		
    	endforeach;
    	
    	wp_reset_postdata();
	} // end page template check
	
	// JSON encode playlist
	$gallery_sets = json_encode( $gallery_sets );
	
	// Set up param object for localization
	$params = array(
        'gallery_views' => $gallery_sets
	);
	
	// Localize params to be used in JS
	wp_localize_script(	'soundcheck_view', 'gallery_params', $params );
}


/**
 * Gallery Display
 *
 * Changes output of [gallery] shortcode in gallery-format posts to use FlexSlider.
 * Also will change output to use FlexSlider if [gallery slider="true"] is used on non-gallery-format post.
 *
 * @since 1.0
 */
if ( ! function_exists( 'soundcheck_gallery_display' ) ) :
function soundcheck_gallery_display( $output, $attr ) {
	global $post;
	
	static $gallery_instance = 0;
	$gallery_instance++;
	
	/* Ignore feed */
	if ( is_feed() )
		return $output;
		
	/* Orderby */
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
	
	/* Get Post ID */
	$post_id = isset( $attr['id'] ) ? $attr['id'] : get_the_ID();
	
	/* Default gallery settings. */
	$defaults = array(
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
		'id' => get_the_ID(),
		'link' => '',
		'itemtag' => 'dl',
		'icontag' => 'dt',
		'captiontag' => 'dd',
		'columns' => 3,
		'size' => 'thumbnail',
		'include' => '',
		'exclude' => '',
		'numberposts' => -1,
		'offset' => '',
		'slider' => false, // theme specific for flexslider integration
		'featured' => false // theme specific to feature at top of post
	);
	
	/* Merge the defaults with user input. Make sure $id is an integer. */
	$attr = shortcode_atts( $defaults, $attr );
	extract( $attr );
	$id = intval( $id );
	
	// Check if $numberposts is still equal to default and
	// Check if the post is in the soundcheck_hero category.
	if( -1 == $numberposts && in_category( soundcheck_option( 'hero_category' ) ) ) {
		// Set the max number of columns to 5. This avoids breaking the layout.
		if( $columns >= 5 ) {
			$columns = 5;
		}
		
		// Set number of posts to the number of columns X 3 (rows)
		// We do this because the hero slider only has so much heigh room.
		// This also excludes grabbing more images than necessary to fill
		// the maximum viewing area.
		$numberposts = $columns * 3;
	}

	/* Arguments for get_children(). */
	$children = array(
		'post_parent' => $id,
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => $order,
		'orderby' => $orderby,
		'exclude' => $exclude,
		'include' => $include,
		'numberposts' => $numberposts,
		'offset' => $offset,
	);
	
	/* Get image attachments. If none, return. */
	$attachments = get_children( $children );

	if ( empty( $attachments ) )
		return '';

	/* Properly escape the gallery tags. */
	$itemtag = tag_escape( $itemtag );
	$icontag = tag_escape( $icontag );
	$captiontag = tag_escape( $captiontag );
	$i = 0; // Counter for columns

	/* Count the number of attachments returned. */
	$attachment_count = count( $attachments );
	
	// Allow developers to overwrite the number of columns.  
	// This can be useful for reducing columns with with fewer images than number of columns.
	$columns = apply_filters( 'soundcheck_gallery_columns', absint( $columns ), $attachment_count, $attr );
	
	/* Open the gallery <div>. */
	$output = sprintf( '<div id="gallery-%1$s" class="gallery galleryid-%2$s gallery-columns-%3$s gallery-size-%4$s">',
	    esc_attr( absint( $gallery_instance ) ),
	    esc_attr( absint( $id ) ),
	    esc_attr( absint( $columns ) ),
	    esc_attr( $size )
	);
	
	/* Loop through each attachment. */
	foreach( (array) $attachments as $id => $attachment ) {
	    /* Add clearfix to each row */
	    $clearfix = ( $columns > 0 && $i % $columns == 0 ) ? 'clearfix' : '';
	    
	    /* Open each gallery item. */
	    $output .= sprintf( '<%1$s class="gallery-item col-%2$s %3$s">', strip_tags( $itemtag ), esc_attr( $columns ), esc_attr( $clearfix ) );
	    	
	    /* Open the element to wrap the image. */
	    $output .= sprintf( '<%1$s class="gallery-icon">', strip_tags( $icontag ) );
	    
	    /* Add the image. */
	    $image = ( ( isset( $attr['link'] ) && 'file' == $attr['link'] ) ? wp_get_attachment_link( $id, $size, false, false ) : wp_get_attachment_link( $id, $size, true, false ) );
	    $output .= apply_filters( 'soundcheck_gallery_image', $image, $id, $attr, $gallery_instance );
	    
	    /* Close the image wrapper. */
	    $output .= sprintf( '</%1$s>', strip_tags( $icontag ) );
	    
	    /* Get the caption. */
	    $caption = apply_filters( 'soundcheck_gallery_caption', wptexturize( esc_html( $attachment->post_excerpt ) ), $id, $attr, $gallery_instance );
	
	    /* If image caption is set. */
	    if ( !empty( $caption ) )
	    	$output .= sprintf( '<%1$s class="wp-caption-text gallery-caption">%2$s<%1$s>', esc_attr( $captiontag ), esc_html( $caption ) );
	
	    /* Close individual gallery item. */
	    $output .= sprintf( '</%1$s>', strip_tags( $itemtag ) );
	    
	    ++$i;
	}
	
	/* Close the gallery <div>. */
	$output .= "</div><!-- .gallery -->";
	
	return $output;
}
endif;


/**
 * Gallery Image
 *
 * Modifies gallery images based on user-selected settings.
 *
 * @since 1.0
 */
function soundcheck_gallery_image( $image, $id, $attr, $instance ) {
	/* If the image should link to nothing, remove the image link. */
	if( 'none' == $attr['link'] ) {
		$image = preg_replace( '/<a.*?>(.*?)<\/a>/', '$1', $image );
	}

	/* If the image should link to the 'file' (full-size image), add in extra link attributes. */
	elseif( 'file' == $attr['link'] ) {		
		$image = str_replace( '<a href=', sprintf( '<a %s href=', soundcheck_gallery_lightbox_attributes( $instance ) ), $image );
	}

	/* If the image should link to an intermediate-sized image, change the link attributes. */
	elseif( in_array( $attr['link'], get_intermediate_image_sizes() ) ) {
		$post = get_post( $id );
		$image_src = wp_get_attachment_image_src( $id, $attr['link'] );

		$attributes = soundcheck_gallery_lightbox_attributes( $instance );
		$attributes .= sprintf( ' href="%s"', esc_url( $image_src[0] ) );
		$attributes .= sprintf( ' title="%s"', esc_attr( $post->post_title ) );

		$image = preg_replace( '/<a.*?>(.*?)<\/a>/', "<a{$attributes}>$1</a>", $image );
	}

	/* Return the formatted image. */
	return $image;
}


/**
 * Gallery Lightbox Attributes
 *
 * Add "view" class to enable view.js to function.
 * Also adds a unique rel attribute to associate
 * related iamges to display in view.js
 *
 * @see soundcheck_gallery_image()
 */
function soundcheck_gallery_lightbox_attributes( $instance ) {
	return sprintf( 'class="view thumbnail-icon gallery" rel="gallery-%s"', esc_attr( $instance ) );
}


/**
 * Remove default gallery style
 *
 * Removes inline styles printed when the 
 * gallery shortcode is used.
 *
 * @since 1.0
 */
add_filter( 'use_default_gallery_style', '__return_false' );


function soundcheck_post_thumbnail( $icon = '' ) {
	// Return early if post does not have a featured image set
	if( ! has_post_thumbnail() )
		return; 
	
	// Display image in lightbox in a single post page, else link to post
	if( is_single() ) {
		$image_id  = get_post_thumbnail_id();  
		$image_url = wp_get_attachment_image_src( $image_id, 'large' );  
		$image_url = $image_url[0];
		$icon .= ' view';
	} else {
		$image_url = get_permalink();
	}
	
	printf( '<figure class="entry-thumbnail"><a class="thumbnail-icon %1$s" href="%2$s" title="%3$s" rel="post-%4$d">%5$s</a></figure>',
		esc_attr( $icon ),
	    esc_url( $image_url ),
	    sprintf( esc_attr__( '%1$s', 'soundcheck' ), the_title_attribute( array( 'echo' => 0 ) ) ),
	    absint( get_the_ID() ),
	    get_the_post_thumbnail( get_the_ID(), soundcheck_thumbnail_size() )
	);
}


function soundcheck_post_format( $format = 'standard' ) {
	switch ( $format ) :
		case 'audio' :
			print do_shortcode( sprintf( '[p75_audio_player album_id="%1$s" autoplay="%2$s" playlist="%3$s"]', 
			    absint( get_the_ID() ),
			    absint( 0 ),
			    absint( 1 )
			) );
			break;
			
		case 'video' :
			print '<div class="entry-video"><!-- Populated via theme.js --></div>';
			break;
		
		default :
			soundcheck_post_thumbnail( $format );
	endswitch;
}



/**
 * Register Sidebars
 *
 * @since 1.0
 */
if( ! function_exists( 'soundcheck_register_sidebars' ) ) :
function soundcheck_register_sidebars() {
	register_sidebar( array(
		'id'            => 'home-column-1',
		'name'          => __( 'Home Column 1', 'soundcheck' ),
		'description'   => __( 'Shown in first column of home page.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'home-column-2',
		'name'          => __( 'Home Column 2', 'soundcheck' ),
		'description'   => __( 'Shown in second column of home page.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'home-column-3',
		'name'          => __( 'Home Column 3', 'soundcheck' ),
		'description'   => __( 'Shown in third column of home page.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-primary',
		'name'          => __( 'Primary Sidebar - All Pages', 'soundcheck' ),
		'description'   => __( 'Shown on all pages in left sidebar.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-primary-products',
		'name'          => __( 'Primary Sidebar - Products', 'soundcheck' ),
		'description'   => __( 'Shown on product pages in left sidebar.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-secondary-products',
		'name'          => __( 'Secondary Sidebar - Products', 'soundcheck' ),
		'description'   => __( 'Shown on single product pages.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
		
	register_sidebar( array(
		'id'            => 'sidebar-secondary-single',
		'name'          => __( 'Secondary Sidebar - Single', 'soundcheck' ),
		'description'   => __( 'Shown on single post pages.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-secondary-page',
		'name'          => __( 'Secondary Sidebar - Page', 'soundcheck' ),
		'description'   => __( 'Shown on page type pages.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
	register_sidebar( array(
		'id'            => 'sidebar-secondary-multiple',
		'name'          => __( 'Secondary Sidebar - Multiple', 'soundcheck' ),
		'description'   => __( 'Shown on pages with multiple posts.', 'soundcheck' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	));
	
			
}
endif;



/**
 * This function takes the content of a tweet, detects @replies,
 * #hashtags, and http://links, and links them appropriately.
 *
 * @author Snipe.net
 * @link http://www.snipe.net/2009/09/php-twitter-clickable-links/
 *
 * @param string $tweet A string representing the content of a tweet
 *
 * @return string
 *
 * @since 2.0
 */
function soundcheck_tweet_linkify( $tweet ) {

	$tweet = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $tweet);
	$tweet = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $tweet);
	$tweet = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $tweet);
	$tweet = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $tweet);

	return $tweet;

}



?>