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

/**
 * Class Complementary.
 * This class returns the complementary color.
 * 
 * @package Color\Value
 */
class Complementary extends HSL
{
    /**
     * Complementary constructor.
     *
     * @param \Color\Value\HSL $HSL
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function __construct(HSL $HSL)
    {
        $H = $HSL->getValue('H');
        $H+= $H > 180 ? -180 : 180;
        
        parent::__construct(
            $H,
            $HSL->getValue('S'),
            $HSL->getValue('L')
        );
    }

    /**
     * Returns the complementary color
     *
     * @return \Color\Value\Complementary
     */
    public function getComplementary(): Complementary
    {
        return $this;
    }
}