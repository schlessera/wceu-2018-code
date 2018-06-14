<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

/**
 * Value object that represents the set of attributes that the user can
 * configure to query the social media mentions.
 */
final class Attributes {

	const SCHEMA = [
		'network'          => [
			'type'    => 'text',
			'default' => 'twitter',
		],
		'mention'          => [
			'type'    => 'text',
			'default' => '#WCEU',
		],
		'limit'            => [
			'type'    => 'integer',
			'default' => 5,
		],
		'sorting_strategy' => [
			'type'    => 'text',
			'default' => 'by_publication_date',
		],
	];

	/**
	 * Social network to search.
	 *
	 * @var string
	 */
	private $network;

	/**
	 * Mention to search for.
	 *
	 * @var string
	 */
	private $mention;

	/**
	 * Maximum number of entries to retrieve.
	 *
	 * @var int
	 */
	private $limit;

	/**
	 * Strategy to use for ordering the entries.
	 *
	 * @var string
	 */
	private $sorting_strategy;

	/**
	 * Instantiate an Attributes object.
	 *
	 * @param string $network          Social network to search.
	 * @param string $mention          Mention to search for.
	 * @param int    $limit            Maximum number of entries to retrieve.
	 * @param string $sorting_strategy Strategy to use for ordering the entries.
	 */
	public function __construct(
		string $network,
		string $mention,
		int $limit,
		string $sorting_strategy
	) {
		$this->network          = $network;
		$this->mention          = $mention;
		$this->limit            = $limit;
		$this->sorting_strategy = $sorting_strategy;
	}

	/**
	 * Create a new Attributes value object from a context data array.
	 *
	 * @param array $context Associative array of context data.
	 *
	 * @return Attributes Attributes value object.
	 */
	public static function from_context( array $context ): Attributes {
		return new self(
			(string) ( $context['network'] ?? Attributes::SCHEMA['network']['default'] ),
			(string) ( $context['mention'] ?? Attributes::SCHEMA['mention']['default'] ),
			(int) ( $context['limit'] ?? Attributes::SCHEMA['limit']['default'] ),
			(string) ( $context['sorting_strategy'] ?? Attributes::SCHEMA['sorting_strategy']['default'] )
		);
	}

	/**
	 * Get the attributes to register.
	 *
	 * @return array Associative array of attributes.
	 */
	public function all(): array {
		return [
			'network'          => $this->network(),
			'mention'          => $this->mention(),
			'limit'            => $this->limit(),
			'sorting_strategy' => $this->sorting_strategy(),
		];
	}

	/**
	 * Get the network name.
	 *
	 * @return string Network name.
	 */
	public function network(): string {
		return $this->network;
	}

	/**
	 * Get the mention to search for.
	 *
	 * @return string Mention to search for.
	 */
	public function mention(): string {
		return $this->mention;
	}

	/**
	 * Get the number of entries to limit the result set to.
	 *
	 * @return int Number of entries to limit the result set to.
	 */
	public function limit(): int {
		return $this->limit;
	}

	/**
	 * Get the strategy with which to sort the entries.
	 *
	 * @return string Strategy with which to sort the entries.
	 */
	public function sorting_strategy(): string {
		return $this->sorting_strategy;
	}
}
