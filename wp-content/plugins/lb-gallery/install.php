<?php
global $wpdb;
if(!function_exists('wp_get_current_user')) {
    include(ABSPATH . "wp-includes/pluggable.php"); 
}
$user = wp_get_current_user();
$queries = array(
	"
		CREATE TABLE IF NOT EXISTS `{$wpdb->lbgal_category}` (
			`id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`description` text COLLATE utf8_unicode_ci NOT NULL,
			`settings` text COLLATE utf8_unicode_ci NOT NULL,
			`gallery_settings` text COLLATE utf8_unicode_ci NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	",	
	"
		CREATE TABLE IF NOT EXISTS `{$wpdb->lbgal_gallery}` (
			`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`title` varchar(255) NOT NULL,
			`description` text NOT NULL,
			`name` varchar(255) NOT NULL,
			`author` varchar(45) NOT NULL,
			`created` bigint(15) unsigned NOT NULL,
			`featured_image` bigint(11) unsigned NOT NULL,
			`settings` text NOT NULL,
			`shortcode` text NOT NULL,
			`cid` bigint(11) unsigned NOT NULL,
			`ordering` bigint(11) unsigned NOT NULL,
			`published` tinyint(3) unsigned NOT NULL DEFAULT '0',
			`linkto` varchar(255) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
	",
	"
		CREATE TABLE IF NOT EXISTS `{$wpdb->lbgal_image}` (
			`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`title` varchar(255) NOT NULL,
			`description` text NOT NULL,
			`created` bigint(15) unsigned NOT NULL,
			`filename` varchar(255) NOT NULL,
			`thumbname` varchar(255) NOT NULL,
			`status` tinyint(3) unsigned NOT NULL,
			`alt` text NOT NULL,
			`ordering` bigint(20) unsigned NOT NULL,
			`gid` bigint(20) unsigned NOT NULL,
			`params` text NOT NULL,
			`type` varchar(15) NOT NULL DEFAULT 'image',
			`storage` varchar(15) NOT NULL DEFAULT 'local',
			`provider` varchar(45) DEFAULT NULL,
			`author` bigint(11) unsigned NOT NULL,
			`linkto` varchar(255) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
	",	
	"
		CREATE TABLE IF NOT EXISTS `{$wpdb->lbgal_rating}` (
			`id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
			`ref_id` bigint(11) unsigned NOT NULL,
			`user_id` bigint(11) unsigned NOT NULL,
			`rating_value` float NOT NULL,
			`rating_type` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'gallery or image',
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	",
	"
		CREATE TABLE IF NOT EXISTS `{$wpdb->lbgal_setting}` (
			`id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
			`key` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
			`value` text COLLATE utf8_unicode_ci NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	"
);
foreach($queries as $query){	
	$wpdb->query($query);
}
if(!$wpdb->get_var("SELECT count(id) FROM {$wpdb->lbgal_setting}")){	
	$query = "
		INSERT INTO `{$wpdb->lbgal_setting}` (`key`, `value`) 
		VALUES
			('CATEGORY_VIEW_SETTINGS', '{\"gallery_rating\":\"1\",\"gallery_link\":\"1\",\"thumb_cols\":\"3\",\"thumb_rows\":\"3\",\"col_offset\":\"30\",\"row_offset\":\"30\",\"thumb_height\":\"65%\",\"blocks\":{\"top\":{\"title\":\"title\"},\"thumb\":{\"description\":\"description\"},\"bottom\":{\"num_of_photos\":\"num_of_photos\",\"author\":\"author\"}},\"blocks_text\":{\"title\":\"{TITLE}\",\"description\":\"{DESCRIPTION}\",\"author\":\"<strong>Author: <\/strong>{AUTHOR}\",\"date\":\"<strong>Created: <\/strong>{DATE}\",\"num_of_photo\":\"{NUM_OF_PHOTO} photos\",\"link\":\"Read More\",\"rating\":\"{RATING}\"},\"thumb_text_effect\":\"slide-up-in\"}'),			('GALLERY_VIEW_SETTINGS','{\"enable_rating\":\"1\",\"enable_link\":\"1\",\"_thumbnail\":{\"thumb_cols\":\"3\",\"thumb_rows\":\"3\",\"col_offset\":\"30\",\"row_offset\":\"30\",\"thumb_height\":\"65%\",\"blocks\":{\"top\":{\"title\":\"title\"},\"thumb\":{\"description\":\"description\"},\"bottom\":{\"rating\":\"rating\",\"date\":\"date\",\"link\":\"link\"}},\"blocks_text\":{\"title\":\"{TITLE}\",\"description\":\"{DESCRIPTION}\",\"author\":\"<strong>Created By: <\/strong>{AUTHOR}\",\"date\":\"<strong>Created Date: <\/strong>{DATE}\",\"link\":\"Read More\",\"rating\":\"{RATING}\"},\"thumb_text_effect\":\"slide-up-in\"}}'),
('GLOBAL_SETTINGS', '{\"date_time_format\":\"D, d M Y\",\"author_field\":\"display_name\",\"shorten_title\":\"1\",\"show_top_bar\":\"1\",\"show_category_dropdown\":\"1\",\"show_gallery_dropdown\":\"1\",\"show_back_gallery_button\":\"1\",\"star_style\":\"yellow_star_square\",\"half_star\":\"0.5\"}'),
('RATING_STAR_SETTINGS', '{\"yellow_star\":{\"title\":\"Yellow Star\",\"src_on\":\"star_yellow_16x16.png\",\"src_off\":\"star_yellow_off_16x16.png\",\"class\":\"yellow-star\",\"size\":[16,16]},\"red_star\":{\"title\":\"Red Star\",\"src_on\":\"star_red_16x16.png\",\"src_off\":\"star_red_off_16x16.png\",\"size\":[16,16],\"class\":\"red-star\"},\"yellow_star_square\":{\"title\":\"Yellow Star Square\",\"src_on\":\"star_yellow_square_16x16.png\",\"src_off\":\"star_yellow_square_off_16x16.png\",\"size\":[16,16],\"class\":\"yellow-star-square\"}}');
	";
	$wpdb->query($query);
}