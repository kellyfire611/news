<?php
/**
 * Mugu Theme Customizer.
 *
 * @package Mugu
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mugu_customize_register($wp_customize)
{
    /* Option list of all post */
    $mugu_options_posts = array();
    $mugu_options_posts_obj = get_posts('posts_per_page=-1');
    $mugu_options_posts[''] = __('Choose Post', 'mugu');
    foreach ($mugu_options_posts_obj as $mugu_posts) {
        $mugu_options_posts[$mugu_posts->ID] = $mugu_posts->post_title;
    }

    /* Option list of all categories */
    $mugu_args = array(
        'type' => 'post',
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => 1,
        'hierarchical' => 1,
        'taxonomy' => 'category');
    $mugu_option_categories = array();
    $mugu_category_lists = get_categories($mugu_args);
    $mugu_option_categories[''] = __('Choose Category', 'mugu');
    foreach ($mugu_category_lists as $mugu_category) {
        $mugu_option_categories[$mugu_category->term_id] = $mugu_category->name;
    }

    /** Default Settings */
    $wp_customize->add_panel('wp_default_panel', array(
        'priority' => 10,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __('Default Settings', 'mugu'),
        'description' => __('Default section provided by wordpress customizer.', 'mugu'),
        ));

    $wp_customize->get_section('title_tagline')->panel = 'wp_default_panel';
    $wp_customize->get_section('colors')->panel = 'wp_default_panel';
    $wp_customize->get_section('header_image')->panel = 'wp_default_panel';
    $wp_customize->get_section('background_image')->panel = 'wp_default_panel';
    $wp_customize->get_section('static_front_page')->panel = 'wp_default_panel';

    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    
    /** Header Layout Settings */
    $wp_customize->add_section(
        'mugu_home_layout_settings',
        array(
            'title'       => __( 'Header Layout Settings', 'mugu' ),
            'priority'    => 30,
            'capability'  => 'edit_theme_options',
        )
    );
    
    /** Header Layout Setting */
    $wp_customize->add_setting(
        'mugu_header_layout',
        array(
            'default'           => 'one',
            'sanitize_callback' => 'mugu_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'mugu_header_layout',
        array(
            'label'   => __( 'Select Header Layout', 'mugu' ),
            'section' => 'mugu_home_layout_settings',
            'type' => 'select',
        'choices' => array(
            'one' => 'Header Layout One',
            'two' => 'Header Layout Two',
        ),
    ));

    /** Home Page Settings */
    $wp_customize->add_panel('mugu_home_page_settings', array(
        'priority' => 40,
        'capability' => 'edit_theme_options',
        'title' => __('Home Page Settings', 'mugu'),
        'description' => __('Customize Home Page Settings', 'mugu'),
        ));

    /** Featured Section */
    $wp_customize->add_section('mugu_featured_settings', array(
        'title' => __('Featured Section', 'mugu'),
        'priority' => 10,
        'panel' => 'mugu_home_page_settings',
        ));

    /** Enable/Disable Featured Section */
    $wp_customize->add_setting('mugu_ed_featured_section', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_checkbox',
        ));

    $wp_customize->add_control('mugu_ed_featured_section', array(
        'label' => __('Enable Featured Section', 'mugu'),
        'section' => 'mugu_featured_settings',
        'type' => 'checkbox',
        ));

    /** Featured Post Layout*/
    $wp_customize->add_setting('mugu_featured_post_layout', array(
        'default' => 'one',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_featured_post_layout', array(
        'label' => __('Select Featured Post Layout', 'mugu'),
        'section' => 'mugu_featured_settings',
        'type' => 'select',
        'choices' => array(
            'one' => 'Featured Layout One',
            'two' => 'Featured Layout Two',
        ),
        ));

    /** Featured Post One*/
    $wp_customize->add_setting('mugu_featured_post_one', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_featured_post_one', array(
        'label' => __('Select Featured Post One', 'mugu'),
        'section' => 'mugu_featured_settings',
        'type' => 'select',
        'choices' => $mugu_options_posts,
        ));

    /** Featured Post Two*/
    $wp_customize->add_setting('mugu_featured_post_two', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_featured_post_two', array(
        'label' => __('Select Featured Post Two', 'mugu'),
        'section' => 'mugu_featured_settings',
        'type' => 'select',
        'choices' => $mugu_options_posts,
        ));
    
    /** Featured Post Three*/
    $wp_customize->add_setting('mugu_featured_post_three', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_featured_post_three', array(
        'label' => __('Select Featured Post Three', 'mugu'),
        'section' => 'mugu_featured_settings',
        'type' => 'select',
        'choices' => $mugu_options_posts,
        ));
    
    /** Featured Post Four */
    $wp_customize->add_setting('mugu_featured_post_four', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_featured_post_four', array(
        'label' => __('Select Featured Post Four', 'mugu'),
        'section' => 'mugu_featured_settings',
        'type' => 'select',
        'choices' => $mugu_options_posts,
        ));

    /** Featured Post Five */
    $wp_customize->add_setting('mugu_featured_post_five', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_featured_post_five', array(
        'label' => __('Select Featured Post Five', 'mugu'),
        'section' => 'mugu_featured_settings',        
        'active_callback' => 'mugu_featured_layout_option',
        'type' => 'select',
        'choices' => $mugu_options_posts,
        ));

    /** Featured Post Six */
    $wp_customize->add_setting('mugu_featured_post_six', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_featured_post_six', array(
        'label' => __('Select Featured Post Six', 'mugu'),
        'section' => 'mugu_featured_settings',
        'active_callback' => 'mugu_featured_layout_option',
        'type' => 'select',
        'choices' => $mugu_options_posts,
        ));
    
    /** Featured Post Seven */
    $wp_customize->add_setting('mugu_featured_post_seven', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_featured_post_seven', array(
        'label' => __('Select Featured Post Seven', 'mugu'),
        'section' => 'mugu_featured_settings',
        'active_callback' => 'mugu_featured_layout_option',
        'type' => 'select',
        'choices' => $mugu_options_posts,
        ));

    /** Featured Section */


    /** Recent and Popular Posts Section */
    $wp_customize->add_section('mugu_blog_section_settings', array(
        'title' => __('Recent and Popular Posts Section', 'mugu'),
        'priority' => 20,
        'panel' => 'mugu_home_page_settings',
        ));

    /** Enable/Disable Recent and Popular Posts Section*/
    $wp_customize->add_setting('mugu_ed_blog_section', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_checkbox',
        ));

    $wp_customize->add_control('mugu_ed_blog_section', array(
        'label' => __('Enable Recent and Popular Posts Section ', 'mugu'),
        'section' => 'mugu_blog_section_settings',
        'type' => 'checkbox',
        ));

    /** Label For Button One */
    $wp_customize->add_setting('mugu_button_one_label', array(
        'default' => __('Latest','mugu'),
        'sanitize_callback' => 'mugu_sanitize_nohtml',
        ));

    $wp_customize->add_control('mugu_button_one_label', array(
        'label' => __('Label For Button One', 'mugu'),
        'section' => 'mugu_blog_section_settings',
        'type' => 'text',
        ));
        
    /** Label For Button Two */
    $wp_customize->add_setting('mugu_button_two_label', array(
        'default' => __('Popular','mugu'),
        'sanitize_callback' => 'mugu_sanitize_nohtml',
        ));

    $wp_customize->add_control('mugu_button_two_label', array(
        'label' => __('Label For Button Two', 'mugu'),
        'section' => 'mugu_blog_section_settings',
        'type' => 'text',
        ));
    /** Blogs Section Ends */

    /** Category Section */
    $wp_customize->add_section('mugu_category_settings', array(
        'title' => __('Category section', 'mugu'),
        'priority' => 30,
        'panel' => 'mugu_home_page_settings',
        ));
    
    /** Category One */
    $wp_customize->add_setting('mugu_category_section_one_cat', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_category_section_one_cat', array(
        'label' => __('Select Category One', 'mugu'),
        'section' => 'mugu_category_settings',
        'type' => 'select',
        'choices' => $mugu_option_categories,
        ));
    
    /** Category Two*/
    $wp_customize->add_setting('mugu_category_section_two_cat', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_category_section_two_cat', array(
        'label' => __('Select Category Two', 'mugu'),
        'section' => 'mugu_category_settings',
        'type' => 'select',
        'choices' => $mugu_option_categories,
        ));

    /** Category Three */
    $wp_customize->add_setting('mugu_category_section_three_cat', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_category_section_three_cat', array(
        'label' => __('Select Category Three', 'mugu'),
        'section' => 'mugu_category_settings',
        'type' => 'select',
        'choices' => $mugu_option_categories,
        ));    

    /** Category Four*/
    $wp_customize->add_setting('mugu_category_section_four_cat', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_select',
        ));

    $wp_customize->add_control('mugu_category_section_four_cat', array(
        'label' => __('Select Category Four', 'mugu'),
        'section' => 'mugu_category_settings',
        'type' => 'select',
        'choices' => $mugu_option_categories,
        ));
    /** category Section Ends**/

    /** Home Page Settings Ends */

    /** Breadcrumb Settings */
    $wp_customize->add_section('mugu_breadcrumb_settings', array(
        'title' => __('Breadcrumb Settings', 'mugu'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        ));

    /** Enable/Disable BreadCrumb */
    $wp_customize->add_setting('mugu_ed_breadcrumb', array(
        'default' => '',
        'sanitize_callback' => 'mugu_sanitize_checkbox',
        ));

    $wp_customize->add_control('mugu_ed_breadcrumb', array(
        'label' => __('Enable Breadcrumb', 'mugu'),
        'section' => 'mugu_breadcrumb_settings',
        'type' => 'checkbox',
        ));

    /** Show/Hide Current */
    $wp_customize->add_setting('mugu_ed_current', array(
        'default' => '1',
        'sanitize_callback' => 'mugu_sanitize_checkbox',
        ));

    $wp_customize->add_control('mugu_ed_current', array(
        'label' => __('Show current', 'mugu'),
        'section' => 'mugu_breadcrumb_settings',
        'type' => 'checkbox',
        ));

    /** Home Text */
    $wp_customize->add_setting('mugu_breadcrumb_home_text', array(
        'default' => __('Home', 'mugu'),
        'sanitize_callback' => 'mugu_sanitize_nohtml',
        ));

    $wp_customize->add_control('mugu_breadcrumb_home_text', array(
        'label' => __('Breadcrumb Home Text', 'mugu'),
        'section' => 'mugu_breadcrumb_settings',
        'type' => 'text',
        ));

    /** Breadcrumb Separator */
    $wp_customize->add_setting('mugu_breadcrumb_separator', array(
        'default' => __('>', 'mugu'),
        'sanitize_callback' => 'mugu_sanitize_nohtml',
        ));

    $wp_customize->add_control('mugu_breadcrumb_separator', array(
        'label' => __('Breadcrumb Separator', 'mugu'),
        'section' => 'mugu_breadcrumb_settings',
        'type' => 'text',
        ));
    /** BreadCrumb Settings Ends */

    /** Social Settings */
    $wp_customize->add_section(
        'mugu_social_settings',
        array(
            'title' => __( 'Social Settings', 'mugu' ),
            'description' => __( 'Leave blank if you do not want to show the social link.', 'mugu' ),
            'priority' => 50,
            'capability'  => 'edit_theme_options',
        )
    );
    
    /** Enable/Disable Social in Header */
    $wp_customize->add_setting(
        'mugu_ed_social',
        array(
            'default' => '',
            'sanitize_callback' => 'mugu_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'mugu_ed_social',
        array(
            'label' => __( 'Enable Social Links', 'mugu' ),
            'section' => 'mugu_social_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Facebook */
    $wp_customize->add_setting(
        'mugu_facebook',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'mugu_facebook',
        array(
            'label' => __( 'Facebook', 'mugu' ),
            'section' => 'mugu_social_settings',
            'type' => 'text',
        )
    );
    
    
    /** Twitter */
    $wp_customize->add_setting(
        'mugu_twitter',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'mugu_twitter',
        array(
            'label' => __( 'Twitter', 'mugu' ),
            'section' => 'mugu_social_settings',
            'type' => 'text',
        )
    );
    
    /** Pinterest */
    $wp_customize->add_setting(
        'mugu_pinterest',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'mugu_pinterest',
        array(
            'label' => __( 'Pinterest', 'mugu' ),
            'section' => 'mugu_social_settings',
            'type' => 'text',
        )
    );
    
    /** LinkedIn */
    $wp_customize->add_setting(
        'mugu_linkedin',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'mugu_linkedin',
        array(
            'label' => __( 'LinkedIn', 'mugu' ),
            'section' => 'mugu_social_settings',
            'type' => 'text',
        )
    );
    
    /** Instagram */
    $wp_customize->add_setting(
        'mugu_instagram',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'mugu_instagram',
        array(
            'label' => __( 'Instagram', 'mugu' ),
            'section' => 'mugu_social_settings',
            'type' => 'text',
        )
    );

    /** YouTube */
    $wp_customize->add_setting(
        'mugu_youtube',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'mugu_youtube',
        array(
            'label' => __( 'YouTube', 'mugu' ),
            'section' => 'mugu_social_settings',
            'type' => 'text',
        )
    );
    /** Social Settings Ends */
    
    /** Advertisement Settings */
    $wp_customize->add_section(
        'mugu_ad_settings',
        array(
            'title'       => __( 'Avertisement Settings', 'mugu' ),
            'description' => __( 'Header & Footer AD Settings', 'mugu' ),
            'priority'    => 60,
            'capability'  => 'edit_theme_options',
        )
    );
    
    /** Enable/Disable Header AD */
    $wp_customize->add_setting(
        'mugu_ed_header_ad',
        array(
            'default'           => '',
            'sanitize_callback' => 'mugu_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'mugu_ed_header_ad',
        array(
            'label'   => __( 'Enable Header Advertisement', 'mugu' ),
            'section' => 'mugu_ad_settings',
            'type'    => 'checkbox',
        )
    );
    
    /** Open Link in Different Tab */
    $wp_customize->add_setting(
        'mugu_open_link_diff_tab',
        array(
            'default'           => '1',
            'sanitize_callback' => 'mugu_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'mugu_open_link_diff_tab',
        array(
            'label'   => __( 'Open Link in Different Tab', 'mugu' ),
            'section' => 'mugu_ad_settings',
            'type'    => 'checkbox',
        )
    );
    
    /** Header Advertisement */
    $wp_customize->add_setting(
        'mugu_header_ad',
        array(
            'default'           => '',
            'sanitize_callback' => 'mugu_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Cropped_Image_Control(
           $wp_customize,
           'mugu_header_ad',
           array(
               'label'   => __( 'Upload Header Advertisement', 'mugu' ),
               'section' => 'mugu_ad_settings',
               'width'   => 728,
               'height'  => 90,
           )
       )
    );
    
    /** Header AD Link */
    $wp_customize->add_setting(
        'mugu_header_ad_link',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'mugu_header_ad_link',
        array(
            'label' => __( 'Header AD Link', 'mugu' ),
            'section' => 'mugu_ad_settings',
            'type' => 'text',
        )
    );
    
    /** Color Scheme */
    $wp_customize->add_section(
        'mugu_color_scheme_settings',
        array(
            'title'       => __( 'Color Scheme', 'mugu' ),
            'priority'    => 60,
            'capability'  => 'edit_theme_options',
        )
    );
    
    $wp_customize->add_setting(
        'mugu_theme_color',
        array(
            'default' => '#1E74C5',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mugu_theme_color', 
        array(
            'label'       => __( 'Theme Color', 'mugu' ),
            'description' => __( 'Change the Theme Color scheme from here.', 'mugu' ),
            'section'     => 'mugu_color_scheme_settings',
            'settings'    => 'mugu_theme_color'
        )
    ));

    /** Custom CSS*/
    if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
        $wp_customize->add_section(
            'mugu_custom_settings',
            array(
                'title' => __( 'Custom CSS Settings', 'mugu' ),
                'priority' => 70,
                'capability' => 'edit_theme_options',
            )
        );
        
        $wp_customize->add_setting(
            'mugu_custom_css',
            array(
                'default' => '',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'mugu_sanitize_css'
                )
        );
        
        $wp_customize->add_control(
            'mugu_custom_css',
            array(
                'label' => __( 'Custom Css', 'mugu' ),
                'section' => 'mugu_custom_settings',
                'description' => __( 'Put your custom CSS', 'mugu' ),
                'type' => 'textarea',
            )
        );
    }
    /** Custom CSS Ends */
           
    /**
     * Sanitization Functions
     * 
     * @link https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php 
     */
    function mugu_sanitize_checkbox($checked)
    {
        // Boolean check.
        return ((isset($checked) && true == $checked) ? true : false);
    }

    function mugu_sanitize_nohtml($nohtml)
    {
        return wp_filter_nohtml_kses($nohtml);
    }

    function mugu_sanitize_select($input, $setting)
    {
        // Ensure input is a slug.
        $input = sanitize_key($input);

        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control($setting->id)->choices;

        // If the input is a valid key, return it; otherwise, return the default.
        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }

    function mugu_sanitize_number_absint($number, $setting)
    {
        // Ensure $number is an absolute integer (whole number, zero or greater).
        $number = absint($number);

        // If the input is an absolute integer, return it; otherwise, return the default
        return ($number ? $number : $setting->default);
    }


    /**
     * Display dates for 30 days based on result of year and month 
     * 
     * @link http://ottopress.com/2015/whats-new-with-the-customizer/
     */
    function mugu_featured_layout_option(  $control ){ 
    $mugu_featured_layout = $control->manager->get_setting( 'mugu_featured_post_layout' )->value();

    if( $mugu_featured_layout == 'two') {
        return true;
    }else { 
        return false; }
    }

    function mugu_sanitize_css( $css ){
        return wp_strip_all_tags( $css );
    }
    
}
add_action('customize_register', 'mugu_customize_register');


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mugu_customize_preview_js()
{
    wp_enqueue_script('mugu_customizer', get_template_directory_uri() .
        '/js/customizer.js', array('customize-preview'), '20151215', true);
}
add_action('customize_preview_init', 'mugu_customize_preview_js');
