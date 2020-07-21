<?php

namespace RIterator\RIteratorAdapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Filter extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	/** @var callable */
	private $closure;

	public function __construct(IteratorInterface $iterator, callable $closure) {
		$this->iterator = $iterator;
		$this->closure = $closure;
	}

	public function next(): Option {
		$closure = &$this->closure;
		while (($value = $this->iterator->next())->isSome()) {
			if ($closure($value->unwrap())) {
				return $value;
			}
		}
		return Option::createNone();
	}
}