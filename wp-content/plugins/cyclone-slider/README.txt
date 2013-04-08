=== Cyclone Slider ===
Contributors: kosinix
Donate link: http://www.codefleet.net/donate
Tags: slider, slideshow, jquery, cycle, jquery cycle, cycle plugin, responsive, multilingual, custom post
Requires at least: 3.3.2
Tested up to: 3.5
Stable tag: 1.3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create amazing slideshows with ease. Built for both developers and non-developers.

== Description ==

Cyclone Slider follows the keep it simple mantra. It leverages wordpress' built-in features. It uses custom post for the slideshow, custom fields to store settings, and media uploader for the images. Its simple yet flexible.

= Features: =
* Uses jQuery Cycle plugin with 25+ transitions
* Very easy to use interface!
* Unlimited slideshows
* Unique settings for each slideshow
* Shortcode for displaying slideshows anywhere in your site
* A simple template system for developers to easily customize the slideshow
* Works with qTranslate. You can place `[:en]English Text[:de]German Text` in a slideshow's title and description fields.
* Ability to import images from NextGEN (NextGEN must be installed and active)
* It's totally FREE!


= Homepage =
Learn more about [Cyclone Slider](http://www.codefleet.net/cyclone-slider/)

= Cyclone Slider 2 = 
Checkout [Cyclone Slider 2](http://wordpress.org/extend/plugins/cyclone-slider-2/), a slideshow for responsive websites. It was forked from Cyclone Slider to accomodate the changes in jQuery Cycle 2 without breaking the older templates of Cyclone Slider. 


== Installation ==

1. Upload the `cyclone-slider` folder to the `/wp-content/plugins/` folder
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Start adding slideshows in 'Cyclone Slider' menu in WordPress
1. You can then use a shortcode to display your slideshow. Example: `[cycloneslider id ="my-slideshow"]`
1. Function do_shortcode can be used inside template files. Example: `<?php echo do_shortcode('[cycloneslider id ="my-slideshow"]'); ?>`
1. Checkout the documentation at [Cyclone Slider's home](http://www.codefleet.net/cyclone-slider/)


== Frequently Asked Questions ==

= Why is my slider not working? =
Check for javascript errors in your page. This is the most common cause of the slider not running.
`cycle not a function` error - most probably you have double jquery (jquery.js) included from improperly coded plugins. Remove the duplicate jquery or deactivate the plugin causing the double jquery include.

= Why is there is an extra slide that I didn't add? = 
Most probably its wordpress adding paragpraphs on line breaks next to the slides therefore adding a blank `<p>` slide. You can try adding this to functions.php:
`remove_filter('the_content', 'wpautop');`

= How to display it in post/page? =
Use the shortcode `[cycloneslider id ="my-slideshow"]`

= How to display it inside template files (header.php, index.php, page.php, etc.)? =
Use `<?php echo do_shortcode('[cycloneslider id ="my-slideshow"]'); ?>`

= What are the shortcode options? =
`[cycloneslider id ="my-slideshow" fx="fade" timeout="5000" speed="1000" width="500" height="300" show_prev_next="true" show_nav="true"]`

= How can I use templates? =
`[cycloneslider id ="my-slideshow" template="custom-name"]` 

= Where do I add my own templates? =
Inside your theme create a folder named "cycloneslider" (as of version 1.0.5). Add your templates inside.

== Screenshots ==

1. All Slideshow Screen
2. Slideshow Editing Screen
3. Slideshow in Action

== Changelog ==

= 1.3.3 - 2012-12-18 = 
* Bug fix. Preserve PNG transparency on resize.

= 1.3.2 - 2012-12-11 = 
* Added gettext calls for qtranslate to work in title and description fields. You can now place [:en]English Text[:de]German Text in these fields.

= 1.3.1 - 2012-12-03 = 
* Removed width and height attributes from slide images in responsive template

= 1.3.0 - 2012-11-28 =
Code now based from Cyclone Slider 2 codebase. The improvements are:

* Cleaner and faster user interface that works well even in IE7
* Ability to import images from NextGEN
* Option to pause slide on hover
* Option to open slide links in new tab
* Improved function cycloneslider_thumb
* Improved codes in templates. Please check your custom templates to match the changes in the template system. Old templates will still work but may not benefit from the newly added options
* Renamed jquery.cookie.js to jquery-cookie.js to prevent the bug in some servers where a file named jquery.cookie.js is blocked and not loaded

= 1.2.2 - 2012-10-05 = 
* Fix error for CSS not loading for WPMU when there is already GET var in the url. Eg. http://www.url.com?lang=en

= 1.2.1 - 2012-09-25 = 
* Added check for undefined jquery cookie plugin

= 1.2.0 - 2012-09-05 = 
* Template selection via admin
* Child theme support. You can now add the `cycloneslider` templates folder inside a child theme. tnx Geoff
* Bug fix for template url/path missing a slash. tnx Chris
* German translation
* Remove unwanted whitespaces on templates at runtime to remove unwanted `<p>` tags from being added by wp

= 1.1.1 - 2012-09-02 = 
* Fix bug on function cycloneslider_thumb
* Added improved thumbnails template

= 1.1.0 - 2012-08-31 = 
* New templates
* New and improved template system

= 1.0.6 - 2012-08-26 = 
* Bug fix for titles and descriptions out of sync after deleting a slide

= 1.0.5 - 2012-08-24 = 
* Caching for thumbnails
* Autodetect "cycloneslider" folder inside current active theme 

= 1.0.4 - 2012-08-18 = 
* Added default values when adding a new slideshow to help users.
* Added visual cues when adding new slides. 
* Hide preview in admin img when its src is blank to hide the img not found on IE and other browsers. Show only when src is given.

= 1.0.3 =
* Bug fix if shortcode attributes are set to zero eg. timeout="0". Change use of empty() to === to differentiate null from integer zero or blank string

= 1.0.2 =
* Prefixed meta keys with underscore _ to hide from wp custom field metabox. Existing slider data will be silently migrated into this new meta keys.
* Thumbnail function added. 


== Upgrade Notice ==

= 1.3.3 - 2012-12-18 = 
* Bug fix. Preserve PNG transparency on resize.

= 1.3.2 = 
* Added gettext calls for qtranslate to work in title and description fields. You can now place [:en]English Text[:de]German Text in these fields.

= 1.3.1 = 
* Removed width and height attributes from slide images in responsive template

= 1.3.0 = 
Code now based from Cyclone Slider 2 codebase. The improvements are:

* Cleaner and faster user interface that works well even in IE7
* Ability to import images from NextGEN
* Option to pause slide on hover
* Option to open slide links in new tab
* Improved function cycloneslider_thumb
* Improved codes in templates. Please check your custom templates to match the changes in the template system. Old templates will still work but may not benefit from the newly added options
* Renamed jquery.cookie.js to jquery-cookie.js to prevent the bug in some servers where a file named jquery.cookie.js is blocked and not loaded

= 1.2.1 = 
* Bug fix

= 1.2.1 = 
* Minor bug fix

= 1.2.0 = 
* Always backup your templates before hitting update. Or better (and recommended), move it inside your theme at yourtheme/cycloneslider.

= 1.1.1 = 
* Fix bug on function cycloneslider_thumb
* Added improved thumbnails template

= 1.1.0 = 
* Do not upgrade if you have made custom changes to the templates. New template is incompatible with v1.0.6 and below

= 1.0.6 =
* Bug fix for titles and descriptions out of sync after deleting a slide

= 1.0.5 =
* Backend enhancements

= 1.0.4 =
* UI enhancements

= 1.0.3 =
* Bug fixed

= 1.0.2 =
* Template thumbnails added. 