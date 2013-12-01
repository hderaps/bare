<?php
/* Bare!
This is the file that contains the functionality and features of Smashing. For
custom functions, please put them in functions.php in the root directory of the
theme.

Modified and Developed by: Karl Castillo
Based on: Bones (http://themble.com/bones/)
Grid used: Base (http://matthewhartman.github.io/base/)
*/

/*********************
SMASHING LAUNCH
Let's start the fun!
*********************/

// Initialize important functions
add_action('after_setup_theme', 'bare_init', 16);

function bare_init() {

	// launching operation cleanup
	add_action('init', 'bare_head_cleanup');
	// remove WP version from RSS
	add_filter('the_generator', 'bare_rss_version');
	// remove pesky injected css for recent comments widget
	add_filter('wp_head', 'bare_remove_wp_widget_recent_comments_style',1);
	// clean up comment styles in the head
	add_action('wp_head', 'bare_remove_recent_comments_style', 1);
	// clean up gallery output in wp
	add_filter('gallery_style', 'bare_gallery_style');

	// enqueue base scripts and styles
	add_action('wp_enqueue_scripts', 'bare_scripts_and_styles', 999);

	// launching this stuff after theme setup
	bare_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'bare_register_sidebars' );
	// adding the bare search form (created in functions.php)
	add_filter( 'get_search_form', 'bare_wpsearch' );

	// cleaning up random code around images
	add_filter( 'the_content', 'bare_filter_ptags_on_images' );
	// cleaning up excerpt
	add_filter( 'excerpt_more', 'bare_excerpt_more' );

} /* end smash_it */

/*********************
CLEAN WP HEAD
Remove and Add things that is needed for Smashing to work.
Feel free to add or comment out things that you need.
*********************/

function bare_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'bare_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'bare_remove_wp_ver_css_js', 9999 );

} /* end bare head cleanup */

// remove WP version from RSS
function bare_rss_version() { return ''; }

// remove WP version from scripts
function bare_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function bare_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function bare_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function bare_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading jquery, reply script, and necessary scripts for BASE
function bare_scripts_and_styles() {
	global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
	if (!is_admin()) {
		// modernizr (without media query polyfill)
		wp_register_script( 'bare-modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );
		// register main stylesheet
		wp_register_style( 'bare-stylesheet', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );
    wp_register_style('mnav-stylesheet', get_stylesheet_directory_uri() . '/library/css/mnav/mnav.css', array(), '', 'all');
    wp_register_style('mnav-theme', get_stylesheet_directory_uri() . '/library/css/mnav/mnav-theme.css', array(), '', 'all');
    
    /*
     * To add another stylesheet:
     * wp_register_style('name', 'path/to/stylesheet', dependancies, version, media);
     * 
     * Then add to queue:
     * wp_enqueue_style('name');
     */
    
		// comment reply script for threaded comments
		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script( 'comment-reply' );
		}
		//adding scripts file in the footer
    wp_register_script('mnav-js', get_stylesheet_directory_uri() . '/library/js/libs/mnav.min.js', array('jquery'), '', true);
		wp_register_script('bare-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true);
    
    /*
     * To add another script:
     * wp_register_script('name', 'path/to/js/file', dependancies, version, in_footer);
     * 
     * Then add to queue:
     * wp_enqueue_script('name');
     */
    
		// enqueue styles and scripts
		wp_enqueue_script( 'bare-modernizr' );
		wp_enqueue_style( 'bare-stylesheet' );
		wp_enqueue_style('mnav-stylesheet');
    wp_enqueue_style('mnav-theme');
    
		/*
		I recommend using a plugin to call jQuery
		using the google cdn. That way it stays cached
		and your site will load faster.
		*/
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'bare-js' );
    wp_enqueue_script('mnav-js');

	}
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function bare_theme_support() {
	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );
	// default thumb size
	set_post_thumbnail_size(125, 125, true);
	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
		array(
		'default-image' => '',  // background image default
		'default-color' => '', // background color default (dont add the #)
		'wp-head-callback' => '_custom_background_cb',
		'admin-head-callback' => '',
		'admin-preview-callback' => ''
		)
	);
	// rss thingy
	add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	);

	// wp menus
	add_theme_support('menus');

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav'     => __('Main Menu', 'baretheme'),   // main nav in header
      'sub-nav'      => __('Secondary Main Menu', 'baretheme'), // sub main menu (maybe a menu above the footer?
      // Add more if you need more menus but three should be enough
			'footer-links' => __('Footer Links', 'baretheme') // secondary nav in footer
		)
	);
} /* end bare theme support */


/*********************
MENUS & NAVIGATION
*********************/

// the main menu
function bare_main_nav() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'container_class' => 'menu section',           // class of container (should you choose to use it)
		'menu' => __( 'The Main Menu', 'baretheme' ),  // nav name
		'menu_class' => 'nav top-nav container',         // adding custom nav class
		'theme_location' => 'main-nav',                 // where it's located in the theme
		'before' => '',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 0,                                   // limit the depth of the nav
		'fallback_cb' => 'bare_main_nav_fallback'      // fallback function
	));
} /* end bare main nav */

// the footer menu (should you choose to use one)
function bare_footer_links() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => '',                              // remove nav container
		'container_class' => 'footer-links section',   // class of container (should you choose to use it)
		'menu' => __( 'Footer Links', 'baretheme' ),   // nav name
		'menu_class' => 'nav footer-nav section',      // adding custom nav class
		'theme_location' => 'footer-links',             // where it's located in the theme
		'before' => '',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 0,                                   // limit the depth of the nav
		'fallback_cb' => 'bare_footer_links_fallback'  // fallback function
	));
} /* end bare footer link */

// this is the fallback for header menu
function bare_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
		'menu_class' => 'nav top-nav container',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
		'link_before' => '',                            // before each link
		'link_after' => ''                             // after each link
	) );
}

// this is the fallback for footer menu
function bare_footer_links_fallback() {
	/* you can put a default here if you like */
}

/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using bare_related_posts(); )
function bare_related_posts() {
	echo '<ul id="bare-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) { 
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'baretheme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
} /* end bare related posts function */

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function bare_page_navi() {
	global $wp_query;
	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 )
		return;
	
	echo '<nav class="pagination">';
	
		echo paginate_links( array(
			'base' 			=> str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
			'format' 		=> '',
			'current' 		=> max( 1, get_query_var('paged') ),
			'total' 		=> $wp_query->max_num_pages,
			'prev_text' 	=> '&larr;',
			'next_text' 	=> '&rarr;',
			'type'			=> 'list',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) );
	
	echo '</nav>';
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bare_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function bare_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __( 'Read', 'baretheme' ) . get_the_title($post->ID).'">'. __( 'Read more &raquo;', 'baretheme' ) .'</a>';
}

/*
 * returns a link to the list of the author's posts.
 */
function bare_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}
?>