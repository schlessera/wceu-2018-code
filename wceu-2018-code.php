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

// First we make sure the Autoloader that Composer provides is loaded.
$autoloader = __DIR__ . '/vendor/autoload.php';

if ( is_readable( $autoloader ) ) {
	include_once $autoloader;
}

// Now we instantiate a feed factory that our Gutenberg block will later be able
// to use to instantiate feeds.
$feed_factory = new SocialNetwork\FeedFactory( [
	SocialNetwork\Feed::NETWORK_WORDPRESS => new Config\NullConfig(),
	SocialNetwork\Feed::NETWORK_TWITTER   => new Config\TwitterCredentials(
		include __DIR__ . '/config/twitter-credentials.php'
	),
] );

// We also need a view factory for our Gutenberg block. We use a "templated" one
// that allows for the view templates to be overridden through parent and child
// themes.
$view_factory = new View\TemplatedViewFactory();

// Now we instantiate the Gutenberg block and inject its dependencies.
$social_media_mentions = new Block\SocialMediaMentions(
	$feed_factory,
	$view_factory
);

// Finally, we hook up our Gutenberg to the WordPress lifecycle.
add_action( 'init', [ $social_media_mentions, 'register' ] );
