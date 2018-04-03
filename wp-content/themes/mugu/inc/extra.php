<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package mugu
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function mugu_body_classes( $classes ) {
    
    global $post;
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color';
    }
    
    if( !( is_active_sidebar( 'right-sidebar' ) ) ) {
        $classes[] = 'full-width'; 
    }
    
    if( is_page() ){
        $sidebar_layout = mugu_sidebar_layout();
        if( $sidebar_layout == 'no-sidebar' )
        $classes[] = 'full-width';
    }

    // return the $classes array
	return $classes;
}
add_filter( 'body_class', 'mugu_body_classes' );

if( ! function_exists( 'mugu_header_site_brand' ) ) :
/**
 * Site Brand
*/
function mugu_header_site_brand(){ ?>
    <div class="site-branding">
            <?php
                if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                    the_custom_logo();
                } 
            ?>
            <div class="text-logo">  
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php
                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) : ?>
                        <p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
                <?php
                    endif; 
                ?>
            </div> 
        </div><!-- .site-branding -->
        <?php
}
endif;
add_action('mugu_header_logo','mugu_header_site_brand');

if( ! function_exists( 'mugu_dynamic_header' ) ) :
/**
 * Dynamic Header 
*/
function mugu_dynamic_header(){
    
    $header_array = array( 'one', 'two' );
    $header = get_theme_mod( 'mugu_header_layout', 'one' );
    if( in_array( $header, $header_array ) ){            
        get_template_part( 'header/' . $header );
    }
}
endif;

add_action( 'mugu_header', 'mugu_dynamic_header' );

/**
 * Mugu Header Layout 
**/
function mugu_header_layout_cb(){ ?>
    <div class="top-bar">
        <div class="page-header">
            <?php 
                if( is_page() ){ 
                    the_title( '<h1 class="page-title">', '</h1>' ); 
                }elseif( is_search() ){ ?>
                    <h1 class="page-title"><?php echo esc_html( 'Search Results', 'mugu' ); ?></h1>
          <?php }elseif( is_home() ) {?>
                <h1 class="page-title"><?php echo esc_html( 'Blogs', 'mugu' ); ?></h1>
          <?php }elseif( is_404() ) {?>
                <h1 class="page-title"><?php echo esc_html( 'Page Not Found', 'mugu' ); ?></h1>
          <?php }elseif( is_archive() ){ ?>
                <header class="page-header">
                <?php
                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    the_archive_description( '<div class="taxonomy-description">', '</div>' );
                ?>
                </header><!-- .page-header -->
          <?php } ?>
        </div>

       <?php
        /**
        * Header Beadcrumb
        */
          do_action('mugu_breadcrumbs');
        ?>
      </div>
<?php }
add_action('mugu_header_layout','mugu_header_layout_cb');

if( ! function_exists( 'mugu_social_cb' ) ) :
/**
 * Mugu Header Layout 
**/
function mugu_social_cb(){ 
$social = get_theme_mod( 'mugu_ed_social' );
$facebook = get_theme_mod( 'mugu_facebook' );
$twitter = get_theme_mod( 'mugu_twitter' );
$pinterest = get_theme_mod( 'mugu_pinterest' );
$linkedin = get_theme_mod( 'mugu_linkedin' );
$instagram = get_theme_mod( 'mugu_instagram' );
$youtube = get_theme_mod( 'mugu_youtube' );


if( $social && ( $facebook || $twitter || $pinterest || $linkedin || $instagram || $youtube ) ) {
    
    echo '<ul class="social-networks">'; 
            
        if( $facebook ) echo'<li><a href="' . esc_url( $facebook ) . '" class="fa fa-facebook" title="facebook"></a></li>';
        if( $twitter ) echo'<li><a href="' . esc_url( $twitter ) . '" class="fa fa-twitter" title="twitter"></a></li>';
        if( $pinterest ) echo'<li><a href="' . esc_url( $pinterest ) . '" class="fa fa-pinterest-p" title="pinterest"></a></li>';
        if( $linkedin ) echo'<li><a href="' . esc_url( $linkedin ) . '" class="fa fa-linkedin" title="linkedin"></a></li>';
        if( $instagram ) echo'<li><a href="' . esc_url( $instagram ) . '" class="fa fa-instagram" title="instagram"></a></li>';
        if( $youtube ) echo'<li><a href="' . esc_url( $youtube ) . '" class="fa fa-youtube" title="youtube"></a></li>';
      
    echo '</ul>';

    }
}
endif;
add_action('mugu_social_link','mugu_social_cb');
  
