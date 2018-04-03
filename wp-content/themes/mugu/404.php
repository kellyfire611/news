<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Mugu
 */

get_header(); ?>

<section class="error-404 not-found error-holder">
	
	<h1><?php esc_html_e( '404', 'mugu' ); ?></h1>
	<h2><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'mugu' ); ?></h2>

	<p><?php esc_html_e( 'The page you are looking for does not exist. It may have been moved, or removed altogether. Perhaps you can return back to the site&rsquo;s homepage and maybe try a search?', 'mugu' ); ?></p>

	<?php
		get_search_form();
	?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-home"><?php esc_html_e( 'back to Home', 'mugu' ); ?></a>

</section><!-- .error-404 -->


<?php
get_footer();
