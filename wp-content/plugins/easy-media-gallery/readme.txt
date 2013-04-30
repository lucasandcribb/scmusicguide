=== Easy Media Gallery ===
Contributors: GhozyLab
Donate link: http://ghozylab.com/donate
Tags: gallery, image gallery, image slider, slider, plugin, admin, widget, portfolio, video gallery, media gallery, google maps plugin, audio gallery, gallery widget, wordpress portfolio plugin, post, admin, posts, sidebar, twitter, google, comments, images, page, links, wordpress gallery, wordpress portfolio, best gallery plugin, best portfolio plugin, reverbnation embed, mp4, embed mp4, embed vimeo, embed youtube, embed dailymotion, embed metacafe, soundcloud embed, embed soundcloud, image, images
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 1.1.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin enables you to create an awesome portfolio or gallery. Over 20,000 WordPress sites are already using Easy Media Gallery. Is Yours?


== Description ==

Easy Media Gallery is a wordpress plugin designed to display portfolios and various media support including gallery sets, single image, google maps, video, audio and link with very ease and elegant.

= Live Demos =

* [DEMO 1](http://ghozylab.com/sample-1)
* [DEMO 2](http://ghozylab.com/sample-2)
* [DEMO 3](http://ghozylab.com/sample-3)
* [DEMO 4](http://ghozylab.com/sample-4)

= Features =

Easy Media Gallery supports a wide range of media formats, and an even wider range of social media sites. Simply link to any image, flash video, or popular website, and the media will be automatically loaded into the overlay. Easy Media Gallery can be used to embed videos from :

* YouTube
* YouTube Playlist
* Vimeo
* Veoh
* DailyMotion
* MetaCafe
* YouKu
* Facebook
* Flickr video
* Google video
* Megavideo
* Quietube + Youtube
* Quietube + Vimeo
* Revver
* RuTube
* Tudou
* MP3, MP4, MOV, M4V, M4A, AIFF (<em>hosted videos/audio</em>)

= Full media support =
<p>Easy Media Gallery satisfy all your needs letting you create different types of portfolio. Each item can be:</p> 

* An image
* An image gallery (<em>Pro Version</em>)
* A video
* An mp3 player
* Embed from Reverbnation or Soundcloud (<em>Pro Version</em>)
* Google Maps (<em>Pro Version</em>)
* A link (<em>Pro Version</em>)

It is a very customizable plugin that allow you to set display whatever you want like adjust colors, positions, media sizes, hover effect and much more with one easy control panel. That easy control panel for experts it would save your time, and for you who do not have more knowledge about website styling, of course this plugin will allow you to manage your website much more easily. 

= Examples =
<p>http://www.youtube.com/watch?v=dXFBNY5t6E8</p>

* You can learn more by watching the video from [our youtube channel](http://www.youtube.com/GhozyLab).

= Upgrade to Easy Media Gallery Pro =

Take your media to the next level with [Easy Media Gallery Pro](http://ghozylab.com/order), which gives you additional features such as:

* No coding, the plugin takes care of everything
* Create unlimited number of media
* Media are built on-the-fly as you enter and select options
* Works with all modern browsers, degrades gracefully for others
* Fully CSS3 compliant with text shadowing, box shadowing, gradients, etc
* Color picker for unlimited color combinations
* See your media on different theme and more.
* Powerfull control panel and Shortcode Manager make getting started super easy
* 24/7 Technical Support


== Installation ==

= For automatic installation: =

The simplest way to install is to click on 'Plugins' then 'Add' and type 'Easy Media Gallery' in the search field.

= For manual installation 1: =

1. Login to your website and go to the Plugins section of your admin panel.
1. Click the Add New button.
1. Under Install Plugins, click the Upload link.
1. Select the plugin zip file (easy-media-gallery.zip) from your computer then click the Install Now button.
1. You should see a message stating that the plugin was installed successfully.
1. Click the Activate Plugin link.

= For manual installation 2: =

1. You should have access to the server where WordPress is installed. If you don't, see your system administrator.
1. Copy the plugin zip file (easy-media-gallery.zip) up to your server and unzip it somewhere on the file system.
1. Copy the "easy-media-gallery" folder into the /wp-content/plugins directory of your WordPress installation.
1. Login to your website and go to the Plugins section of your admin panel.
1. Look for "Easy Media Gallery" and click Activate.


== Frequently Asked Questions ==

= Images not showing up =

Sometimes you may face problem that your images are not displaying in the site. We use timthumb script to resize the images. To change permission, you can use a FTP program like FileZilla or you can even use File Manager from your cPanel. We would recommend you use FileZilla to do this task, you can [DOWNLOAD HERE](https://filezilla-project.org/download.php) . Okay, Changing permission is very easy.

1. Firstly you should have FTP account, if you don't have, make one from cPanel.
1. Now login to FTP, using FileZilla and navigate to Easy Media Gallery folder/directory in /wp-content/plugins/easy-media-gallery/includes/class/
1. Make sure there is a folder with name <strong>cache</strong>, If not exist just create new one and right click on <strong>cache</strong> folder and click on Permissions. Type 755 and click on OK. If this still does not work, then try applying 777 permission to cache folder (<em>Not Recommended - Less secure</em>) or you can try to bypass modescurity from .htaccess using <strong>SecFilterEngine Off</strong>. See example below:

`<IfModule mod_security.c>
SecFilterEngine Off
</IfModule>
`

* [VIDEO - How to change cache folder permission from cPanel](http://youtu.be/lYDJ8fM18pc)
* [VIDEO - How to change cache folder permission from FileZilla](http://youtu.be/S_Az2Zg5OLc)

= How do I use the shortcode to my post/page template? =

There are 2 ways to use the shortcode, once you've created your media, you can use them in your website simply using the Easy Media Gallery shortcode wizard on top of each page or post editor.

`[easy-media med="231,233"]`

or you can display it where you want and as you want outside your post/page using wordpress <strong>do_shortcode</strong>. See example below:

`<?php echo do_shortcode('[easy-media med="231,233"]'); ?>`

<strong>Keep in mind:</strong>
We have created a shortcode manager that allow you to put media wherever you like with ease. Please learn more at:

* [Basic Tutorials](http://ghozylab.com/create-media)
* [Youtube Channel](http://www.youtube.com/GhozyLab)


= Is there any documentation with detail for this plugin? =

To make the plugin easy for everyone, the documentation comes with detailed videos explaining each step necessary to setup and use Easy Media Gallery:

* [Easy Media Gallery Installation](http://www.youtube.com/watch?v=PSCYB-N-TEE)
* [Full Tutorial How to Use Easy Media Gallery](http://www.youtube.com/watch?v=LBck-tnVYas)
* [How to Create Google Maps Media Types](http://www.youtube.com/watch?v=PEgfleRf6hg)
* [How to Create Audio (mp3) Media Types](http://www.youtube.com/watch?v=Bsn-CB5Hpbw)
* [How to Create Video (Youtube) Media Types](http://www.youtube.com/watch?v=htxwZw_aPF0)
* [How to Insert Image into Media Description](http://www.youtube.com/watch?v=9cuYyBMKx2k)
* [How to Change Media Columns](http://www.youtube.com/watch?v=56f_C7OXiAE)
* [How to Change Media Border Size and Color](http://www.youtube.com/watch?v=2T73wvt_wOA)
* [How to Publish Easy Media Gallery ( Standard Method )](http://www.youtube.com/watch?v=Z2qwXz7GIRw)
* [How to Publish Easy Media Gallery ( Advance Method )](http://www.youtube.com/watch?v=LMBg0Zv8048)


= How can I get support? =

* We are not able to provide anything other than community based support for Easy Media Gallery Lite. Please consider upgrading to [Easy Media Gallery Professional](http://ghozylab.com/) for support.


= How can I say thanks? =

* Just recommend our plugin to your friends! or
* If you really love Easy Media Gallery, any donation would be appreciated! It helps to continue the development and support of the plugin.
But seriously, I just want to drink coffee for free, so help a developer out. You can use this link [Donate to Easy Media Gallery][easymedia donate].

[easymedia donate]: http://ghozylab.com/donate
            "Donate to Easy Media Gallery"


== Screenshots ==

1. Easy Media Gallery Control Panel
2. Easy Media Gallery Metabox (Gallery)
3. Easy Media Gallery Media List
4. Easy Media Gallery Admin Panel
5. Easy Media Gallery Shortcode Manager
6. Easy Media Gallery Metabox (Audio)
7. Embed music from Soundcloud
8. Embed music from Reverbnation

== Changelog ==

= 1.1.9 =
* Added : admin notify option 
* Fixed : timthumb chmod issue 
* Fixed : IE 8 issue
* Fixed : uninstall issue
* Fixed : dailymotion compatible iPhone, iPad, Android 
* Updated : pro version price
* Many other code clean and optimization
* Fixes for minor issues discovered since 1.1.7

= 1.1.7 =
* Added : Embed Youtube playlist 
* Fixed : jQuery UI (CSS) conflict 
* Fixed : Double post with some themes
* Many other code clean and optimization
* Fixes for minor issues discovered since 1.1.5

= 1.1.5 =
* Added : parsing - parse youtu.be 
* Fixed : overflow issue (chrome)
* Fixed : hover effect with old jQuery version < 1.6.4
* Fixed : jQuery UI (CSS) conflict
* Fixed : Mediabox jQuery Scroll Func 
* Fixed : jQuery conflict with some themes

= 1.1.3 =
* Added function to allow shortcodes on widget
* Added the option to keep data when uninstall/upgrade plugin
* Added the option video autoplay
* Added some help inside the Admin interface for very common questions
* Improved loading for backend javascripts
* Fixes for minor issues discovered since 1.1.1

= 1.1.1 =
* Add Resize thumbnails option
* Removed the use of PHP function getimagesize()
* Fixed: jQuery image preview
* Update: Video tutorial
* Many other code clean and optimization

= 1.1.0 =
* Fixed: PHP warning in the tinymce-dlg.php file
* Fixed: Hover effect not works on several themes
* Fixed: Only display 10 media, although we have determined more than 10. Now you can put unlimited media
* Fixed: Title was given wrong position by CSS
* Fixed: Theme's that set image heights affected the media image dimensions.
* Many other code clean and optimization
* Add Dasboard Share Button

= 1.0.0 =
* This is the launch version. No changes yet.

== Upgrade Notice ==

= 1.1.9 =
New version availabe, update NOW!