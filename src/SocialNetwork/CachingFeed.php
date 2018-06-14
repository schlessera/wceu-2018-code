<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

use WordCampEurope\Workshop\CachingEngine;

/**
 * Turns an implementation of the Feed interface that represents a collection
 * of feed entries into a cached collection of feed entries that only get
 * recalculated when the cache expires or when the attributes change.
 *
 * Pattern: Decorator
 *
 * @see http://designpatternsphp.readthedocs.io/en/latest/Structural/Decorator/README.html
 */
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
	 * Caching engine to use.
	 *
	 * @var CachingEngine
	 */
	private $cache;

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

		return $this->cache->remember(
			$key,
			function () use ( $attributes ) {
				return $this->feed->get_entries( $attributes );
			},
			5 * MINUTE_IN_SECONDS
		);
	}
}
