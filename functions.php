<?php
////////////////
/* NAVIGATION */
////////////////
require_once('wp_bootstrap_navwalker.php');

function register_mcbc_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('header', 'mcbc'), // Main Navigation
        'footer-menu' => __('footer', 'mcbc'), // Extra Navigation if needed (duplicate as many as you need!)
        'social-media-header-menu' => __('social-media', 'mcbc') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

if ( function_exists( 'add_theme_support' ) ) { 
    add_theme_support( 'post-thumbnails' );
    // additional image sizes
    // delete the next line if you do not need additional image sizes
    add_image_size( 'archive-thumb', 385, 255, array ('center', 'center' ) ); //300 pixels wide (and unlimited height)

}


add_action('init', 'register_mcbc_menu'); // Add Menus


/////////////////////
/* END NAVIGATION */
///////////////////

////////////////
/* EXCERPT */
////////////////
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/////////////////////
/* END EXCERPT */
///////////////////

/**
* Conditional function to check if post belongs to term in a custom taxonomy.
*
* @param    tax        string                taxonomy to which the term belons
* @param    term    int|string|array    attributes of shortcode
* @param    _post    int                    post id to be checked
* @return             BOOL                True if term is matched, false otherwise
*/
function pa_in_taxonomy($tax, $term, $_post = NULL) {
	// if neither tax nor term are specified, return false
	if ( !$tax || !$term ) { return FALSE; }
	// if post parameter is given, get it, otherwise use $GLOBALS to get post
	if ( $_post ) {
		$_post = get_post( $_post );
	} else {
		$_post =& $GLOBALS['post'];
	}
	// if no post return false
	if ( !$_post ) { return FALSE; }
	// check whether post matches term belongin to tax
	$return = is_object_in_term( $_post->ID, $tax, $term );
	// if error returned, then return false
	if ( is_wp_error( $return ) ) { return FALSE; }
	return $return;
}

function get_events_in_cat ($events, $categories) {
	$output = array();
	foreach($events as $e):
		foreach($categories as $c):
			if( pa_in_taxonomy('tribe_events_cat', $c, $e->ID)):
				// events can be in more than one cat, so if it's already been added don't add it again
				if(!in_array($e, $output)):
					array_push($output, $e);
				endif;
			endif;
		endforeach;
	endforeach;
	return $output;
}


/* REMOVE POST CONTENT FROM HOMEPAGE */
function remove_editor() {
    if (isset($_GET['post'])) {
        $id = $_GET['post'];
        $template = get_post_meta($id, '_wp_page_template', true);

        if($template == 'page-home.php'){ 
            remove_post_type_support( 'page', 'editor' );
            remove_post_type_support( 'page', 'excerpt' );     
        }
    }
}


function cleanup_templates() {
    remove_post_type_support( 'page', 'thumbnail' );          
    remove_post_type_support( 'post', 'thumbnail' );          
    remove_post_type_support( 'news', 'thumbnail' );          
	remove_post_type_support( 'tribe_venue', 'editor' );                      
    remove_post_type_support( 'tribe_organizer', 'editor' );      
}


add_action('init', 'remove_editor');
add_action('init', 'cleanup_templates');

/* WIDGET */

function my_widgets_init() {

	register_sidebar( array(
		'name'          => 'Main Content Area',
		'id'            => 'main-content-area',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'my_widgets_init' );

/* END WIDGET */

function curl_post($url, array $post = NULL, array $options = array()) 
{ 
    $defaults = array( 
        CURLOPT_POST => 1, 
        CURLOPT_HEADER => 0, 
        CURLOPT_URL => $url, 
        CURLOPT_FRESH_CONNECT => 1, 
        CURLOPT_RETURNTRANSFER => 1, 
        CURLOPT_FORBID_REUSE => 1, 
        CURLOPT_TIMEOUT => 4, 
        CURLOPT_POSTFIELDS => http_build_query($post) 
    ); 

    $ch = curl_init(); 
    curl_setopt_array($ch, ($options + $defaults)); 
    if( ! $result = curl_exec($ch)) 
    { 
        trigger_error(curl_error($ch)); 
    } 
    curl_close($ch); 
    return $result; 
} 

/////////////////////
/* OPTIONS */
///////////////////

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}
/////////////////////
/* END OPTIONS */
///////////////////

/////////////////////
/* TAGS */
// allows for tags to be queried against custom post types
///////////////////

function wpse28145_add_custom_types( $query ) {
    if( is_tag() && $query->is_main_query() ) {

        // this gets all post types:
        $post_types = get_post_types();

        // alternately, you can add just specific post types using this line instead of the above:
        // $post_types = array( 'post', 'your_custom_type' );

        $query->set( 'post_type', $post_types );
    }
}
add_filter( 'pre_get_posts', 'wpse28145_add_custom_types' );
/////////////////////
/* END TAGS */
///////////////////

/////////////////////
/* AJAX LOAD POSTS */
///////////////////
add_filter('next_posts_link_attributes', 'next_posts_link_attributes');
// add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function next_posts_link_attributes() {
    return 'class="button border-white color-white more-posts"';
}

function my_enqueue_assets() {

	wp_enqueue_script( 'vendor',  get_stylesheet_directory_uri() . '/js/vendor.min.js', null, '1.0', true );
	wp_enqueue_script( 'plugins',  get_stylesheet_directory_uri() . '/js/plugin.min.js', null, '1.0', true );
	wp_enqueue_script( 'main',  get_stylesheet_directory_uri() . '/js/main.min.js', null, '1.0', true );
	
	global $wp_query;
	wp_localize_script( 'main', 'ajaxpagination', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'query_vars' => json_encode( $wp_query->query )
	));

	wp_localize_script( 'main', 'ajaxsubscribe', array(
		'url' => get_stylesheet_directory_uri() . '/handlers/sml-subscribe-ajax.php'
	));


}
add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' );

