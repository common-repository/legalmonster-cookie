<?php
/**
 * Plugin Name: Legalmonster Cookie Plugin
 * Plugin URI: http://www.legalmonster.com/cookie
 * Description: Legal Monster provide a well-designed and compliant cookie pop-up for your wordpress site. Easy and good looking compliance in no time!
 * Version: 1.1.1
 * Author: Legal Monster Aps
 * Author URI: http://www.legalmonster.com
 */

class Legalmonster_Plugin {
	/**
	* Constructor
	*/
	public function __construct() {

		// Plugin Details
        $this->plugin               = new stdClass;
        $this->plugin->name         = 'legalmonster'; // Plugin Folder
        $this->plugin->displayName  = 'Legal Monster Cookie Pop-up'; // Plugin Name
        $this->plugin->version      = '1.1.1';
        $this->plugin->folder       = plugin_dir_path( __FILE__ );
        $this->plugin->url          = plugin_dir_url( __FILE__ );
        $this->plugin->db_welcome_dismissed_key = $this->plugin->name . '_welcome_dismissed_key';

		// Hooks
		add_action( 'admin_init', array( &$this, 'registerSettings' ) );
        add_action( 'admin_menu', array( &$this, 'adminPanelsAndMetaBoxes' ) );

        // Frontend Hooks
		add_action( 'wp_footer', array( &$this, 'frontendFooter' ) );
		add_action( 'admin_enqueue_scripts', array( 
                    $this,
                    'legalmonster_style'
                ));
	}




	/**
	 * Enqueue a script in the WordPress admin on edit.php.
	 *
	 * @param int $hook Hook suffix for the current admin page.
	 */
	function legalmonster_style( $hook ) {
		if($hook != 'toplevel_page_legalmonster') {
	        return;
	    }
		wp_enqueue_style( 'wp-legalmonster-style', plugins_url('css/style.css', __FILE__));
    	wp_enqueue_script( 'wp-legalmonster-js', plugins_url( 'js/openTab.js', __FILE__ ));
	}

	/**
    * Output the Administration Panel
    * Save POSTed data from the Administration Panel into a WordPress option
    */
    function adminPanel() {
		// only admin user can access this page
		if ( !current_user_can( 'administrator' ) ) {
			echo '<p>' . __( 'Sorry, you are not allowed to access this page.', 'legalmonster' ) . '</p>';
			return;
		}

    	// Save Settings
        if ( isset( $_REQUEST['submit'] ) ) {
        	// Check nonce
			if ( !isset( $_REQUEST[$this->plugin->name.'_nonce'] ) ) {
	        	// Missing nonce
	        	$this->errorMessage = __( 'nonce field is missing. Settings NOT saved.', 'legalmonster' );
        	} elseif ( !wp_verify_nonce( $_REQUEST[$this->plugin->name.'_nonce'], $this->plugin->name ) ) {
	        	// Invalid nonce
	        	$this->add_flash_notice( __("My notice message, this is an info, but, it is not dismissible"), "error", true );
        	} else {
	        	// Save
				// $_REQUEST has already been slashed by wp_magic_quotes in wp-settings
				// so do nothing before saving

				if ( isset ( $_REQUEST['lm_insert_footer'] )) {
					update_option( 'lm_insert_footer', sanitize_text_field($_REQUEST['lm_insert_footer']) );
				}

				if ( isset ( $_REQUEST['lm_locale'] )) {
					update_option( 'lm_locale', sanitize_text_field($_REQUEST['lm_locale']) );
				}


	    		$this->add_flash_notice( __("Settings updated!"), "success", true );
				update_option( $this->plugin->db_welcome_dismissed_key, 1 );
			}

		

        }

        // Get latest settings
        $this->settings = array(
			'lm_insert_footer' => esc_html( wp_unslash( get_option( 'lm_insert_footer' ) ) ),
			'lm_locale' => esc_html( wp_unslash( get_option( 'lm_locale' ) ) )
        );


    	// Load Settings Form
        include_once( $this->plugin->folder . '/views/settings.php' );

    }

    /**
	* Loads plugin textdomain
	*/
	function loadLanguageFiles() {
		load_plugin_textdomain( 'legalmonster', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	* Outputs script / CSS to the frontend footer
	*/
	function frontendFooter() {
		$snippet = '
			<script>
	    		!function(){var i,e,t,s=window.legal=window.legal||[];if(s.SNIPPET_VERSION="3.0.0",i="https://widgets.legalmonster.com/v1/legal.js",!s.__VERSION__)if(s.invoked)window.console&&console.info&&console.info("legal.js: The initialisation snippet is included more than once on this page, and does not need to be.");else{for(s.invoked=!0,s.methods=["cookieConsent","document","ensureConsent","handleWidget","signup","user"],s.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);return e.unshift(t),s.push(e),s}},e=0;e<s.methods.length;e++)t=s.methods[e],s[t]=s.factory(t);s.load=function(e,t){var n,o=document.createElement("script");o.setAttribute("data-legalmonster","sven"),o.type="text/javascript",o.async=!0,o.src=i,(n=document.getElementsByTagName("script")[0]).parentNode.insertBefore(o,n),s.__project=e,s.__loadOptions=t||{}},s.widget=function(e){s.__project||s.load(e.widgetPublicKey),s.handleWidget(e)}}}();

