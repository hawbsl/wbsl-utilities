<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.wbsys.co.uk
 * @since             1.1.0
 * @package           Wbsl_Utilities
 *
 * @wordpress-plugin
 * Plugin Name:       WBSL Utilities
 * Plugin URI:        www.wbsys.co.uk
 * Description:       Wimborne Business Systems Ltd utilities plugin
 * Version:           1.1.1
 * Author:            WBSL
 * Author URI:        www.wbsys.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wbsl-utilities
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wbsl-utilities-activator.php
 */
function activate_wbsl_utilities() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wbsl-utilities-activator.php';
	Wbsl_Utilities_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wbsl-utilities-deactivator.php
 */
function deactivate_wbsl_utilities() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wbsl-utilities-deactivator.php';
	Wbsl_Utilities_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wbsl_utilities' );
register_deactivation_hook( __FILE__, 'deactivate_wbsl_utilities' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wbsl-utilities.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.1.0
 */

 //FOOTER INFO
 //================================
function define_current_template( $template ) {
    $GLOBALS['current_theme_template'] = basename($template);
    return $template;
}
add_action('template_include', 'define_current_template', 1000);

function get_current_template( $echo = false ) {
     if( !isset( $GLOBALS['current_theme_template'] ) )
         return false;
     if( $echo )
         echo $GLOBALS['current_theme_template'];
     else
         return $GLOBALS['current_theme_template'];
}

//inject into the footer
function wbsl_insert_footer_meta() {
	    if ( is_user_logged_in() ) {            
			$current_user = wp_get_current_user();
 			
			if (endsWith($current_user->user_email, '@wbsys.co.uk') || $current_user->user_email=='michelle.bowrey@googlemail.com') {
            echo '<div style="margin-top:-20px;text-align:center;color:red;"><br>--xx'.$_SERVER['REMOTE_ADDR'].'xx<br>';           
                get_current_template( true ); 
            echo '</div>'; 
            ?>
            <style>.zurb-helper{background-color:yellow;position:fixed;top:0px;z-index:999999;color:red;width:20%;position:fixed;left:50%;margin-left:-10%;text-align:center;height:10px;font-size:10px;line-height:8px}</style>
            <div class="zurb-helper">
                <div class="show-for-small-only">
                    small
                </div>
                <div class="show-for-medium-only">
                    medium
                </div>
                <div class="show-for-large-only">
                    large
                </div>
                <div class="show-for-xlarge">
                    xlarge
                </div>
            </div>
            <?php
        }
    }
}
add_action( 'wp_footer', 'wbsl_insert_footer_meta', 100 );
	
	
//STRING FUNCTIONS
//================================
function startsWith($haystack, $needle)
    {return $needle === "" || strpos($haystack, $needle) === 0;}

function endsWith($haystack, $needle)
    {return $needle === "" || substr($haystack, -strlen($needle)) === $needle;}
	
	
//BRANDED LOGIN
//================================
function wbsl_change_my_wp_login_image() {
	
	$filename=get_bloginfo('template_url')."/assets/images/wbsl-admin-logo.png";
	$file_headers = @get_headers($filename);
	if($file_headers[0] == 'HTTP/1.0 404 Not Found'){		
		$filename="http://www.wd4d.co.uk/wp-admin-logo.png";
	}
	
	echo "
	<style>
		body.login #login h1 a {
		background: url('".$filename."') 0px 0 no-repeat transparent;
		height:148px;
		width:320px; }
	</style>
	";
}
add_action("login_head", "wbsl_change_my_wp_login_image");
	
function wbsl_custom_login_message() {
	$message = '<p class="message">Supported customers call <a href="tel:01202849492">01202 849492</a> or email <a href="mailto:webteam@wbsys.co.uk">webteam@wbsys.co.uk</a> for help.</p><br>';
	return $message;
}
add_filter('login_message', 'wbsl_custom_login_message');	


//HACK THE ADMIN MENUS
//=========================
add_action( 'admin_menu', 'wbsl_remove_menus', 999 );
function wbsl_remove_menus() {
    
    //best tutorial for this is here:
    //http://justintadlock.com/archives/2011/06/13/removing-menu-pages-from-the-wordpress-admin
        
    //MENUS
    //remove comments
    //remove_menu_page( 'edit-comments.php' );

    //remove comments
    //remove_menu_page( 'tools.php' );
    //remove_menu_page( 'edit.php?post_type=acf' );    //This is advanced custom fields Pages
        
    //SUBMENUS
    // = theme editor
    //remove_submenu_page( 'themes.php', 'theme-editor.php' );
    // = widgets
    //remove_submenu_page( 'themes.php', 'widgets.php' );
    
    ////don't show the Post Type Instructions settings
    //remove_submenu_page( 'options-general.php', 'apti' );
    //remove_submenu_page( 'options-general.php', 'mla-settings-menu-general' );

    $current_user = wp_get_current_user();
    
    if ($current_user->user_login !="WBSupport") {
        $list=get_option('admin_menus_to_suppress');
        $lines=explode(PHP_EOL, $list);
        foreach($lines as $line) {
            $line=str_replace("admin.php?page=", "", $line);
            remove_menu_page($line);
        }
    }
}  	

//SETTINGS PAGE
function wbsl_theme_settings_page()
{
    ?>
	    <div class="wrap">
	    <h1>WBSL Settings</h1>
	    <form method="post" action="options.php">
	        <?php
	            settings_fields("section");
	            do_settings_sections("theme-options");      
	            submit_button(); 
	        ?>          
	    </form>
		</div>
	<?php
}

function wbsl_admin_menus_to_suppress()
{
	?>
    	<textarea type="text"  cols=120 rows=10 name="admin_menus_to_suppress" id="admin_menus_to_suppress"><?php echo get_option('admin_menus_to_suppress'); ?></textarea>
    <?php
}


function display_theme_panel_fields()
{
	add_settings_section("section", "All Settings", null, "theme-options");
	add_settings_field("admin_menus_to_suppress", "Admin URLs to Suppress<br><i>Input the part of the URL after http://mysite.co.uk/wp-admin/</i><br><br>Applies only to non-WBSupport logins", "wbsl_admin_menus_to_suppress", "theme-options", "section");
    register_setting("section", "admin_menus_to_suppress");

}

add_action("admin_init", "display_theme_panel_fields");

function wbsl_add_theme_menu_item()
{
	//add_menu_page("WBSL Settings", "WBSL Settings", "manage_options", "wbsl-theme-panel", "wbsl_theme_settings_page", null, 99);
    add_submenu_page(
        'options-general.php',
        'WBSL Settings',
        'WBSL Settings',
        'manage_options',
        'wbsl-theme-panel',
        'wbsl_theme_settings_page' );

}

add_action("admin_menu", "wbsl_add_theme_menu_item");

