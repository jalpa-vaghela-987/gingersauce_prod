<?php

/**
 * Colors.
 *
 * @author Tobias Köngeter
 * @copyright Copyright © 2020 Bit&Black
 * @link https://www.bitandblack.com
 * @license MIT
 */

namespace Color\Value;

use ArrayIterator;
use IteratorAggregate;

/**
 * Class Collection
 * 
 * @package Color\Value
 * @implements IteratorAggregate<int, ValueInterface>
 */
class Collection implements IteratorAggregate
{    
    /**
     * Color objects
     *
     * @var \Color\Value\ValueInterface[]
     */
    private $colors = [];
     
    /**
     * Gets colors
     *
     * @return ArrayIterator<int, ValueInterface>
     */        
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->colors);
    }

    /**
     * Adds a color object
     *
     * @param ValueInterface $color
     * @return \Color\Value\Collection<ValueInterface>
     */    
    public function add(ValueInterface $color): self 
    {
        $this->colors[] = $color;
        return $this;
    }
}
