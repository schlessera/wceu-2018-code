<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

use WordCampEurope\Workshop\Exception\MissingConfigKey;

final class SocialNetworks extends BaseConfig {

	/**
	 * Asserts that the current configuration data is valid.
	 */
	protected function validate_config() {
		foreach ( $this->getArrayCopy() as $name => $attributes ) {
			if ( ! array_key_exists( 'implementation', $attributes )
			     || ! class_exists( $attributes['implementation'] ) ) {
				throw MissingConfigKey::from_social_network_implementation(
					$name
				);
			}

			if ( ! array_key_exists( 'label', $attributes ) ) {
				throw MissingConfigKey::from_social_network_label(
					$name
				);
			}
		}
	}
}
