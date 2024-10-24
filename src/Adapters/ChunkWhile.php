<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;
use RIterator\None;
use RIterator\Option;
use RIterator\Some;

class ChunkWhile extends Iterator
{
    private Peekable $iterator;
    private $callable;

    public function __construct(IteratorInterface $iterator, callable $callable)
    {
        $this->iterator = new Peekable($iterator);
        $this->callable = $callable;
    }

    /** @inheritDoc */
    public function next(): Option
    {
        $callable = &$this->callable;
        $first_value = $this->iterator->next();
        if ($first_value->isNone()) {
            return $first_value;
        }
		$first_value = $first_value->unwrap();
        $old_check = $callable($first_value);
        $chunk[] = $first_value;
        while (($value = $this->iterator->peek())->isSome()) {
            if ($old_check !== $callable($value->unwrap())) {
                return new Some($chunk);
            }
            $chunk[] = $this->iterator->next()->unwrap();
        }
		if (!empty($chunk)) {
			return new Some($chunk);
		}
        return new None();
    }
}