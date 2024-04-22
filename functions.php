<?php
add_action('wp_enqueue_scripts', 'cocrianca');
function cocrianca(){
    wp_enqueue_style('customstyle', get_template_directory_uri() . '/css/style.css', array(), '1.0.15', 'all');
    wp_enqueue_style('slickcss', get_template_directory_uri() . '/slick/slick.css', array(), '1.8.0', 'all');
    wp_enqueue_style('slicktheme', get_template_directory_uri() . '/slick/slick-theme.css', array(), '1.8.0', 'all');
    wp_enqueue_script('slickjs',  get_template_directory_uri() . '/slick/slick.js', array('jquery'), '', false);
    wp_enqueue_script('customjs',  get_template_directory_uri() . '/js/index.js', array(), NULL, false );
}


function cocrianca_add_custom_image_sizes() {

     // Add "vertical" image
    add_image_size( 'vertical', 590, 670, true);
    add_image_size( 'vertical-larger', 890, 970, true);
    //horizontal
    add_image_size( 'horizontal', 450, 300, true);
    add_image_size( 'horizontal-b', 740, 540, true);
    add_image_size( 'horizontal-c', 342, 290, true);
    add_image_size( 'horizontal-plus', 715, 225, true);
    add_image_size( 'quarter', 225, 225, true);
    //others
    add_image_size('image_desktop_full_no_crop', 2000 , 2500, false);
}

add_action('after_setup_theme', 'cocrianca_add_custom_image_sizes' );

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
    Container::make( 'theme_options', __( 'Theme Options', 'crb' ) )
        ->add_fields( array(
            Field::make( 'text', 'email', 'E-mail' ),
            Field::make( 'text', 'phone', 'Phone' ),
            Field::make( 'text', 'doacao', 'Doação' ),
            Field::make( 'text', 'instagram', 'Instagram' ),
            Field::make( 'text', 'youtube', 'Youtube' ),
            Field::make( 'text', 'facebook', 'Facebook' ),
            Field::make( 'text', 'linkedin', 'Linkedin' ),

        ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_about' );
function crb_attach_about() {
    Container::make( 'theme_options', __( 'About', 'crb' ) )
        ->add_fields( array(
            Field::make( 'text', 'fixed_title', 'FIXED title' ),
            Field::make( 'text', 'fixed_subtile_1', 'FIXED Block one - subtitle' ),
            Field::make( 'rich_text', 'fixed_description_1', 'FIXED Block one - description' ),
            Field::make( 'text', 'fixed_subtile_2', 'FIXED Block two - subtitle' ),
            Field::make( 'rich_text', 'fixed_description_2', 'FIXED Block two - description' ),
            Field::make( 'text', 'fixed_subtile_3', 'FIXED Block three - subtitle' ),
            Field::make( 'rich_text', 'fixed_description_3', 'FIXED Block three - description' ),
            Field::make( 'text', 'fixed_footer_title_1', 'FOOTER title - first' ),
            Field::make( 'rich_text', 'fixed_footer_description_1', 'FOOTER description - first' ),
            Field::make( 'text', 'fixed_footer_link_1', 'FOOTER link - first' ),
            Field::make( 'text', 'fixed_footer_title_2', 'FOOTER title - second' ),
            Field::make( 'rich_text', 'fixed_footer_description_2', 'FOOTER description - second' ),
            Field::make( 'text', 'fixed_footer_link_2', 'FOOTER link - second' ),
        ) )
        ->add_fields( array(
            Field::make( 'image', 'photo_2', 'SECTION 2 - image' ),
            Field::make( 'rich_text', 'scroll_description_2', 'SECTION 2 - description' ),
            Field::make( 'rich_text', 'scroll_box_description_2', 'SECTION 2 - box' ),
        ) )
        ->add_fields( array(
            Field::make( 'image', 'photo_list_1', 'SECTION 3 - Photo list 1' ),
            Field::make( 'image', 'photo_list_2', 'SECTION 3 - Photo list 2' ),
            Field::make( 'image', 'photo_list_3', 'SECTION 3 - Photo list 3' ),
            Field::make( 'rich_text', 'scroll_description_3', 'SECTION 3 - description' ),
            Field::make( 'text', 'scroll_box_title_3', 'SECTION 3 - box title' ),
            Field::make( 'rich_text', 'scroll_box_description_3', 'SECTION 3 - box description' ),
        ) );
}



add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
	//define o caminho para o carbon-fields
	define(
		'Carbon_Fields\URL',
		get_template_directory_uri() . '/vendor/htmlburger/carbon-fields'
	);
  require_once('vendor/autoload.php');
  \Carbon_Fields\Carbon_Fields::boot();
}
add_action('after_setup_theme', 'register_carbon_fields');
function register_carbon_fields() {
	require_once('blocks/load.php');
}

///////////
///MENU////
///////////


/**
 * Main menu navigation
 */
register_nav_menus(array(
  'main-menu' => 'Menu principal',
  'footer' => 'Footer',
));

add_action( 'wp_head', 'add_viewport_meta_tag' , '1' );

function add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
}

