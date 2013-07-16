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
			<a href="#" class="footer-link terms-link">Terms of Use</a>
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

<div id="terms-of-use">
	<img class="x-out" src="/wp-content/images/x.png" />
	<div id="terms-container">
		<div id="terms-title">Terms of Use</div>
		<div class="terms-subtitle">1. Use of Content </div>
		<div class="terms-info">
			South Carolina Music Guide is pleased to make its original content available under a Creative Commons Attribution Non-Commercial License, 
			for non-commercial reproduction with credit to the source site. This license permits anyone to do the following with original South Carolina 
			Music Guide content, in any medium:
			<ul>
				<li>
					To reproduce, remix, or otherwise alter original South Carolina Music Guide site material so long as the logo is displayed and credit 
					is given. This includes, specifically, permission:
					<ul>
						<li>to reproduce quotes</li>
						<li>to reproduce screenshots of any page of a South Carolina Music Guide Site</li>
						<li>to include original South Carolina Music Guide material for movies, TV, print, or online</li>
					</ul>
				</li>
				<li>
					Important Note: This does not include the right to republish images from South Carolina Music Guide Sites, for which South Carolina 
					Music Guide may not be the copyright holder, except in the context of a screenshot of the whole site. South Carolina Music Guide 
					makes no representations or guarantees about the suitability for third-party use of content that appears on the South Carolina Music 
					Guide Sites, and licenses herewith only the content of which South Carolina Music Guide is the copyright holder.
				</li>
			</ul>
		</div>
	
		<div class="terms-subtitle">2. Web Syndication of South Carolina Music Guide Content </div>
		<div class="terms-info">
			<ul>
				<li>Internal links in the Site content must not be removed.</li>
				<li>The Site logo and/or URL should appear on each page displaying site content.</li>
				<li>"More From…" links back to original Site at the end of each post must be included on content pages and may not be removed.</li>
			</ul>
		</div>
	
		<div class="terms-subtitle">3. Print Syndication Terms of Use</div>
		<div class="terms-info">
			<ul>
				<li>Reproduction of screenshots from the Site is permissible, without prior written approval, so long as the site logo and URL is fully visible or otherwise included on the page. See above for general permissions on partial content.</li>
				<li>The Site logo and URL must appear prominently at the top of each section displaying site content.</li>
				<li>Content must be unedited, except for replacement of hyperlinks with full URLs and use of product manufacturer's site links where appropriate.</li>
				<li>Images from a Site must not be used in print without you obtaining the appropriate copyright clearances yourself.</li>
			</ul>
		</div>
	
		<div class="terms-subtitle">4. General Terms of Use</div>
		<div class="terms-info">
			South Carolina Music Guide provides content "as is" and South Carolina Music Guide shall not be held liable for your use of the information, or 
			your use of the South Carolina Music Guide Site. Use of the Site's content, including text and images, on your site, or in print, is entirely 
			at your discretion. South Carolina Music Guide is not responsible for any complaints regarding content or images that you choose to display on 
			your site or in print. TO THE FULLEST EXTENT ALLOWED, South Carolina Music Guide DISCLAIMS ALL WARRANTIES INCLUDING WARRANTIES FOR 
			MERCHANTABILITY, NON-INFRINGEMENT AND FITNESS FOR A PARTICULAR PURPOSE. By accessing the South Carolina Music Guide Sites, you indicate that 
			you understand and agree to these terms and conditions set forth in the Terms of Use.</br>
			South Carolina Music Guide is not responsible for the content of user comments. If a third party complains that your comment violates our 
			Terms of Use or their rights, we will invite them to respond in the comments themselves. If they pursue the complaint, we will make reasonable 
			efforts to contact you by the means you have provided us, to alert you to the situation. We will protect your contact information as described 
			in our Privacy Policy, but may be compelled to turn it over pursuant to legal process.
		</div>
	
		<div class="terms-subtitle">5. Image and Video Terms of Use</div>
		<div class="terms-info">
			South Carolina Music Guide Sites typically display images, audio, and video (the "Material") as part of blog posts written by our editors and writers. 
			The types of Material they are authorized to use on South Carolina Music Guide sites include:
			<ul>
				<li>Material licensed from photographic archive and video vendors;</li>
				<li>Material supplied to our editors or released into the public domain by public relations and marketing companies for press purposes;</li>
				<li>Reader-submitted Material, with the implied representation that the person submitting the material owns the copyright in the material and the right to give it to us for use on South Carolina Music Guide Site(s);</li>
				<li>Material published on Flickr or other public photo / video sites with licenses granted under Creative Commons, with attribution in accordance with the Creative Commons license granted in each case;</li>
				<li>Material commissioned by South Carolina Music Guide</li>
				<li>
					Material that we believe to be covered by the Fair Use Doctrine, taking into account factors such as:
					<ul>
						<li>The purpose and character of the use (i.e. transformation from the original, use for criticism, satire or parody)</li>
						<li>The nature of the copyrighted work (i.e. factual or newsworthy versus creative works)</li>
						<li>The amount and substantiality of the portion used in relation to the whole (i.e. use of cropped, reduced, low-resolution Material used for no more than to convey the point made)</li>
						<li>The effect on the potential market for the copyrighted work (e.g. use that is not substitutive for the original, or would never be licensed in any event)</li>
					</ul>
				</li>
			</ul>
		</div>
	
	
		<div class="terms-subtitle">6. Notices</div>
		<div class="terms-info">
			If South Carolina Music Guide receives notice that Material posted is not in keeping with the Terms of Use or the intended use of the Comments 
			section where it is posted, we reserve to right to remove the material. If you think we have published Material that infringes your copyright, 
			we will address your concerns; however, if the material falls into one of the categories listed above, we believe that our use is legitimate and 
			we will not remove it from the site. Please note that we will respond only to notices of alleged infringement that comply with the Digital 
			Millennium Copyright Act. The text of the Act can be found at the U.S. Copyright Office Web Site. To file a notice of infringement with us, you 
			must provide a written communication (by email with an attached and signed PDF or by fax) that sets forth the items specified below. Please do 
			not send us regular mail, as we may not receive it in a timely fashion.</br>
			To enable us to address your concerns, please provide the following information:
			<ul>
				<li>For each allegedly infringing image, video or piece of text that you wish to have removed from one of our sites, provide the exact permanent 
					URL for the page containing the material.</li>
				<li>Provide information reasonably sufficient to permit us to contact you: an email address is preferred, as well as a telephone contact number.</li>
				<li>For images, provide the following information detailing your claim to ownership of the copyright in the allegedly infringing image:</li>
				<li>Proof of copyright in the image concerned, namely proof of registration of the Image under the DMCA; OR, absent such registration, a detailed 
					description of where the photograph was taken, by whom, who or what the subject of the image is, and evidence to support your claim that you 
					own the copyright in the image. We will not comply with requests to remove an image where the complainant cannot prove that they own the copyright 
					in the image in question.</li>
				<li>Include the following statement: "I swear, under penalty of perjury, that the information in the notification is accurate and that I am the 
					copyright owner or am authorized to act on behalf of the owner of an exclusive right that is allegedly infringed."</li>
				<li>Email the document and email it to: admin@scmusicguide.com  Please note that you will be liable for damages (including costs and attorneys' fees) 
					if you materially misrepresent that any material on our sites is infringing your copyrights.</li>
			</ul>
		</div>
	
		<div class="terms-subtitle">7. External Links Disclaimer</div>
		<div class="terms-info">
			South Carolina Music Guide Sites may contain links to external, third party websites. By providing links to other sites, South Carolina Music Guide does not 
			guarantee, approve or endorse the information or products available at these sites, nor does a link indicate any association with or endorsement by the linked 
			site to the South Carolina Music Guide in question. South Carolina Music Guide does not operate or control and has no responsibility for the information, products 
			and/or services found on any external sites. Nor do such links represent or endorse the accuracy or reliability of any information, products and/or services provided 
			on or through any external sites, including, without limitation, warranties of any kind, either express or implied, warranties of title or non-infringement or implied 
			warranties of merchantability or fitness for a particular purpose. Visitors to South Carolina Music Guide assume complete responsibility and risk in their use of any 
			external sites. Visitors should direct any concerns regarding any external link to its site administrator or webmaster.
		</div>
	</div>
</div>

<div id="bg-fade"></div>

<?php wp_footer(); ?>
</body>
</html>