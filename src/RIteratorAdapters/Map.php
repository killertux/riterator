<?php

namespace RIterator\RIteratorAdapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Map extends Iterator {

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
		$closure = &$this->closure;
		if ($value->isSome()) {
			return Option::createSome($closure($value->unwrap()));
		}
		return Option::createNone();
	}
}