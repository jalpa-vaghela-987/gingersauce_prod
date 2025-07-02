<?php

/**
 * Colors.
 *
 * @author Tobias Köngeter
 * @copyright Copyright © 2020 Bit&Black
 * @link https://www.bitandblack.com
 * @license MIT
 */

namespace Color\Value\Exception;

use Color\Exception;

/**
 * Class InvalidInputLengthException
 * 
 * @package Color\Value\Exception
 */
class InvalidInputLengthException extends Exception
{
    /**
     * InvalidInputException constructor.
     *
     * @param string|int|float $input
     * @param int $min
     * @param int $max
     * @param string $class
     */
    public function __construct($input, int $min, int $max, string $class)
    {
        parent::__construct('Input of class "'.$class.'" needs to be have a length between '.$min.' and '.$max.
            ' but is '.$input.' instead');
    }
}