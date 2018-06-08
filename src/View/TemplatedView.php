<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\View;

use WordCampEurope\Workshop\Exception\InvalidURI;

/**
 * Extension of the BaseView to make it "templated" in the WordPress sense of
 * the word.
 *
 * This means that it has a cascade of locations (child theme folder, parent
 * theme folder, plugin folder) that are scanned to find the view template to
 * be used for rendering.
 */
final class TemplatedView extends BaseView {

	/**
	 * Validate an URI.
	 *
	 * @param string $uri URI to validate.
	 *
	 * @return string Validated URI.
	 */
	protected function validate( $uri ): string {
		$uri = $this->check_extension( $uri, static::VIEW_EXTENSION );

		foreach ( $this->get_locations( $uri ) as $location ) {
			if ( is_readable( $location ) ) {
				return $location;
			}
		}

		if ( ! is_readable( $uri ) ) {
			throw InvalidURI::from_uri( $uri );
		}

		return $uri;
	}

	/**
	 * Get the possible locations for the view.
	 *
	 * @param string $uri URI of the view to get the locations for.
	 *
	 * @return array<string> Array of possible locations.
	 */
	protected function get_locations( $uri ): array {
		return [
			trailingslashit( STYLESHEETPATH ) . $uri,
			trailingslashit( TEMPLATEPATH ) . $uri,
			trailingslashit( dirname( __DIR__, 2 ) ) . $uri,
		];
	}
}
