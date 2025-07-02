<?php

namespace Color\Tests\Value;

use Color\Value\HEX;
use PHPUnit\Framework\TestCase;

/**
 * Class HEXTest
 * 
 * @package Color\Tests\Value
 */
class HEXTest extends TestCase
{
    /**
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testCanHandleShortColorNames(): void 
    {
        $hex1 = new HEX('cccccc');
        $hex2 = new HEX('ccc');
        $hex3 = new HEX('CCC');

        self::assertSame(
            $hex1->getRGB()->getValues(),
            [
                'R' => 204,
                'G' => 204,
                'B' => 204
            ]
        );

        self::assertSame(
            $hex2->getRGB()->getValues(),
            [
                'R' => 204,
                'G' => 204,
                'B' => 204
            ]
        );

        self::assertSame(
            $hex3->getRGB()->getValues(),
            [
                'R' => 204,
                'G' => 204,
                'B' => 204
            ]
        );

        self::assertSame(
            $hex1->getRGB()->getValues(),
            $hex2->getRGB()->getValues()
        );
        
        self::assertSame(
            $hex1->getRGB()->getValues(),
            $hex3->getRGB()->getValues()
        );
    }
}