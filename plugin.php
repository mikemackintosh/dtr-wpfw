<?php

defined('ABSPATH') or die("No script kiddies please!");

/**
 * dTR Plugin Framework
 **/
abstract class dtr_plugin {

	// Private variables
	private static
		$plugin_path,
		$plugin_url;

	private
		$settings = array(),
		$pages = array(),
		$taxonomies = array(),
		$custom_post_types = array();

	abstract function activation();
	abstract function deactivation();

	/*
	 *
	 */
	public function __construct(){

		// Plugin specifics
		self::$plugin_path = plugin_dir_path( __FILE__ );
		self::$plugin_url  = plugin_dir_url( __FILE__ );

	}

	public static function debug( $message ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $message ) || is_object( $message ) ) {
				error_log( print_r( $message ), true );
			} else {
				error_log( $message );
			}
		}
	}
	
	public static function make_singular( $word ) {
		$rules = array(
			'ss'  => false,
			'os'  => 'o',
			'ies' => 'y',
			'xes' => 'x',
			'oes' => 'o',
			'ves' => 'f',
			's'   => ''
		);

		// Loop through all the rules and do the replacement.
		foreach ( array_keys( $rules ) as $key ) {
			// If the end of the word doesn't match the key, it's not a candidate for replacement. Move on to the next plural ending.

			if ( substr( $word, ( strlen( $key ) * -1 ) ) != $key ) {
				continue;
			}

			// If the value of the key is false, stop looping and return the original version of the word.
			if ( $key === false ) {
				return $word;
			}

			// We've made it this far, so we can do the replacement.
			return substr( $word, 0, strlen( $word ) - strlen( $key ) ) . $rules[ $key ];
		}

		return $word;
	}

	public static function make_slug( $string ) {
		return str_replace( ' ', '-', strtolower( $string ) );
	}
}