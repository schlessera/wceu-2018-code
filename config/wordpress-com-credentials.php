<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

/*
 * Configuration data that regroups the WordPress.com authentication credentials.
 *
 * The credentials can not only be encoded as default values in this file (which
 * is NOT recommended), but can also be provided through environment variables.
 *
 * You can create an application for the WordPress.com API and retrieve its
 * authentication keys here: https://developer.wordpress.com/apps/
 */

return [
	WordPressComCredentials::CLIENT_ID     => getenv( 'WORDPRESS_COM_CLIENT_ID' ) ?: '',
	WordPressComCredentials::CLIENT_SECRET => getenv( 'WORDPRESS_COM_CLIENT_SECRET' ) ?: '',
	WordPressComCredentials::USERNAME      => getenv( 'WORDPRESS_COM_USERNAME' ) ?: '',
	WordPressComCredentials::PASSWORD      => getenv( 'WORDPRESS_COM_PASSWORD' ) ?: '',
];
