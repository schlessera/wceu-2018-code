<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\View;

use WordCampEurope\Workshop\View;

/**
 * Interface for a factory that instantiates implementations of the View
 * interface.
 *
 * Pattern: Simple Factory
 *
 * @see http://designpatternsphp.readthedocs.io/en/latest/Creational/SimpleFactory/README.html
 */
interface ViewFactory {

	/**
	 * Create a new view instance.
	 *
	 * @param string $uri            Template URI to create the view for.
	 * @param string $escape_context Escape context to use for the view.
	 *
	 * @return View View instance to use.
	 */
	public function create( string $uri, string $escape_context = '' ): View;
}
