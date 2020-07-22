<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Enumerate extends Iterator {

	/** @var int */
	private $enumerate = 0;
	/** @var IteratorInterface */
	private $iterator;

	public function __construct(IteratorInterface $iterator) {
		$this->iterator = $iterator;
	}

	public function next(): Option {
		$value = $this->iterator->next();
		if ($value->isSome()) {
			return Option::createSome([$this->enumerate++, $value->unwrap()]);
		}
		return Option::createNone();
	}
}