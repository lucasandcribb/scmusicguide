<?php
/*
Template Name: Submit Artist
*/
?>
<?php get_header(); ?>
	<?php get_sidebar(); ?>
	
	<div id="add-artist">
		<div id="add-artist-title">Add an Artist</div>
		<div class="add-title-text">We enjoy receiving Artist submissions.  After all, this effort will help us grow and ensure that you are exposed in the best light possible. </div>

		<div class="add-title-text">However, please make sure to read the following disclaimer: </div>

		<div class="add-title-text add-text-bold">
			Permissions and Licenses: By submitting this form I agree that I have the legal authority to do so and all copyright licenses and permissions 
			have been secured in order to grant the South Carolina Music Guide the rights to deliver music via digital delivery for streaming/listening from 
			the South Carolina Music Guide and download deliveries. Furthermore, I also agree that I have the legal authority to submit all other supporting 
			materials in addition to the musical tracks.  These include, but are not limited to digital images, both still and moving, as well as any written 
			publications pertaining to the artist(s) in question.
		 </div>

		<div class="add-title-text">So...if you are still interested, we invite you to fill out the below form to get started! </div>
	</div>

	<?php echo do_shortcode('[gravityform id=3 title=false description=false ajax=true]'); ?>


<?php get_footer(); ?>