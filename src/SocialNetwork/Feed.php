<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

interface Feed {

	const NETWORK_TWITTER  = 'twitter';
	const NETWORK_FACEBOOK = 'facebook';

	/**
	 * Get the feed entries for the social network.
	 *
	 * @param string $user  User to get the feed for.
	 * @param int    $limit Optional. Limit the number of feed entries to this
	 *                      number. Defaults to 5.
	 *
	 * @return FeedEntry[] Array of FeedEntry objects.
	 */
	public function get_entries( string $user, int $limit = 5 ): array;
}
