<?php

namespace WordCampEurope\Workshop;

use WordCampEurope\Workshop\Exception\MissingDependency;

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
		// This is the collection of networks we have access to.
		$networks = Config\SocialNetworks::create_from_file(
			'social-networks.php'
		);

		// Now we instantiate a feed factory that our Gutenberg block will later be able
		// to use to instantiate feeds.
		$feed_factory = new SocialNetwork\FeedFactory(
			$networks
		);

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
			$feed_factory,
			$view_factory,
			$networks
		);

		// Finally, we hook up our Gutenberg to the WordPress lifecycle.
		$social_media_mentions->register();
	}

}