<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;

class Peekable extends Iterator {

	private mixed $next_value;

	public function __construct(private readonly IteratorInterface $iterator) {
		$this->next_value = null;
	}

	/** @inheritDoc */
	public function next(): Option {
		if ($this->next_value === null) {
			return $this->iterator->next();
		}
		$next_value = $this->next_value;
		$this->next_value = null;
		return $next_value;
	}

	public function peek(): Option {
		if ($this->next_value === null) {
			$this->next_value = $this->iterator->next();
		}
		return $this->next_value;
	}
}
