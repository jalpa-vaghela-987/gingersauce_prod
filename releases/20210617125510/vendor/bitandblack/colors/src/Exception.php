<?php

/**
 * Colors.
 *
 * @author Tobias Köngeter
 * @copyright Copyright © 2020 Bit&Black
 * @link https://www.bitandblack.com
 * @license MIT
 */

namespace Color;

/**
 * Class Exception
 * 
 * @package Color
 */
class Exception extends \Exception
{
    /**
     * Exception constructor.
     * 
     * @param string $message
     */
    public function __construct(string $message) 
    {
        parent::__construct($message);
    }
}