/**
 * Custom Bread Crumb
 *
 * @link http://www.qualitytuts.com/wordpress-custom-breadcrumbs-without-plugin/
 */ 
function mugu_breadcrumbs_cb() {

  $mugu_ed_breadcrumb = get_theme_mod('mugu_ed_breadcrumb');
  if($mugu_ed_breadcrumb){
 
  $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter = esc_html( get_theme_mod( 'mugu_breadcrumb_separator', __( '>', 'mugu' ) ) ); // delimiter between crumbs
  $home = esc_html( get_theme_mod( 'mugu_breadcrumb_home_text', __( 'Home', 'mugu' ) ) ); // text for the 'Home' link
  $showCurrent = get_theme_mod( 'mugu_ed_current', '1' ); // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  global $post;
  $homeLink = esc_url( home_url( ) );
 
  if ( is_front_page() ) {
 
    if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
 
  } else {
 
    echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      $thisCat = get_category(get_query_var('cat'), false);
      if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
      echo $before . single_cat_title('', false) . $after;
 
    } elseif ( is_search() ) {
      echo $before . esc_html__( 'Search Result', 'mugu' ) . $after;
 
    } elseif ( is_day() ) {
      echo '<a href="' . esc_url( get_year_link( get_the_time('Y') ) ) . '">' . esc_html( get_the_time('Y') ) . '</a> ' . $delimiter . ' ';
      echo '<a href="' . esc_url( get_month_link( get_the_time('Y'), get_the_time('m') ) ) . '">' . esc_html( get_the_time('F') ) . '</a> ' . $delimiter . ' ';
      echo $before . esc_html( get_the_time('d') ) . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . esc_url( get_year_link( get_the_time('Y') ) ) . '">' . esc_html( get_the_time('Y') ) . '</a> ' . $delimiter . ' ';
      echo $before . esc_html( get_the_time('F') ) . $after;
 
    } elseif ( is_year() ) {
      echo $before . esc_html( get_the_time('Y') ) . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . esc_html( $post_type->labels->singular_name ) . '</a>';
        if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . esc_html( get_the_title() ) . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
        echo $cats;
        if ($showCurrent == 1) echo $before . esc_html( get_the_title() ) . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . esc_html( $post_type->labels->singular_name ) . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . esc_url( get_permalink($parent) ) . '">' . esc_html( $parent->post_title ) . '</a>';
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . esc_html( get_the_title() ) . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo $before . esc_html( get_the_title() ) . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_post($parent_id);
        $breadcrumbs[] = '<a href="' . esc_url( get_permalink($page->ID) ) . '">' . esc_html( get_the_title( $page->ID ) ) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        echo $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
      }
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . esc_html( get_the_title() ) . $after;
 
    } elseif ( is_tag() ) {
      echo $before . esc_html( single_tag_title('', false) ) . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . esc_html( $userdata->display_name ) . $after;
 
    } elseif ( is_404() ) {
        echo $before . esc_html__( '404 Error - Page not Found', 'mugu' ) . $after;
    } elseif( is_home() ){
        echo $before;
        single_post_title();
        echo $after;
    }

    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __( 'Page', 'mugu' ) . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
  }
  }
} // end mugu_breadcrumbs()
add_action( 'mugu_breadcrumbs', 'mugu_breadcrumbs_cb' );

