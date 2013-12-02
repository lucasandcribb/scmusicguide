<?php

/**
 * Tests Facebook Importer url building & remote fetching functions
 *
 * @package Tribe_FB_Importer
 * @since 1.0
 * @author jkudish
 */
class WP_Test_Tribe_FB_Get_Events extends Tribe_WP_UnitTestCase {

	/**
	 * Add to the setUp() function the initialization of the plugin, when assignations take place.
	 *
 	 * @since 1.0
	 * @author jkudish
	 */
	public function setUp() {
		parent::setUp();

		// init TribeEvents & Tribe_FB_Importer
		$this->ecp = TribeEvents::instance();
		$this->ecp->init();
		$this->fb_importer = Tribe_FB_Importer::instance();

		// setup vars used in tests
		$this->test_uids = array( 'ASuperGreatCommunity' );
		$this->raw_access_token = $this->fb_importer->get_raw_access_token();
		$this->access_token = $this->fb_importer->get_raw_access_token();
		$this->events = $this->fb_importer->get_events_for_specfic_user_or_page_ids( $this->test_uids );
	}

	/**
	 * Test to make sure the access token is properly generated
	 *
	 * @since 1.0
	 * @author jkudish
	 */
	public function test_get_raw_ccess_token() {
		 $this->assertRegExp( '/access_token=([^&]+)/', $this->raw_access_token );
	}

	/**
	 * Test to make sure access token is properly parsed
	 *
	 * @since 1.0
	 * @author jkudish
	 */
	public function test_get_access_token() {
		 $this->assertRegExp( '/([^&]+)/', $this->access_token );
	}


	/**
	 * Test to make sure getting events from facebook returns expectected resutls
	 *
 	 * @since 1.0
	 * @author jkudish
	 */
	public function test_get_events() {
		$this->assertInternalType( 'array', $this->events );
		foreach ( $this->events as $event_id ) {
			$event = $this->fb_importer->get_facebook_object( $event_id );
			$this->assertNotEmpty( $event->name );
			$this->assertNotEmpty( $event->description );
			$this->assertNotEmpty( $event->start_time );
			$this->assertNotEmpty( $event->end_time );
			$this->assertNotEmpty( $event->id );
		}
	}

}