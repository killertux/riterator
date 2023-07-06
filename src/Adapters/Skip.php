<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class Skip extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	/** @var int */
	private $n;
	private $should_skip = true;

	public function __construct(IteratorInterface $iterator, int $n) {
		$this->iterator = $iterator;
		$this->n = $n;
	}

	/** @inheritDoc */
	public function next(): mixed {
		if ($this->should_skip) {
			$this->should_skip = false;
			for ($i = 0; $i < $this->n; $i++) {
				$this->iterator->next();
			}
		}
		return $this->iterator->next();
	}
}
