<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Asset;

/**
 * Interface for an asset location.
 */
interface Location {

	/**
	 * Get the URI of the location to access it from the client.
	 *
	 * @return string Absolute client-side URI.
	 */
	public function get_uri(): string;

	/**
	 * Get the filesystem path of the location to access it on the server.
	 *
	 * @return string Absolute filesystem path.
	 */
	public function get_path(): string;
}
