<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\View;

use WordCampEurope\Workshop\View;

/**
 * Decorator that escapes the rendering output of a given view for a WordPress
 * Post context. This means that the content will be passed through the
 * wp_kses_post() method.
 *
 * Pattern: Decorator
 *
 * @see http://designpatternsphp.readthedocs.io/en/latest/Structural/Decorator/README.html
 */
final class PostEscapedView implements View {

	/**
	 * View instance to decorate.
	 *
	 * @var View
	 */
	private $view;

	/**
	 * Instantiate a PostEscapedView object.
	 *
	 * @param View $view View instance to decorate.
	 */
	public function __construct( View $view ) {
		$this->view = $view;
	}

	/**
	 * Render a given URI.
	 *
	 * @param array $context Context in which to render.
	 *
	 * @return string Rendered HTML.
	 */
	public function render( array $context = [] ): string {
		return wp_kses_post( $this->view->render( $context ) );
	}

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
	 * @return string Rendered HTML.
	 */
	public function section( $uri, array $context = null ): string {
		return wp_kses_post( $this->view->section( $uri, $context ) );
	}
}
