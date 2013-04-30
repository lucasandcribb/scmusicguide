// -------- CONTROL PANEL SHOW/HIDE
    jQuery(document).ready(function(){
		jQuery('.sps_options').slideUp();
		
		jQuery('.sps_section h3').click(function(){		
			if(jQuery(this).parent().next('.sps_options').css('display')=='none')
				{	jQuery(this).removeClass('inactive');
					jQuery(this).addClass('active');
					jQuery(this).children('img').removeClass('inactive');
					jQuery(this).children('img').addClass('active');
					
				}
			else
				{	jQuery(this).removeClass('active');
					jQuery(this).addClass('inactive');		
					jQuery(this).children('img').removeClass('active');			
					jQuery(this).children('img').addClass('inactive');
				}
				
			jQuery(this).parent().next('.sps_options').slideToggle('slow');	
		});

// -------- NOTIFICATION
			jQuery("#notifynovalidimg").hide("slow");

			jQuery("#upload_image").change(function() {
				if (jQuery("#upload_image").val().length > 0 ) {
					IsValidImageUrl(jQuery("#upload_image").val());} 
					else if (jQuery("#upload_image").val().length <= 0 ) {
						jQuery("#imgpreviewbox").hide("slow");
						jQuery("#notifynovalidimg").hide("slow");
						jQuery(".deleteimage").hide("fast");
						} 
				});
	
// -------- COPY IMAGE URL 	
   jQuery(".addmed a").bind("click", function() {
       var msgclk = jQuery(this).attr( 'rel' );

window.send_to_editor = function(html) {

if (msgclk == 'image'){
	
	imgurl = jQuery('img',html).attr('src');
	jQuery('#upload_image').val(imgurl);
	
	if (imgurl.length > 0 ) {
		tb_remove();
		IsValidImageUrl(imgurl);
		return false;
		};}
	
	else if(msgclk == 'audio'){
		fileurl = jQuery(html).attr('href');
		jQuery('#upload_audio').val(fileurl);
		
	if (fileurl.length > 0 ) {
		tb_remove();
		IsValidAuUrl(fileurl);
		return false;
		};}

}
    });	
	
// -------- RESIZE DONATE DIALOX BOX	
	jQuery('#easymediadonatebtn').on("click", function () {
		
			emg_H = 200;
			emg_W = 400;
			
		setTimeout(function() {
			tb_show( 'Donate Us', '#TB_inline?height='+emg_H+'&width='+emg_W+'&inlineId=easymedia_donate' );
						
			jQuery('#TB_window').css("height", emg_H);
			jQuery('#TB_window').css("width", emg_W);
			jQuery('#TB_window').css("top", ((jQuery(window).height() - emg_H) / 5) + 'px');
			jQuery('#TB_window').css("left", ((jQuery(window).width() - emg_W) / 4) + 'px');
			jQuery('#TB_window').css("margin-top", ((jQuery(window).height() - emg_H) / 5) + 'px');
			jQuery('#TB_window').css("margin-left", ((jQuery(window).width() - emg_W) / 4) + 'px');
			jQuery("#TB_window").css('height','auto');
			jQuery("#TB_ajaxContent").css('height','auto');				
	
		}, 300);	
	});	

// -------- SHOW/HIDE MEDIA
			jQuery('#emediaimagediv').hide();
			jQuery('#easmedia_metaboxmediavideo').hide();
			jQuery('#easmedia_metaboxmediaaudio').hide();
			jQuery('#easmedia_metabox_media_desc').hide();
			
			jQuery("#easmedia_metabox_media_type").change(function(){
				
				var sctyp = document.getElementById("easmedia_metabox_media_type").selectedIndex;
				
				if (sctyp == '1'){  // Single Image
					jQuery("#easmedia_metaboxmediatypeselect").css({marginBottom: "20px"});
					jQuery("#emediaimagediv").show("slow");
					jQuery('#easmedia_metabox_media_desc').show("slow");
					jQuery("#easmedia_metaboxmediavideo").hide("slow");
					jQuery("#medsingimgtut").show();
					jQuery('.easmedia_metabox_media_image_opt1').show();
					jQuery('#emediaimagediv .hndle span').text("Select Image");
					jQuery('#easmedia_metaboxmediaaudio').hide("slow");}			
												
				else if (sctyp == '2'){ // Video
					jQuery("#easmedia_metaboxmediatypeselect").css({marginBottom: "20px"});
					jQuery("#emediaimagediv").show("slow");
					jQuery('#easmedia_metabox_media_desc').show("slow");
					jQuery("#easmedia_metaboxmediavideo").show("slow");
					jQuery('#easmedia_metaboxmedialink').hide("slow");
					jQuery("#medsingimgtut").hide();				
					jQuery('#emediaimagediv .hndle span').text("Select the Cover Video");					
					jQuery('#easmedia_metaboxmediagallery').hide("slow");	
					jQuery('.easmedia_metabox_media_image_opt1').hide();
									
					jQuery('#easmedia_metaboxmediaaudio').hide("slow");}	
					
				else if (sctyp == '3'){ // Audio
					jQuery("#easmedia_metaboxmediatypeselect").css({marginBottom: "20px"});
					jQuery("#emediaimagediv").show("slow");
					jQuery('#easmedia_metabox_media_desc').show("slow");
					jQuery('#easmedia_metaboxmediaaudio').show("slow");			
					jQuery("#easmedia_metaboxmediavideo").hide("slow");
					jQuery("#medsingimgtut").hide();
					jQuery('#emediaimagediv .hndle span').text("Select the Cover Audio");					
					jQuery('#easmedia_metaboxmediagallery').hide("slow");
					jQuery('.easmedia_metabox_media_image_opt1').hide();				
					jQuery('#easmedia_metaboxmedialink').hide("slow");}												
					
				else {
					jQuery('#emediaimagediv .hndle span').text("Select Image");
					jQuery("#emediaimagediv").hide("slow");
					jQuery("#easmedia_metaboxmediavideo").hide("slow");
					jQuery('#easmedia_metaboxmediaaudio').hide("slow");
					jQuery('#easmedia_metabox_media_desc').hide("slow");
					jQuery("#easmedia_metaboxmediatypeselect").css({marginBottom: "170px"});					
		    		jQuery('#emgvideopreview').hide("fast"); }						
				});
					jQuery('#easmedia_metabox_media_type').change();
					
});