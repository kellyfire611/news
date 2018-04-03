<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mugu
 */

?>
        </div><!-- #content -->
	
        <?php
     
            if ( ! ( is_page_template( 'template-home.php') ) ) echo '</div>';  
     
            if(  is_home() || is_archive() || is_category() )  echo '</div>';  
    
                the_posts_pagination( array(
                    'mid_size' => 2,
                    'prev_text' => __( '<span class="fa fa-long-arrow-left"></span>', 'mugu' ),
                    'next_text' => __( '<span class="fa fa-long-arrow-right"></span>', 'mugu' ),    
                    ) ); 
        ?>
    
    </div><!-- #container -->

	<footer class="site-footer">
	<?php if ( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) ) { ?>
		<div class="footer-t">
			<div class="container">
				<div class="row">

					<?php
                        if ( is_active_sidebar( 'footer-one' ) ) {
                        	echo '<div class="col">';
			                	dynamic_sidebar( 'footer-one' ); 
			                echo '</div>';
						}
					
						if ( is_active_sidebar( 'footer-two' ) ) {
							echo '<div class="col">';
                            	dynamic_sidebar( 'footer-two' ); 
                            echo '</div>';
						}
					
						if ( is_active_sidebar( 'footer-three' ) ) {
							echo '<div class="col">';
                            	dynamic_sidebar( 'footer-three' ); 
                            echo '</div>';
						}
					?>
				</div>
			</div>
		</div>
		<?php 
			}    
            
            /**
             * @hooked mugu_footer_credit
             */
            do_action( 'mugu_footer' );
        	
        	?>	
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>