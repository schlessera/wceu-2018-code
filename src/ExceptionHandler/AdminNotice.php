<?php

namespace WordCampEurope\Workshop\ExceptionHandler;

use WordCampEurope\Workshop\ExceptionHandler;
use WordCampEurope\Workshop\Registerable;

use Exception;

/**
 * An ExceptionHandler instance that displays an admin notice containing the
 * exceptions message.
 */
class AdminNotice
	implements ExceptionHandler, Registerable {

	/**
	 * @var Exception
	 */
	protected $exception;

	public function register() {
		add_action( 'admin_notices', [ $this, 'display' ] );
	}

	/**
	 * Display the admin notice if an exception is present.
	 */
	public function display() {
		if ( null === $this->exception ) {
			return;
		}

		?>

		<div class="notice notice-error is-dismissible">
			<p><?= wp_kses_post( $this->exception->getMessage() ); ?></p>
		</div>

		<?php
	}

	/**
	 * @param Exception $exception
	 */
	public function handle( Exception $exception ) {
		$this->exception = $exception;
	}

}