///////////
////post///
///////////
function my_theme_setup(){
    add_theme_support('post-thumbnails');
    add_image_size('cc__thumbnail_a4_horizontal_crop', 999, 700, array('center', 'center'));
}

add_action('after_setup_theme', 'my_theme_setup');

//////////
//excerpt//
///////////
add_post_type_support( 'page', 'excerpt' );


////////
//vcard///
///////////
function _thz_enable_vcard_upload( $mime_types ){
    $mime_types['vcf'] = 'text/vcard';
    $mime_types['vcard'] = 'text/vcard';
    return $mime_types;
}
add_filter('upload_mimes', '_thz_enable_vcard_upload' );





/**
* Removes or edits the 'Protected:' part from posts titles
*/
function the_title_trim($title) {

    $title = attribute_escape($title);

    $findthese = array(
        '#Protected:#',
        '#Private:#',
        '#Protegido:#'
    );

    $replacewith = array(
        '', // What to replace "Protected:" with
        '' // What to replace "Private:" with
    );

    $title = preg_replace($findthese, $replacewith, $title);
    return $title;
}
add_filter('the_title', 'the_title_trim');

// enable gutenberg for woocommerce
function activate_gutenberg_product( $can_edit, $post_type ) {
 if ( $post_type == 'product' ) {
        $can_edit = true;
    }
    return $can_edit;
}
add_filter( 'use_block_editor_for_post_type', 'activate_gutenberg_product', 10, 2 );

// enable taxonomy fields for woocommerce with gutenberg on
function enable_taxonomy_rest( $args ) {
    $args['show_in_rest'] = true;
    return $args;
}
add_filter( 'woocommerce_taxonomy_args_product_cat', 'enable_taxonomy_rest' );
add_filter( 'woocommerce_taxonomy_args_product_tag', 'enable_taxonomy_rest' );

/////////// 
/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options –> Reading
  // Return the number of products you wanna show per page.
  $cols = 3;
  return $cols;
}






/**
 * Remove product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );          // Remove the description tab
    unset( $tabs['reviews'] );          // Remove the reviews tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab

    return $tabs;
}

add_filter ('yith_wcan_use_wp_the_query_object', '__return_true');

/**
* Create taxonomy portfolio
*/

////////////////
////taxonomia///
////////////////

/* -- Post Type - Projetos -- */
function custom_post_type_projetos() {
    $labels = [
        "name" => __( "Projetos"),
        "singular_name" => __( "Projetos"),
    ];

    $args = [
        "label" => __( "Projetos"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => [ "slug" => "projetos", "with_front" => false, 'hierarchical' => true ],
        "query_var" => true,
        "menu_position" => 5,
        "menu_icon" => "dashicons-book-alt",
        "supports" => [ "title", "editor", "thumbnail", "excerpt", "trackbacks", "custom-fields", "comments", "revisions", "author", "page-attributes", "post-formats" ],
        "taxonomies" => [ "genero" ],
    ];

    register_post_type( "projetos", $args );
}

add_action( 'init', 'custom_post_type_projetos' );

/* ------------------------------ Taxonomias - Genero -----------------------------*/
function custom_taxonomy_projeto() {

    /**
     * Taxonomy: Projeto.
     */

    $labels = [
        "name" => __( "Tipos de projeto"),
        "singular_name" => __( "Tipo de projeto"),
    ];

    $args = [
        "label" => __( "Tipo de projeto"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => [ "slug" => "projeto", "with_front" => false, 'hierarchical' => true ],
        "show_admin_column" => true,
        "show_in_rest" => true,
        "rest_base" => "projeto",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => true,
    ];

    register_taxonomy( "projeto", [ "projetos" ], $args );
}
add_action( 'init', 'custom_taxonomy_projeto' );


//add breadcrumb
function get_breadcrumb() {
    echo ' <div class="breadcrumb structure-container" >
    <div class="structure-container__content structure-container__side">
    <div class="breadcrumb__content">
    <a href="'.home_url().'" rel="nofollow">Página inicial</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;>&nbsp;&nbsp;";
        the_category(' &bull; ');
            if (is_single()) {
                echo " &nbsp;&nbsp;>&nbsp;&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;>&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;>&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
    echo '</div>
    </div>
    </div>';
}


