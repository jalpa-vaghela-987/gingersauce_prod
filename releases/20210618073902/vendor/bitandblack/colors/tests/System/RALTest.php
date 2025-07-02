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

use Color\System\Enum\RAL as RALEnum;
use Color\System\RAL;
use Color\Value\Exception\InvalidValue;
use PHPUnit\Framework\TestCase;

/**
 * Class RALTest
 * 
 * @package Color\Tests\System
 */
class RALTest extends TestCase
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

        $ralSystem = new RAL(
            RALEnum::RAL()
        );

        $ralSystem->getColor('MISSING_COLOR');
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

        $ralSystem = new RAL(
            RALEnum::RAL()
        );

        $ralSystem->getColorInformation('MISSING_COLOR');
    }
}