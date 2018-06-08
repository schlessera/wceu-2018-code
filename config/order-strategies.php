<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

use WordCampEurope\Workshop\SocialNetwork\OrderStrategy;

return [
	'by_publication_date' => [
		'label'          => __( 'By Publication Date' ),
		'implementation' => OrderStrategy\ByPublicationDate::class,
	],
	'by_author_name'      => [
		'label'          => __( 'By Author Name' ),
		'implementation' => OrderStrategy\ByAuthorName::class,
	],
	'by_content_length'   => [
		'label'          => __( 'By Content Length' ),
		'implementation' => OrderStrategy\ByContentLength::class,
	],
];
