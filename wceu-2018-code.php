<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop;

use WordCampEurope\Workshop\ExceptionHandler\AdminNotice;

/*
 * Plugin Name:     WCEU-2018 Workshop Code: Dependency Injection and Design Patterns in Real Life
 * Plugin URI:      https://github.com/schlessera/wceu-2018-code
 * Description:     Workshop code for the WordCamp Europe 2018 Workshop "Dependency Injection and Design Patterns in Real Life" presented by David Mosterd & Alain Schlesser
 * Author:          David Mosterd & Alain Schlesser
 * Text Domain:     wceu-2018-code
 * Domain Path:     /languages
 * Version:         1.0.0
 */

// First we make sure the Autoloader that Composer provides is loaded.
$autoloader = __DIR__ . '/vendor/autoload.php';

if ( is_readable( $autoloader ) ) {
	include_once $autoloader;
}

$admin_notice = new AdminNotice();
$admin_notice->register();

$plugin = new ExceptionHandlerPlugin( new Plugin, $admin_notice );

add_action( 'init', [ $plugin, 'compose' ] );