if( ! function_exists( 'mugu_header_ad' ) ) :
/**
 * Header AD
*/
function mugu_header_ad(){
    $ed_header_ad = get_theme_mod( 'mugu_ed_header_ad' ); //from customizer
    $ad_img       = get_theme_mod( 'mugu_header_ad' ); //from customizer
    $ad_link      = get_theme_mod( 'mugu_header_ad_link' ); //from customizer
    $ad_image     = wp_get_attachment_image_src( $ad_img, 'full' );
    $target       = get_theme_mod( 'mugu_open_link_diff_tab', '1' ) ? 'target="_blank"' : '';
    
    if( $ed_header_ad && $ad_img ){ ?>
    <div class="advertise">
        <?php if( $ad_link ) echo '<a href="' . esc_url( $ad_link ) . '" ' . $target . '>'; ?>
            <img src="<?php echo esc_url( $ad_image[0] ); ?>"  />
        <?php if( $ad_link ) echo '</a>'; ?>        
    </div>
    <?php
    }
}
endif;
add_action( 'mugu_header_ad', 'mugu_header_ad' );

if( ! function_exists( 'mugu_featured_before_content' ) ) :
/**
 * Featured Content  
*/
function mugu_featured_before_content(){
    
    $ed_featured_section = get_theme_mod( 'mugu_ed_featured_section' );
    $featured_section_layout = get_theme_mod( 'mugu_featured_post_layout', 'one' );
    $featured_post_one   = get_theme_mod( 'mugu_featured_post_one' );
    $featured_post_two   = get_theme_mod( 'mugu_featured_post_two' );
    $featured_post_three = get_theme_mod( 'mugu_featured_post_three' );
    $featured_post_four  = get_theme_mod( 'mugu_featured_post_four' );
    $featured_post_five  = get_theme_mod( 'mugu_featured_post_five' );
    $featured_post_six  = get_theme_mod( 'mugu_featured_post_six' );
    $featured_post_seven  = get_theme_mod( 'mugu_featured_post_seven' );
  
    $featured_posts = array( $featured_post_one, $featured_post_two, $featured_post_three, $featured_post_four, $featured_post_five ,$featured_post_six ,$featured_post_seven );
    $featured_posts = array_diff( array_unique( $featured_posts ), array('') );
    
    $x        = 0; 
    $class    = '';
    $img_size = '';
    
    if( ( $featured_section_layout == 'two' ) && $ed_featured_section && $featured_posts ){

        $featured_qry = new WP_Query( array( 
            'post_type'             => 'post',
            'posts_per_page'        => -1,
            'post__in'              => $featured_posts,
            'orderby'               => 'post__in',
            'ignore_sticky_posts'   => true 
        ) );
        
        if( $featured_qry->have_posts() ){ ?>
        
        <div class="featured-post layout-2">
       
        <?php
        while( $featured_qry->have_posts() ){
            $featured_qry->the_post();
            
            if( has_post_thumbnail() ){
             
                if($x == 2){
                    $img_size = 'mugu-featured-second-two';
                }else{
                    $img_size = 'mugu-featured-second-one'; 

                }

                if( ($x == 0) || ($x == 3) ||($x == 5) ){
                    echo '<div class="col">';
                }elseif($x == 2){
                    echo '<div class="col large">';
                }     
                ?>
                <div class="post<?php echo esc_attr( $class ); ?>">
                    <a href="<?php the_permalink(); ?>" class="post-thumbnail"><?php the_post_thumbnail( esc_attr( $img_size ) ); ?></a>
                    <div class="text-holder">                
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>
                        <span class="byline"><a href="<?php the_permalink(); ?>"><?php the_author(); ?></a></span>
                    </div>
                </div>             
                <?php 
                if( ($x == 1) || ($x == 2) || ($x == 4) ||($x == 6) ){ echo '</div>'; }
                $x++;
                
            }
            
        }
        wp_reset_postdata(); 
        ?>
        </div>
        <?php
        }     
    }
}
endif;
add_action( 'mugu_home_page_before_content', 'mugu_featured_before_content', 10 );

