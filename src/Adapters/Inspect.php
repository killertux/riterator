<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Inspect extends Iterator {

	private $closure;

	public function __construct(private readonly IteratorInterface $iterator, callable $closure) {
		$this->closure = $closure;
	}

	/** @inheritDoc */
	public function next(): Option {
		$value = $this->iterator->next();
		if ($value->isSome()) {
			$closure = &$this->closure;
			$closure($value->unwrap());
			return $value;
		}
		return $value;
	}
}
