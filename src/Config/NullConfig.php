<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

class NullConfig extends BaseConfig {

	/**
	 * Asserts that the current configuration data is valid.
	 */
	protected function validate_config() {
		return true;
	}
}
