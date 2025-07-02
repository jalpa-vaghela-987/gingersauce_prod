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

use Color\System\Enum\PANTONE as PANTONEEnum;
use Color\System\PANTONE;
use Color\Value\Exception\InvalidValue;
use PHPUnit\Framework\TestCase;

/**
 * Class PANTONETest
 * 
 * @package Color\Tests\System
 */
class PANTONETest extends TestCase
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

        $pantoneSystem = new PANTONE(
            PANTONEEnum::PANTONE_PLUS_SOLID_COATED()
        );

        $pantoneSystem->getColor('MISSING_COLOR');
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

        $pantoneSystem = new PANTONE(
            PANTONEEnum::PANTONE_PLUS_SOLID_COATED()
        );

        $pantoneSystem->getColorInformation('MISSING_COLOR');
    }
}