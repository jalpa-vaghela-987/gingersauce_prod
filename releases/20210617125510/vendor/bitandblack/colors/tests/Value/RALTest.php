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

use Color\System\Enum\RAL as RALEnum;
use Color\System\RAL as RALSystem;
use Color\Value\RAL;
use PHPUnit\Framework\TestCase;

/**
 * Class RALTest
 * 
 * @package Color\Tests
 */
class RALTest extends TestCase
{
    /**
     * @throws \Color\System\Exception\InvalidSystem
     * @throws \Color\Value\Exception\InvalidInputLengthException
     * @throws \Color\Value\Exception\InvalidInputNumberException
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function testColor(): void
    {
        $ral = new RAL(
            '1020', 
            new RALSystem(
                RALEnum::RAL()
            )
        );

        self::assertEquals(
            0,
            $ral->getCMYK()->getValue('C')
        );
        
        self::assertEquals(
            15,
            $ral->getCMYK()->getValue('M')
        );
        
        self::assertEquals(
            76,
            $ral->getCMYK()->getValue('Y')
        );
        
        self::assertEquals(
            38,
            $ral->getCMYK()->getValue('K')
        );
    }
}