<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\CachingEngine;

use WordCampEurope\Workshop\CachingEngine;

/**
 * Implementation of the CachingEngine interface that uses the WordPress object
 * cache.
 *
 * Note: This only does real caching if a persistent object cache has been
 * properly configured for use by WordPress.
 *
 * This only caches values for the current process using static memory.
 */
final class ObjectCache extends CachingEngine {

	/**
	 * Read operation on the cache.
	 *
	 * @param string $key Identifier under which to remember the value.
	 *
	 * @return mixed Value of the cache.
	 */
	public function read( string $key ) {
		return wp_cache_get( $key );
	}

	/**
	 * Write operation on the cache.
	 *
	 * @param string $key        Identifier under which to remember the value.
	 * @param mixed  $value      Value to write to the cache.
	 * @param int    $expiration Expiration time in seconds.
	 */
	public function write( string $key, $value, int $expiration ) {
		wp_cache_set( $key, $value, null, $expiration );
	}
}
