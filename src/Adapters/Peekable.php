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
		$this->next_value = Option::createNone();
	}

	public function next(): Option {
		if ($this->next_value->isNone()) {
			$this->next_value = $this->iterator->next();
		}
		$next_value = $this->next_value;
		$this->next_value = Option::createNone();
		return $next_value;
	}

	public function peek(): Option {
		if ($this->next_value->isNone()) {
			$this->next_value = $this->iterator->next();
		}
		return $this->next_value;
	}
}