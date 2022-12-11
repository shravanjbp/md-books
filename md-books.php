<?php
/*
Plugin Name: Books Library
Description: Enables functionality to add books and search them.
Version: 1.0.0
Author: Shravan Sharma
Author URI: http://shravan.com/
Text Domain: md-books-library
Domain Path: /languages
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

define( 'MDBOOKS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MDBOOKS_PLUGIN_FILE', __FILE__ );

if( !class_exists( 'MdBooks' ) ) {

	// Bootstrap Class
	class MdBooks {
	    public static $version = '1.0.0';
	    public static $prefix = 'mdbooks_';
	    public static $app;

	    public static function autoload( $className ) {
	        if( strpos($className, '\\' ) !== false ) {
	            $classPath = explode( '\\', $className );
	            if( $classPath[0] == 'MdBooks' ) { //print_r($classPath);
	                $fileName = MDBOOKS_PLUGIN_PATH.$classPath[1].DIRECTORY_SEPARATOR.$classPath[2].'.php';
	                require_once $fileName;
	            }
	        }
	    }

	}

	spl_autoload_register( array( 'MdBooks', 'autoload' ), true, true );
	MdBooks::$app = new \MdBooks\Controller\MdBooksApp();
}