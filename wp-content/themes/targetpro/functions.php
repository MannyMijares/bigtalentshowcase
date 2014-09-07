<?php

if ( ! isset( $content_width ) )
	$content_width = 620;

/** Tell WordPress to run target_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'target_setup' );

if ( ! function_exists( 'target_setup' ) ):

function target_setup() {

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );	

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'target', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
		
			// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'target' ),
	) );

}
endif;
?>
<?php
function target_list_pings($comment, $args, $depth) { 
	$GLOBALS['comment'] = $comment; ?>
	<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php } ?>
<?php
add_filter('get_comments_number', 'target_comment_count', 0);
function target_comment_count( $count ) {
	if ( ! is_admin() ) {
	global $id;
	$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
	return count($comments_by_type['comment']);
} else {
return $count;
}
}
?>
<?php
if ( ! function_exists( 'target_comment' ) ) :
function target_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s', 'target' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'target' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'target' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'target' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'target' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'target'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override target_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 */
function target_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'target' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'target' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'target' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'target' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'target' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'target' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'target' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'target' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'target' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'target' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
if ( ! function_exists( 'target_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 */
function target_posted_on() {
	printf( __( '%2$s <span class="meta-sep">by</span> %3$s', 'target' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'target' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;
/** Register sidebars by running target_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'target_widgets_init' );

/** Excerpt */
function target_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'target_excerpt_length' );

function target_auto_excerpt_more( $more ) {
	return ' &hellip;' ;
}
add_filter( 'excerpt_more', 'target_auto_excerpt_more' );


/*-----------------------------------------------------------------------------------*/
/* Exclude categories from displaying on the "Blog" page template.
/*-----------------------------------------------------------------------------------*/

// Exclude categories on the "Blog" page template.
add_filter( 'target_blog_template_query_args', 'target_exclude_categories_blogtemplate' );

function target_exclude_categories_blogtemplate ( $args ) {

	if ( ! function_exists( 'target_prepare_category_ids_from_option' ) ) { return $args; }

	$excluded_cats = array();

	// Process the category data and convert all categories to IDs.
	$excluded_cats = target_prepare_category_ids_from_option( 'exclude_cat' );


	if ( count( $excluded_cats ) > 0 ) {

		// Setup the categories as a string, because "category__not_in" doesn't seem to work
		// when using query_posts().

		foreach ( $excluded_cats as $k => $v ) { $excluded_cats[$k] = '-' . $v; }
		$cats = join( ',', $excluded_cats );

		$args['cat'] = $cats;
	}

	return $args;

}

/*-----------------------------------------------------------------------------------*/
/* target_prepare_category_ids_from_option()
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'target_prepare_category_ids_from_option' ) ) {

	function target_prepare_category_ids_from_option ( $option ) {

		$cats = array();

		$stored_cats = of_get_option( $option );

		$cats_raw = explode( ',', $stored_cats );

		if ( is_array( $cats_raw ) && ( count( $cats_raw ) > 0 ) ) {
			foreach ( $cats_raw as $k => $v ) {
				$value = trim( $v );

				if ( is_numeric( $value ) ) {
					$cats_raw[$k] = $value;
				} else {
					$cat_obj = get_category_by_slug( $value );
					if ( isset( $cat_obj->term_id ) ) {
						$cats_raw[$k] = $cat_obj->term_id;
					}
				}

				$cats = $cats_raw;
			}
		}

		return $cats;

	}

}


// custom function
function target_head_css() {
		$output = '';
		$custom_css = of_get_option('custom_css');
		if ($custom_css <> '') {
			$output .= $custom_css . "\n";
		}
		
		$main_body_typography = of_get_option('main_body_typography');
		if ($main_body_typography) {
			$theme_options_styles = '
			body{ 
				font-family: ' . $main_body_typography['face'] . '; 
				font-weight: ' . $main_body_typography['style'] . '; 
				color: ' . $main_body_typography['color'] . '; 
			}';
		}
		
		// Output styles
		if ($output <> '') {
			$output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}
		
		if($theme_options_styles){
			echo '<style>' 
			. $theme_options_styles . '
			</style>';
		}
	
}

add_action('wp_head', 'target_head_css');

function target_of_analytics(){
$googleanalytics= of_get_option('go_code');
echo stripslashes($googleanalytics);
}
add_action( 'wp_footer', 'target_of_analytics' );

function target_favicon() {
	if (of_get_option('favicon_image') != '') {
	echo '<link rel="shortcut icon" href="'. of_get_option('favicon_image') .'"/>'."\n";
	}
}

add_action('wp_head', 'target_favicon');


/*small title*/
function target_small_title($amount,$echo=true) {
	$small = get_the_title(); 
	if ( strlen($small) <= $amount ) $echo_out = ''; else $echo_out = '...';
	$small = mb_substr( $small, 0, $amount, 'UTF-8' );
	if ($echo) {
		echo $small;
		echo $echo_out;
	}
	else { return ($small . $echo_out); }
}

function target_date_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s', 'target' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		)
	);
}

function of_register_js() {
	if (!is_admin()) {
		wp_register_script('cycle', get_template_directory_uri() . '/js/jquery.cycle.all.js', 'jquery','1.0', TRUE);
		wp_register_script('easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', 'jquery','1.0', TRUE);
		wp_register_script('custom', get_template_directory_uri() . '/js/jquery.custom.js', 'jquery', '1.0', TRUE);
	
		wp_enqueue_script('cycle');	
		wp_enqueue_script('easing');
		wp_enqueue_script('custom');
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'of_register_js');

function of_single_scripts() {
	if(is_singular()) wp_enqueue_script( 'comment-reply' ); // loads the javascript required for threaded comments 
}
add_action('wp_print_scripts', 'of_single_scripts');

function of_styles() {
		wp_register_style( 'dropdown', get_template_directory_uri() . '/css/dropdown.css' );
		wp_register_style( 'advanced', get_template_directory_uri() . '/css/default.advanced.css' );
		wp_enqueue_style( 'dropdown' );
		wp_enqueue_style( 'advanced' );
}
add_action('wp_print_styles', 'of_styles');

/** redirect */
if ( is_admin() && isset($_GET['activated'] ) && $pagenow ==	"themes.php" )
	wp_redirect( 'themes.php?page=options-framework');

// POST TYPES

function post_type_slides() {
$args = array(
'label' => 'SLIDES',
'public' => true,
'show_ui' => true,
'capability_type' => 'post',
'hierarchical' => false,
'rewrite' => true,
'query_var' => true,
'supports' => array(
'title',
'editor',
'thumbnail')
 );

register_post_type( 'slides', $args );
}
add_action('init', 'post_type_slides');

/*small title*/
function small_title($amount,$echo=true) {
	$small = get_the_title(); 
	if ( strlen($small) <= $amount ) $echo_out = ''; else $echo_out = '...';
	$small = mb_substr( $small, 0, $amount, 'UTF-8' );
	if ($echo) {
		echo $small;
		echo $echo_out;
	}
	else { return ($small . $echo_out); }
}

// include panel file.
if ( !function_exists( 'optionsframework_init' ) ) {

	/*-----------------------------------------------------------------------------------*/
	/* Options Framework Theme
	/*-----------------------------------------------------------------------------------*/

	/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */

	if ( get_stylesheet_directory() == get_template_directory_uri() ) {
		define('OPTIONS_FRAMEWORK_URL', get_template_directory() . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');
	} else {
		define('OPTIONS_FRAMEWORK_URL', get_template_directory() . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');
	}

	require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');

}

// Add the Portfolio Custom Meta
include("includes/slider-meta.php");

// include wp-pagenavi file.
require("includes/wp-pagenavi.php");