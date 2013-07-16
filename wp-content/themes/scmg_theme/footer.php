<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div>
	
	<?php $genre_array = array("Acoustic","Bluegrass","Blues","Funk","Rock"); ?>
	<?php $genreCount = 0; foreach ($genre_array as $genre) { $genreCount++; } ?>
	
	
	<footer id="colophon">
		<!-- <div id="footer-by-cat">
			<?php for ($i = 0; $i < $genreCount; $i++) {
	    		echo "<div class='footer-cat-links'><a href='#index-".$genre_array[$i]."' class='genre-link' rel='".$genre_array[$i]."'>".$genre_array[$i]."</a> </div>";
			} ?>
		</div> -->
		<div class="footer-section">
			<div class="footer-title">Reviews</div>
			<a href="/album-reviews" class="footer-link">Albums</a>
		</div>
		<div class="footer-section">
			<div class="footer-title">Articles</div>
			<a href="/category/spotlight/" class="footer-link">In the Spotlight</a>
			<a href="/category/sights-and-sounds/" class="footer-link">Sights and Sounds</a>
			<a href="/category/guest-article/" class="footer-link">The Guest List</a>
		</div>
		<div class="footer-section">
			<div class="footer-title">Artists</div>
			<a href="/artists-index-page" class="footer-link">Artist Index</a>
		</div>
		<div class="footer-section">
			<div class="footer-title">More Info</div>
			<!-- <div class="footer-link">RSS</div> -->
			<a href="#" class="footer-link">Terms of Use</a>
			<a href="/about-us" class="footer-link">Staff</a>
			<a href="/contact-us" class="footer-link">Contact</a>
		</div>
		<div class="footer-section social-links">
			<a href="http://www.facebook.com/sharer.php?u=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?> " target="_blank"><img class="social-link" src="/wp-content/images/social-icons/fb.jpg" /></a>
			<a href="http://www.twitter.com/share?text=<?php echo bloginfo('name'); ?>&url=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" target="_blank"><img class="social-link" src="/wp-content/images/social-icons/twitter.jpg" /></a>
			<a href="https://plus.google.com/share?url=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" target="_blank"><img class="social-link" src="/wp-content/images/social-icons/g.jpg" /></a>
			<a href="http://www.tumblr.com/share/link?url=<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>&name=<?php echo bloginfo('name'); ?>" target="_blank"><img class="social-link" src="/wp-content/images/social-icons/tumblr.jpg" /></a>
		</div>
		

		<div class="footer-copywrite">
			© 2013 South Carolina Music Guide All rights reserved.
		</div>
		<div class="footer-sitecredit">
			Site Credit: Lucas &amp Cribb
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>