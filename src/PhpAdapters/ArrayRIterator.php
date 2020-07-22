<?php

namespace RIterator\PhpAdapters;

use RIterator\DoubleEndedIterator;
use RIterator\Option;

class ArrayRIterator extends DoubleEndedIterator {

	private $array;
	private $first_iteration = true;

	public function __construct(array $array) {
		$this->array = $array;
	}

	public function next(): Option {
		if ($this->first_iteration) {
			$this->first_iteration = false;
			reset($this->array);
			return $this->getValueFromPosition();
		}
		next($this->array);
		return $this->getValueFromPosition();
	}

	public function nextBack(): Option {
		if ($this->first_iteration) {
			$this->first_iteration = false;
			end($this->array);
			return $this->getValueFromPosition();
		}
		prev($this->array);
		return $this->getValueFromPosition();
	}

	private function getValueFromPosition(): Option {
		$value = current($this->array);
		if ($value === false && key($this->array) === null) {
			return Option::createNone();
		}
		return Option::createSome($value);
	}
}