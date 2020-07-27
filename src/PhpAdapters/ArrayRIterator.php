<?php

namespace RIterator\PhpAdapters;

use RIterator\DoubleEndedIterator;
use RIterator\Option;

class ArrayRIterator extends DoubleEndedIterator {

	private $array;

	public function __construct(array $array) {
		$this->array = $array;
	}

	public function next(): Option {
		$first_key = array_key_first($this->array);
		return $this->getValueAndRemoveItFromKey($first_key);
	}

	public function nextBack(): Option {
		$last_key = array_key_last($this->array);
		return $this->getValueAndRemoveItFromKey($last_key);
	}

	private function getValueAndRemoveItFromKey($key): Option {
		if ($key === null) {
			return Option::createNone();
		}
		$value = $this->array[$key];
		unset($this->array[$key]);
		return Option::createSome($value);
	}

}