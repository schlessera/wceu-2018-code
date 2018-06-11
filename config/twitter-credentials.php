<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

/*
 * Configuration data that regroups the Twitter authentication credentials.
 *
 * The credentials can not only be encoded as default values in this file (which
 * is NOT recommended), but can also be provided through environment variables.
 *
 * You can create an application for the Twitter API and retrieve its
 * authentication keys here: https://apps.twitter.com/
 */

return [
	TwitterCredentials::OAUTH_ACCESS_TOKEN        => getenv( 'TWITTER_OAUTH_ACCESS_TOKEN' ),
	TwitterCredentials::OAUTH_ACCESS_TOKEN_SECRET => getenv( 'TWITTER_OAUTH_ACCESS_TOKEN_SECRET' ),
	TwitterCredentials::CONSUMER_KEY              => getenv( 'TWITTER_CONSUMER_KEY' ),
	TwitterCredentials::CONSUMER_SECRET           => getenv( 'TWITTER_CONSUMER_SECRET' ),
];