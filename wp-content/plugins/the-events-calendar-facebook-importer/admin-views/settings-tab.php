<?php

// Don't load directly
if ( !defined( 'ABSPATH' ) )
	die( '-1' );

$facebook_tab = array(
	'priority' => 37,
	'fields' => array(
		'fb-sync-instructions' => array(
			'type' => 'html',
			'html' =>
				'<div id="modern-tribe-info">' .
					'<h2>' . __( 'Import Facebook Events', 'tribe-fb-import' ) . '</h2>' .
					'<h3>' . __( 'Getting Started', 'tribe-fb-import' ) . '</h3>' .
				 	'<p>' . __( "You need your Facebook App ID and App Secret to access data via the Facebook Graph API to import your events from Facebook. We've provided a default set of API credentials, however we encourage you to create your own Facebook App and enter your credentials below.", 'tribe-fb-import' ) . '</p>' .
				 	'<ul class="admin-list">' .
				 		'<li>' . sprintf( __( '%s to learn more about Facebook Apps', 'tribe-fb-import' ), '<a href="http://developers.facebook.com/docs/guides/canvas/" target="_blank">' . __( 'Click here', 'tribe-fb-import' ) . '</a>' ) . '</li>' .
				 		'<li>' . sprintf( __( '%s to view or create Facebook Apps', 'tribe-fb-import' ), '<a href="https://developers.facebook.com/apps" target="_blank">' . __( 'Click here', 'tribe-fb-import' ) . '</a>' ) . '</li>' .
				 	'</ul>' .
			 		'<h3>' . __( 'Selecting pages or users to sync events with', 'tribe-fb-import' ) . '</h3>' .
			 		'<p>' . __( 'You can import events belonging to a Facebook organization or a Facebook page. You will need the username(s) or ID of each organization or page that you want to fetch events from. We do not currently support importing events from personal profiles.', 'tribe-fb-import' ) . '</p>' .
				 	'<ul class="admin-list">' .
				 		'<li>' . sprintf( __( "A page or organization's username or ID can be found in the URL used to access its profile. Modern Tribe's page is %s and the username is 'ModernTribeInc'. If a page or organization doesn't have a username, you will see the ID (numerical) in the URL.", 'tribe-fb-import' ), '<a href="https://www.facebook.com/ModernTribeInc">https://www.facebook.com/ModernTribeInc</a>' ).
				 		'<li>' . sprintf( __( "You can also find the ID of an organization or page by visiting the Graph API. For example, to find Modern Tribe's ID, visit %s. You will get a json response with information about the user or page. The first result should be the ID.", 'tribe-fb-import' ), '<a href="https://graph.facebook.com/ModernTribeInc" target="_blank">https://graph.facebook.com/ModernTribeInc</a>' ). '</li>' .
				 	'</ul>' .
			 	'</div>',
		),
		'tribe-form-content-start' => array(
			'type' => 'html',
			'html' => '<div class="tribe-settings-form-wrap">',
		),
		'tribeEventsFacebookAcctTitle' => array(
			'type' => 'html',
			'html' => '<h3>' . __( 'Account Settings', 'tribe-events-calendar-pro' ) . '</h3>',
		),
		'fb_api_key' => array(
			'type' => 'text',
			'label' => __( 'Facebook App ID', 'tribe-fb-import' ),
			'tooltip' => __( 'This information is optional.', 'tribe-fb-import' )  . '<br>' . __( 'Follow the instructions above to create or find your Facebook App ID.', 'tribe-fb-import' ),
			'size' => 'medium',
			'validation_type' => 'alpha_numeric',
			'can_be_empty' => true,
			'parent_option' => TribeEvents::OPTIONNAME,
		),
		'fb_api_secret' => array(
			'type' => 'text',
			'label' => __( 'Facebook App secret', 'tribe-fb-import' ),
			'tooltip' => __( 'This information is optional.', 'tribe-fb-import' )  . '<br>' . __( 'Follow the instructions above to create or find your App Secret.', 'tribe-fb-import' ),
			'size' => 'medium',
			'validation_type' => 'alpha_numeric',
			'can_be_empty' => true,
			'parent_option' => TribeEvents::OPTIONNAME,
		),
		'fb_uids' => array(
			'type' => 'textarea',
			'label' => __( 'Organization and page usernames / IDs to sync with', 'tribe-fb-import' ),
			'tooltip' => __( 'Please put one entry per line.', 'tribe-fb-import' )  . '<br>' . __( 'Follow the instructions above to find usernames or IDs.', 'tribe-fb-import' ),
			'size' => 'medium',
			'validation_type' => 'alpha_numeric_multi_line_with_dots_and_dashes',
			'can_be_empty' => true,
			'parent_option' => TribeEvents::OPTIONNAME,
			'esc_display' => 'tribe_multi_line_remove_empty_lines',
		),
		'tribeEventsFacebookImportTitle' => array(
			'type' => 'html',
			'html' => '<h3>' . __( 'Import Settings', 'tribe-events-calendar-pro' ) . '</h3>',
		),
		'fb_default_status' => array(
			'type' => 'dropdown',
			'label' => __( 'Default status to use for imported events', 'tribe-fb-import' ),
			'options' => array( 'publish' => __( 'Published', 'tribe-fb-import' ), 'draft' => __( 'Draft', 'tribe-fb-import' ), 'pending' => __( 'Pending Review', 'tribe-fb-import' ) ),
			'validation_type' => 'options',
			'parent_option' => TribeEvents::OPTIONNAME,
		),
		'fb_enable_GoogleMaps' => array(
			'type' => 'checkbox_bool',
			'label' => __( 'Enable Google Maps on imported events', 'tribe-events-calendar' ),
			'tooltip' => __( 'Check to enable maps for imported events in the frontend. Please enable Google Maps on the "General" tab to ensure your events will have map options.', 'tribe-fb-import' ),
			'default' => true,
			'class' => 'google-embed-size',
			'validation_type' => 'boolean',
		),
		'fb_auto_import' => array(
			'type' => 'checkbox_bool',
			'label' => __( 'Auto import from Facebook', 'tribe-fb-import' ),
			'tooltip' => __( 'If selected, events will be automatically imported from Facebook at the set interval.', 'tribe-fb-import' ),
			'validation_type' => 'boolean',
			'parent_option' => TribeEvents::OPTIONNAME,
		),
		'fb_auto_frequency' => array(
			'type' => 'dropdown',
			'label' => __( 'Import frequency', 'tribe-fb-import' ),
			'tooltip' => __( 'How often should we fetch events from Facebook. Only applies if Auto Import is set.', 'tribe-fb-import' ),
			'options' => array( 'weekly' => __( 'Weekly', 'tribe-fb-import' ), 'daily' => __( 'Daily', 'tribe-fb-import' ), 'twicedaily' => __( 'Twice daily', 'tribe-fb-import' ), 'hourly' => __( 'Hourly', 'tribe-fb-import' ) ),
			'validation_type' => 'options',
			'parent_option' => TribeEvents::OPTIONNAME,
		),
		'tribe-form-content-end' => array(
			'type' => 'html',
			'html' => '</div>',
		),
	),
);