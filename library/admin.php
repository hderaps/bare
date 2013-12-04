<?php
/*
This file handles the admin area and functions.
You can use this file to make changes to the
dashboard. Updates to this page are coming soon.
It's turned off by default, but you can call it
via the functions file.

*/

/************* DASHBOARD WIDGETS *****************/

// disable default dashboard widgets
function disable_default_dashboard_widgets() {
	// remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );    // Right Now Widget
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' ); // Comments Widget
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );  // Incoming Links Widget
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );         // Plugins Widget

	// remove_meta_box('dashboard_quick_press', 'dashboard', 'core' );   // Quick Press Widget
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );   // Recent Drafts Widget
	remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );         //
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );       //

	// removing plugin dashboard boxes
	remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );         // Yoast's SEO Plugin Widget
}

// RSS Dashboard Widget
function bare_rss_dashboard_widget() {
	if ( function_exists( 'fetch_feed' ) ) {
		include_once( ABSPATH . WPINC . '/feed.php' );               // include the required file
		$feed = fetch_feed( 'http://bare.karlworks.com/feed/rss/' );        // specify the source feed
		$limit = $feed->get_item_quantity(7);                        // specify number of items
		$items = $feed->get_items(0, $limit);                        // create an array of items
	}
	if ($limit == 0) echo '<div>The RSS Feed is either empty or unavailable.</div>';   // fallback message
	else foreach ($items as $item) { ?>

	<h4 style="margin-bottom: 0;">
		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date( __( 'j F Y @ g:i a', 'baretheme' ), $item->get_date( 'Y-m-d H:i:s' ) ); ?>" target="_blank">
			<?php echo $item->get_title(); ?>
		</a>
	</h4>
	<p style="margin-top: 0.5em;">
		<?php echo substr($item->get_description(), 0, 200); ?>
	</p>
	<?php }
}

// calling all custom dashboard widgets
function bare_custom_dashboard_widgets() {
	wp_add_dashboard_widget( 'bare_rss_dashboard_widget', __( 'Recently on Bare (Customize on admin.php)', 'baretheme' ), 'bare_rss_dashboard_widget' );
	/*
	Be sure to drop any other created Dashboard Widgets
	in this function and they will all load.
	*/ 
}


// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets' );
// adding any custom widgets
add_action( 'wp_dashboard_setup', 'bare_custom_dashboard_widgets' );


/************* CUSTOM OPTIONS PAGE ***************/
function bare_theme_options_init() {
  register_setting('bare_options', 'bare_theme_options');
}

function bare_theme_options_menu() {
  add_theme_page('Bare Options', 'Bare Options',
          'edit_theme_options', 'bare_theme_options', 'bare_theme_options_page');
}

function bare_theme_options_page() {
  global $select_options;
  if(!isset($_REQUEST['settings-updated'])) {
    $_REQUEST['settings-updated'] = false;
  }
?>
  <div>
    <h2>Bare Theme Options</h2>
  <?php if($_REQUEST['settings-updated']): ?>
    <div>
      <p><strong><?php _e('Options Saved', 'baretheme'); ?></strong></p>
    </div>
  <?php endif; ?>
  </div>
  
  <form method="post" action="options.php">
  <?php settings_fields('bare_options');
  $opts = get_option('bare_theme_options'); ?>
  
  <table>
    <tr valign="top"><th><?php _e('Navigation Button Position', 'baretheme'); ?></th>
      <td>
        <select id="bare_theme_options[navPosition]" name="bare_theme_options[navPosition]">
          <option value="left" <?php echo ($opts['navPosition'] == 'left') ? 'selected' : ''; ?>>Left</option>
          <option value="center" <?php echo ($opts['navPosition'] == 'center') ? 'selected' : ''; ?>>Center</option>
          <option value="right" <?php echo ($opts['navPosition'] == 'right') ? 'selected' : ''; ?>>Right</option>
        </select>
      </td>
    </tr>
    <?php // For more options, add them here ?>
  </table>
  
  <p><input type="submit" value="Save Options" /></p>
  </form>
<? }

add_action('admin_init', 'bare_theme_options_init');
add_action('admin_menu', 'bare_theme_options_menu');

/************* CUSTOM LOGIN PAGE *****************/

// calling your own login css so you can style it

//Updated to proper 'enqueue' method
//http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
function bare_login_css() {
	wp_enqueue_style( 'bare_login_css', get_template_directory_uri() . '/library/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function bare_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function bare_login_title() { return get_option( 'blogname' ); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'bare_login_css', 10 );
add_filter( 'login_headerurl', 'bare_login_url' );
add_filter( 'login_headertitle', 'bare_login_title' );


/************* CUSTOMIZE ADMIN *******************/

// Custom Backend Footer
function bare_custom_admin_footer() {
	_e( '<span id="footer-thankyou">Developed by <a href="http://yoursite.com" target="_blank">Your Site Name</a></span>. Built using <a href="http://bare.karlworks.com" target="_blank">Bare</a>.', 'baretheme' );
}

// adding it to the admin area
add_filter( 'admin_footer_text', 'bare_custom_admin_footer' );

?>
