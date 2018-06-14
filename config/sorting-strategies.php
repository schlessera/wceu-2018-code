<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

use WordCampEurope\Workshop\SocialNetwork\SortingStrategy;

/*
 * Configuration data that represents the collection of available sorting
 * strategies.
 *
 * This is the only existing file that needs to be modified when a new sorting
 * strategy is to be added.
 */

return [
	// TODO leave the array, but remove the data
	'by_publication_date' => [
		'label'          => __( 'By Publication Date' ),
		'implementation' => SortingStrategy\ByPublicationDate::class,
	],
	'by_author_name'      => [
		'label'          => __( 'By Author Name' ),
		'implementation' => SortingStrategy\ByAuthorName::class,
	],
	'by_content_length'   => [
		'label'          => __( 'By Content Length' ),
		'implementation' => SortingStrategy\ByContentLength::class,
	],
];
