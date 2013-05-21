<?php
/**
 * Audio Player Shortcode
 * [p75_audio_player album="album_id" autoplay="true/false" playlist="true/false"]
 *
 * This shortcode inserts a custom audio player.
 */
class Soundcheck_Audio_Player_Shortcode {
	static $add_script;
	static $album_id;
	static $autoplay;
	static $content;
	static $playlist;
	
	static $random_id;
 
	static function init() {
		add_shortcode( 'p75_audio_player', array( __CLASS__, 'handle_shortcode' ) );
	}
	
	static function handle_shortcode( $atts ) {
		self::$add_script = true;
 
		extract( shortcode_atts( array(
			'album_id' => get_the_ID(),
			'autoplay' => 0,
			'content'  => 1,
			'playlist' => 0
		), $atts ) );
		
		self::$album_id = $album_id;
		self::$autoplay = $autoplay;
		self::$content = $content;
		self::$playlist = $playlist;
		
		self::$random_id = substr( md5( uniqid( rand(), true) ), 0, 4 );
		
		$output = '';
		$output .= '<div class="audio-player">';
			$output .= sprintf( '<div id="jquery_jplayer_%1$s_%2$s" class="jp-jplayer"></div>', 
				esc_attr( self::$random_id ),
				esc_attr( self::$album_id )
			);
			
			$output .= sprintf( '<div id="jp_container_%1$s_%2$s" class="jp-audio clearfix %3$s">', 
				esc_attr( self::$random_id ),
				esc_attr( self::$album_id ),
				self::$content ? '' : 'hide-content'
			);
			    
			    $output .= '<div class="jp-interface jp-gui">';

					/**
					 * Artwork
					 *
					 */		
			        $output .= '<figure class="jp-current-artwork">';
			        	$output .= sprintf( '<img src="%1$s"  alt="%2$s" class="preloading artwork" />',
			        		esc_url( get_template_directory_uri() . '/images/default-artwork.png' ),
			        		esc_attr__( 'Album Artwork', 'soundcheck' )
			        	); 
			        $output .= '</figure>';
			        
					/**
					 * Playlist Controls
					 *
					 */		
			        $output .= '<nav class="jp-controls-wrap">';
			        	$output .= '<div class="jp-controls">';
			        		$output .= sprintf( '<a href="javascript:;" class="jp-previous" tabindex="1"><span>%1$s</span></a>', 
			        			__( 'Previous', 'soundcheck' ) 
			        		);
			        		$output .= sprintf( '<a href="javascript:;" class="jp-play" tabindex="2"><span>%1$s</span></a>', 
			        			__( 'Play', 'soundcheck' ) 
			        		);
			        		$output .= sprintf( '<a href="javascript:;" class="jp-pause" tabindex="3"><span>%1$s</span></a>', 
			        			__( 'Pause', 'soundcheck' ) 
			        		);
			        		$output .= sprintf( '<a href="javascript:;" class="jp-next" tabindex="4"><span>%1$s</span></a>', 
			        			__( 'Next', 'soundcheck' ) 
			        		);
			        	$output .= '</div><!-- .jp-controls -->';
			        $output .= '</nav>';
			        
					/**
					 * View Controls
					 *
					 */		
			        $output .= '<div class="jp-view-controls">';
			    		if( self::$playlist ) :
							$output .= sprintf( '<a class="jp-playlist-view" href="#" class="tooltip" title="%1$s"><span></span><span></span><span></span><span></span></a>', esc_attr__( 'Show Playlist', 'soundcheck' ) );
			    		endif;
			    		
			    		if( ! self::$content ) :
							$output .= sprintf( '<a class="jp-content-view" href="#" class="tooltip" title="%1$s">i</a>',
								esc_attr__( 'Show Playlist', 'soundcheck' ) 
							);
			    		endif;
			    	$output .= '</div>';
			    $output .= '</div><!-- .jp-interface -->';
			    
			    $output .= '<div class="jp-content">';
					/**
					 * Current Item Info
					 *
					 */		
			        $output .= '<div class="jp-current-item">';
			        	$current_item = '<span class="jp-current-%1$s"></span>';
			        	
			        	//if( ! is_singular() || is_page_template( 'template-discography.php' ) ) {
			        		$current_item = sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', 
			        			esc_url( get_permalink( $album_id ) ),
			        			esc_attr__( 'View album details', 'soundcheck' ),
			        			$current_item
			        		);
			        	//}		        	
			        	$output .= sprintf( $current_item, 'track' );
						$output .= sprintf( $current_item, 'artist' );
						$output .= sprintf( $current_item, 'album' );
					$output .= '</div><!-- .jp-current-item -->';
			    
					/**
					 * Notifications
					 *
					 */		
					$notification = '<div id="jp-%1$s" class="jp-notification"><h4 class="jp-notification-title">%2$s</h4><span class="jp-notification-description">%3$s</span></div>';
					
					// Loading
					$output .= sprintf( $notification,
						esc_attr( 'loading' ),
						esc_html__( 'Loading audio&hellip;', 'soundcheck' ),
						esc_html__( 'Please wait while the audio tracks are being loaded.', 'soundcheck' )
					);
					
					// No Tracks
					$output .= sprintf( $notification,
						esc_attr( 'no-tracks' ),
						esc_html__( 'No Audio Available', 'soundcheck' ),
						esc_html__( 'It appears there are not any audio playlists available to play.', 'soundcheck' )
					);
					
					// Bad URL
					$output .= sprintf( $notification,
						esc_attr( 'e_url' ),
						esc_html__( 'Bad URL', 'soundcheck' ),
						esc_html__( 'The track url currently being played either does not exist or is not linked correctly.', 'soundcheck' )
					);
					
					// No Solution
					$output .= sprintf( $notification,
						esc_attr( 'e_no_solution' ),
						esc_html__( 'Update Required To Play Media', 'soundcheck' ),
						sprintf( __( 'Update your browser to a recent version or update your %1$s.', 'soundcheck' ),
							sprintf( '<a href="http://get.adobe.com/flashplayer/" title="%1$s" target="_blank">%2$s</a>',
								esc_attr__( 'Link to Adobe Flash Player Plugin', 'soundcheck' ),
								esc_html__( 'Flash plugin', 'soundcheck' )
							)
						)
					);
					
					/**
					 * Progress Bar
					 *
					 */		
			        $output .= '<div class="jp-progress-wrap">';
			            $output .= '<div class="jp-progress">';
			            	$output .= '<div class="jp-seek-bar">';
			            		$output .= '<div class="jp-play-bar"></div>';
			            	$output .= '</div>';
			            $output .= '</div>';
			        $output .= '</div><!-- .jp-progress-wrap -->';
					
					/**
					 * Current Time
					 *
					 */		
			        $output .= '<div class="jp-current-time"></div>';
			        
			    $output .= '</div><!-- .jp-player-content -->';

				/**
				 * Playlist
				 *
				 */		
			    $output .= '<div class="jp-type-playlist preloading">';
			        $output .= '<div class="jp-playlist">';
			        	$output .= '<h3 class="tracks-title">Tracks</h3>';
			        	$output .= '<ul class="tracks">';
			        		$output .= '<li></li>';
			        	$output .= '</ul>';
			        $output .= '</div>';
			    $output .= '</div><!-- .jp-type-playlist -->';
			    
			$output .= '</div><!-- #jp_container_N -->';
		$output .= '</div><!-- .audio-player -->';
		
		return $output;
	}
}
 
Soundcheck_Audio_Player_Shortcode::init();

?>