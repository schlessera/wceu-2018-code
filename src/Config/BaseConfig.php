<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

use ArrayObject;

abstract class BaseConfig extends ArrayObject {

	/**
	 * Instantiate a BaseConfig object.
	 *
	 * @param array $config
	 */
	public function __construct( $config = array() ) {
		// Make sure the config entries can be accessed as properties.
		parent::__construct( $config, \ArrayObject::ARRAY_AS_PROPS );

		$this->validate_config();
	}

	/**
	 * Asserts that the current configuration data is valid.
	 */
	abstract protected function validate_config();
}
