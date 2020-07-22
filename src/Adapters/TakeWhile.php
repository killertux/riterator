<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class TakeWhile extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	/** @var callable */
	private $closure;
	private $taking = true;

	public function __construct(IteratorInterface $iterator, callable $closure) {
		$this->iterator = $iterator;
		$this->closure = $closure;
	}

	public function next(): Option {
		if (!$this->taking) {
			return Option::createNone();
		}
		$closure = &$this->closure;
		$value = $this->iterator->next();
		if ($closure($value->unwrap())) {
			return $value;
		}
		$this->taking = false;
		return Option::createNone();
	}
}