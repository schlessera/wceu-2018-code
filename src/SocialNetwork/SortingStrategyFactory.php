<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

use WordCampEurope\Workshop\Config\SortingStrategies;
use WordCampEurope\Workshop\Exception\MissingSortingStrategy;

/**
 * Instantiates and returns an implementation of the SortingStrategy interface,
 * based on a sorting strategy identifier that is provided.
 *
 * The identifier is the value of the select drop-down in the block settings,
 * so we don't need to use any conditional logic or other magic.
 *
 * Pattern: Simple Factory
 *
 * @see http://designpatternsphp.readthedocs.io/en/latest/Creational/SimpleFactory/README.html
 */
final class SortingStrategyFactory {

	/**
	 * Sorting strategies configuration data.
	 *
	 * @var SortingStrategies
	 */
	private $strategies;

	/**
	 * Instantiate a SortingStrategyFactory object.
	 *
	 * @param SortingStrategies $strategies Sorting strategies configuration data.
	 */
	public function __construct( SortingStrategies $strategies ) {
		$this->strategies = $strategies;
	}

	/**
	 * Simple factory to create an sorting strategy object for a given strategy.
	 *
	 * @param string $strategy Strategy to create the object for.
	 *
	 * @return SortingStrategy Sorting strategy object for the requested strategy.
	 */
	public function create( string $strategy ): SortingStrategy {
		if ( empty( $strategy ) ) {
			$strategy = 'by_publication_date';
		}

		if ( ! isset( $this->strategies[ $strategy ] ) ) {
			throw MissingSortingStrategy::from_strategy( $strategy );
		}

		$class = $this->strategies[ $strategy ]['implementation'];

		return new $class;
	}
}