if( ! function_exists( 'mugu_featured_content' ) ) :
/**
 * Featured Content  
*/
function mugu_featured_content(){
    
    $ed_featured_section = get_theme_mod( 'mugu_ed_featured_section' );
    $featured_section_layout = get_theme_mod( 'mugu_featured_post_layout', 'one' );
    $featured_post_one   = get_theme_mod( 'mugu_featured_post_one' );
    $featured_post_two   = get_theme_mod( 'mugu_featured_post_two' );
    $featured_post_three = get_theme_mod( 'mugu_featured_post_three' );
    $featured_post_four  = get_theme_mod( 'mugu_featured_post_four' );
  
    $featured_posts = array( $featured_post_one, $featured_post_two, $featured_post_three, $featured_post_four );
    $featured_posts = array_diff( array_unique( $featured_posts ), array('') );
    
    $x        = 0; 
    $class    = '';
    $img_size = '';
    
    if( ( $featured_section_layout == 'one' ) && $ed_featured_section && $featured_posts ){
     
        $featured_qry = new WP_Query( array( 
            'post_type'             => 'post',
            'posts_per_page'        => -1,
            'post__in'              => $featured_posts,
            'orderby'               => 'post__in',
            'ignore_sticky_posts'   => true 
        ) );
        
        if( $featured_qry->have_posts() ){ ?>
        
        <div class="featured-post layout-1">
       
        <?php
        while( $featured_qry->have_posts() ){
            $featured_qry->the_post();
            
            if( has_post_thumbnail() ){
                if($x == 0){
                    $class = '';
                    $img_size = 'mugu-featured-one';
                }elseif($x == 1){
                    $class = ' medium';
                    $img_size = 'mugu-featured-two';                  
                }else{
                    $class = ' small';
                    $img_size = 'mugu-featured-three';                    
                }
                ?>
                <div class="post<?php echo esc_attr( $class ); ?>">
                    <a href="<?php the_permalink(); ?>" class="post-thumbnail"><?php the_post_thumbnail( esc_attr( $img_size ) ); ?></a>
                    <div class="text-holder">                
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>
                        <span class="byline"><a href="<?php the_permalink(); ?>"><?php the_author(); ?></a></span>
                    </div>
                </div>             
                <?php
                $x++;
            }
        }
        wp_reset_postdata(); 
        ?>
        </div>
        <?php
        }     
    }
}
endif;
add_action( 'mugu_home_page', 'mugu_featured_content', 10 );

if( ! function_exists( 'mugu_post_wrapper_start' ) ) :
/**
 * Popular and Category post start
*/
function mugu_post_wrapper_start(){
    echo '<div class="post-section">';
} 
endif;
add_action( 'mugu_home_page', 'mugu_post_wrapper_start', 20 );

