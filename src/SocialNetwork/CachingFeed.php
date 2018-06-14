<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

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

		$value = $this->read( $key );

		if ( false === $value ) {
			$value = $this->feed->get_entries( $attributes );
			$this->write( $key, $value, 5 * MINUTE_IN_SECONDS );
		}

		return $value;
	}

	/**
	 * Read operation on the cache.
	 *
	 * @param string $key Identifier under which to remember the value.
	 *
	 * @return mixed Value of the cache.
	 */
	private function read( string $key ) {
		return get_transient( $key );
	}

	/**
	 * Write operation on the cache.
	 *
	 * @param string $key        Identifier under which to remember the value.
	 * @param mixed  $value      Value to write to the cache.
	 * @param int    $expiration Expiration time in seconds.
	 */
	private function write( string $key, $value, int $expiration ) {
		set_transient( $key, $value, $expiration );
	}
}
