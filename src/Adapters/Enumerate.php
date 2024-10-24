<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\None;
use RIterator\Option;
use RIterator\Some;

class Enumerate extends Iterator {
	private int $enumeration = 0;

	public function __construct(private readonly IteratorInterface $iterator) {
	}

	/** @inheritDoc */
	public function next(): Option {
		$value = $this->iterator->next();
		if ($value->isSome()) {
			return new Some([$this->enumeration++, $value->unwrap()]);
		}
		return new None();
	}
}
