<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class Scan extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	/** @var callable */
	private $closure;
	/** @var mixed */
	private $initial_state;

	public function __construct(IteratorInterface $iterator, callable $closure, $initial_state) {
		$this->iterator = $iterator;
		$this->closure = $closure;
		$this->initial_state = $initial_state;
	}

	/** @inheritDoc */
	public function next(): mixed {
		if (($value = $this->iterator->next()) !== null) {
			$closure = &$this->closure;
			$initial_state = &$this->initial_state;
			return $closure($initial_state, $value);
		}
		return null;
	}
}
