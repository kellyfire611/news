<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mugu
 */

 global $post;
 $sidebar_layout = mugu_sidebar_layout();

?>
 <div class = "post-section">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if( has_post_thumbnail() ){ ?>
        <div class="post-thumbnail">
            <?php ( is_active_sidebar( 'right-sidebar' ) && ( $sidebar_layout == 'right-sidebar' ) ) ? the_post_thumbnail( 'mugu-with-sidebar' ) : the_post_thumbnail( 'mugu-without-sidebar' ); ?>
        </div>
    <?php } ?>
    
        <div class="entry-content">
            <?php
                the_content();
                
                wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mugu' ),
				'after'  => '</div>',
                ) );
            ?>
        </div><!-- .entry-content -->

        <?php if ( get_edit_post_link() ) : ?>
            <footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'mugu' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
            </footer><!-- .entry-footer -->
        <?php endif; ?>
    </article><!-- #post-## -->
</div>