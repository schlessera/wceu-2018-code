<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

final class CachingFeed implements Feed {

	/**
	 * Format of the cache key.
	 */
	const KEY_FORMAT = 'wceu2018/mentions/%s';

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
	 * @param Attributes $attributes Attributes to get the feed entry for.
	 *
	 * @return FeedEntry[] Array of FeedEntry objects.
	 */
	public function get_entries( Attributes $attributes ): array {
		$key = sprintf(
			self::KEY_FORMAT,
			md5( json_encode( $attributes->all() ) )
		);

		$entries = get_transient( $key );

		if ( false !== $entries ) {
			return $entries;
		}

		$entries = $this->feed->get_entries( $attributes );

		set_transient( $key, $entries, 1 * MINUTE_IN_SECONDS );

		return $entries;
	}
}