if( ! function_exists( 'mugu_latest_popular_posts' ) ) :
/**
 * Latest & Popular Posts
*/
function mugu_latest_popular_posts(){
    
    $ed_latest_popular       = get_theme_mod( 'mugu_ed_blog_section' );
    $mugu_button_one_label   = get_theme_mod( 'mugu_button_one_label', __('Latest', 'mugu') ); 
    $mugu_button_two_label   = get_theme_mod( 'mugu_button_two_label', __('Popular', 'mugu') );
    
    if( $ed_latest_popular ){
        
        if( $mugu_button_one_label && $mugu_button_two_label ){ ?>
            <ul class="tabs-menu">
                <li class="current">
                    <div class="tab-btn" id="latest-post"><?php echo esc_html( $mugu_button_one_label); ?></div>
                </li>
                <li>
                    <div class="tab-btn" id="most-popular"><?php echo esc_html( $mugu_button_two_label); ?></div>
                </li>
            </ul>
    	<?php 
        } 
        
        $mugu_qry = new WP_Query( array( 
            'post_type'           => 'post', 
            'post_status'         => 'publish',
            'posts_per_page'      => 6,             
            'ignore_sticky_posts' => true,            
        ) );

        if( $mugu_qry->have_posts() ){ ?>

            <div class="article-holder row">

            <?php while( $mugu_qry->have_posts() ){ 
                $mugu_qry->the_post(); ?>
                
                <article class="post">
			
                    <?php if( has_post_thumbnail() ){ ?>
                        <a href="<?php the_permalink();?>" class="post-thumbnail">
                            <?php the_post_thumbnail( 'mugu-blog-post' );?>
                        </a>
                    <?php } ?>
    					
                    <div class="text-holder">
    				
                        <?php 
                             mugu_category_list(); 
                             the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 
                             echo '<div class="entry-meta">';
                             mugu_posted_on(); 
                             echo '</div>';
                             the_excerpt();
                             echo '<a href="'. esc_url( get_the_permalink() ) . '" class="readmore">'.  esc_html__( 'Read More', 'mugu' ) . '</a>' ; 
                        ?>
                        
    		            </div>
                    
		            </article>
		        <?php }
                wp_reset_postdata();
                ?>
            </div>
            <div id="loader"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>    
        <?php
        }
    }    
}
endif; 
add_action( 'mugu_home_page', 'mugu_latest_popular_posts', 30 ); 

if( ! function_exists( 'mugu_category_content' ) ) :
/**
 * Category Contents
*/
function mugu_category_content(){
    
    $one_cat   = get_theme_mod( 'mugu_category_section_one_cat' );
    $two_cat   = get_theme_mod( 'mugu_category_section_two_cat' );    
    $three_cat = get_theme_mod( 'mugu_category_section_three_cat' );
    $four_cat  = get_theme_mod( 'mugu_category_section_four_cat' );
    
    if( $one_cat ) mugu_get_category_content( $one_cat, 'small' );
    if( $two_cat ) mugu_get_category_content( $two_cat, 'big' );
    if( $three_cat ) mugu_get_category_content( $three_cat, 'small' );
    if( $four_cat ) mugu_get_category_content( $four_cat, 'big' );
    
}
endif;
add_action( 'mugu_home_page', 'mugu_category_content', 40 );

if( ! function_exists( 'mugu_post_wrapper_end' ) ) :
/**
 * Popular and Category post end
*/
function mugu_post_wrapper_end(){
    echo '</div>';
} 
endif;
add_action( 'mugu_home_page', 'mugu_post_wrapper_end', 50 );

function mugu_get_category_content( $cat_id, $style ){
    $img_size = '';
    $img_size = ( $style === 'small' ) ? 'mugu-popular-post' : 'mugu-blog-post' ;
    $cat = get_category( $cat_id );
    
    $args = array( 
		'post_type'             => 'post',
		'cat'           		=> $cat_id,
		'post_status'           => 'publish',
		'posts_per_page'   		=> 6,
		'ignore_sticky_posts'   => true 
    );
    
    $mugu_qry = new WP_Query( $args );

    if( $mugu_qry->have_posts() ){ ?>
    <?php if( $style === 'small' ){ ?>
      	<div class="holder">
    		<div class="popular-posts"> 
        <?php } ?>
      			<h2 class="main-title"><?php echo esc_html( $cat->name ); ?></h2>
      			<div class="row">
    
          		<?php
            		while ($mugu_qry->have_posts()){ 
                        $mugu_qry->the_post(); ?>
                	
                	<div class="post">
                        <?php if( has_post_thumbnail() ){ ?>
                        	<a href="<?php the_permalink(); ?>" class="post-thumbnail"><?php the_post_thumbnail( esc_attr( $img_size ) ); ?></a>
                        <?php } ?>
                       
                        <div class="text-holder">
                            <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php if( $style === 'big' ){ ?>
                                <div class="entry-meta">
                                    <?php mugu_posted_on(); ?> 
                                </div>
                                <?php the_excerpt(); ?>
                                <a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e( 'Read More','mugu' ); ?></a>
                            <?php } ?>
                        </div>
                  	</div>
          		    <?php 
                    }
                wp_reset_postdata();
          		?>
      			</div>
    		<?php 
            if( $style === 'small' ){ ?>
            </div>
    	</div>
    <?php }
    }
}

