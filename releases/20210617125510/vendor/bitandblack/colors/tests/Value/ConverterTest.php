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

use Color\Value\CMY;
use Color\Value\HSLA;
use Color\Value\CIELab;
use Color\Value\CMYK;
use Color\Value\Converter;
use Color\Value\HEX;
use Color\Value\HSL;
use Color\Value\RGB;
use Color\Value\RGBA;
use Color\Value\XYZ;
use PHPUnit\Framework\TestCase;

/**
 * Class ConverterTest
 * 
 * @package Color\Tests\Value
 */
class ConverterTest extends TestCase
{
    /**
     * @var \Color\Value\Converter
     */
    private $converter;

    /**
     * ConverterTest constructor.
     */
    public function __construct()
    {
        $this->converter = new Converter();
        parent::__construct();
    }

    /**
     * Tests if a RGB color can be converted to XYZ
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetXYZFromRGB(): void
    {
        $RGB = new RGB(18, 31, 41);
        $XYZ = $this->converter->getXYZFromRGB($RGB);

        self::assertEquals(
            [
                'X' => 1.14,
                'Y' => 1.269,
                'Z' => 2.283,
            ],
            $XYZ->getValues()
        );
    }

    /**
     * Tests if a HEX color can be converted to RGB
     * 
     * @throws \Color\Value\Exception\InvalidInputLengthException
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetRGBFromHEX(): void
    {
        $HEX = new HEX('121f29');
        $RGB = $this->converter->getRGBFromHEX($HEX);

        self::assertEquals(
            [
                'R' => 18,
                'G' => 31,
                'B' => 41,
            ],
            $RGB->getValues()
        );
    }

    /**
     * Tests if a RGB color can be converted to HEX
     * 
     * @throws \Color\Value\Exception\InvalidInputLengthException
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetHEXFromRGB(): void
    {
        $RGB = new RGB(18, 31, 41);
        $HEX = $this->converter->getHEXFromRGB($RGB);

        self::assertEquals(
            [
                'HEX' => '121f29',
            ],
            $HEX->getValues()
        );
    }

    /**
     * Tests if a CMYK color can be converted to RGB
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetRGBFromCMYK(): void
    {
        $CMYK = new CMYK(83, 56, 39, 78);
        $RGB = $this->converter->getRGBFromCMYK($CMYK);

        self::assertEquals(
            [
                'R' => 10,
                'G' => 25,
                'B' => 34,
            ],
            $RGB->getValues()
        );
    }

    /**
     * Tests if a XYZ color can be converted to CIELab
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetCIELabFromXYZ(): void
    {
        $XYZ = new XYZ(1.13, 1.26, 2.30);
        $CIELab = $this->converter->getCIELabFromXYZ($XYZ);

        self::assertEquals(
            [
                'L' => 11,
                'A' => -2,
                'B' => -9,
            ],
            $CIELab->getValues()
        );
    }

    /**
     * Tests if a XYZ color can be converted to RGB
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetRGBFromXYZ(): void
    {
        $XYZ = new XYZ(1.13, 1.26, 2.30);
        $RGB = $this->converter->getRGBFromXYZ($XYZ);

        self::assertEquals(
            [
                'R' => 17,
                'G' => 31,
                'B' => 41,
            ],
            $RGB->getValues()
        );

        $XYZ = new XYZ(68, 70, 22);
        $RGB = $this->converter->getRGBFromXYZ($XYZ);

        self::assertEquals(
            [
                'R' => 255,
                'G' => 213,
                'B' => 100,
            ],
            $RGB->getValues()
        );
        
        $XYZ = new XYZ(17, 19, 59);
        $RGB = $this->converter->getRGBFromXYZ($XYZ);

        self::assertEquals(
            [
                'R' => 0,
                'G' => 128,
                'B' => 203,
            ],
            $RGB->getValues()
        );
    }

    /**
     * Tests if a CMYK color can be converted to CMY
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetCMYFromCMYK(): void
    {
        $CMYK = new CMYK(83, 56, 39, 78);
        $CMY = $this->converter->getCMYFromCMYK($CMYK);
        
        self::assertEquals(
            [
                'C' => 96,
                'M' => 90,
                'Y' => 87,
            ],
            $CMY->getValues()
        );
    }

    /**
     * Tests if a RGB color can be converted to CMYK
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetCMYFromRGB(): void
    {
        $RGB = new RGB(18, 31, 41);
        $CMY = $this->converter->getCMYFromRGB($RGB);

        self::assertEquals(
            [
                'C' => 93,
                'M' => 88,
                'Y' => 84,
            ],
            $CMY->getValues()
        );
    }

    /**
     * Tests if a CIELab color can be converted to XYZ
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetXYZFromCIELab(): void
    {
        $CIELab = new CIELab(11, -2, -9);
        $XYZ = $this->converter->getXYZFromCIELab($CIELab);

        self::assertEquals(
            [
                'X' => 1.135,
                'Y' => 1.261,
                'Z' => 2.299
            ],
            $XYZ->getValues()
        );
    }

    /**
     * Tests if a CMY color can be converted to RGB
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetRGBFromCMY(): void
    {
        $CMY = new CMY(93, 88, 84);
        $RGB = $this->converter->getRGBFromCMY($CMY);
        
        self::assertEquals(
            [
                'R' => 17,
                'G' => 30,
                'B' => 40,
            ],
            $RGB->getValues()
        );
    }

    /**
     * Tests if a CMY color can be converted to CMYK
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetCMYKFromCMY(): void
    {
        $CMY = new CMY(93, 88, 84);
        $CMYK = $this->converter->getCMYKFromCMY($CMY);

        self::assertEquals(
            [
                'C' => 56,
                'M' => 25,
                'Y' => 0,
                'K' => 84,
            ],
            $CMYK->getValues()
        );
    }

    /**
     * Tests if a RGB color can be converted to RGBA
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetRGBAFromRGB(): void
    {
        $RGB = new RGB(18, 31, 41);
        $RGBA = $this->converter->getRGBAFromRGB($RGB);
        
        self::assertEquals(
            [
                'R' => 18,
                'G' => 31,
                'B' => 41,
                'A' => 1.0,
            ],
            $RGBA->getValues()
        );
    }

    /**
     * Tests if a RGBA color can be converted to RGB
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetRGBFromRGBA(): void
    {
        $RGBA = new RGBA(18, 31, 41, .5);
        $RGB = $this->converter->getRGBFromRGBA($RGBA);

        self::assertEquals(
            [
                'R' => 9,
                'G' => 15,
                'B' => 20,
            ],
            $RGB->getValues()
        );    
    }

    /**
     * Tests if a RGB color can be converted to HSL
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetHSLFromRGB(): void
    {
        $RGB = new RGB(18, 31, 41);
        $HSL = $this->converter->getHSLFromRGB($RGB);

        self::assertEquals(
            [
                'H' => 206,
                'S' => 39,
                'L' => 12,
            ],
            $HSL->getValues()
        );
    }

    /**
     * Tests if a HSL color can be converted to RGB
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetRGBFromHSL(): void
    {
        $HSL = new HSL(206, 39, 12);
        $RGB = $this->converter->getRGBFromHSL($HSL);

        self::assertEquals(
            [
                'R' => 19,
                'G' => 32,
                'B' => 43,
            ],
            $RGB->getValues()
        );
    }

    /**
     * Tests if a HSL color can be converted to HSLA
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetHSLAFromHSL(): void
    {
        $HSL = new HSL(206, 39, 12);
        $HSLA = $this->converter->getHSLAFromHSL($HSL);

        self::assertEquals(
            [
                'H' => 206,
                'S' => 39,
                'L' => 12,
                'A' => 1,
            ],
            $HSLA->getValues()
        );
    }

    /**
     * Tests if a HSLA color can be converted to RGB
     * 
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function testGetRGBAFromHSLA(): void
    {
        $HSLA = new HSLA(206, 39, 12, .5);
        $RGBA = $this->converter->getRGBAFromHSLA($HSLA);

        self::assertEquals(
            [
                'R' => 19,
                'G' => 32,
                'B' => 43,
                'A' => 0.5,
            ],
            $RGBA->getValues()
        );
    }
}