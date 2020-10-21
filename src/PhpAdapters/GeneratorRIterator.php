<?php

namespace RIterator\PhpAdapters;

use RIterator\Iterator;

class GeneratorRIterator extends Iterator {

	private $generator;
	private $first_iteration = true;

	public function __construct(\Generator $generator) {
		$this->generator = $generator;
	}

	/**
	 * @inheritDoc
	 */
	public function next() {
		$this->doIteration();
		if ($this->generator->valid()) {
			return $this->generator->current();
		}
		return null;
	}

	private function doIteration(): void {
		if ($this->first_iteration) {
			$this->first_iteration = false;
			$this->generator->rewind();
			return;
		}
		$this->generator->next();
	}
}
