=== Plugin Name ===
Contributors: eyn
Donate link: http://www.channel-ai.com/blog/donate.php?plugin=star-rating-for-reviews
Tags: star, rating, review
Requires at least: 2.0
Tested up to: 2.3
Stable tag: 0.4

Insert inline rating stars within your posts based on the score you assign, supports outputting list of reviews sorted by date, score or post title.

== Description ==

Star Rating for Reviews is a simple WordPress plugin that inserts pretty rating stars based on the score you assign using intuitive, inline [rating:] tags. It can also calculate and output overall ratings for you based on all previous scores you have assigned, useful for reviews that have multiple categories or an album review where each track is assigned a score.

This plugin supports storing rating data into your WordPress database. These data can then be retrieved by plugin functions to output a list of reviews, sortable by date, post title or rating scores. Random reviews function and single post function (to be used in WordPress loop) are also provided, see Usage section for detailed description of these functions.

Features:

* uses simple, intuitive tags to generate kawaii inline rating stars for your posts
* supports versatile rating systems
* supports text only output for RSS
* automatically calculates and displays overall ratings, if desired
* supports storing rating scores automatically into database *
* supports outputting list of reviews sortable by date, post title or rating scores *
* supports widget-like, sortable table of reviews *
* supports custom star images
* supports custom prefixes and suffixes for your own CSS class
* supports globally forced star count for consistency
* uses as many stars as you want! **
* standards compliant: valid XHTML

== Installation ==

1. Download and extract the “star-rating-for-reviews” folder
1. Upload the “star-rating-for-reviews” folder to your WordPress plugin directory, usually “wp-content/plugins”
1. Activate the plugin in your WordPress admin panel

== Frequently Asked Questions ==

= How can I list all reviews I have written on pages? =

Use sr_listreviews() function. See functions documentation for more details.

= Is it possible to output top reviews based on categories? =

Not at this time due to the recent changes of WordPress database schema, I still need time to become familiar with the terms table.
