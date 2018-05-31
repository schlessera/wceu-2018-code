<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork\Twitter;

use WordCampEurope\Workshop\SocialNetwork\Feed as FeedInterface;
use WordCampEurope\Workshop\SocialNetwork\FeedEntry;

final class Feed implements FeedInterface {

	/**
	 * Get the feed entries for the social network.
	 *
	 * @param int $limit Optional. Limit the number of feed entries to this
	 *                   number. Defaults to 5.
	 *
	 * @return FeedEntry[] Array of FeedEntry objects.
	 */
	public function get_entries( int $limit = 5 ): array {
		$entries = [];

		// TODO: retrieve entries.
		return $entries;
	}
}
