<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

use ArrayObject;

/**
 * Base configuration object that all of our configs extend.
 *
 * We use the built-in PHP ArrayObject for some of its convenient
 * out-of-the-box behavior. This makes our Config iterable and provides indexed
 * array access as well.
 */
abstract class BaseConfig extends ArrayObject {

	/**
	 * Instantiate a BaseConfig object.
	 *
	 * @param array $config Associative array if configuration data.
	 */
	public function __construct( $config = array() ) {
		// Make sure the config entries can be accessed as properties.
		parent::__construct( $config, ArrayObject::ARRAY_AS_PROPS );

		$this->validate_config();
	}

	/**
	 * Create a new Config instance based on a relative filename.
	 *
	 * @param string $filename Relative filename of the config file.
	 *
	 * @return static
	 */
	public static function create_from_file( string $filename ) {
		$root = dirname( __DIR__, 2 ) . '/config';

		return new static( include "{$root}/{$filename}" );
	}

	/**
	 * Asserts that the current configuration data is valid.
	 */
	abstract protected function validate_config();
}
