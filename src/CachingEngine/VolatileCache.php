<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\CachingEngine;

use WordCampEurope\Workshop\CachingEngine;

/**
 * Volatile implementation of the CachingEngine interface.
 *
 * This only caches values for the current process using static memory.
 */
final class VolatileCache extends CachingEngine {

	/**
	 * Values stored in the cache.
	 *
	 * @var array
	 */
	private $values = [];

	/**
	 * Expiry timestamps for the cache.
	 *
	 * @var array<int>
	 */
	private $expiry_timestamps = [];

	/**
	 * Read operation on the cache.
	 *
	 * @param string $key Identifier under which to remember the value.
	 *
	 * @return mixed Value of the cache.
	 */
	public function read( string $key ) {
		if ( ! array_key_exists( $key, $this->values )
		     || ! array_key_exists( $key, $this->expiry_timestamps ) ) {
			return false;
		}

		if ( $this->expiry_timestamps[ $key ] < time() ) {
			return false;
		}

		return $this->values[ $key ];
	}

	/**
	 * Write operation on the cache.
	 *
	 * @param string $key        Identifier under which to remember the value.
	 * @param mixed  $value      Value to write to the cache.
	 * @param int    $expiration Expiration time in seconds.
	 */
	public function write( string $key, $value, int $expiration ) {
		$this->values[ $key ]            = $value;
		$this->expiry_timestamps[ $key ] = time() + $expiration;
	}
}
