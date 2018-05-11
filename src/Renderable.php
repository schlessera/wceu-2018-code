<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop;

interface Renderable {

	/**
	 * Render the current Renderable.
	 *
	 * @param array $context Context in which to render.
	 *
	 * @return string Rendered output.
	 */
	public function render( array $context = [] ): string;
}