			    legal.widget({
			        type: "cookie",
			        widgetPublicKey: "' . esc_js($this->output( 'lm_insert_footer' )) . '" ,
			        locale: "' . esc_js($this-> set_locale() ). '"
			    });
			</script>';
			echo $snippet;
	}

	/**
    * Register the plugin settings panel
    */
	function adminPanelsAndMetaBoxes() {
		$logo = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 127.5 126.8"><style type="text/css">.st0{fill:#FFFFFF;}</style><g id="Draw_Layer"><path d="M127.4,67.4c-0.2-6.8-0.9-12.8-3.1-19.3c3.5,0.7-1.3-8.5-1.9-9.4c-1.9-3.6-4.3-7-7.1-10c1.7-4.8-8.3-12.1-8.3-12.1		c-2.8-1.9-8.7-5.9-11-7.4C94.8,4.2,81.5,0,63.8,0S37.6,1.8,36.2,6.7c-5.9,1.4-19,8.1-18.3,14.9C14.4,23.9,0.3,35.9,6.1,39.6		c-3.1,3-9.6,24.3-3.7,25.9c-1.3,4.3-1.9,28.7,5.7,26.7c1.2,4.5,3.1,8.7,5.9,12.4c1.9,2.6,5.4,8.1,9,7.5		c3.1,5.2,16.5,15.4,22.3,12.2c8.3,3.3,18.1,2.4,26.7,1.1c3.6,2.3,8.3,0,11.8-1.5c4.6-1.7,9-4.1,12.9-7c6.2,4.9,15.9-13.3,17.4-17.1		c3.3-1.1,4.6-2.2,6.1-5.6c0.9-2.1,1.7-4.3,2.2-6.5c1-3.5,1.5-7.2,1.4-10.8C128.1,76.9,127.6,70.3,127.4,67.4z"/>	<path d="M102.7,13.6L102.7,13.6z"/>	<path class="st0" d="M99.7,56.3L99.7,56.3c0.4-4.5-3.7-4-7-4.1c-3.6-0.1-7.1-0.1-10.7,0h-1.9c0.8,1.8,1.3,3.6,1.5,5.5		c0.8,9.2-6.8,17.3-15.4,19.4c-7.9,2-17.7-2.5-19.8-10.8c-1-4.4-0.7-9,1-13.1c-3.1,0.2-6.2,0.4-9.3,0.6c-2.3,0.2-4.8,0.1-7.1,0.5		c-4.8,0.8-2.9,4.6-2.5,8.2l0,0c0.3,1.8,0.9,3.6,1.7,5.3v-0.1c5.3,12.2,16.7,19.2,29.5,20.8h-0.1c10.1,1.3,21.5-1.7,28.6-9.2		c2.5-2.8,4.7-5.8,6.5-9.1C96.8,66.7,100.4,60.6,99.7,56.3z"/></g></svg>';
		add_menu_page( $this->plugin->displayName, $this->plugin->displayName, 'manage_options', $this->plugin->name, array( &$this, 'adminPanel' ), 'data:image/svg+xml;base64,' . base64_encode($logo) );
	}

	/**
	* Register Settings
	*/
	function registerSettings() {
		register_setting( $this->plugin->name, 'lm_insert_footer', 'trim' );
		register_setting( $this->plugin->name, 'lm_locale', 'trim' );
	}

	function set_locale() {
		if (empty (get_option( 'lm_locale' ) ) ) {
			return 'en-us';
		} else {
			return get_option( 'lm_locale' );
		}

	}

	/**
	* Outputs the given setting, if conditions are met
	*
	* @param string $setting Setting Name
	* @return output
	*/
	function output( $setting ) {
		// Ignore admin, feed, robots or trackbacks
		if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {
			return;
		}

		// provide the opportunity to Ignore IHAF - both headers and footers via filters
		if ( apply_filters( 'disable_lm', false ) ) {
			return;
		}

		// provide the opportunity to Ignore IHAF - footer only via filters
		if ( 'lm_insert_footer' == $setting && apply_filters( 'disable_lm_footer', false ) ) {
			return;
		}

		// Get meta
		$meta = get_option( $setting );
		if ( empty( $meta ) ) {
			return;
		}
		if ( trim( $meta ) == '' ) {
			return;
		}

		// Output
		return sanitize_text_field( $meta );
	}


	 /**
	 * Add a flash notice to {prefix}options table until a full page refresh is done
	 *
	 * @param string $notice our notice message
	 * @param string $type This can be "info", "warning", "error" or "success", "warning" as default
	 * @param boolean $dismissible set this to TRUE to add is-dismissible functionality to your notice
	 * @return void
	 */
	 
	function add_flash_notice( $notice = "", $type = "warning", $dismissible = true ) {
	    // Here we return the notices saved on our option, if there are not notices, then an empty array is returned
	    $notices = get_option( "my_flash_notices", array() );
	 
	    $dismissible_text = ( $dismissible ) ? "is-dismissible" : "";
	 
	    // We add our new notice.
	    array_push( $notices, array( 
	            "notice" => $notice, 
	            "type" => $type, 
	            "dismissible" => $dismissible_text
	        ) );
	 
	    // Then we update the option with our notices array
	    update_option("my_flash_notices", $notices );
	    $this->display_flash_notices();
	}
	 
	/**
	 * Function executed when the 'admin_notices' action is called, here we check if there are notices on
	 * our database and display them, after that, we remove the option to prevent notices being displayed forever.
	 * @return void
	 */
	 
	function display_flash_notices() {
	    $notices = get_option( "my_flash_notices", array() );
	     
	    // Iterate through our notices to be displayed and print them.
	    foreach ( $notices as $notice ) {
	        printf('<div class="notice notice-%1$s %2$s"><p>%3$s</p></div>',
	            $notice['type'],
	            $notice['dismissible'],
	            $notice['notice']
	        );
	    }
	 
	    // Now we reset our options to prevent notices being displayed forever.
	    if( ! empty( $notices ) ) {
	        delete_option( "my_flash_notices", array() );
	    }
	}

	
}

$lm = new Legalmonster_Plugin();