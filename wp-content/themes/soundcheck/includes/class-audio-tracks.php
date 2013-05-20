<?php  

class Soundcheck_Audio {
	
	var $id = '';

	var $album = '';
	var $artist = '';
	var $artwork = '';
	var $number = '';
	var $src = '';
	var $title = '';

	var $attachement;
	var $track = array();
	var $tracks = array();

	function __construct( $post_id ) {
		$this->id = ( isset( $post_id ) ) ? $post_id : get_the_ID();
		$this->number = 0;
	}

	// Get Album
	function get_album( $attachment ) {
		if( $attachment ) {
			$attachment_description = apply_filters( 'the_content', $attachment->post_content );
		}
		
		if( isset( $attachment_description ) && ! empty( $attachment_description ) ) {
		    $this->album = $attachment_description;
		} else {
		    $this->album = get_the_title();
		}

		return $this->album;
	}

	// Get Artwork
	function get_artwork() {
		if ( has_post_thumbnail() ) {
		    $this->artwork = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
		    $this->artwork = $this->artwork[0];
		} else {
			$this->artwork = get_template_directory_uri() . '/images/default-artwork.png';
		}

		return $this->artwork;
	}

	// Get Artist
	function get_artist( $attachment ) {
		if( $attachment ) {
			$attachment_caption = apply_filters( 'the_excerpt', $attachment->post_excerpt );
		}
		
		if( isset( $attachment_caption ) && ! empty( $attachment_caption ) ) {
		    $this->artist = $attachment_caption;
		} else {
		    $this->artist = get_the_author_meta( 'display_name' );
		}

		return $this->artist;
	}
	
	// Get Source
	function get_src( $attachment ) {
		if( $attachment ) {
			$attachment_url = wp_get_attachment_url( $attachment->ID );
		}
		
		if( isset( $attachment_url ) && ! empty( $attachment_url ) ) {
		    $this->src = $attachment_url;
		} else {
		    $this->src = get_template_directory_uri() . '/images/default-audio.mp3';
		}
		
		return $this->src;
	}

	// Get Title
	function get_title( $attachment ) {
		if( $attachment ) {
			$attachment_title = apply_filters( 'the_title', $attachment->post_title );
		}
			
		if( isset( $attachment_title ) && ! empty( $attachment_title ) ) {
		    $this->title = $attachment_title;
		} else {
		    $this->title = __( 'No Title', 'soundcheck' );
		}
		
		return $this->title;
	}

	// Increment Number (track number)
	function increment_number() {
		return $this->number++;
	}

	// Get Audio Attachements
	function get_audio_attachments() {
		$args = array(
		    'post_parent'    => $this->id,
		    'post_type'      => 'attachment',
		    'post_mime_type' => 'audio',
		    'post_status'    => null,
		    'numberposts'    => -1,
		    'order'          => 'ASC',
		    'orderby'        => 'menu_order'
		);

		return get_children( $args );
	}

	// Construct Track 
	function track( $attachment = false ) {
		$track = array( 
			'number' => absint( $this->number ),
			'title'  => esc_attr( strip_tags( $this->get_title( $attachment ) ) ),
			'artist' => esc_attr( strip_tags( $this->get_artist( $attachment ) ) ),
			'album'  => esc_attr( strip_tags( $this->get_album( $attachment ) ) ),
			'poster' => esc_url( $this->get_artwork( $attachment ) ),
			'mp3'    => esc_url( $this->get_src( $attachment ) )
		);

		return $track;
	}
	
	// Contruct tracks (tracks)
	function tracks() {
		$attachments = $this->get_audio_attachments();
		
		if ( $attachments ) :
		    foreach ( $attachments as $this->attachment ) : 
		    	$this->increment_number();
		    	$this->tracks[] = $this->track( $this->attachment );
		    endforeach;
		else : 
		    $this->tracks[] = $this->track();
		endif;
		
		return $this->tracks;
	}
}

?>