<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\None;
use RIterator\Option;

class FilterMap extends Iterator {
	/** @var callable */
	private $closure;

	public function __construct(private IteratorInterface $iterator, callable $closure) {
		$this->closure = $closure;
	}

	/** @inheritDoc */
	public function next(): Option {
		$closure = &$this->closure;
		while (($value = $this->iterator->next())->isSome()) {
			$mapped_value = $closure($value->unwrap());
			if ($mapped_value->isSome()) {
				return $mapped_value;
			}
		}
		return new None();
	}
}
