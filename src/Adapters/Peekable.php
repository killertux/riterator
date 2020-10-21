<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Peekable extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	private $next_value;

	public function __construct(IteratorInterface $iterator) {
		$this->iterator = $iterator;
		$this->next_value = null;
	}

	/** @inheritDoc */
	public function next() {
		if ($this->next_value === null) {
			$this->next_value = $this->iterator->next();
		}
		$next_value = $this->next_value;
		$this->next_value = null;
		return $next_value;
	}

	/** @return null|mixed */
	public function peek() {
		if ($this->next_value === null) {
			$this->next_value = $this->iterator->next();
		}
		return $this->next_value;
	}
}
