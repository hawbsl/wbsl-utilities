<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.wbsys.co.uk
 * @since      1.1.0
 *
 * @package    Wbsl_Utilities
 * @subpackage Wbsl_Utilities/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.1.0
 * @package    Wbsl_Utilities
 * @subpackage Wbsl_Utilities/includes
 * @author     WBSL <webteam@wbsys.co.uk>
 */
class Wbsl_Utilities_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.1.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wbsl-utilities',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
