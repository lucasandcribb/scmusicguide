<?php

//include the main class file
require_once( FFL_PATH . 'includes/classes/admin-page-class/admin-page-class.php' );
require_once( FFL_PATH . 'includes/classes/class.AdminPageClassExtension.php' );
require_once( FFL_PATH . 'includes/classes/class.FrontendLogin.php' );
require_once( FFL_PATH . 'includes/markdown.php' ); // required to parse the readme.txt
/**
 * configure your admin page
 */
$config = array(    
'menu'=> 'settings',             //sub page to settings page
'page_title' => 'Flexible Frontend Login',       //The name of this page 
'capability' => 'manage_options',         // The capability needed to view the page 
'option_group' => 'flexible_frontend_login',       //the name of the option to create in the database
'id' => 'flexible_frontend_login',            // meta box id, unique per page
'fields' => array(),            // list of fields (can be added by field arrays)
'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);  

/**
 * Initiate your admin page
 */
$options_panel = new BF_Admin_Page_Class($config);
$options_panel->OpenTabs_container('');

/**
 * define your admin page tabs listing
 */
$options_panel->TabsListing( array(
			'links' => array(
						'options_1' =>  __('General Options', 'flexible-frontend-login' ),
						'options_2' =>  __('HTML Options', 'flexible-frontend-login' ),
//						'options_3' => __('CSS Options', 'flexible-frontend-login' ),
						'options_4' => __('Test Your Settings', 'flexible-frontend-login' ),
						'options_5' => __('Help', 'flexible-frontend-login' ),
)
			)
);



$options_panel->OpenTab('options_1');

	//title
	$options_panel->Title( __('General Options', 'flexible-frontend-login' ) );
	
	// Subtitle
	$options_panel->addParagraph( '<h3>' . __( 'Edit plugin output to your liking.', 'flexible-frontend-login' ) . '</h3>' );
	
	//popup_link_text
	$options_panel->addText( 
		'popup_link_text', 
		array(
			'name'=> __( 'Popup Link Text', 'flexible-frontend-login' ), 
			'std'=> '' 
		) 
	);
	
//vertical_position
$options_panel->addRadio(
	'vertical_position',
	array(
		'top' 			=> __('top', 'flexible-frontend-login' ),
		'bottom' 	=> __('bottom', 'flexible-frontend-login' )
	),
	array(
		'name' => __('Vertical Position', 'flexible-frontend-login' ), 
		'std' => array(
			'top'
		),
	'desc' => '<small>' . __( "Default is 'bottom' for a popup link in the top right corner of your site.", 'flexible-frontend-login' ) . '</small>'
	)
);

//horizontal_position
$options_panel->addRadio(
	'horizontal_position',
	array(
		'left' 			=> __('left', 'flexible-frontend-login' ),
		'right' 	=> __('right', 'flexible-frontend-login' )
	),
	array(
		'name' => __('Horizontal Position', 'flexible-frontend-login' ), 
		'std' => array(
			'left'
		),
		'desc' => '<small>' . __( "Default is 'left' for a popup link in the top right corner of your site.", 'flexible-frontend-login' ) . '</small>'
	)
);

	// arrange_logged_in_links
/* @TODO
 * implement method to arrange the links in output.php
 * 	$options_panel->addSortable(
		'arrange_logged_in_links',
		array(
			'1' 	=> 'Admin Link',
			'2'	=> 'Username', 
			'3' 	=> 'Logout Link'
			),
		array(
			'name'=> __( 'Arrange list order for logged in user links', 'flexible-frontend-login' ), 
			'desc' => '<small>' . __('Only those you have chosen to display below will be included.', 'flexible-frontend-login' ) . '</small>',
		)
	);
	*/

	// show_logout_link
	$options_panel->addCheckbox(
		'show_logout_link', 
		array( 
			'name'=> __( 'Show Logout Link', 'flexible-frontend-login' ), 
			'desc' => '<small>' . __('Turn ON if you want to display a <strong>logout link</strong> for logged in users.', 'flexible-frontend-login' ) . '</small>',
			'std' => true
		) 
	);
	
	// logout_link_text
	$options_panel->addText( 
		'logout_link_text', 
		array(
			'name'=> __( 'Logout Link Text', 'flexible-frontend-login' ), 
			'std'=>  __( 'Logout', 'flexible-frontend-login' ) 
		) 
	);

	// show_username
	$options_panel->addCheckbox(
		'show_username', 
		array( 
			'name'=> __( 'Show Username', 'flexible-frontend-login' ), 
			'desc' => '<small>' . __('Turn ON if you want to display the <strong>user\'s name</strong> for logged in users.', 'flexible-frontend-login' ) . '</small>',
			'std' => true 
		) 
	);

	// show_admin_link
	$options_panel->addCheckbox(
		'show_admin_link', 
		array( 
			'name'=> __( 'Show Admin Link', 'flexible-frontend-login' ), 
			'desc' => '<small>' . __('Turn ON if you want to display an <strong>admin link</strong> for logged in users.', 'flexible-frontend-login' ) . '</small>',
			'std' => true 
		) 
	);

	// admin_link_text
	$options_panel->addText( 
		'admin_link_text', 
		array(
			'name'=> __( 'Admin Link Text', 'flexible-frontend-login' ), 
			'std'=>  __( 'Admin', 'flexible-frontend-login' ) 
		) 
	);

//role_for_admin_link

/**
 * @ TODO
 * define method to filter the Admin links in output.php
 * 
	$options_panel->addRoles(
		'role_for_admin_link',
		array(),
		array(
			'name'	=> __( 'User Level for Admin Link', 'flexible-frontend-login' ), 
			'desc'		=> '<small>' .__( 'Choose the lowest user level to display an admin link. (Takes effect only if you turn on "Show Admin Link".)', 'flexible-frontend-login' ) . '</small>',
			'std' => 'Subscriber' 
			)
);
*/

/**
 * @todo  
 * define deactivation routine
	// delete_options_on_deactivation
	$options_panel->addCheckbox(
		'delete_options_on_deactivation', 
		array( 
			'name'=> __( 'Delete options on deactivation', 'flexible-frontend-login' ), 
			'desc' => '<small>' . __('Turn ON if you want to delete all plugin options when you deactivate the plugin. (Default: Off)', 'flexible-frontend-login' ) . '</small>',
			'std' => false 
		) 
	);
*/

/**
 * @ TODO 
* define deinstallation routine 
	// delete_options_on_plugin_delete
		$options_panel->addCheckbox(
		'delete_options_on_plugin_delete', 
		array( 
		'name'=> __( 'Delete options when plugin is deleted', 'flexible-frontend-login' ), 
		'desc' => '<small>' . __('Turn ON if you want to delete all plugin options when you delete the plugin from your site. (Default: On)', 'flexible-frontend-login' ) . '</small>',
		'std' => true 
		) 
	);
*/

$options_panel->CloseTab();

// HTML Options
$options_panel->OpenTab( 'options_2' );
	
	//title
	$options_panel->Title( __( 'HTML Options', 'flexible-frontend-login' ) );
	
	// Subtitle
	$options_panel->addParagraph( '<h3>' . __( 'Change the HTML output of the popup content', 'flexible-frontend-login' ) . '</h3>' );

	// html_block
	$options_panel->addCode( 'html_block', array( 'name' => 'HTML Editor ','syntax' => 'html' ) );
	
	// Instructions
	$options_panel->addParagraph(
		__( 'Use these placeholders:', 'flexible-frontend-login' ) .
		"<br><br>%label_for_username%<br>%input_username%<br>%label_for_password%<br>%input_password%<br>%send_button%<br>%lost_password%"
	);

$options_panel->CloseTab();


// CSS Options
$options_panel->OpenTab('options_3');

	//title
	$options_panel->Title( __('CSS Options', 'flexible-frontend-login' ) );

	// Subtitle
	$options_panel->addParagraph( '<h3>' . __( 'Set how the plugin should handle CSS', 'flexible-frontend-login' ) . '</h3>' );

	//select CSS usage
	$options_panel->addSelect(
		'css_usage',
		array(
			'css_from_plugin'		=> __( 'Use plugin\'s built in CSS file', 'flexible-frontend-login' ), 
			'css_from_theme'		=> __( 'Use CSS file from your theme (recommended)', 'flexible-frontend-login' ),
			'css_from_options'	=> __( 'Use CSS from options panel', 'flexible-frontend-login' )
		),
		array(
			'name'	=> __( 'Choose CSS source', 'flexible-frontend-login' ), 
			'std'		=> array( 'css_from_plugin' ) 
		) 
	);

	// custom_css_settings
	$options_panel->addCode( 
		'custom_css_settings', 
		array( 
			'name' => 'CSS Editor',
			'syntax' => 'css',
			'std'		=> '',
			'desc'		=> 		__( 'You should only use this for testing purposes.', 'flexible-frontend-login' ) . 
										'<br>' .
										__( 'See help section on how to add custom CSS file to your theme.', 'flexible-frontend-login' )
		) 
	);
	
$options_panel->CloseTab();



// Test Settings
$options_panel->OpenTab('options_4');

	//title
	$options_panel->Title( __('Test Settings', 'flexible-frontend-login' ) );

	// Subtitle
	$options_panel->addParagraph( '<h3>' . __( 'Test your settings first...', 'flexible-frontend-login' ) . '</h3>' );
	
	// Create Form Previews
	$frontendlogin = new FrontendLogin();
	
	// Get the options from database
// Get the options from database
global $wpdb;
$options = get_option( 'flexible_frontend_login' ); 

// assign options to the new instance

$frontendlogin->vertical_position = $options['vertical_position'];
$frontendlogin->horizontal_position = $options['horizontal_position'];
$frontendlogin->popup_link_text = $options['popup_link_text'];
$frontendlogin->html_block = $options['html_block'];

	$options = get_option( 'flexible_frontend_login' ); 


	if ( !isset( $options['show_username'] ) ) $options['show_username'] = 0;
	if ( !isset( $options['show_logout_link'] ) ) $options['show_logout_link'] = 0;
	if ( !isset( $options['show_admin_link'] ) ) $options['show_admin_link'] = 0;

	$links = "<ul id='ffl-userlinks'>";
		if ( $options['show_username'] == 1 ) {
			$links .= "<li><a href='#username'>Username</a></li>";
		}
		if ( $options['show_logout_link']  == 1 ) {
			$links .= "<li><a href='#logout'>Logout</a></li>";
		}
		if ( $options['show_admin_link']  == 1 ) {
			$links .= "<li><a href='#admin'>Admin</a></li>";
		}

	$html = "<small>";
	$html .= __( 'Test your settings before using shortcode, template tags or widgets.', 'flexible-frontend-login' );
	$html .= "<br>";
	$html .= __( 'You need to save your settings first!', 'flexible-frontend-login' ); 
	$html .= "<br>";
	$html .= __( 'It might still look slightly different on your website depending on your theme.',  'flexible-frontend-login' );
	$html .= "</small>";
	$html .= "<table style='width:100%' cellpadding='10'><tr><td style='width:33%; padding:1em; vertical-align:top;'>";
	$html .= __( 'Lightbox effect preview...',  'flexible-frontend-login'  );
	$html .= "<div style='background:#EAF1F6; border:1px solid #333; padding:1em;'>";
	$html .= $frontendlogin->ffl_wrap_form_modal_before();
	$html .= $frontendlogin->ffl_form_content();
	$html .= $frontendlogin->ffl_wrap_form_modal_after();
	$html .= "</div></td><td style='width:33%; padding:1em; vertical-align:top;'>";
	$html .= __( 'Simple popup preview...',  'flexible-frontend-login'  );
	$html .= "<div style='background:#EAF1F6; border:1px solid #333; padding:1em;'>";
	$html .= $frontendlogin->ffl_wrap_form_before();
	$html .= $frontendlogin->ffl_form_content();
	$html .= $frontendlogin->ffl_wrap_form_after();
	$html .= "</div></td><td style='width:33%; padding:1em; vertical-align:top;'>";
	$html .= __( 'Preview for logged in users...',  'flexible-frontend-login'  );
	$html .= "<div style='background:#EAF1F6; border:1px solid #333; padding:1em;'>";
	$html .= $links;
	$html .= "</div></td></tr></table>";
	
	$options_panel->addParagraph( $html );

$options_panel->CloseTab();


// Help
$options_panel->OpenTab('options_5');

	//title
	$options_panel->Title( __('Help', 'flexible-frontend-login' ) );
	
	//include the readme.txt
	$readmetxt= file_get_contents( FFL_PATH . '/readme.txt' );
	$readmetxt = MARKDOWN($readmetxt); 
	$options_panel->addParagraph( $readmetxt );
	
$options_panel->CloseTab();


add_action( 'admin_enqueue_scripts', 'paw_ffl_admin_css' );
function paw_ffl_admin_css() {
	/* Register our stylesheet. */
	if ( file_exists( TEMPLATEPATH . '/flexible-frontend-login/fll-style.css' ) ) {
		wp_register_style( 'flexible-frontend-login', TEMPLATEPATH . '/flexible-frontend-login/fll-style.css', 'screen, projection' );
	} else {
		wp_register_style( 'flexible-frontend-login', FFL_URL . '/css/ffl-style.css' , 'screen, projection' );
	}
    wp_enqueue_style('flexible-frontend-login');
}

add_action( 'admin_enqueue_scripts', 'paw_ffl_admin_js' );

function paw_ffl_admin_js()
{
	wp_enqueue_script( 'ffl-js', FFL_URL . '/js/ffl.js', 'jquery', true );
}

?>
