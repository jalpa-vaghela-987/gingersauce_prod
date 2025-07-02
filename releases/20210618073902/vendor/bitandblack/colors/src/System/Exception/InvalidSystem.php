<?php

/**
 * Colors.
 *
 * @author Tobias Köngeter
 * @copyright Copyright © 2020 Bit&Black
 * @link https://www.bitandblack.com
 * @license MIT
 */

namespace Color\System\Exception;

use Color\Exception;

/**
 * Handles invalid color systems errors
 */
class InvalidSystem extends Exception
{
    /**
     * InvalidSystem constructor.
     * @param string $colorSystem
     */
    public function __construct(string $colorSystem) 
    {
        parent::__construct('Unknown color system "'.$colorSystem.'"');
    }
}
