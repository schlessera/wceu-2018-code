<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

use WordCampEurope\Workshop\Config\SocialNetworks;
use WordCampEurope\Workshop\Exception\MissingConfigKey;

/**
 * Instantiates and returns an implementation of the Feed interface, based on a
 * network identifier that is provided.
 *
 * The identifier is the value of the select drop-down in the block settings,
 * so we don't need to use any conditional logic or other magic.
 *
 * Pattern: Simple Factory
 *
 * @see http://designpatternsphp.readthedocs.io/en/latest/Creational/SimpleFactory/README.html
 */
final class FeedFactory {

	/**
	 * Configuration data of available social networks.
	 *
	 * @var SocialNetworks
	 */
	private $networks;

	/**
	 * Sorting strategy factory to use for ordering feeds.
	 *
	 * @var SortingStrategyFactory
	 */
	private $sorting_strategy_factory;

	/**
	 * Instantiate a FeedFactory object.
	 *
	 * @param SocialNetworks $networks Social networks configuration data.
	 * @param SortingStrategyFactory Factory for creating sorting strategy.
	 */
	public function __construct(
		SocialNetworks $networks,
		SortingStrategyFactory $sorting_strategy_factory
	) {
		$this->networks                 = $networks;
		$this->sorting_strategy_factory = $sorting_strategy_factory;
	}

	/**
	 * Simple factory to create a network feed object for a given network.
	 *
	 * @param Attributes $attributes Attributes for which to create a feed.
	 *
	 * @return Feed Feed object for the requested network.
	 */
	public function create( Attributes $attributes ): Feed {
		if ( ! isset( $this->networks[ $attributes->network() ] ) ) {
			throw MissingConfigKey::from_network( $attributes->network() );
		}

		return new CachingFeed(
			new OrderedFeed(
				$this->get_feed_for_network( $attributes->network() ),
				$this->sorting_strategy_factory->create( $attributes->sorting_strategy() )
			)
		);
	}

	/**
	 * Get the feed for a specific network.
	 *
	 * @param string $network Network to get the feed for.
	 *
	 * @return Feed Feed object for the requested network.
	 */
	public function get_feed_for_network( string $network ) {
		$implementation = $this->networks[ $network ]['implementation'];

		if ( isset( $this->networks[ $network ]['client'] ) ) {
			$client = $this->networks[ $network ]['client'];

			if ( isset( $this->networks[ $network ]['config'] ) ) {
				$config = $this->networks[ $network ]['config'];

				return new $implementation( new $client( $config ) );
			}

			return new $implementation( new $client() );
		}

		return new $implementation();
	}
}
