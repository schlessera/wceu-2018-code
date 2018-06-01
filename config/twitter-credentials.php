<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

return [
	TwitterCredentials::OAUTH_ACCESS_TOKEN        => getenv( 'TWITTER_OAUTH_ACCESS_TOKEN' ) ?: '111356320-w6gJ7Z2WWAVVdUphls5V8vN8RwBqeM2o9fM9tG7E',
	TwitterCredentials::OAUTH_ACCESS_TOKEN_SECRET => getenv( 'TWITTER_OAUTH_ACCESS_TOKEN_SECRET' ) ?: 'ColsGddb5SSGwzICmJjnq9HltR5m9JnTY4YqkLAQR5uU0',
	TwitterCredentials::CONSUMER_KEY              => getenv( 'TWITTER_CONSUMER_KEY' ) ?: 'LdDlQzGMC3T9DS1p6vZJBBU4E',
	TwitterCredentials::CONSUMER_SECRET           => getenv( 'TWITTER_CONSUMER_SECRET' ) ?: 'SOgltaeeOpCf66ti9qLnibH2aMbtVtbKRtTmIPjE3cU1PcsCPH',
];
