<?php

namespace RIterator\PhpAdapters;

use RIterator\DoubleEndedIterator;
use RIterator\None;
use RIterator\Option;
use RIterator\Some;

class ArrayRIterator extends DoubleEndedIterator {

	public function __construct(private array $array) {}

	/**
	 * @inheritDoc
	 */
	public function next(): Option {
		if (empty($this->array)) {
			return new None();
		}
		return new Some(array_shift($this->array));
	}

	/**
	 * @inheritDoc
	 */
	public function nextBack(): Option {
		if (empty($this->array)) {
			return new None();
		}
		return new Some(array_pop($this->array));
	}
}
