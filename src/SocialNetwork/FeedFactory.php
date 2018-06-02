<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

use WordCampEurope\Workshop\Exception\MissingConfigKey;

final class FeedFactory {

	/**
	 * Array of Config objects for the individual networks.
	 *
	 * @var array
	 */
	private $configs;

	/**
	 * Instantiate a FeedFactory object.
	 *
	 * @param array $configs
	 */
	public function __construct( array $configs ) {
		$this->configs = $configs;
	}

	/**
	 * Simple factory to create a network feed object for a given network.
	 *
	 * @param string $network Network to create the feed for.
	 *
	 * @return Feed Feed object for the requested network.
	 */
	public function create( string $network ) {
		if ( ! array_key_exists( $network, $this->configs ) ) {
			throw MissingConfigKey::from_network( $network );
		}

		return new CachingFeed( $this->get_feed_for_network( $network ) );
	}

	/**
	 * Get the feed for a specific network.
	 *
	 * @param string $network Network to get the feed for.
	 *
	 * @return Feed Feed object for the requested network.
	 */
	public function get_feed_for_network( string $network ) {
		switch ( $network ) {
			case Feed::NETWORK_FACEBOOK:
				//return new Facebook\Feed();
			case Feed::NETWORK_TWITTER:
			default:
				return new Twitter\Feed(
					new Twitter\Client( $this->configs[ $network ] )
				);
		}
	}
}
