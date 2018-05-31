<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

interface Feed {

	/**
	 * Get the feed entries for the social network.
	 *
	 * @param int $limit Optional. Limit the number of feed entries to this
	 *                   number. Defaults to 5.
	 *
	 * @return FeedEntry[] Array of FeedEntry objects.
	 */
	public function get_entries( int $limit = 5 ): array;
}
