<?php

namespace WordCampEurope\Workshop;

/**
 * A decorator for the Plugin that handles any exception it throws.
 */
class ExceptionHandlerPlugin
	implements Composable {

	/**
	 * @var Plugin
	 */
	protected $plugin;

	/**
	 * @var ExceptionHandler
	 */
	private $exception_handler;

	/**
	 * @param Plugin           $plugin
	 * @param ExceptionHandler $exception_handler
	 */
	public function __construct( Plugin $plugin, ExceptionHandler $exception_handler ) {
		$this->plugin = $plugin;
		$this->exception_handler = $exception_handler;
	}

	/**
	 * Call the ExceptionHandler when an exception occurs
	 */
	public function compose() {
		try {
			$this->plugin->compose();
		} catch ( \Exception $exception ) {
			$this->exception_handler->handle( $exception );
		}
	}

}