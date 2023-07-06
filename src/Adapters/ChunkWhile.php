<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

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
    public function next(): mixed
    {
        $callable = $this->callable;
        $first_value = $this->iterator->next();
        if ($first_value === null) {
            return null;
        }
        $old_check = $callable($first_value);
        $chunk[] = $first_value;
        while (($value = $this->iterator->peek()) != null) {
            if ($old_check !== $callable($value)) {
                return $chunk;
            }
            $chunk[] = $this->iterator->next();
        }
        return $chunk;
    }
}