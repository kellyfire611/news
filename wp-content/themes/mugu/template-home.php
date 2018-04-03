<?php
/**
 * Template Name: Home Page
 *
 * @package Mugu
 */

get_header(); 

    /**
     * Home Page Contents
     * 
     * @hooked mugu_featured_content            - 10
     * @hooked mugu_post_wrapper_start          - 20
     * @hooked mugu_latest_popolar_posts        - 30
     * @hooked mugu_category_content            - 40
     * @hooked mugu_post_wrapper_end            - 50
    */
    do_action( 'mugu_home_page' );
    
    
get_footer();