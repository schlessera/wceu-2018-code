<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\View;

use WordCampEurope\Workshop\Exception\FailedToLoadView;
use WordCampEurope\Workshop\Exception\InvalidURI;
use WordCampEurope\Workshop\View;

/**
 * Base implementation of the View interface.
 *
 * It uses PHP output buffering to render a standard PHP template into a string.
 *
 * Pattern: Template View
 *
 * @see https://martinfowler.com/eaaCatalog/templateView.html
 */
class BaseView implements View {

	/**
	 * Extension to use for view files.
	 */
	const VIEW_EXTENSION = 'php';

	/**
	 * URI to the view file to render.
	 *
	 * @var string
	 */
	protected $uri;

	/**
	 * Internal storage for passed-in context.
	 *
	 * @var array
	 */
	protected $_context_ = [];

	/**
	 * Instantiate a View object.
	 *
	 * @param string $uri URI to the view file to render.
	 */
	public function __construct( $uri ) {
		$this->uri = $this->validate( $uri );
	}

	/**
	 * Render a given URI.
	 *
	 * @param array $context Context in which to render.
	 *
	 * @return string Rendered HTML.
	 */
	public function render( array $context = [] ): string {

		// Add context to the current instance to make it available within the
		// rendered view.
		foreach ( $context as $key => $value ) {
			$this->$key = $value;
		}

		// Add entire context as array to the current instance to pass onto
		// partial views.
		$this->_context_ = $context;

		// Save current buffering level so we can backtrack in case of an error.
		// This is needed because the view itself might also add an unknown
		// number of output buffering levels.
		$buffer_level = ob_get_level();
		ob_start();

		try {
			include $this->uri;
		} catch ( \Exception $exception ) {
			// Remove whatever levels were added up until now.
			while ( ob_get_level() > $buffer_level ) {
				ob_end_clean();
			}
			throw FailedToLoadView::view_exception(
				$this->uri,
				$exception
			);
		}

		return ob_get_clean();
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
		$view = new static( $uri );

		return $view->render( $context ?: $this->_context_ );
	}

	/**
	 * Validate an URI.
	 *
	 * @param string $uri URI to validate.
	 *
	 * @return string Validated URI.
	 */
	protected function validate( $uri ): string {
		$uri = $this->check_extension( $uri, static::VIEW_EXTENSION );
		$uri = trailingslashit( dirname( __DIR__, 2 ) ) . $uri;

		if ( ! is_readable( $uri ) ) {
			throw InvalidURI::from_uri( $uri );
		}

		return $uri;
	}

	/**
	 * Check that the URI has the correct extension.
	 *
	 * Optionally adds the extension if none was detected.
	 *
	 * @param string $uri       URI to check the extension of.
	 * @param string $extension Extension to use.
	 *
	 * @return string URI with correct extension.
	 */
	protected function check_extension( $uri, $extension ): string {
		$detected_extension = pathinfo( $uri, PATHINFO_EXTENSION );

		if ( $extension !== $detected_extension ) {
			$uri .= '.' . $extension;
		}

		return $uri;
	}
}
