<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

// You can create an application for the WordPress.com API and retrieve its
// authentication keys here: https://developer.wordpress.com/apps/

return [
	WordPressComCredentials::CLIENT_ID     => getenv( 'WORDPRESS_COM_CLIENT_ID' ) ?: '',
	WordPressComCredentials::CLIENT_SECRET => getenv( 'WORDPRESS_COM_CLIENT_SECRET' ) ?: '',
	WordPressComCredentials::USERNAME      => getenv( 'WORDPRESS_COM_USERNAME' ) ?: '',
	WordPressComCredentials::PASSWORD      => getenv( 'WORDPRESS_COM_PASSWORD' ) ?: '',
];
