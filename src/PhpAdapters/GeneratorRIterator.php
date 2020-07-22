<?php

namespace RIterator\PhpAdapters;

use RIterator\Iterator;
use RIterator\Option;

class GeneratorRIterator extends Iterator {

	private $generator;
	private $first_iteration = true;

	public function __construct(\Generator $generator) {
		$this->generator = $generator;
	}

	public function next(): Option {
		if ($this->first_iteration) {
			$this->first_iteration = false;
			$this->generator->rewind();
		}
		if ($this->generator->valid()) {
			$value = $this->generator->current();
			$this->generator->next();
			return Option::createSome($value);
		}
		return Option::createNone();
	}
}