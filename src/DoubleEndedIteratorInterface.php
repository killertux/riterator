<?php

namespace RIterator;

interface DoubleEndedIteratorInterface extends IteratorInterface {

	/**
	 * @return Option
	 */
	public function nextBack(): Option;
}