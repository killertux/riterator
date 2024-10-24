<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\None;
use RIterator\Option;

class TakeWhile extends Iterator {
	/** @var callable */
	private $closure;
	private bool $taking = true;

	public function __construct(private IteratorInterface $iterator, callable $closure) {
		$this->closure = $closure;
	}

	/** @inheritDoc */
	public function next(): Option {
		if (!$this->taking) {
			return new None();
		}
		$closure = &$this->closure;
		$value = $this->iterator->next();
		if ($value->isNone()) {
			$this->taking = false;
			return $value;
		}
		if ($closure($value->unwrap())) {
			return $value;
		}
		$this->taking = false;
		return new None();
	}
}
