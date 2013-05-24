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
		<div id="footer-by-cat">
			<div class="footer-cat-links">
				<?php for ($i = 0; $i < $genreCount; $i++) {
	    			echo "<a href='#index-".$genre_array[$i]."' class='genre-link' rel='".$genre_array[$i]."'>".$genre_array[$i]."</a> ";
				} ?>
			</div>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>