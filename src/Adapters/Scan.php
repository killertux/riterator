<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Scan extends Iterator {

	/** @var callable */
	private $closure;


	public function __construct(private readonly IteratorInterface $iterator, callable $closure, private mixed $initial_state) {
		$this->closure = $closure;
	}

	/** @inheritDoc */
	public function next(): Option {
		if (($value = $this->iterator->next())->isSome()) {
			$closure = &$this->closure;
			$initial_state = &$this->initial_state;
			return $closure($initial_state, $value->unwrap());
		}
		return $value;
	}
}
