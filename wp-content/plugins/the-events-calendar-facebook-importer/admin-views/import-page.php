<?php

// Don't load directly
if ( !defined( 'ABSPATH' ) )
	die('-1');

$fb_uids = TribeEvents::getOption( 'fb_uids' );
$settings_link = '<a href="' . add_query_arg( array( 'post_type' => TribeEvents::POSTTYPE, 'page' => 'tribe-events-calendar', 'tab' => 'fb-import' ), admin_url( 'edit.php' ) ) . '">' . __( 'settings page', 'tribe-fb-import' ) . '</a>';
$events_link = '<a href="' . add_query_arg( array( 'post_type' => 'tribe_events' ), admin_url( 'edit.php' ) ) . '">' . __( 'Go take a look at your event(s)', 'tribe-fb-import' ) . ' &raquo; </a>';

?>

<div class="tribe_settings wrap">

	<?php screen_icon( 'edit' ); ?>
	<h2><?php _e( 'Import Facebook Events', 'tribe-fb-import' ); ?></h2>

	<?php if ( !empty( $this->errors ) ) : ?>
		<div class="error">
			<p><strong><?php _e( 'The following errors have occurred:', 'tribe-fb-import' ); ?></strong></p>
			<ul class="admin-list">
				<?php foreach ( $this->errors as $error ) : ?>
					<li><?php echo $error; ?></li>
				<?php endforeach; ?>
			</ul>
			<?php if ( $this->no_events_imported ) : ?>
				<p><?php _e( 'Please note that as a result, no events were successfully imported.', 'tribe-fb-import' ); ?></p>
			<?php else : ?>
				<p><?php _e( 'Please note that other events have been successfully imported.', 'tribe-fb-import' ); ?></p>
			<?php endif; ?>
		</div>
	<?php elseif ( $this->success ) : ?>
		<div class="updated">
			<p><?php 

				printf(_n('The selected event has been successfully imported.', 'The %d selected events have been successfully imported.', $this->imported_total, 'tribe-fb-import' ), $this->imported_total);
				echo ' ' . $events_link; 

			?></p>
		</div>
	<?php endif; ?>

	<div id="modern-tribe-info" style="max-width: 800px; padding-top: 15px;">
		<h2><?php _e( 'How to Import Facebook Events', 'tribe-fb-import' ); ?></h2>
		<?php if ( empty( $fb_uids ) ) : ?>
			<h4><?php printf( __( 'Visit the %s to insert the Facebook User or Page Identifiers that you wish to import from. Once you do, you will be able to select which events you wish to import.', 'tribe-fb-import' ), $settings_link ); ?></h4>
		<?php else : ?>
			<h4><?php printf( __( "Since you've already setup some Facebook user(s) or page(s) to import from, you can import those events below. Visit the %s to modify the Facebook user(s) or page(s) you want to import from.",'tribe-fb-import' ), $settings_link ); ?></h4>
		<?php endif; ?>
			<h4><?php _e( 'You can also import any arbitrary event by entering Facebook event IDs in the text area below.', 'tribe-fb-import' ); ?></h4>
			<ul class="admin-list">
				<li><?php printf( __( "You can determine an event's Facebook ID by looking at the URL of the event. For example, the ID of this event: %s would be %s", 'tribe-fb-import' ), 'https://www.facebook.com/events/12345689', '123456789' ); ?>
				<li><?php _e( 'Please enter one Facebook event ID per line.', 'tribe-fb-import' ); ?></li>
			</ul>
	</div>
	
	<div class="tribe-settings-form">

	<form method="post">
		<div class="tribe-settings-form-wrap">

		<?php if ( !empty( $fb_uids ) ) : ?>
			<h3><?php _e( "Events from Facebook organization(s) or page(s) you've added:", 'tribe-fb-import' ); ?></h3>		
			<div class="admin-indent">
				<?php $this->build_import_fields( $fb_uids ) ?>
			</div>
			<br>
		<?php endif; ?>

		<h3><?php _e( 'Import events by their Facebook ID:', 'tribe-fb-import' ); ?></h3>
		
		<div class="admin-indent">
			<label for="tribe-fb-import-events-by-id"></label><br><textarea id="tribe-fb-import-events-by-id" name="tribe-fb-import-events-by-id" rows="5" cols="50"></textarea>
			<p><span class="description"><?php _e( 'One event ID per line', 'tribe-fb-import' ); ?></span></p>
			<br><br>
		</div>

		<?php wp_nonce_field( 'tribe-fb-import', 'tribe-confirm-import' ) ?>
		<input id="tribe-fb-import-submit" class="button-primary" type="submit" value="<?php _e( 'Import events', 'tribe-fb-import' ); ?>">
		
		</div>
	<form>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('#tribe-fb-import-submit').click(function(e){
			var any_checked = false;
			$('.checkbox').each(function(){
				if ( $(this).prop('checked') && !$(this).prop('disabled') ) {
					any_checked = true;
				}
			});
			if ( !any_checked && $('#tribe-fb-import-events-by-id').val() == '' ) {
				e.preventDefault();
				alert("<?php _e( 'Please select or enter the ID of at least one event to import', 'tribe-fb-import' ) ?>");
			}
		});;
	});
</script>