<?php

namespace Utils;

use RIterator\IntoIterator;
use RIterator\Iterator;

class PrimeNumbers extends IntoIterator {

	/** @var int */
	private $limit;

	public function __construct(int $limit) {
		$this->limit = $limit;
	}

	public function intoIterator(): Iterator {
		return new PrimeNumbersIterator($this->limit);
	}
}
