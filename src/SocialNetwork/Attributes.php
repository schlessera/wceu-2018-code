<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

final class Attributes {

	const SCHEMA = [
		'network'        => [
			'type'    => 'text',
			'default' => 'twitter',
		],
		'mention'        => [
			'type'    => 'text',
			'default' => '#WCEU',
		],
		'limit'          => [
			'type'    => 'integer',
			'default' => 5,
		],
		'order_strategy' => [
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
	private $order_strategy;

	/**
	 * Instantiate an Attributes object.
	 *
	 * @param string $network        Social network to search.
	 * @param string $mention        Mention to search for.
	 * @param int    $limit          Maximum number of entries to retrieve.
	 * @param string $order_strategy Strategy to use for ordering the entries.
	 */
	public function __construct(
		string $network,
		string $mention,
		int $limit,
		string $order_strategy
	) {
		$this->network        = $network;
		$this->mention        = $mention;
		$this->limit          = $limit;
		$this->order_strategy = $order_strategy;
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
			(string) ( $context['order_strategy'] ?? Attributes::SCHEMA['order_strategy']['default'] )
		);
	}

	/**
	 * Get the attributes to register.
	 *
	 * @return array Associative array of attributes.
	 */
	public function all(): array {
		return [
			'network'        => $this->network(),
			'mention'        => $this->mention(),
			'limit'          => $this->limit(),
			'order_strategy' => $this->order_strategy(),
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
	 * Get the strategy with which to order the entries.
	 *
	 * @return string Strategy with which to order the entries.
	 */
	public function order_strategy(): string {
		return $this->order_strategy;
	}
}
