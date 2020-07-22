<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\Option;
use RIterator\PhpAdapters\ArrayRIterator;
use RIterator\PhpAdapters\GeneratorRIterator;
use RIterator\PhpAdapters\IteratorRIterator;

class Flatten extends Iterator {

	/** @var IteratorInterface */
	private $iterator;
	/** @var bool  */
	private $flattening = false;
	/** @var IteratorInterface  */
	private $temp_iterator = null;

	public function __construct(IteratorInterface $iterator) {
		$this->iterator = $iterator;
	}

	public function next(): Option {
		if ($this->flattening) {
			return $this->handleFlattening();
		}
		$value = $this->iterator->next();
		if ($value->isSome()) {
			return $this->returnValueOrHandleFlattening($value->unwrap());
		}
		return Option::createNone();
	}

	private function returnValueOrHandleFlattening($value): Option {
		if (is_array($value)) {
			$this->setUpArrayFlattening($value);
			return $this->handleFlattening();
		}

		if ($value instanceof \Iterator) {
			$this->setUpIteratorFlattening($value);
			return $this->handleFlattening();
		}

		if ($value instanceof \IteratorAggregate) {
			$this->setUpIteratorAggregateFlattening($value);
			return $this->handleFlattening();
		}

		if ($value instanceof IteratorInterface) {
			$this->setUpRIteratorFlattening($value);
			return $this->handleFlattening();
		}
		return Option::createSome($value);
	}

	private function handleFlattening(): Option {
		$value = $this->temp_iterator->next();
		if ($value->isNone()) {
			$this->flattening = false;
			return $this->next();
		}
		return $value;
	}

	private function setUpArrayFlattening(array $value): void {
		$this->flattening = true;
		$this->temp_iterator = new ArrayRIterator($value);
	}

	private function setUpIteratorFlattening(\Iterator $value): void {
		$this->flattening = true;
		$this->temp_iterator = new IteratorRIterator($value);
	}

	private function setUpIteratorAggregateFlattening(\IteratorAggregate $value): void {
		$generator = function (\Traversable $t) {
			foreach ($t as $value) {
				yield $value;
			}
		};
		$this->flattening = true;
		$this->temp_iterator = new GeneratorRIterator($generator($value));
	}

	private function setUpRIteratorFlattening(IteratorInterface $value): void {
		$this->flattening = true;
		$this->temp_iterator = $value;
	}
}