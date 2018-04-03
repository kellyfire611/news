<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Mugu
 */

if ( ! function_exists( 'mugu_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function mugu_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'mugu' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
	
    if (  ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '/ <span class="comments">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment', 'mugu' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

}
endif;

if ( ! function_exists( 'mugu_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function mugu_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( '', 'mugu' ) );
		if ( $tags_list ) {
			printf( '<div class="left"><div class="tags">' . esc_html__( '%1$s', 'mugu' ) . '</div></div>', $tags_list ); // WPCS: XSS OK.
		}
	}
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'mugu' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function mugu_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'mugu_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'mugu_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so mugu_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so mugu_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in mugu_categorized_blog.
 */
function mugu_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'mugu_categories' );
}
add_action( 'edit_category', 'mugu_category_transient_flusher' );
add_action( 'save_post',     'mugu_category_transient_flusher' );


if ( ! function_exists( 'mugu_category_list' ) ) :
/**
 * Prints Categories lists
*/
function mugu_category_list(){
    // Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'mugu' ) );
		if ( $categories_list && mugu_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( '%1$s', 'mugu' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}		
	}
}
endif;