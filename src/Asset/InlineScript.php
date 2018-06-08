<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Asset;

final class InlineScript implements Enqueueable {

	/**
	 * Handle of the script asset.
	 *
	 * @var string
	 */
	private $handle;

	/**
	 * Script data to inline.
	 *
	 * @var string
	 */
	private $data;

	/**
	 * Where to inline the script relative to the handle.
	 *
	 * @var string
	 */
	private $position;

	/**
	 * Instantiate an InlineScript object.
	 *
	 * @param string $handle   Handle of the script to attach the inlining to.
	 * @param string $data     Script data to inline.
	 * @param string $position Optional. Where to inline the script relative to
	 *                         the handle. Defaults to 'after'.
	 */
	public function __construct(
		string $handle,
		string $data,
		string $position = 'after'
	) {
		$this->handle   = $handle;
		$this->data     = $data;
		$this->position = $position;
	}

	/**
	 * Get the handle to which the inline script should be attached to.
	 *
	 * @return string Handle to which the inline script should be attached.
	 */
	public function get_handle(): string {
		return $this->handle;
	}

	/**
	 * Get the data that should be inlined.
	 *
	 * @return string Data to inline.
	 */
	public function get_data(): string {
		return $this->data;
	}

	/**
	 * Get the position at which to inline the script relative to the handle.
	 *
	 * @return string Position to inline at.
	 */
	public function get_position(): string {
		return $this->position;
	}

	/**
	 * Register an enqueueable object.
	 *
	 * @return void
	 */
	public function register() {
		// Not doing anything here, we only act on 'enqueue' for inline scripts.
	}

	/**
	 * Enqueue an enqueueable object.
	 *
	 * @return void
	 */
	public function enqueue() {
		wp_add_inline_script(
			$this->get_handle(),
			$this->get_data(),
			$this->get_position()
		);
	}
}
