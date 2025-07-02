<?php

/**
 * Colors.
 *
 * @author Tobias Köngeter
 * @copyright Copyright © 2020 Bit&Black
 * @link https://www.bitandblack.com
 * @license MIT
 */

namespace Color\Tests\System;

use Color\System\Enum\HKS as HKSEnum;
use Color\System\HKS;
use Color\Value\Exception\InvalidValue;
use PHPUnit\Framework\TestCase;

/**
 * Class HKSTest
 * 
 * @package Color\Tests\System
 */
class HKSTest extends TestCase
{
    /**
     * @throws \Color\System\Exception\InvalidSystem
     * @throws \Color\Value\Exception\InvalidInputLengthException
     * @throws \Color\Value\Exception\InvalidInputNumberException
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function testHandlesMissingColor1(): void
    {
        $this->expectException(InvalidValue::class);

        $hksSystem = new HKS(
            HKSEnum::HKS_K()
        );

        $hksSystem->getColor('MISSING_COLOR');
    }

    /**
     * @throws \Color\System\Exception\InvalidSystem
     * @throws \Color\Value\Exception\InvalidInputLengthException
     * @throws \Color\Value\Exception\InvalidInputNumberException
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function testHandlesMissingColor2(): void
    {
        $this->expectException(InvalidValue::class);
        
        $hksSystem = new HKS(
            HKSEnum::HKS_K()
        );

        $hksSystem->getColorInformation('MISSING_COLOR');
    }
}