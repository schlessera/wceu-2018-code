<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\View;

use WordCampEurope\Workshop\Exception\InvalidEscapeContext;
use WordCampEurope\Workshop\View;

final class TemplatedViewFactory implements ViewFactory {

	/**
	 * Create a new view instance.
	 *
	 * @param string $uri            Template URI to create the view for.
	 * @param string $escape_context Escape context to use for the view.
	 *
	 * @return View View instance to use.
	 */
	public function create( string $uri, string $escape_context = '' ): View {
		$view = new TemplatedView( $uri );

		if ( empty( $escape_context ) ) {
			return $view;
		}

		if ( ! class_exists( $escape_context ) ) {
			throw InvalidEscapeContext::from_escape_context( $escape_context );
		}

		return new $escape_context( $view );
	}
}
