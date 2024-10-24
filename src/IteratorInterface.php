<?php 

namespace RIterator;

interface IteratorInterface {

	/**
	 * Advances the iterator and return the next value.
	 *
	 * Return None if the iteration is finished.
	 *
	 * @return Option|None|Some
	 */
	public function next(): Option;
} 
