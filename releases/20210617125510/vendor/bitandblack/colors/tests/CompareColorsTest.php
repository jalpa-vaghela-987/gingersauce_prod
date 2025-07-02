<?php

/**
 * Colors.
 *
 * @author Tobias Köngeter
 * @copyright Copyright © 2020 Bit&Black
 * @link https://www.bitandblack.com
 * @license MIT
 */

namespace Color\Tests;

use Color\Value\CMYK;
use PHPUnit\Framework\TestCase;

/**
 * Class CompareColorsTest
 * 
 * @package Color\Tests
 */
class CompareColorsTest extends TestCase
{
    /**
     * Tests if a the conversion from CMYK to RGB to CMYK returns same values
     *
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testCMYKtoRGBtoCMYK(): void
    {
        $color = new CMYK(0, 100, 90, 0);
        
        $original = [
            $color->getValue('C'), 
            $color->getValue('M'), 
            $color->getValue('Y'), 
            $color->getValue('K'), 
        ];
        
        $colorConverted = $color->getRGB()->getCMYK();

        $converted = [
            $colorConverted->getValue('C'), 
            $colorConverted->getValue('M'), 
            $colorConverted->getValue('Y'), 
            $colorConverted->getValue('K'), 
        ];

        self::assertEquals(
            $original,
            $converted
        );
    }

    /**
     * Tests if a the conversion from CMYK to HEX to CMYK returns same values
     *
     * @throws \Color\Value\Exception\InvalidInputLengthException
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testCMYKtoHEXtoCMYK(): void
    {
        $color = new CMYK(0, 100, 90, 0);
        
        $original = [
            $color->getValue('C'), 
            $color->getValue('M'), 
            $color->getValue('Y'), 
            $color->getValue('K'), 
        ];
        
        $colorConverted = $color->getHEX()->getCMYK();

        $converted = [
            $colorConverted->getValue('C'), 
            $colorConverted->getValue('M'), 
            $colorConverted->getValue('Y'), 
            $colorConverted->getValue('K'), 
        ];

        self::assertEquals(
            $original,
            $converted
        );
    }
}
