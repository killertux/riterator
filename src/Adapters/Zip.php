<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;
use RIterator\Some;

class Zip extends Iterator {

	public function __construct(private readonly IteratorInterface $iterator_1, private readonly IteratorInterface $iterator_2) {
	}

	/** @inheritDoc */
	public function next(): Option {
		$value_1 = $this->iterator_1->next();
		if ($value_1->isNone()) {
			return $value_1;
		}
		$value_2 = $this->iterator_2->next();
		if ($value_2->isNone()) {
			return $value_2;
		}
		return new Some([
			$value_1->unwrap(),
			$value_2->unwrap(),
		]);
	}
}
