<?php

namespace RIterator;

interface DoubleEndedIteratorInterface extends IteratorInterface {

	/**
	 * Removes and return an element from the end of the iterator
	 *
	 * Return and None option if the iteration is finished.
	 *
	 * @return null|mixed
	 */
	public function nextBack();
}
