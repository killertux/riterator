<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class FilterMap extends Iterator {

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
			/** @var Option $mapped_value */
			$mapped_value = $closure($value->unwrap());
			if ($mapped_value->isSome()) {
				return $mapped_value;
			}
		}
		return Option::createNone();
	}
}