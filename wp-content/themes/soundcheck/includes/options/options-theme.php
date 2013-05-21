<?php
/**
 * Theme Options
 *
 */
global $theme_options;

/* Setup Menu Item */
$theme_options = new Struts_Options( 'soundcheck_options', 'soundcheck_options', 'Theme Options' );

/* Setup Sections */
$theme_options->add_section( 'logo_section', __( 'Logo and Background', 'soundcheck' ) );
$theme_options->add_section( 'general_section', __( 'General', 'soundcheck' ) );
$theme_options->add_section( 'hero_section', __( 'Hero Slider', 'soundcheck' ) );
$theme_options->add_section( 'carousel_section', __( 'Thumbnail Carousel', 'soundcheck' ) );
$theme_options->add_section( 'audio_section', __( 'Audio Player', 'soundcheck' ) );
$theme_options->add_section( 'social_section', __( 'Social Media', 'soundcheck' ) );
$theme_options->add_section( 'footer_section', __( 'Footer', 'soundcheck' ) );

/* Setup Common Variables */
$categories = soundcheck_get_category_list();	


/* Setup Options */
// LOGO
$theme_options->add_option( 'logo_url', 'image', 'logo_section' )
    ->label( __( 'Logo URL:', 'soundcheck' ) )
    ->description( __( 'Your image can be any width and height.', 'soundcheck' ) );
    
$theme_options->add_option( 'text_logo_desc', 'checkbox', 'logo_section' )
    ->label( __( 'Enable Site Tagline', 'soundcheck' ) )
    ->description( __( 'Display your site tagline beneath your text/image based logo.', 'soundcheck' ) );


// General Section
$theme_options->add_option( 'blog_category', 'select', 'general_section' )
    ->label( __( 'Blog Category', 'soundcheck' ) )
    ->description( __( 'Select a category to be used for the blog.', 'soundcheck' ) )
    ->valid_values( $categories );

$theme_options->add_option( 'products_category', 'select', 'general_section' )
    ->label( __( 'Store Category', 'soundcheck' ) )
    ->description( __( 'Select which category should be used for the Products display.', 'soundcheck' ) )
    ->valid_values( $categories );
    
$theme_options->add_option( 'featured_primary_home_sidebar', 'checkbox', 'general_section' )
    ->label( __( 'Featured Sidebar - Home Col. 1', 'soundcheck' ) )
    ->description( __( 'This option pulls the first home page widget column up over the hero area.', 'soundcheck' ) );
    
$theme_options->add_option( 'featured_primary_sidebar', 'checkbox', 'general_section' )
    ->label( __( 'Featured Sidebar - Primary', 'soundcheck' ) )
    ->description( __( 'This option pulls the primary sidebar widgets up over the hero area', 'soundcheck' ) );

$theme_options->add_option( 'featured_primary_product_sidebar', 'checkbox', 'general_section' )
    ->label( __( 'Featured Sidebar - Primary Products ', 'soundcheck' ) )
    ->description( __( 'This option pulls the Primary Products sidebar widgets up over the hero area.', 'soundcheck' ) );


  
// Hero Slider Section
$default_hero_slide = get_cat_ID( 'hero-slides' );
$theme_options->add_option( 'hero_category', 'select', 'hero_section' )
    ->label( __( 'Category', 'soundcheck' ) )
    ->description( __( 'Select a category to be used for the Hero slides.', 'soundcheck' ) )
    ->default_value( $default_hero_slide )
    ->valid_values( $categories );
    
$theme_options->add_option( 'hero_randomize', 'checkbox', 'hero_section' )
    ->label( __( 'Randomize Slides', 'soundcheck' ) )
    ->description( __( 'Yes, display slides in random order.', 'soundcheck' ) );

$theme_options->add_option( 'hero_fx', 'select', 'hero_section' )
    ->label( __( 'Slide Animation', 'soundcheck' ) )
    ->description( __( 'Choose a type of animation for each slide transition.', 'soundcheck' ) )
    ->default_value( 'scrollVert' )
    ->valid_values( array(
        'scrollVert' => __( 'Slide (vertical)', 'soundcheck' ),
        'fade' => __( 'Fade', 'soundcheck' ) 
    ));

$theme_options->add_option( 'hero_speed', 'text', 'hero_section' )
    ->label( __( 'Hero Slider Speed', 'soundcheck' ) )
    ->description( __( 'Speed (in seconds) at which the slides will animate between transitions.', 'soundcheck' ) )
    ->default_value( 1 );

$theme_options->add_option( 'hero_timeout', 'text', 'hero_section' )
    ->label( __( 'Hero Slider Timeout', 'soundcheck' ) )
    ->description( __( 'Time (in seconds) before transitioning to the next slide. Leave empty to disable.', 'soundcheck' ) )
    ->default_value( 6 );  


