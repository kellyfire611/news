<?php
/**
 * Header One
 * 
 * @package Mugu
*/
?>
<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<?php
				/**
				 * Mugu Pro Header Logo
				 * @see mugu_header_site_brand 
				 */
				do_action('mugu_header_logo' );
			?>
			<?php if ( has_nav_menu( 'primary' ) ) { ?>
				<div id="mobile-header">
    				<a id="responsive-menu-button" href="#sidr-main">
    					<span></span>
    					<span></span>
    					<span></span>
    				</a>
				</div>
			
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php wp_nav_menu( 
						array( 
							'theme_location' => 'primary',
							'menu_id' => 'primary-menu',
   							) ); 
   					?>
				</nav>
			<?php } ?>

			<ul class="tool-lists">
				<li class="search">
					<span class="fa fa-search"></span>
					<div class="form-holder">
						<?php get_search_form(); ?>
					</div>
				</li>
			</ul>
		</div>
	</header><!-- #masthead -->