<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

interface Feed {

	const NETWORK_TWITTER = 'twitter';

	const NETWORK_WORDPRESS = 'wordpress';

	/**
	 * Get the feed entries for the social network.
	 *
	 * @param Attributes $attributes Attributes to get the feed entry for.
	 *
	 * @return FeedEntry[] Array of FeedEntry objects.
	 */
	public function get_entries( Attributes $attributes ): array;
}
