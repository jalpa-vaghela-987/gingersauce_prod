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
 * Handles invalid color value errors
 */
class InvalidValue extends Exception
{
    /**
     * InvalidValue constructor.
     * 
     * @param string $colorName
     */
    public function __construct(string $colorName) 
    {
        parent::__construct('Unknown color value "'.$colorName.'"');
    }
}
