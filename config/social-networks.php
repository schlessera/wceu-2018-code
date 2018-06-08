<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

use WordCampEurope\Workshop\SocialNetwork;

return [
	'twitter'   => [
		'label'          => __( 'Twitter' ),
		'implementation' => SocialNetwork\Twitter\Feed::class,
		'client'         => SocialNetwork\Twitter\Client::class,
		'config'         => TwitterCredentials::create_from_file( 'twitter-credentials.php' ),
	],
	'wordpress' => [
		'label'          => __( 'WordPress.com' ),
		'implementation' => SocialNetwork\WordPress\Feed::class,
		'client'         => SocialNetwork\WordPress\Client::class,
		'config'         => WordPressComCredentials::create_from_file( 'wordpress-com-credentials.php' ),
	],
];
