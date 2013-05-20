<?php
/**
 * Template Name: Article List Page
 * -------------------------------------
 * This is an example template that displays a single arlima article list.
 * In this file we will go through all the different callbacks that you can
 * hook into during the rendering of the article list.
 *
 * @package Arlima
 */

get_header();
?>
<div id="primary" class="arlima-content">
    <div id="content" role="main">
        <?php

        // Define the width of our list. This is later used to crop article images
        // This width is also defined in /plugins/arlima/css/template.css, so make
        // sure you change on both places if you need to change the width
        define('TMPL_ARTICLE_WIDTH', 480);

        // Get id of current page
        $page_id = false; while ( have_posts() ) : the_post(); global $post; $page_id = $post->ID; endwhile;

        // Get arlima slug added to this pages in a custom field
        $arlima_slug = get_post_meta($page_id, 'arlima', true);
        if( !$arlima_slug ) {
            echo '<p>'.__('No list slug is defined. Please add custom field &quot;arlima&quot; to this page with the slug name of the list that you want to display', 'arlima').'</p>';
        }
        else {

            // Load the arlima list
            $version = isset( $_GET['arlima-preview'] ) && is_user_logged_in() ? 'preview':'';
            $list = new ArlimaList($arlima_slug, $version);
            if( !$list->exists ) {
                echo '<p>'.__('It does not exist any arlima list with the slug', 'arlima').' &quot;'.$arlima_slug.'&quot;</p>';
            }
            else {

                // Show a link that takes logged in users directly to wp-admin
                // where current list can be edited
                arlima_edit_link($list);

                // Initiate template renderer that's responsible of
                // rendering current arlima list.
                $arlima_renderer = new ArlimaListTemplateRenderer($list);

                // Callback for article image
                $arlima_renderer->setGetImageCallback(function($article) {

                    if( !empty($article['image_options']) && !empty( $article['image_options']['attach_id'] ) ) {

                        $attach_meta = wp_get_attachment_metadata($article['image_options']['attach_id']);
                        if( !$attach_meta )
                            return false;

                        $article_width = empty($article['parent']) || $article['parent'] == -1 ? TMPL_ARTICLE_WIDTH : round(TMPL_ARTICLE_WIDTH * 0.5);

                        switch($article['image_options']['size']) {
                            case 'half':
                                $width = round($article_width * 0.5);
                                $size = array($width, round( $attach_meta['height'] * ($width / $attach_meta['width'])));
                                break;
                            case 'third':
                                $width = round($article_width * 0.33);
                                $size = array($width, round( $attach_meta['height'] * ($width / $attach_meta['width'])));
                                break;
                            case 'quarter':
                                $width = round($article_width * 0.25);
                                $size = array($width, round( $attach_meta['height'] * ($width / $attach_meta['width'])));
                                break;
                            default:
                                $size = array($article_width, round( $attach_meta['height'] * ($article_width / $attach_meta['width'])));
                                break;
                        }

                        $img_class = $article['image_options']['size'].' '.$article['image_options']['alignment'];
                        $img_alt = htmlspecialchars( $article['title'] );
                        $attach_url = wp_get_attachment_url( $article['image_options']['attach_id'] );
                        $img_url = WP_PLUGIN_URL . '/arlima/timthumb/timthumb.php?q=90&amp;w='.$size[0].'&amp;h='.$size[1].'&amp;src=' . urlencode($attach_url);

                        return sprintf('<img src="%s" width="%s" height="%s" alt="%s" class="%s" />', $img_url, $size[0], $size[1], $img_alt, $img_class);
                    }

                    return false;
                });

                // Callback used when a future posts comes up in the list
                $arlima_renderer->setFuturePostCallback(function($post, $article) {
                    if( is_user_logged_in() ) {
                        ?>
                        <div class="future-post">
                            Hey dude, <a href="<?php echo get_permalink($post->ID) ?>" target="_blank">this post</a>
                            will not show up in the list until its published, unless you're not logged in that is...
                        </div>
                        <?php
                    }
                });

                // Modify text content
                $arlima_renderer->setTextModifierCallback(function($article, $is_post, $post) {
                    $article['text'] = apply_filters('the_arlima_content', $article['text']);
                    return arlima_link_entrywords(trim($article['text']), $article['url']);
                });

                // Callback for related posts
                $arlima_renderer->setRelatedPostsCallback(function($article, $is_post) {
                    return $is_post ? arlima_related_posts('inline', null, false) : '';
                });

                // Callback taking place before every article is rendered
                $arlima_renderer->setBeforeArticleCallback(function($article_counter, $article) {
                    // ...
                });

                // Callback taking place after every article is rendered
                $arlima_renderer->setAfterArticleCallback(function($article_counter, $article) {
                    // ...
                });

                // The list doesn't have any articles :(
                if( !$arlima_renderer->havePosts() ) {
                    echo '<p><em>'.__('Please feed me some articles, I\'m hungry').'</em></p>';
                }

                // Let the magic happen...
                else {
                    $arlima_renderer->renderList();
                }
            }
        }
        ?>
    </div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>