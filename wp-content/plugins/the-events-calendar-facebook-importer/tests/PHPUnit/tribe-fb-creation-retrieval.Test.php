<?php

/**
 * Tests Facebook Importer creation & retrieval functions
 *
 * @package Tribe_FB_Importer
 * @since 1.0
 * @author jkudish
 */
class WP_Test_Tribe_FB_Creation_Retrieval extends Tribe_WP_UnitTestCase {

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
		$this->fb_events_ids = $this->fb_importer->get_events_for_specfic_user_or_page_ids( $this->test_uids );

		// create local events
		$this->local_events = array();
		foreach ( $this->fb_events_ids as $event ) {
			$this->local_events[] = $this->fb_importer->create_local_event( $event );
		}
	}

	/**
	 * test local creation of events using the test event objects
	 *
	 * @since 1.0
	 * @author jkudish
	 */
	public function test_create_events() {
		foreach ( $this->local_events as $event ) {
			$this->assertInternalType( 'array', $event );
			foreach ( $event as $event_or_organizer_or_venue_id ) {
				$this->assertTrue( is_numeric( $event_or_organizer_or_venue_id ) );
			}
		}
	}

	/**
	 * test local retrieval of events using the facebook IDs
	 * created above
	 *
	 * @since 1.0
	 * @author jkudish
	 */
	public function test_get_events() {
		foreach ( $this->fb_events_ids as $facebook_event_id ) {
			$local_event_id = $this->fb_importer->find_local_object_with_fb_id( $facebook_event_id );
			$this->assertTrue( is_numeric( $local_event_id ) );
			$this->assertTrue( tribe_is_event( $local_event_id ) );
		}
	}

}