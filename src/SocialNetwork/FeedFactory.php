<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

class FeedFactory {

	const NETWORK_TWITTER  = 'twitter';
	const NETWORK_FACEBOOK = 'facebook';

	/**
	 * Simple factory to create a network feed object for a given network.
	 *
	 * @param string $network Network to create the feed for.
	 *
	 * @return Feed Feed object for the requested network.
	 */
	public function create( string $network ) {
		switch ( $network ) {
			case static::NETWORK_FACEBOOK:
				//return new Facebook\Feed();
			case static::NETWORK_TWITTER:
			default:
				return new Twitter\Feed();
		}
	}
}
