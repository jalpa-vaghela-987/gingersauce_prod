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

use Color\System\Enum\HKS as HKSEnum;
use Color\System\HKS as HKSSystem;
use Color\Value\HKS;
use PHPUnit\Framework\TestCase;

/**
 * Class HKSTest
 * 
 * @package Color\Tests
 */
class HKSTest extends TestCase
{
    /**
     * @throws \Color\System\Exception\InvalidSystem
     * @throws \Color\Value\Exception\InvalidInputLengthException
     * @throws \Color\Value\Exception\InvalidInputNumberException
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function testColor(): void
    {
        $hks = new HKS(
            '10', 
            new HKSSystem(
                HKSEnum::HKS_K()
            )
        ); 

        self::assertEquals(
            58,
            $hks->getCIELab()->getValue('L')
        );
        
        self::assertEquals(
            67,
            $hks->getCIELab()->getValue('A')
        );
        
        self::assertEquals(
            66,
            $hks->getCIELab()->getValue('B')
        );
    }
}