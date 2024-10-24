<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\None;
use RIterator\Option;
use RIterator\PhpAdapters\ArrayRIterator;
use RIterator\PhpAdapters\IteratorRIterator;
use RIterator\Some;

class Flatten extends Iterator {

	/** @var bool  */
	private $flattening = false;
	/** @var IteratorInterface  */
	private $current_iterator = null;

	public function __construct(private readonly IteratorInterface $iterator) {
	}

	/** @inheritDoc */
	public function next(): Option {
		if ($this->current_iterator === null) {
			$iterator = $this->iterator->next();
			if ($iterator->isNone()) {
				return new None();
			}
			$this->current_iterator = $this->convertIterator($iterator->unwrap());
		}
		$value = $this->current_iterator->next();
		if ($value->isNone()) {
			$new_iterator = $this->iterator->next();
			if ($new_iterator->isNone()) {
				return new None();
			}
			$this->current_iterator = $this->convertIterator($new_iterator->unwrap());
			return $this->next();
		}
		return new Some($value->unwrap());
	}

	private function convertIterator($value): IteratorInterface {
		if ($value instanceof IteratorInterface) {
			return $value;
		}

		if (is_array($value)) {
			return new ArrayRIterator($value);
		}

		if ($value instanceof \Iterator) {
			return new IteratorRIterator($value);
		}

		if ($value instanceof \IteratorAggregate) {
			return new IteratorRIterator($value->getIterator());
		}

		return new ArrayRIterator([$value]);
	}
}
