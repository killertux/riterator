<?php 

namespace RIterator;

interface IteratorInterface {

	/**
	 * Advances the iterator and return the next value.
	 *
	 * Return null if the iteration is finished.
	 *
	 * @return null|mixed
	 */
	public function next(): mixed;
} 
