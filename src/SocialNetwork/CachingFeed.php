<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

final class CachingFeed implements Feed {

	/**
	 * Format of the cache key.
	 */
	const KEY_FORMAT = 'wceu2018/mentions/%s/%s/%s';

	/**
	 * Feed to cache.
	 *
	 * @var Feed
	 */
	private $feed;

	/**
	 * Instantiate a CachingFeed object.
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
		$key = sprintf(
			self::KEY_FORMAT,
			md5( get_class( $this->feed ) ),
			md5( $mention ),
			$limit
		);

		$entries = get_transient( $key );

		if ( false !== $entries ) {
			return $entries;
		}

		$entries = $this->feed->get_entries( $mention, $limit );

		set_transient( $key, $entries, 1 * MINUTE_IN_SECONDS );

		return $entries;
	}
}
