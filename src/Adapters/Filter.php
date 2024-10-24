<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\None;
use RIterator\Option;

class Filter extends Iterator {
	/** @var callable */
	private $closure;

	public function __construct(private IteratorInterface $iterator, callable $closure) {
		$this->closure = $closure;
	}

	/** @inheritDoc */
	public function next(): Option {
		$closure = &$this->closure;
		while (($value = $this->iterator->next())->isSome()) {
			if ($closure($value->unwrap())) {
				return $value;
			}
		}
		return new None();
	}
}
