<?php

namespace RIterator;

use RIterator\Adapters\Chain;
use RIterator\Adapters\Enumerate;
use RIterator\Adapters\Filter;
use RIterator\Adapters\FilterMap;
use RIterator\Adapters\FlatMap;
use RIterator\Adapters\Flatten;
use RIterator\Adapters\Fuse;
use RIterator\Adapters\Inspect;
use RIterator\Adapters\Map;
use RIterator\Adapters\Peekable;
use RIterator\Adapters\Scan;
use RIterator\Adapters\Skip;
use RIterator\Adapters\SkipWhile;
use RIterator\Adapters\StepBy;
use RIterator\Adapters\Take;
use RIterator\Adapters\TakeWhile;
use RIterator\Adapters\Zip;

abstract class Iterator implements IteratorInterface {

	/**
	 * @inheritDoc
	 */
	abstract public function next(): Option;

	public function collect(): array {
		$collect = [];
		while (($value = $this->next())->isSome()) {
			$collect[] = $value->unwrap();
		}
		return $collect;
	}

	public function count(): int {
		$count = 0;
		while ($this->next()->isSome()) {
			$count++;
		}
		return $count;
	}

	public function last(): Option {
		$last = Option::createNone();
		while (($value = $this->next())->isSome()) {
			$last = $value;
		}
		return $last;
	}

	/**
	 * @return float|int
	 */
	public function sum() {
		$sum = 0;
		while (($value = $this->next())->isSome()) {
			$sum += $value->unwrap();
		}
		return $sum;
	}

	public function nth(int $n): Option {
		for ($i = 0; $i < $n; $i++) {
			$this->next();
		}
		return $this->next();
	}

	public function stepBy(int $n): StepBy {
		return new StepBy($this, $n);
	}

	public function chain(IteratorInterface $iterator): Chain {
		return new Chain($this, $iterator);
	}

	public function zip(IteratorInterface $iterator): Zip {
		return new Zip($this, $iterator);
	}

	public function map(callable $closure): Map {
		return new Map($this, $closure);
	}

	public function forEach(callable $closure): void {
		while (($value = $this->next())->isSome()) {
			$closure($value->unwrap());
		}
	}

	public function filter(callable $closure): Filter {
		return new Filter($this, $closure);
	}

	public function filterMap(callable $closure): FilterMap {
		return new FilterMap($this, $closure);
	}

	public function enumerate(): Enumerate {
		return new Enumerate($this);
	}

	public function peekable(): Peekable {
		return new Peekable($this);
	}

	public function skipWhile(callable $closure): SkipWhile {
		return new SkipWhile($this, $closure);
	}

	public function takeWhile(callable $closure): TakeWhile {
		return new TakeWhile($this, $closure);
	}

	public function skip(int $n): Skip {
		return new Skip($this, $n);
	}

	public function take(int $n): Take {
		return new Take($this, $n);
	}

	public function scan($initial_state, callable $closure) : Scan {
		return new Scan($this, $closure, $initial_state);
	}

	public function flatten(): Flatten {
		return new Flatten($this);
	}

	public function flatMap(callable $closure): FlatMap {
		return new FlatMap($this, $closure);
	}

	public function fuse(): Fuse {
		return new Fuse($this);
	}

	public function inspect(callable $closure): Inspect {
		return new Inspect($this, $closure);
	}

	public function partition(callable $closure): array {
		$partition_true = [];
		$partition_false = [];
		while (($value = $this->next())->isSome()) {
			$unwraped_value = $value->unwrap();
			if ($closure($unwraped_value)) {
				$partition_true[] = $unwraped_value;
			} else {
				$partition_false[] = $unwraped_value;
			}
		}
		return [$partition_true, $partition_false];
	}

	public function fold($acc, callable $closure) {
		while (($value = $this->next())->isSome()) {
			$acc = $closure($acc, $value->unwrap());
		}
		return $acc;
	}

	public function all(callable $closure): bool {
		while (($value = $this->next())->isSome()) {
			if (!$closure($value->unwrap())) {
				return false;
			}
		}
		return true;
	}

	public function any(callable $closure): bool {
		while (($value = $this->next())->isSome()) {
			if ($closure($value->unwrap())) {
				return true;
			}
		}
		return false;
	}

	public function find(callable $closure): Option {
		while (($value = $this->next())->isSome()) {
			if ($closure($value->unwrap())) {
				return $value;
			}
		}
		return Option::createNone();
	}

	public function findMap(callable $closure): Option {
		$iterator = new Map($this, $closure);
		while (($value = $iterator->next())->isSome()) {
			$unwraped_value = $value->unwrap();
			if ($unwraped_value->isSome()) {
				return $unwraped_value;
			}
		}
		return Option::createNone();
	}

	public function position(callable $closure): Option {
		$index = 0;
		while (($value = $this->next())->isSome()) {
			if ($closure($value->unwrap())) {
				return Option::createSome($index);
			}
			$index++;
		}
		return Option::createNone();
	}
}