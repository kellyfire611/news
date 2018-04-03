<?php
/**
 * Header Two
 * 
 * @package Mugu
*/
?>
<header id="masthead" class="site-header  header-1" role="banner">
    <div class="header-top">
		<div class="container">
			<?php
				/**
				 * Mugu Pro Header Logo
				 * 
				 * @see mugu_header_site_brand 
				 */
				do_action('mugu_header_logo' );
			?>
			<div class="right-panel">
				<?php 
					/**
					 * Mugu Header Social Links
					 * 
					 * mugu_social_cb
					 *
					**/
					do_action( 'mugu_social_link' );
					echo '<div class= "search">';
					get_search_form();
					echo '</div>';
				?>

			</div>
		</div>
	</div>
	<div class="header-bottom">
		<div class="container">
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
	    </div>
	</div>
</header>