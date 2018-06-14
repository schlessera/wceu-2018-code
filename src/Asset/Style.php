<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Asset;

/**
 * Asset implementation that represents a WordPress CSS asset.
 */
final class Style implements Enqueueable {

	/**
	 * Handle of the style asset.
	 *
	 * @var string
	 */
	private $handle;

	/**
	 * Location of the style asset.
	 *
	 * @var Location
	 */
	private $location;

	/**
	 * Array of handles that the style asset depends on.
	 *
	 * @var array<string>
	 */
	private $dependencies;

	/**
	 * Instantiate a Script object.
	 *
	 * @param string   $handle       Handle of the style asset.
	 * @param Location $location     Location of the style asset.
	 * @param array    $dependencies Optional. Array of handles that the style
	 *                               asset depends on. Defaults to an empty
	 *                               array.
	 */
	public function __construct(
		string $handle,
		Location $location,
		array $dependencies = []
	) {
		$this->handle       = $handle;
		$this->location     = $location;
		$this->dependencies = $dependencies;
	}

	/**
	 * Get the handle that is being used for enqueueing.
	 *
	 * @return string Handle under which to enqueue.
	 */
	public function get_handle(): string {
		return $this->handle;
	}

	/**
	 * Get the location of the style asset.
	 *
	 * @return Location Location of the file that represents the style asset.
	 */
	private function get_location(): Location {
		return $this->location;
	}

	/**
	 * Get the dependencies of the style asset.
	 *
	 * @return array Array of handles that the style depends on.
	 */
	private function get_dependencies(): array {
		return $this->dependencies;
	}

	/**
	 * Register an enqueueable object.
	 *
	 * @return void
	 */
	public function register() {
		wp_register_style(
			$this->get_handle(),
			$this->get_location()->get_uri(),
			$this->get_dependencies(),
			filemtime( $this->get_location()->get_path() )
		);
	}

	/**
	 * Enqueue an enqueueable object.
	 *
	 * @return void
	 */
	public function enqueue() {

		if ( wp_script_is( $this->get_handle(), 'enqueued' ) ) {
			return;
		}

		if ( ! wp_script_is( $this->get_handle(), 'registered' ) ) {
			$this->register();
		}

		wp_enqueue_style( $this->get_handle() );
	}
}
