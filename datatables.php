<?php
/**
 * The plugin bootstrap file
 *
 * @wordpress-plugin
 * Plugin Name:       DataTables
 * Description:       DataTables integration.
 * Version:           1.0.0
 * Author:            donvardix
 * Author URI:        https://t.me/donvardix
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       datatables
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) or exit;

class DataTables
{
    private static $instance;

    function __construct() {
        // php check
        if ( version_compare( phpversion(), '5.6', '<' ) ) {
            add_action( 'admin_notices', array( $this, 'upgrade_notice' ) );
            return;
        }

        // setup variables
        define( 'DATATABLES_VERSION', '1.0.0' );
        define( 'DATATABLES_DIR', dirname( __FILE__ ) );
        define( 'DATATABLES_FILE', __FILE__ );

        // get the gears turning
        require_once DATATABLES_DIR . '/includes/class-datatables-loader.php';
    }

    /**
     * Singleton
     */
    public static function instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Require PHP 5.6+
     */
    function upgrade_notice() {
        $message = __( 'DataTables requires PHP %s or above. Please contact your host and request a PHP upgrade.', 'datatables' );
        echo '<div class="error"><p>' . sprintf( $message, '5.6' ) . '</p></div>';
    }
}

function datatables_init() {
    return DataTables::instance();
}

datatables_init();
