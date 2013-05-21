=== Audio Playlist Manager with Autoresume===

Contributors: toughride

Donate link: http://www.toughride.com/wordpress/how-to-embed-mp3-to-a-website-and-play-continuously-without-interruption-across-pages/

Tags: audio player, playlist, media, podcast, player, audio, autoresume, continuous playback, boutell, xspf player, embed mp3

Requires at least: 2.8.4

Tested up to: 3.0.1

Stable tag: 2.2.3



Audio Playlist Manager with autoresume has cool features for embedding mp3 audio into posts or templates. This plugin has the option to chose 'autoresume' for continuous playback across pageloads, with only a pause between pages.



== Description ==



Audio Playlist Manager with autoresume has cool features for embedding mp3 audio into posts or templates. This plugin has the option to chose 'autoresume' for continuous playback across pageloads, with only a pause between pages.



Features include:



1. Embed single/multiple audio file(s) on a post page or template

1. Embed single/multiple audio playlist(s) on a post page or template

1. Build your own XSPF compatible player and link our XML to it

1. Continuous playback option

1. Boutell XSPF player is the default flash player



There are customizable short code that can be pasted into any page / post, as well as code to embed into your template.



If you are looking to embed a playlist on to your page, you can use the following short code.



using the short code `[ti_audio]` by itself  will attempt to play playlist #1, which may or may not exist. It's always preferable to use a named Playlist when calling the player or to set the id.

	



Plays playlist with name "Name of Playlist"  (case sensitive) 

`[ti_audio name="Name of Playlist"]`



Plays playlist #1

`[ti_audio id="1"]`



Uses the swf located at this location, rather than the default.

Your root folder must contain a crossdomain.xml file allowing

another domain's swf access to XML data.  Also passed is the

name of the player and the swf's width and height values.

`[ti_audio skin="/player/xspf_player_custom.swf" width="260" height="315"]`



In addition, you can also change the following attributes of the player (defaults shown):

 

Sets player to begin playing on load. Default is off, 0.

`autoplay="0"`



Sets player for continuous playback, fresh page-load will only pause the player for moments (given the player resides in a common place sucha as sidebar or footer). Default is off, 0.

`autoresume="0"`



 

Sets player to begin loading assets before the user clicks anything. Default is on, 1.

`autoload="1"`

 

Sets player to repeat once it reaches the end of the playlist. Default is off, 0.

`repeat="0"`

 

URL of the XSPF swf to use for display. Uses default player unless specified.

`skin="xspf_player.swf"`

 

Set if the skin attribute points to a SWF of different dimensions.

`width="400"`

`height="170"`

 

Set default volume level (in percent)

`volume="50"`

 

Set the playlist to play in random order

`randomize="1"`



Single Audio Track:



If you are looking to embed a single file, use the following short code.



Plays audio file with id of 1

`[ti_audio media='201']`





Plays single audio file, set to auto play, repeat and volume at 60%

`[ti_audio media='201' autoplay="1" repeat="1" volume="60"]`



Templates:



You can embed the audio player into any WordPress template.  Much like the short code examples above, you can customize the values within your own templates. Here are all of the fields that you can specify should you choose. Omitting a field will set it to the plugin’s default values.



`<? if (function_exists ("ti_apm_print_player")) {

   print ti_apm_print_player (array(

    "name" => "Name of Playlist",

    "skin" => "/player/xspf_player_custom.swf",

    "autoplay" => "0",

    "repeat" => "0",

    "width" => "400",

    "height" => "170"

    )); 

} ?>`






To play a single audio file within your template, specify the following:



`<? if (function_exists ("ti_apm_print_player")) {

    ti_apm_print_player (array(

    "media" => "3"

    )); 

} ?>`



Inspiration and the story **[Audio Playlist Manager with Autoresume](http://www.toughride.com/wordpress/how-to-embed-mp3-to-a-website-and-play-continuously-without-interruption-across-pages/)** page.



== Changelog ==



All changes and modifications below were from the tierrainnovation and originally implemented on the 'Tierra Audio Playlist Manager' plugin. These changes are inherited by this plugin too.


= 2.2.2 = 

Bug fix.


= 2.2.1 = 



Made autoload playlist regardless of the 'autoplay' status



= 2.2 = 



Fixed widget randomize bug

Fixed syntax error on certain browsers with output



= 2.1 = 



Fixed RSS 'array' bug introduced with WP 3.0



= 2.0 = 



Added widget support

Added notice on plugin page about max_file_size limitations

Fixed loading bug upon activation in WP 3.0.1

Fixed plugin to work correctly in WP 3.0.1

Fixed rendering bug on file upload size limit (see add notice)



= 1.1.0 = 



Added "randomize" to playlist shortcode for default player

Added loading indicator to default player

Fixed bug in player causing multiple instances of track to play

Changed preview to use text area for shortcode selection



= 1.0.9 =



Fixed bug in admin playlist display reported to affect IE users



= 1.0.8 =



Fixed bug in player that could lead to simultaneous sound playing

Added logo to admin page.



= 1.0.7 =



Fixed glitches in Admin UI lightbox.  Updated ti-player.swf to better accomodate long album, artist and track names.  Removed visual glitch when ti-player.swf is launched without autoplay (Player would expand and shrink upon load).  Fixed error thrown when selecting tracks from right-click menu while player was paused



= 1.0.6 =



Changed Roles & Capabilities user level code to check against edit_others_posts per some users permissions issues.



= 1.0.5 =



Fixed the template embed code to render the player inside a theme.



= 1.0.4 =



Changed embed code to increase compatibility with older XSPF players



= 1.0.3 =



Fixed issue where users who were not administators could not access the plugin page.  You can now access if you are an Editor or Administrator.  If you are an Editor, you will see the link to the plugin page under the "Tools" menu.  If you are an "Administrator" you will see the link to the plugin page under both "Tools" and "Settings."  Also fixed an HTML bug on the edit asset screen.



== Installation ==



1. Upload `tierra-audio-with-autoresume` to the `/wp-content/plugins/` directory

1. Activate the plugin through the 'Plugins' menu in WordPress

1. Select 'Audio Playlist Manager' from the 'Settings' menu and configure your options.



You can additionally view a **[recorded screencast](http://tierra-innovation.com/wordpress-cms/plugins/audio-playlist-manager/)** for further configuration options.



== Screenshots ==



**[View Screen Shots](http://www.toughride.com/wordpress/how-to-embed-mp3-to-a-website-and-play-continuously-without-interruption-across-pages/)**



== Frequently Asked Questions ==



Tierrainnovation has an extensive **[FAQ List](http://tierra-innovation.com/wordpress-cms/faq/)** for all of their plugins.  Please check it for your question, and if you cannot locate a solution, feel free to **[contact us](http://www.toughride.com/contact-me/)**.