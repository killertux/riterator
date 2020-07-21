<?php

namespace RIterator\RIteratorAdapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Zip extends Iterator {

	/** @var IteratorInterface */
	private $iterator_1;
	/** @var IteratorInterface */
	private $iterator_2;

	public function __construct(IteratorInterface $iterator_1, IteratorInterface $iterator_2) {
		$this->iterator_1 = $iterator_1;
		$this->iterator_2 = $iterator_2;
	}

	public function next(): Option {
		$value_1 = $this->iterator_1->next();
		if ($value_1->isNone()) {
			return Option::createNone();
		}
		$value_2 = $this->iterator_2->next();
		if ($value_2->isNone()) {
			return Option::createNone();
		}
		return Option::createSome([
			$value_1->unwrap(),
			$value_2->unwrap(),
		]);
	}
}