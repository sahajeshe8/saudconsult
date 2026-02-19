<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<div class="header-page-other">
    <div class="container error-404">
              <h1 class="h3-heading"><?php _e( 'Whoops, Our Bad...', 'twentyseventeen' ); ?></h1>
              <p><?php _e( 'The page you requested was not found and here are the possible solutions:', 'twentyseventeen' ); ?></p>
              <ul>
                <li><?php _e( 'If you have typed the URL directly on the address bar, please make sure the spelling is correct', 'twentyseventeen' ); ?></li>
                <li><?php _e( 'If you reached this page when you clicked a product link or any link, then that link is probably outdated.', 'twentyseventeen' ); ?></li>
            </ul>
            <h3 class="h3-heading">What can you do?</h3>

            <p><?php _e( 'Here are what you could try to get back to our Site:', 'twentyseventeen' ); ?></p>
            <ul>
                <li><?php _e( 'Click the back button to go back the previous page', 'twentyseventeen' ); ?></li>
            </ul>
            <?php //get_search_form(); ?>
            <a class="viewall-btn-llj" href="<?php echo site_url(); ?>" style="margin-bottom: 30px; margin-top: 20px; margin-left: 0px;">Go back to home</a>
        </div>
</div>

<?php get_footer();
