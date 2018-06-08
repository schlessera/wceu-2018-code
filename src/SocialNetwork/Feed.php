<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

interface Feed {

	/**
	 * Get the feed entries for the social network.
	 *
	 * @param Attributes $attributes Attributes to get the feed entry for.
	 *
	 * @return FeedEntry[] Array of FeedEntry objects.
	 */
	public function get_entries( Attributes $attributes ): array;
}
