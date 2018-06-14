<?php

namespace WordCampEurope\Workshop;

use WordCampEurope\Workshop\Config\TwitterCredentials;
use WordCampEurope\Workshop\Config\WordPressComCredentials;
use WordCampEurope\Workshop\Exception\MissingDependency;
use WordCampEurope\Workshop\SocialNetwork;

/**
 * Plugins main class that is responsible of composing the object graph required to
 * run the plugin.
 */
class Plugin
	implements Composable {

	/**
	 * Compose our object graph
	 */
	public function compose() {
		$client = new SocialNetwork\Twitter\Client( TwitterCredentials::create_from_file( 'twitter-credentials.php' ) );
		$feed = new SocialNetwork\Twitter\Feed( $client );

		$client = new SocialNetwork\WordPress\Client( WordPressComCredentials::create_from_file( 'wordpress-com-credentials.php' ) );
		$feed = new SocialNetwork\WordPress\Feed( $client );

		// We also need a view factory for our Gutenberg block. We use a "templated" one
		// that allows for the view templates to be overridden through parent and child
		// themes.
		$view_factory = new View\TemplatedViewFactory();

		if ( ! function_exists( 'register_block_type' ) ) {
			throw MissingDependency::for_gutenberg();
		}

		// Then we can instantiate the Gutenberg block and inject all of its
		// dependencies.
		$social_media_mentions = new Block\SocialMediaMentions(
			$feed,
			$view_factory
		);

		// Finally, we hook up our Gutenberg to the WordPress lifecycle.
		$social_media_mentions->register();
	}

}