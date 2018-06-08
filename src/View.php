<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop;

/**
 * View interface.
 *
 * Pattern: Template View
 *
 * @see https://martinfowler.com/eaaCatalog/templateView.html
 */
interface View extends Renderable {

	/**
	 * Render a partial view as a section.
	 *
	 * This can be used from within a currently rendered view, to include
	 * nested partials.
	 *
	 * The passed-in context is optional, and will fall back to the parent's
	 * context if omitted.
	 *
	 * @param string     $uri     URI of the partial to render.
	 * @param array|null $context Context in which to render the partial.
	 *
	 * @return string Rendered output.
	 */
	public function section( $uri, array $context = null ): string;
}
