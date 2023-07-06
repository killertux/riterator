<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class Zip extends Iterator {

	/** @var IteratorInterface */
	private $iterator_1;
	/** @var IteratorInterface */
	private $iterator_2;

	public function __construct(IteratorInterface $iterator_1, IteratorInterface $iterator_2) {
		$this->iterator_1 = $iterator_1;
		$this->iterator_2 = $iterator_2;
	}

	/** @inheritDoc */
	public function next(): mixed {
		$value_1 = $this->iterator_1->next();
		if ($value_1 === null) {
			return null;
		}
		$value_2 = $this->iterator_2->next();
		if ($value_2 === null) {
			return null;
		}
		return [
			$value_1,
			$value_2,
		];
	}
}
