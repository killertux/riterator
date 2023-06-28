<?php

namespace RIterator\Adapters;

use RIterator\Iterator;
use RIterator\IteratorInterface;

class ChunkSize extends Iterator
{
    private IteratorInterface $iterator;
    private int $size;

    public function __construct(IteratorInterface $iterator, int $size)
    {
        $this->iterator = $iterator;
        $this->size = $size;
    }

    /** @inheritDoc */
    public function next()
    {
        $chunk = [];
        while (($value = $this->iterator->next()) != null) {
            $chunk[] = $value;
            if (count($chunk) == $this->size) {
                return $chunk;
            }
        }
        return $chunk;
    }
}