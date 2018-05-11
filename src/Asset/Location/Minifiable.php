<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Asset\Location;

use WordCampEurope\Workshop\Asset\Location;

final class Minifiable implements Location {

	const SUFFIX = '.min';

	/**
	 * Location that can be minified.
	 *
	 * @var Location
	 */
	private $location;

	/**
	 * Instantiate a Minifiable object.
	 *
	 * @param Location $location Location that can be minified.
	 */
	public function __construct( Location $location ) {
		$this->location = $location;
	}

	/**
	 * Get the URI of the location to access it from the client.
	 *
	 * @return string Absolute client-side URI.
	 */
	public function get_uri(): string {
		return $this->maybe_add_suffix( $this->location->get_uri() );
	}

	/**
	 * Get the filesystem path of the location to access it on the server.
	 *
	 * @return string Absolute filesystem path.
	 */
	public function get_path(): string {
		return $this->maybe_add_suffix( $this->location->get_path() );
	}

	/**
	 * Maybe add a minified suffix to the location.
	 *
	 * @param string $location Location that might need a suffix.
	 *
	 * @return string Location that was modified as needed.
	 */
	private function maybe_add_suffix( string $location ): string {
		if ( ! $this->should_be_minified( $location ) ) {
			return $location;
		}

		list( $dirname, $basename, $extension, $filename ) = pathinfo( $location );

		$minified_location = sprintf(
			'%s/%s%s.%s',
			$dirname,
			$filename,
			self::SUFFIX,
			$extension
		);

		if ( ! file_exists( $minified_location ) ) {
			return $location;
		}

		return $minified_location;
	}

	/**
	 * Check whether assets should be used in their minified version.
	 *
	 * @param string $location Location of the asset for which to check.
	 *
	 * @return bool Whether minified assets should be used.
	 */
	private function should_be_minified( string $location ): bool {
		return ! defined( 'SCRIPT_DEBUG' )
		       || ! SCRIPT_DEBUG;
	}
}
