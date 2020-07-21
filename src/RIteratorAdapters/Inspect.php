<?php

namespace RIterator\RIteratorAdapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Inspect extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	/** @var callable */
	private $closure;

	public function __construct(IteratorInterface $iterator, callable $closure) {
		$this->iterator = $iterator;
		$this->closure = $closure;
	}

	public function next(): Option {
		$value = $this->iterator->next();
		if ($value->isSome()) {
			$closure = &$this->closure;
			$closure($value->unwrap());
			return $value;
		}
		return Option::createNone();
	}
}