<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

use WordCampEurope\Workshop\Config\SocialNetworks;
use WordCampEurope\Workshop\Exception\MissingConfigKey;

final class FeedFactory {

	/**
	 * Configuration data of available social networks.
	 *
	 * @var SocialNetworks
	 */
	private $networks;

	/**
	 * Order strategy factory to use for ordering feeds.
	 *
	 * @var OrderStrategyFactory
	 */
	private $order_strategy_factory;

	/**
	 * Instantiate a FeedFactory object.
	 *
	 * @param SocialNetworks $networks Social networks configuration data.
	 * @param OrderStrategyFactory Factory for creating order strategy.
	 */
	public function __construct(
		SocialNetworks $networks,
		OrderStrategyFactory $order_strategy_factory
	) {
		$this->networks               = $networks;
		$this->order_strategy_factory = $order_strategy_factory;
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
				$this->order_strategy_factory->create( $attributes->order_strategy() )
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
