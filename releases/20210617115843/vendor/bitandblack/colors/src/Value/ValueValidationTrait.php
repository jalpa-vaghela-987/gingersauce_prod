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

use Color\Value\Exception\InvalidInputLengthException;
use Color\Value\Exception\InvalidInputNumberException;

/**
 * Trait ValueValidationTrait
 * 
 * @package Color\Value
 */
trait ValueValidationTrait
{
    /**
     * @param int|float $input
     * @param int $min
     * @param int $max
     * @throws \Color\Value\Exception\InvalidInputNumberException
     * @return void
     */
    public function validateNumber($input, int $min, int $max): void
    {
        if ($input < $min || $input > $max) {
            throw new InvalidInputNumberException($input, $min, $max, get_class($this));
        }   
    }

    /**
     * @param string|int|float $input
     * @param int $min
     * @param int $max
     * @throws \Color\Value\Exception\InvalidInputLengthException
     * @return void
     */
    public function validateLength($input, int $min, int $max): void
    {
        $length = strlen((string) $input);
        
        if ($length < $min || $length > $max) {
            throw new InvalidInputLengthException($input, $min, $max, get_class($this));
        }
    }
}