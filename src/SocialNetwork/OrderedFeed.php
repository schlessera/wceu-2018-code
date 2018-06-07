<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

final class OrderedFeed implements Feed {

	/**
	 * Feed to cache.
	 *
	 * @var Feed
	 */
	private $feed;

	/**
	 * Instantiate a OrderedFeed object.
	 *
	 * @param Feed $feed Feed to cache.
	 */
	public function __construct( Feed $feed ) {
		$this->feed = $feed;
	}

	/**
	 * Get the feed entries for the social network.
	 *
	 * @param string $mention Mention to get the feed for.
	 * @param int    $limit   Optional. Limit the number of feed entries to this
	 *                        number. Defaults to 5.
	 *
	 * @return FeedEntry[] Array of FeedEntry objects.
	 */
	public function get_entries( string $mention, int $limit = 5 ): array {
		$entries = $this->feed->get_entries( $mention, $limit );

		// TODO: Sort entries using a Strategy.

		return $entries;
	}
}
