<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mugu
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">

	<?php
	/**
	 * Mugu Header
	 *
	 * @see mugu_dynamic_header
	 */
	do_action( 'mugu_header' );

	/**
     * Header AD
     * 
    */
    do_action( 'mugu_header_ad' );
	
	if( is_page_template('template-home.php') ){
		/**
		 * Home page featured layout two
		 *
		 * @see mugu_featured_before_content
		 */
		do_action( 'mugu_home_page_before_content' );
	}
	?>
    
    <div class="container">	
		<?php
			
			if( is_home() || is_archive() || is_category() ) echo '<div class = "post-section">';
			
            
		           
            if ( ! ( is_page_template( 'template-home.php') ) ){ 
				do_action('mugu_header_layout');
			} 
			if ( ! ( is_page_template( 'template-home.php') ) ) echo '<div class = "row">'; 
        ?>	
	   <div id="content" class="site-content">    
