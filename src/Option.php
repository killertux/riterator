<?php

namespace RIterator;

class Option {

	private static $none_instance;
	private $value;
	private $is_some;

	private function __construct(bool $is_some, $value = null) {
		$this->is_some = $is_some;
		$this->value = $value;
	}

	/**
	 * @param mixed $value
	 * @return static
	 */
	public static function createSome($value) {
		return new static(true, $value);
	}

	/**
	 * @return static
	 */
	public static function createNone() {
		return static::$none_instance
			?? static::$none_instance = new static(false);
	}

	public function isSome(): bool {
		return $this->is_some;
	}

	public function isNone(): bool {
		return !$this->is_some;
	}

	public function unwrap() {
		if ($this->is_some) {
			return $this->value;
		}
		throw new UnwrapNoneException();
	}
}