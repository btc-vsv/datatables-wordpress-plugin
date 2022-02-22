<?php

defined( 'ABSPATH' ) or exit;


class DataTables_Loader
{
    private $version;

    function __construct() {
        $this->version = DATATABLES_VERSION;

        // hooks
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_filter( 'plugin_action_links_' . plugin_basename( DATATABLES_FILE ), array( $this, 'plugin_action_links' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
    }

    public function admin_menu() {
        add_options_page(
            esc_html__( 'DataTables Settings', 'datatables' ),
            'DataTables',
            'manage_options',
            'datatables',
            array( $this, 'settings_page' )
        );
    }

    public function settings_page() {
        $options = $this->get_plugin_options();

        if ( isset( $_POST['submit'] ) ) {
            check_admin_referer( 'datatables_settings', 'nonce_field' );

            if ( in_array( $_POST['include'], array( 'everywhere', 'posts', 'manually' ), true ) ) {
                $options['include'] = $_POST['include'];
            }

            if ( ! empty( $_POST['posts_ids'] ) ) {
                $ids = explode( ',', str_replace( ' ', '', sanitize_text_field( $_POST['posts_ids'] ) ) );
                $options['posts_ids'] = array_map('absint', $ids);
            }

            update_option( 'datatables_options', $options );
        }

        require_once DATATABLES_DIR . '/templates/page-settings.php';
    }

    public function plugin_action_links( $actions ) {
        $settings_link['settings'] = sprintf(
            '<a href="%s">%s</a>',
            esc_url( admin_url( 'options-general.php?page=datatables' ) ),
            esc_html__( 'Settings', 'datatables' )
        );

        return array_merge( $settings_link, $actions );
    }

    public function admin_scripts() {
        wp_enqueue_script( 'datatables-admin', plugins_url( 'assets/js/datatables-admin.js', DATATABLES_FILE ), array( 'jquery' ), $this->version, true );
    }

    public function front_scripts() {
        $validate = $this->validate_include_scripts();
        if ( $validate ) {
            wp_enqueue_style( 'datatables-style', plugins_url( 'assets/css/datatables.min.css', DATATABLES_FILE ) );
            wp_enqueue_script( 'datatables-script', plugins_url( 'assets/js/datatables.min.js', DATATABLES_FILE ), array( 'jquery' ), $this->version, true );
            if ( 'manually' === $validate ) {
            } else {
                wp_enqueue_script( 'datatables-options', plugins_url( 'assets/js/datatables-options.js', DATATABLES_FILE ), array( 'jquery' ), $this->version, true );
            }
        }
    }

    private function validate_include_scripts() {
        $options = $this->get_plugin_options();

        switch ( $options['include'] ) {
            case 'everywhere':
            case ( 'posts' == $options['include'] && $this->is_include_posts( $options['posts_ids'] ) ):
                return true;
            case 'manually':
                return 'manually';
        }

        return false;
    }

    private function is_include_posts( $posts_ids ) {
        if ( is_page( $posts_ids ) || is_single( $posts_ids ) ) {
            return true;
        }

        return false;
    }

    private function get_plugin_options() {
        $options = get_option( 'datatables_options' );

        if ( ! $options ) {
            $options = array(
                'include' => 'everywhere',
                'posts_ids' => ''
            );

            update_option( 'datatables_options', $options );
        }

        return $options;
    }
}

new DataTables_Loader;
