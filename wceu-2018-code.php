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
use WordCampEurope\Workshop\Config\OrderStrategies;
use WordCampEurope\Workshop\Config\SocialNetworks;

$autoloader = __DIR__ . '/vendor/autoload.php';

if ( is_readable( $autoloader ) ) {
	include_once $autoloader;
}

// This is the collection of networks we have access to.
$networks = SocialNetworks::create_from_file( 'social-networks.php' );

// This is the collection of order strategies we have access to.
$order_strategies = OrderStrategies::create_from_file( 'order-strategies.php' );

// We need an order strategy factory so that the block logic can ignore the
// actual sorting logic and we can move that into separate objects and make
// it more future-proof that way.
$order_strategy_factory = new SocialNetwork\OrderStrategyFactory(
	$order_strategies
);

// Now we instantiate a feed factory that our Gutenberg block will later be able
// to use to instantiate feeds.
$feed_factory = new SocialNetwork\FeedFactory(
	$networks,
	$order_strategy_factory
);

// We also need a view factory for our Gutenberg block. We use a "templated" one
// that allows for the view templates to be overridden through parent and child
// themes.
$view_factory = new View\TemplatedViewFactory();

// Then we can instantiate the Gutenberg block and inject all of its
// dependencies.
$social_media_mentions = new Block\SocialMediaMentions(
	$feed_factory,
	$view_factory,
	$networks,
	$order_strategies
);

// Finally, we hook up our Gutenberg to the WordPress lifecycle.
add_action( 'init', [ $social_media_mentions, 'register' ] );
