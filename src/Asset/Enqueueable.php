<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Asset;

/**
 * Segregated interface for an asset that can be enqueued.
 */
interface Enqueueable {

	/**
	 * Get the handle that is being used for enqueueing.
	 *
	 * @return string Handle under which to enqueue.
	 */
	public function get_handle(): string;

	/**
	 * Register an enqueueable object.
	 *
	 * @return void
	 */
	public function register();

	/**
	 * Enqueue an enqueueable object.
	 *
	 * @return void
	 */
	public function enqueue();
}
