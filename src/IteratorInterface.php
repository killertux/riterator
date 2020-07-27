<?php 

namespace RIterator;

interface IteratorInterface {

	/**
	 * Advances the iterator and return the next value wrapped in an Option.
	 *
	 * Return and None option if the iteration is finished.
	 *
	 * @return Option
	 */
	public function next(): Option;
} 