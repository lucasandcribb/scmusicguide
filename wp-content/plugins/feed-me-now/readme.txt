=== Feed Me Now ===
Author: steveattwell
Tags: rss
Requires at least: 2.7
Tested up to: 3.3.1
Stable tag: trunk
Contributors: Steven Attwell


== Description ==
Feed Me Now is a Wordpress widget that allows you to display multiple RSS feeds in a single 
listing allowing selection of specific feed items based on a key word search. FeedMeNow uses 
LastRSS to parse RSS feeds with the caching option enabled. Activating the plugin will create a folder 'feedmenow_rsscachefiles' in the root of your Wordpress location. 

<h4>LastRSS Caching</h4>
FeedMeNow uses LastRSS caching option. Activating the plugin will create a folder <em>feedmenow_rsscachefiles</em> in the root of your Wordpress location. If you receive errors regarding the unavailability of the folder or the cache files please manually create the folder with chmod 0777 permissions.
For more information on LastRSS please visit the <a title="here" href="http://lastrss.oslab.net/" target="_blank">LastRSS home page here</a>.


<h3>Settings</h3>
<a name="Settings"></a>
Conveniently widget comes with some handy default settings to give you an idea of how to set the options. If you read the preamble you'll understand that the default key words and feeds are for my favorite soccer team.

Let's explore the default settings some more so that you can easily replace them.
<h3>Title</h3>
The name you want to appear above the RSS feeds in your blog. In this example I will change the title from the default 'feedmenow' to 'BCFC News'
<h3>Display Feed Header Image</h3>
Some RSS feeds come with a header image defined in the feed XML. If you want to see this image then check this. This option only works if the first feed in the <strong>RSS XML Feeds</strong> list has a feed image.
<h3>No news message</h3>
If no news articles are found this message will display.
<h3>Key Words</h3>
This is a comma separated list of the key words that will be used in the search. In our example there are four key word strings; 'Bristol City', 'Robins', 'Ashton Gate' and 'Steve Lansdown'. The search is not case sensitive.
<h3>RSS XML Feeds</h3>
This is a list of RSS feeds locations delimited by a character the default delimiter is the Tilda '~' but you can specify a different delimiter character if you wish.

The the example there are two RSS feeds
<ol>
	<li><em>http://www.skysports.com/rss/0,20514,11688,00.xml</em></li>
	<li><em>http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/rss.xml</em></li>
</ol>
<strong><em>How do I locate an RSS feed?</em></strong> you might ask. Using Sky Sport RSS for an example step one is to search for the location of the feed in Google so , <em>Sky Sports Football RSS</em> returns a number of links. Click on one of them and look for the RSS image. The RSS Feed page will look like a basic listing sometimes with a header image. Below is the example from Sky Sports. On this particular day the first story happens to be about my team, unfortunately we lost. However we can use this example to show that the original feed contained many stories about all English Championship league teams, we're only interested in the stories that hit our key words. The location of the feed is what we would enter into the RSS feeds list in FeedMeNow in this case the feed location is
<h3>http://www.skysports.com/rss/0,20514,11688,00.xml</h3>

As long as the feed URL is standard RSS format feed me now should work :P 

You can add as many RSS feed locations as you like in in the RSS XML Feeds text box.


== Installation ==
<a name="Installation"></a>
<ol>
	<li>Upload feed me now to the /wp-content/plugins/ directory</li>
	<li>Activate the plugin through the Plugins menu in WordPress</li>
	<li>From Appearance->Widgets in the menu add the <strong>Feed Me Now</strong> widget to a sidebar</li>
	<li>Configure the options</li>
</ol>
== Frequently Asked Questions == 

Q. Does Feed me now work with Feedburner format RSS?
A. Feed Me Now will work with certain Feedburner content if you add "?format=xml" to the end of the Feedburner Url
For example URL http://feeds.feedburner.com/VanceLucas
In Feed Me Now add the URL as http://feeds.feedburner.com/VanceLucas?format=xml

== Download ==
<a title="Download FeedMeNow" href="http://creativedesignsolutionsnyc.com/downloads/fmn_1_0_0.zip">Download FeedMeNow</a>

== Plugin Home Page ==
http://creativedesignsolutionsnyc.com/feed-me-now/

== Author URI ==  
www.creativedesignsolutionsnyc.com

== Changelog ==
= 1.0 = 03/01/12
* The initial release