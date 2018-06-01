<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Asset\Location;

use WordCampEurope\Workshop\Asset\Location;

final class Relative implements Location {

	/**
	 * Location relative to the plugin base dir.
	 *
	 * @var string
	 */
	private $relative_location;

	/**
	 * Instantiate a Relative object.
	 *
	 * @param string $relative_location Location relative to the plugin base
	 *                                  dir.
	 */
	public function __construct( string $relative_location ) {
		$this->relative_location = $relative_location;
	}

	/**
	 * Get the URI of the location to access it from the client.
	 *
	 * @return string Absolute client-side URI.
	 */
	public function get_uri(): string {
		return trailingslashit( plugins_url( null, dirname( __FILE__, 3 ) ) )
		       . ltrim( $this->relative_location, '/' );
	}

	/**
	 * Get the filesystem path of the location to access it on the server.
	 *
	 * @return string Absolute filesystem path.
	 */
	public function get_path(): string {
		return trailingslashit( dirname( __DIR__, 3 ) )
		       . ltrim( $this->relative_location, '/' );
	}
}
