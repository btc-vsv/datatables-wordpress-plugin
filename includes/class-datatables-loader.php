<?php

class DataTables_Loader
{
    private $version;

    function __construct() {
        $this->version = DATATABLES_VERSION;

        add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
    }

    public function front_scripts() {
        wp_enqueue_style( 'datatables-style', plugins_url( 'assets/css/datatables.min.css', DATATABLES_FILE ) );
        wp_enqueue_script( 'datatables-script', plugins_url( 'assets/js/datatables.min.js', DATATABLES_FILE ), array( 'jquery' ), $this->version, true );
        wp_enqueue_script( 'datatables-options', plugins_url( 'assets/js/datatables-options.js', DATATABLES_FILE ), array( 'jquery' ), $this->version, true );
    }
}

new DataTables_Loader;
