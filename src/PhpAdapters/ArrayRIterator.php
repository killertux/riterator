<?php

namespace RIterator\PhpAdapters;

use RIterator\DoubleEndedIterator;

class ArrayRIterator extends DoubleEndedIterator {

	private $array;

	public function __construct(array $array) {
		$this->array = $array;
	}

	/**
	 * @inheritDoc
	 */
	public function next(): mixed {
		$first_key = array_key_first($this->array);
		return $this->getValueAndRemoveItFromKey($first_key);
	}

	/**
	 * @inheritDoc
	 */
	public function nextBack(): mixed {
		$last_key = array_key_last($this->array);
		return $this->getValueAndRemoveItFromKey($last_key);
	}

	private function getValueAndRemoveItFromKey($key) {
		if ($key === null) {
			return null;
		}
		$value = $this->array[$key];
		unset($this->array[$key]);
		return $value;
	}

}
