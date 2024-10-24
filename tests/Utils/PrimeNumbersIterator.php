<?php

namespace Utils;

use RIterator\Iterator;
use RIterator\None;
use RIterator\Option;
use RIterator\Some;

class PrimeNumbersIterator extends Iterator {

	/** @var int */
	private $limit;
	private $current_number;

	public function __construct(int $limit) {
		$this->limit = $limit;
		$this->current_number = 0;
	}

	public function next(): Option {
		$divisions = 0;
		$this->current_number++;
		if ($this->limit <= 0) {
			return new None();
		}
		for ($i = 1; $i <= floor(sqrt($this->current_number)); $i++) {
			$divisions += ($this->current_number % $i === 0) ? 1 : 0;
			if ($divisions >= 2) {
				return $this->next();
			}
		}
		$this->limit--;
		return new Some($this->current_number);
	}
}
