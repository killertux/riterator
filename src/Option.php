<?php declare(strict_types=1);

namespace RIterator;

/**
 * Option represents an optional value: every Option is either Some and contains a value, or None, and does not
 *
 * @template T
 */
abstract readonly class Option {

	public abstract function isSome(): bool;
	public abstract function isNone(): bool;
	public abstract function unwrap(): mixed;

	/**
	 * If Some, calls $m on its value and returns a new Option containing the return value of $m.
	 * If None, returns itself.
	 *
	 * @template U
	 * @param callable(T): U $m
	 * @return Option<U>
	 */
	public function map(callable $m): Option {
		if ($this->isSome()) {
			return new Some($m($this->unwrap()));
		} else {
			return $this;
		}
	}

	/**
	 * If Some, calls $some on its value and returns the return value of $some.
	 * If None, calls $none and returns the return value of $none.
	 *
	 * @template R
	 * @param callable(T): R $some
	 * @param callable(): R $none
	 * @return R
	 */
	public function match(callable $some, callable $none): mixed {
		if ($this->isSome()) {
			return $some($this->unwrap());
		} else {
			return $none();
		}

	}
}