/** 
 * Hook to move comment text field to the bottom in WP 4.4 
 *
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-move-comment-text-field-to-bottom-in-wordpress-4-4/  
 */
function mugu_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'mugu_move_comment_field_to_bottom' );

/**
 * Callback function for Comment List *
 * 
 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments 
 */
 
function mugu_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	
    <footer class="comment-meta">
    
        <div class="comment-author vcard">
    	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    	<?php printf( __( '<b class="fn"><a href="<?php get_the_author(); ?>">%s</a></b>', 'mugu' ), get_comment_author_link() ); ?>
    	</div>
    	<?php if ( $comment->comment_approved == '0' ) : ?>
    		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'mugu' ); ?></em>
    		<br />
    	<?php endif; ?>
    
    	<div class="comment-metadata commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_date(); ?>">
    		<?php
    			/* translators: 1: date, 2: time */
    			printf( __( '%s', 'mugu' ), get_comment_date() ); ?></time></a><?php edit_comment_link( __( '(Edit)', 'mugu' ), '  ', '' );
    		?>
    	</div>
    </footer>
    
    <div class="comment-content"><?php comment_text(); ?></div>

	<div class="reply">
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}

/**
 * Return sidebar layouts for pages
*/
function mugu_sidebar_layout(){
    global $post;
    
    if( get_post_meta( $post->ID, 'mugu_sidebar_layout', true ) ){
        return get_post_meta( $post->ID, 'mugu_sidebar_layout', true );    
    }else{
        return 'right-sidebar';
    }
}

/**
 * Footer Credits 
*/
function mugu_footer_credit(){
      
    $text  = '<div class="site-info"><div class="container"><p>';
    $text .= esc_html__( 'Copyright &copy; ', 'mugu' ) . esc_html(date_i18n('Y') ); 
    $text .= ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a> &verbar; ';
    $text .= '<a href="' . esc_url( 'http://raratheme.com/wordpress-themes/mugu/' ) .'" rel="author" target="_blank">' . esc_html__( 'Mugu by: Rara Theme', 'mugu' ) . '</a> &verbar; ';
    $text .= sprintf( esc_html__( 'Powered by: %s', 'mugu' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'mugu' ) ) .'" target="_blank">WordPress</a>' );
    $text .= '</p></div></div>';
    echo apply_filters( 'mugu_footer_text', $text );    
}
add_action( 'mugu_footer', 'mugu_footer_credit' );

/**
 * Dynamic CSS
 * @see mugu_dynamic_styles
*/
add_action( 'wp_head', 'mugu_dynamic_styles', 100 );

/**
 * Custom CSS
*/
function mugu_custom_css(){
    $custom_css = get_theme_mod( 'mugu_custom_css' );
    if( $custom_css ){
        echo '<style type="text/css" media="all">';
    echo wp_strip_all_tags( $custom_css );
        echo '</style>';
    }
}
add_action( 'wp_head', 'mugu_custom_css', 101 );


