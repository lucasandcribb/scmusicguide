=== Facebook Events ===
Contributors:  ModernTribe, roblagatta, codearachnid, PaulHughes01, peterchester, reid.peifer, shane.pearlman
Tags: modern tribe, tribe, facebook, events, calendar, recurring, event, venue, import, importer, api, dates, date, plugin, posts, conference, workshop, concert, meeting, seminar, summit
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QA7QZM4CNQ342
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 1.0.5

Import events into The Events Calendar from a Facebook organization or page.

== Description ==

Import individual Facebook events into <a href="http://wordpress.org/extend/plugins/the-events-calendar/" target="_blank">The Events Calendar</a>, or choose to bulk import them from Facebook user(s) or page(s) that you define.

Make sure to get the free <a href="http://wordpress.org/extend/plugins/the-events-calendar/" target="_blank">The Events Calendar</a> plugin first.

== Screenshots ==

1. Options page
2. Import page

== Installation ==

= Install =

1. Ensure The Events Calendar plugin 2.0.7 or higher is installed and configured - http://wordpress.org/extend/plugins/the-events-calendar/.
2. Install the plugin like you would any other plugin.

= Activate =

1. Activate from the plugins list as you would any other plugin.
2. Navigate to Settings -> The Events Calendar section within WordPress and follow the instructions on the "Facebook" tab.
3. Or, simply visit the Import FB Events section under Events on the left-hand admin menu to start importing individual events.

= Requirements =

* PHP 5.2 or above
* WordPress 3.3 or above
* The Events Calendar 2.0.11 or above

== Frequently Asked Questions ==

1. Q: What is the Facebook App ID and App Secret, and where do I find them?

A: Facebook requires a Facebook App ID and App Secret to access data via the Facebook graph API in order to import your events from Facebook. Provided with the plugin is a default set of API credentials, however we encourage you to create your own Facebook App and enter your credentials on the settings page. For more, please see this tutorial: http://tri.be/how-to-create-a-facebook-app-id/.

2. Q: Where can I find a user's or page's username or ID?

A user's username or ID can be found in the URL used to access his or her profile. For example https://www.facebook.com/zuck is the URL used to access Mark Zuckerberg's profile. His username is 'zuck'. If a user doesn't have a username, you will see his or her ID (numerical)in the URL for his profile. The same concept applies to pages, you can find their username or ID in their URL. Modern Tribe's Page is https://www.facebook.com/ModernTribeInc and the username is 'ModernTribeInc'. You can also find the ID of a user or page by visiting the Graph API. For example, to find Modern Tribe's ID, visit https://graph.facebook.com/ModernTribeInc. You will get a json response with information about the user or page. The first result should be the ID.

3. Q: Where can I find an event's Facebook ID?

A: You can determine an event's Facebook ID by looking at the URL of the event. For example, the ID of this event: https://www.facebook.com/events/12345689 would be 123456789

4. Q: Where can I get support if I encounter problems or bugs?

A: Please visit the Facebook Events support forum at <a href="http://tri.be/support/forums/forum/events/facebook-importer/" target="_blank">http://tri.be/support/forums/forum/events/facebook-importer/.</a>

== Documentation ==

Looking for filters & hooks related to Facebook Events? Start <a href="http://tri.be/support/documentation-facebook-importer/facebook-importer-filters?ref=tec-readme" target="_blank">http://tri.be/support/documentation-facebook-importer/facebook-importer-filters/.</a>Otherwise, all of our additional documentation can be found at <a href="http://tri.be/support/documentation?ref=tec-readme" target="_blank">http://tri.be/support/documentation</a>

For support, please see question #4 above. If you have any questions about the core The Events Calendar plugin, please take look at the dedicated forum here on WordPress.org at <a href="http://wordpress.org/tags/the-events-calendar">http://wordpress.org/tags/the-events-calendar</a>. Please search before opening a new thread.

If you want, you can read the <a href="http://tri.be/support/forums/?ref=tec-readme">Modern Tribe PRO support forums</a> in case that helps, although you won't be able to post a message, unless you have purchase a PRO license.

== Contributors ==

The plugin is produced by <a href="http://tri.be/?ref=tec-readme">Modern Tribe Inc</a>.

= Current Contributors =

