<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

if ( isset( $_POST['id'] ) && !empty( $_POST['id'] ) ) {
ajax_req_handle( $_POST['id'] );
}

else {
}

function ajax_req_handle( $id ) {
	
	global $post;
	
	$boxmediattl = get_post_meta( $id, 'easmedia_metabox_title', true );
	$boxmediasbttl = get_post_meta( $id, 'easmedia_metabox_sub_title', true );
	$imgsrc = get_post_meta( $id, 'easmedia_metabox_img', true );
	$mediatype = get_post_meta( $id, 'easmedia_metabox_media_type', true );
	$domname = preg_replace( '/^www\./','',$_SERVER['SERVER_NAME'] );
		
	switch ( $mediatype ) {
		case 'Single Image':
		$boxlink = $imgsrc;
	        break;		
			
		case 'Video':
		$boxlink = get_post_meta( $id, 'easmedia_metabox_media_video', true );
	        break;
			
		case 'Audio':
		$boxlink = get_post_meta( $id, 'easmedia_metabox_media_audio', true );
	        break;			
					
	}
	
	if ( $boxmediasbttl =='' ) {$boxmediasbttl = 'by '. $domname;}
	if ( $boxmediattl == '' && get_the_title( $id ) == '' ) {$boxmediattl = 'Media';}
	else if ( $boxmediattl == '' && get_the_title( $id ) != '' ) {$boxmediattl = get_the_title( $id );}	
	
$therest = array( $boxmediattl,$boxmediasbttl );
echo json_encode( $therest );
exit;
}

?>