/**
 * Ajax Callback for Featured Category
*/
function mugu_category_ajax(){
    $id = $_POST['id'];
    
    $args = array( 
        'post_type'           => 'post', 
        'post_status'         => 'publish',
        'posts_per_page'      => 6,             
        'ignore_sticky_posts' => true,
    );
    
    if( $id === 'most-popular'){
        $args['orderby'] = 'comment_count';
    }
    
    $mugu_qry = new WP_Query( $args );

    if( $mugu_qry->have_posts() ){
        while( $mugu_qry->have_posts() ){ 
          $mugu_qry->the_post(); 
            
          $response .= '<article class="post">'; 
            
            if( has_post_thumbnail() ){
                $response .= '<a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
                $response .= get_the_post_thumbnail( get_the_ID(), 'mugu-blog-post' );
                $response .= '</a>';
            } 

            $response .= '<div class="text-holder">';
        
            if ( 'post' === get_post_type() ) {
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list( esc_html__( ', ', 'mugu' ) );
                if ( $categories_list && mugu_categorized_blog() ) {
                    $response .= sprintf( '<span class="cat-links">' . esc_html__( '%1$s', 'mugu' ) . '</span>', $categories_list ); // WPCS: XSS OK.
                }
            } 
            
            $response .= '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_html( get_the_title() ) . '</a></h2>';
             
            $response .= '<div class="entry-meta">';
            
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
                
            $response .= '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
              
            if (  ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
                $response .= '/ <span class="comments">';
                
                $num_comments = get_comments_number(); // get_comments_number returns only a numeric value
                    if ( $num_comments == 0 ) {
                    $comments = __( 'Leave a Comment', 'mugu' );
                  } elseif ( $num_comments > 1 ) {
                    $comments = $num_comments . __(' Comments', 'mugu' );
                  } else {
                    $comments = __( '1 Comment', 'mugu' );
                  }
                  $response .= '<a href="' . esc_url( get_comments_link() ) .'">'. esc_html( $comments ) .'</a>';
                    
                    $response .= '</span>';
            }
            
            $response .= '</div>';
            
            $response .= wpautop( esc_html( get_the_excerpt() ) );
            
            $response .= '<a href="'. esc_url( get_the_permalink() ) . '" class="readmore">'. esc_html__( 'Read More', 'mugu' ) . '</a>' ; 
                         
        $response .= '</div></article>';
            
        }
        wp_reset_postdata(); 
    }
    
    echo $response;
    
    wp_die();
}
add_action( 'wp_ajax_mugu_cat_ajax', 'mugu_category_ajax' );
add_action( 'wp_ajax_nopriv_mugu_cat_ajax', 'mugu_category_ajax' );

if ( ! function_exists( 'mugu_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function mugu_excerpt_more() {
  return ' &hellip; ';
}
add_filter( 'excerpt_more', 'mugu_excerpt_more' );
endif;

if ( ! function_exists( 'mugu_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function mugu_excerpt_length( $length ) {
  return 20;
}
add_filter( 'excerpt_length', 'mugu_excerpt_length', 999 );
endif;


if( ! function_exists( 'mugu_post_author' ) ) :

/**
 * Post Author
 */

function mugu_post_author(){

/**
 * Author Bio
 * 
 * @since 1.0.1
*/

global $post;

// Detect if it is a single post with a post author
if(isset( $post->post_author )){
  // Get author's display name 
  $display_name = get_the_author_meta( 'display_name', $post->post_author );

// If display name is not available then use nickname as display name
if ( empty( $display_name ) )
  $display_name = get_the_author_meta( 'nickname', $post->post_author );

  // Get link to the author archive page
  $user_posts = get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author));

  // Pass all this info to post content  
  echo '<section class="author"> <div class="img-holder">';
  echo get_avatar( get_the_author_meta('ID') , 114);
  echo '</div> <div class="text-holder"><h2 class="title">';
  echo esc_html( $display_name ) . '</h2>';
  echo wpautop( esc_html( get_the_author_meta( 'description' ) ) ); 
  echo '</section>';
  }
}
endif;

/**
 * After post content
 * 
*/
add_action( 'mugu_after_post_content', 'mugu_post_author', 10 );