* <a href="http://profiles.wordpress.org/users/paulhughes01">Paul Hughes</a>
* <a href="http://profiles.wordpress.org/users/roblagatta">Rob La Gatta</a>
* <a href="http://profiles.wordpress.org/users/codearachnid">Timothy Wood</a>
* <a href="http://profiles.wordpress.org/users/leahkoerper">Leah Koerper</a>
* <a href="http://profiles.wordpress.org/users/peterchester">Peter Chester</a>
* <a href="http://profiles.wordpress.org/users/reid.peifer">Reid Peifer</a>
* <a href="http://profiles.wordpress.org/users/shane.pearlman">Shane Pearlman</a>

= Past Contributors =

* <a href="http://profiles.wordpress.org/users/jkudish">Joachim Kudish</a>

= Translators =

* German from Mark Galliath
* Czech from Petr Bastan
* Polish from Marek Kosinski

== Add-Ons ==

You can see a full list of Modern Tribe Products at <a href="http://tri.be/shop/?ref=tec-readme" target="_blank">http://tri.be/shop/</a>

Our Free Plugins:

* <a href="http://wordpress.org/extend/plugins/the-events-calendar/" target="_blank">The Events Calendar</a>
* <a href="http://wordpress.org/extend/plugins/advanced-post-manager/" target="_blank">Advanced Post Manager</a>

Our Premium Plugins:

* <a href="http://tri.be/wordpress-events-calendar-pro/?ref=tec-readme" target="_blank">The Events Calendar PRO</a>
* <a href="http://tri.be/shop/wordpress-eventbrite-tickets/?ref=tec-readme" target="_blank">The Events Calendar: Eventbrite Tickets</a>
* <a href="http://tri.be/shop/wordpress-community-events/?ref=tec-readme" target="_blank">The Events Calendar: Community Events</a>
* <a href="http://tri.be/shop/wootickets/?ref=tec-readme" target="_blank">The Events Calendar: WooTickets</a>
* <a href="http://tri.be/shop/conference-manager/?ref=tec-readme" target="_blank">The Events Calendar: Conference Manager (coming later in 2012)</a>


== Changelog ==

= 1.0.5 =

*Small features, UX and Content Tweaks:*

* Incorporated new Polish language files, courtesy of Marek Kosinski.

*Bug Fixes:*

* International time zones no longer converting to local times by default.
* Various improvements to handling of imports from one time zone into another one.
* Fixed an issue where images were failing to import or generating an error for certain users.
* Improved how plugin addresses venue imports to minimize duplicates (though note: Facebook's API is limited in such a way that we cannot cut out duplicate venues 100% at this time)
* Organizer phone number no longer displays as Facebook page's hovercard ID.
* Fixed an issue with unreachable code in Tribe_FB_Importer::json_retrieve().
* Various improvements & enhancements to improve integration with the forthcoming The Events Calendar 3.0 release.

= 1.0.4 = 

Various bug fixes.

= 1.0.3 =

*Small features, UX and Content Tweaks:*

* Incorporated updated German translation files, courtesy of Mark Galliath.

*Bug Fixes:*

* Fixed an issue impacting some users (due to a recent change in the Facebook API) where attempting to import Facebook events yielded an error.

= 1.0.2 =

*Small features, UX and Content Tweaks:*

* Events that have passed no longer appear on the list of importable Facebook Events.
* Photos that are attached to Facebook Events are now carried over and set as featured image on your WordPress event.
* Plugin now provides written confirmation of how many events were imported with each manual import.
* Incorporated new German translation files, courtesy of Mark Galliath.
* Incorporated new Czech translation files, courtesy of Petr Bastan.

*Bug Fixes:*

* Deleted events no longer continue to be re-imported when auto import is enabled. 
* Facebook user IDs with dashes are now accepted across the board.
* Fixed some untranslatable strings found in the 1.0.1 POT file.

= 1.0.1 =

*Small features, UX and Content Tweaks:*

* Integration with Presstrends (<a href="http://www.presstrends.io/">http://www.presstrends.io/</a>).

*Bug Fixes:*

* Removed unclear/confusing message warning message regarding the need for plugin consistency and added clearer warnings with appropriate links when plugins or add-ons are out date.

= 1.0 =

* Initial release