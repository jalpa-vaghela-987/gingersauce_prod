<?php

/**
 * Colors.
 *
 * @author Tobias Köngeter
 * @copyright Copyright © 2020 Bit&Black
 * @link https://www.bitandblack.com
 * @license MIT
 */

namespace Color\Tests\Value;

use Color\Value\RGBA;
use PHPUnit\Framework\TestCase;

/**
 * Class RGBATest
 * 
 * @package Color\Tests\Value
 */
class RGBATest extends TestCase
{
    /**
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testCanHandleAlpha(): void
    {
        $RGBA = new RGBA(0, 255, 125, .5);

        self::assertEquals(0, $RGBA->getValue('R'));
        self::assertEquals(255, $RGBA->getValue('G'));
        self::assertEquals(125, $RGBA->getValue('B'));
        self::assertEquals(.5, $RGBA->getValue('A'));
    }
}