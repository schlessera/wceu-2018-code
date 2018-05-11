<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop;

/*
 * Plugin Name:     WCEU-2018 Workshop Code: Dependency Injection and Design Patterns in Real Life
 * Plugin URI:      https://github.com/schlessera/wceu-2018-code
 * Description:     Workshop code for the WordCamp Europe 2018 Workshop "Dependency Injection and Design Patterns in Real Life" presented by David Mosterd & Alain Schlesser
 * Author:          David Mosterd & Alain Schlesser
 * Text Domain:     wceu-2018-code
 * Domain Path:     /languages
 * Version:         1.0.0
 */

if ( ! defined( 'WCEU_2018_WORKSHOP_PLUGIN_DIR' ) ) {
	define( 'WCEU_2018_WORKSHOP_PLUGIN_DIR', __DIR__ );
}

if ( ! defined( 'WCEU_2018_WORKSHOP_PLUGIN_URL' ) ) {
	define(
		'WCEU_2018_WORKSHOP_PLUGIN_URL',
		plugins_url( null, __FILE__ )
	);
}

$autoloader = WCEU_2018_WORKSHOP_PLUGIN_DIR . '/vendor/autoload.php';
if ( is_readable( $autoloader ) ) {
	include_once $autoloader;
}

add_action( 'init', [ new Block\SocialMediaMentions(), 'register' ] );
