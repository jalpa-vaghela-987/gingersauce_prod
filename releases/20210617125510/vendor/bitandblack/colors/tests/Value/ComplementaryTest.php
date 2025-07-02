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

use Color\Value\RGB;
use PHPUnit\Framework\TestCase;

/**
 * Class ComplementaryTest
 * 
 * @package Color\Tests\Value
 */
class ComplementaryTest extends TestCase
{
    /**
     * Proofs if the correct value can be found
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testCanFindComplementary(): void
    {
        $RGB = new RGB(200, 100, 50);
        $complementary = $RGB->getComplementary()->getRGB();
        
        self::assertEquals(
            [
                'R' => 50,
                'G' => 150,
                'B' => 200
            ],
            $complementary->getValues()
        );
    }
}