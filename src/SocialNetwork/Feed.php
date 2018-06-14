<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

/**
 * A feed represents a collection of feed entries for a specific social network.
 */
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