// AJAX
add_action( 'wp_ajax_nopriv_ajax_pagination', 'my_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', 'my_ajax_pagination' );

function my_ajax_pagination() {
	$query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );
    $query_vars['paged'] = $_POST['page'];
    $posts = new WP_Query( $query_vars );
    // var_dump($query_vars['paged']);
	//	var_dump($posts->max_num_pages);
    $GLOBALS['wp_query'] = $posts;
	// if this is a search
	if( ! $posts->have_posts() ) {
		if ( is_search() ) {
	        get_template_part('search', 'result'); 				
		} else {
	        get_template_part('post', 'details'); 		
		}
    }
    else {
        while ( $posts->have_posts() ) { 
            $posts->the_post();
			if ( is_search() ) {
		        get_template_part('search', 'result'); 				
			} else {
		        get_template_part('post', 'details'); 		
			}
		}
    }
	
	if ( $posts->max_num_pages > floatval($query_vars['paged'])) :
		$next = $query_vars['paged'] + 1;
		echo '<div data-next-url="'.$next.'" class="hidden nextpage">'.get_next_posts_link( 'Load More').'</div>';
	endif;
	
	
    die();
}


// POSTS

function getSimilarPosts($post_type, $exclude, $term_list_name, $count = 3, $tax = 'target') {
	$args = array(
		'post_type' => $post_type,
		'post_status' => 'publish',
		'posts_per_page' => $count,
		'exclude' => $exclude,
		'tax_query' => array(
			array (
				'taxonomy' => $tax,
				'field' => 'name',
				'terms' => $term_list_name
			)
		)
	);
	
	return get_posts( $args );
}

// responsive image sizes



/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function mcbc_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 600 <= $width ) {
		$sizes = '(max-width: 991px) 80vw, (max-width: 1199px) 55vw, 793px';
	}
	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'mcbc_content_image_sizes_attr', 10, 2 );


/**
 * Removes width and height attributes from image tags
 *
 * @param string $html
 *
 * @return string
 */
function remove_image_size_attributes( $html ) {
    return preg_replace( '/(width|height)="\d*"\s/', "", $html );
}
 
// Remove image size attributes from post thumbnails
add_filter( 'post_thumbnail_html', 'remove_image_size_attributes' );
 
// Remove image size attributes from images added to a WordPress post
add_filter( 'image_send_to_editor', 'remove_image_size_attributes' );


// projects
function getProjectPage($term) {
	$args = array(
	'numberposts'	=> -1,
	'post_type'		=> 'page',
	'meta_key'		=> 'selected_project',
	'meta_value'	=> $term
	);
	
	$post = get_posts( $args );
	return get_permalink($post[0]->ID);
	
}


// RTE 
function wpb_mce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

/*
* Callback function to filter the MCE settings
*/
 
function my_mce_before_init_insert_formats( $init_array ) {  
 
// Define the style_formats array
 
    $style_formats = array(  
/*
* Each array child is a format with it's own settings
* Notice that each array has title, block, classes, and wrapper arguments
* Title is the label which will be visible in Formats menu
* Block defines whether it is a span, div, selector, or inline style
* Classes allows you to define CSS classes
* Wrapper whether or not to add a new block-level element around any selected elements
*/
        array(  
            'title' => 'TITLE',  
            'block' => 'h1',  
            'classes' => 'title-item',
            'wrapper' => false,
        ),
        array(  
            'title' => 'Subheading',  
            'block' => 'h2',  
            'classes' => 'subheading',
            'wrapper' => false,
             
        ),
        array(  
            'title' => 'Hook / Lede',  
            'block' => 'p',  
            'classes' => 'lede',
            'wrapper' => false,
        ),
        array(  
            'title' => 'Body',  
            'block' => 'p',  
            'classes' => 'body',
            'wrapper' => false,
        ),
        array(  
            'title' => 'Subhead 1',  
            'block' => 'h3',  
            'classes' => 'subhead-1',
            'wrapper' => false,
        ),
        array(  
            'title' => 'Subhead 2',  
            'block' => 'h4',  
            'classes' => 'subhead-2',
            'wrapper' => false,
        ),
        array(  
            'title' => 'Pull Quote',  
            'block' => 'div',  
            'classes' => 'pull-quote',
            'wrapper' => false
        ),
        array(  
            'title' => 'Caption',  
            'block' => 'p',  
            'classes' => 'caption',
            'wrapper' => false,
        ),
    );  
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );  
     
    return $init_array;  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 

// custom colors
function my_mce4_options($init) {

    $custom_colours = '
        "000000", "Black",
        "52575b", "Mid Gray",
        "004b50", "Dark Teal",
        "3bdcb2", "Celeste Green"
    ';

    // build colour grid default+custom colors
    $init['textcolor_map'] = '['.$custom_colours.']';

    // change the number of rows in the grid if the number of colors changes
    // 8 swatches per row
    $init['textcolor_rows'] = 1;

    return $init;
}
add_filter('tiny_mce_before_init', 'my_mce4_options');

function my_theme_add_editor_styles() {
    add_editor_style( 'editor-style.css' );
}
add_action( 'init', 'my_theme_add_editor_styles' );

?>