// Featured Image Carousel Section
$theme_options->add_option( 'carousel_category', 'select', 'carousel_section' )
    ->label( __( 'Thumbnail Carousel Category', 'soundcheck' ) )
    ->description( __( 'Select which category should be shown in the image carousel. By default, all categories will be used.', 'soundcheck' ) )
    ->valid_values( $categories );

$theme_options->add_option( 'carousel_count', 'text', 'carousel_section' )
    ->label( __( 'Thumbnail Count', 'soundcheck' ) )
    ->description( __( 'Max Number of thumbnails to display in the carousel.', 'soundcheck' ) )
    ->default_value( 10 );  

$theme_options->add_option( 'carousel_home', 'checkbox', 'carousel_section' )
    ->label( __( 'Home Page', 'soundcheck' ) )
    ->description( __( 'Enable carousel on the home page?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_multiple', 'checkbox', 'carousel_section' )
    ->label( __( 'Multiple Post Page', 'soundcheck' ) )
    ->description( __( 'Enable carousel on  multiple post page?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_single', 'checkbox', 'carousel_section' )
    ->label( __( 'Single Post Pages', 'soundcheck' ) )
    ->description( __( 'Enable carousel on single post page?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_pages', 'checkbox', 'carousel_section' )
    ->label( __( 'Page - Regular', 'soundcheck' ) )
    ->description( __( 'Enable carousel on regular pages?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_product', 'checkbox', 'carousel_section' )
    ->label( __( 'Page - Product', 'soundcheck' ) )
    ->description( __( 'Enable carousel on product type pages? Requires Cart66 Plugin.', 'soundcheck' ) );

$theme_options->add_option( 'carousel_discography', 'checkbox', 'carousel_section' )
    ->label( __( 'Page - Discography', 'soundcheck' ) )
    ->description( __( 'Enable carousel on the discography page?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_gigpress', 'checkbox', 'carousel_section' )
    ->label( __( 'Page - GigPress', 'soundcheck' ) )
    ->description( __( 'Enable carousel on GigPress type page?', 'soundcheck' ) );

$theme_options->add_option( 'carousel_full', 'checkbox', 'carousel_section' )
    ->label( __( 'Page - Full Width', 'soundcheck' ) )
    ->description( __( 'Enable carousel on the full width type pages?', 'soundcheck' ) );



    
    
// Audio Section
$theme_options->add_option( 'audio_single_playlist', 'checkbox', 'audio_section' )
    ->label( __( 'Display playlist by default?', 'soundcheck' ) )
    ->description( __( 'Display playlist by default on single audio post pages.', 'soundcheck' ) );

$theme_options->add_option( 'audio_single_autoplay', 'checkbox', 'audio_section' )
    ->label( __( 'Autoplay audio?', 'soundcheck' ) )
    ->description( __( 'Autoplay audio by default on single audio post pages.', 'soundcheck' ) );
    

// Social Media Section
$theme_options->add_option( 'social_rss', 'checkbox', 'social_section' )
    ->label( __( 'RSS', 'soundcheck' ) )
    ->description( __( 'Display RSS Icon', 'soundcheck' ) );
    
$theme_options->add_option( 'feedburner_url', 'text', 'social_section' )
    ->label( __( 'FeedBurner', 'soundcheck' ) )
    ->description( __( 'Provide your <a href="http://feedburner.google.com" title="Go to FeedBurner" target="_blank">FeedBurner</a> feed to enable this functionality. The RSS icon must be enabled above.', 'soundcheck' ) );    


// Social Media Section
$social_media = array(
	'amazon' => 'Amazon',
	'bandcamp' => 'Bandcamp',
	'facebook' => 'Facebook',
	'flickr' => 'Flickr',
	'itunes' => 'iTunes',
	'lastfm' => 'Last.fm',
	'myspace' => 'MySpace',
	'soundcloud' => 'SoundCloud',
	'twitter' => 'Twitter',
	'vimeo' => 'Vimeo',
	'youtube' => 'YouTube'
);

foreach( $social_media as $key => $value ) :
	$theme_options->add_option( "social_$key", 'text', 'social_section' )
    ->label( sprintf( __( '%s', 'soundcheck' ), $value ) )
    ->description( __( 'Provide URL including http://', 'soundcheck' ) );
endforeach;


// Footer
$theme_options->add_option( 'footer_copyright', 'textarea', 'footer_section' )
    ->label( __( 'Footer Text', 'soundcheck' ) )
    ->description( __( 'Set the text to be displayed in the footer.', 'soundcheck' ) );


/* Initialize Options */
$theme_options->initialize();

?>