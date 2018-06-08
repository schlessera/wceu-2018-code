<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

use WordCampEurope\Workshop\Config\OrderStrategies;
use WordCampEurope\Workshop\Exception\MissingOrderStrategy;

final class OrderStrategyFactory {

	/**
	 * Order strategies configuration data.
	 *
	 * @var OrderStrategies
	 */
	private $strategies;

	/**
	 * Instantiate a OrderStrategyFactory object.
	 *
	 * @param OrderStrategies $strategies Order strategies configuration data.
	 */
	public function __construct( OrderStrategies $strategies ) {
		$this->strategies = $strategies;
	}

	/**
	 * Simple factory to create an order strategy object for a given strategy.
	 *
	 * @param string $strategy Strategy to create the object for.
	 *
	 * @return OrderStrategy Order strategy object for the requested strategy.
	 */
	public function create( string $strategy ): OrderStrategy {
		if ( empty( $strategy ) ) {
			$strategy = 'by_publication_date';
		}

		if ( ! isset( $this->strategies[ $strategy ] ) ) {
			throw MissingOrderStrategy::from_strategy( $strategy );
		}

		$class = $this->strategies[ $strategy ]['implementation'];

		return new $class;
	}
}
