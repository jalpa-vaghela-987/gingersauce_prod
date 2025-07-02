<?php

/**
 * Colors.
 *
 * @author Tobias Köngeter
 * @copyright Copyright © 2020 Bit&Black
 * @link https://www.bitandblack.com
 * @license MIT
 */

namespace Color\Value;

use Color\System\CIELab as CIELabSystem;
use Color\System\SystemInterface;

/**
 * Holds CIELab values
 */
class CIELab implements ValueInterface
{    
    /**
     * Instance of converter
     *
     * @var \Color\Value\Converter
     */
    private $converter;
    
    /**
     * Color values
     *
     * @var array<string, float>
     */
    private $cieLab;
    
    /**
     * @var \Color\System\CIELab
     */
    private $colorSystem;
    
    /**
     * @var string
     */
    private $name;

    /**
     * Set up a color
     *
     * @param float $L The lightness value
     * @param float $A The a chrominance value
     * @param float $B The b chrominance value
     * @param \Color\System\CIELab|null $colorSystem
     */
    public function __construct(float $L, float $A, float $B, CIELabSystem $colorSystem = null)
    {
        $this->cieLab = [
            'L' => $L,
            'A' => $A,
            'B' => $B,
        ];
        $this->colorSystem = $colorSystem ?? new CIELabSystem();
        $this->converter = new Converter();
        $this->name = implode(
            ';',
            array_map(
                static function($key, $value) {
                    return $key.'='.$value;
                },
                array_keys($this->cieLab),
                array_values($this->cieLab)
            )
        );
    }

    /**
     * Returns the color system
     *
     * @return \Color\System\SystemInterface
     */
    public function getSystem(): SystemInterface
    {
        return $this->colorSystem;
    }
    
    /**
     * Returns a single color value
     *
     * @param string $value
     * @return float
     */    
    public function getValue(string $value): float
    {
        return $this->cieLab[$value];
    }
    
    /**
     * Returns color values in CIELab
     *
     * @return CIELab
     */    
    public function getCIELab(): CIELab
    {        
        return $this;
    }

    /**
     * Returns color values in RGB
     *
     * @return RGB
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */    
    public function getRGB(): RGB
    {     
        $CIELab = $this->getCIELab();
        $XYZ = $this->converter->getXYZFromCIELab($CIELab);
        return $this->converter->getRGBFromXYZ($XYZ);
    }

    /**
     * Returns color values in HEX
     *
     * @return HEX
     * @throws \Color\Value\Exception\InvalidInputLengthException
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */    
    public function getHEX(): HEX
    {
        $CIELab = $this->getCIELab();
        $XYZ = $this->converter->getXYZFromCIELab($CIELab);
        $RGB = $this->converter->getRGBFromXYZ($XYZ);
        return $this->converter->getHEXFromRGB($RGB);
    }

    /**
     * Returns color values in CMYK
     *
     * @return CMYK
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getCMYK(): CMYK
    {
        $CIELab = $this->getCIELab();
        $XYZ = $this->converter->getXYZFromCIELab($CIELab);
        $RGB = $this->converter->getRGBFromXYZ($XYZ);
        $CMY = $this->converter->getCMYFromRGB($RGB);
        return $this->converter->getCMYKFromCMY($CMY);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return implode('/', $this->cieLab);
    }

    /**
     * Returns the color value as a formatted string
     *
     * @param string $format
     * @return string
     */
    public function getFormattedValue(string $format): string
    {
        return sprintf($format, ...array_values($this->cieLab));
    }

    /**
     * Returns color values in RGBA
     *
     * @return RGBA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBA(): RGBA
    {
        $CIELab = $this->getCIELab();
        $XYZ = $this->converter->getXYZFromCIELab($CIELab);
        $RGB = $this->converter->getRGBFromXYZ($XYZ);
        
        return new RGBA(
            $RGB->getValue('R'),
            $RGB->getValue('G'),
            $RGB->getValue('B'),
            1
        );
    }

    /**
     * Returns all color values
     *
     * @return array<string, float>
     */
    public function getValues(): array
    {
        return $this->cieLab;
    }

    /**
     * Returns color values in HSL
     *
     * @return \Color\Value\HSL
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getHSL(): HSL
    {
        $RGB = $this->getRGB();
        return $this->converter->getHSLFromRGB($RGB);
    }

    /**
     * Returns color values in HSLA
     *
     * @return \Color\Value\HSLA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getHSLA(): HSLA
    {
        $HSL = $this->getHSL();
        return $this->converter->getHSLAFromHSL($HSL);
    }

    /**
     * Returns the complementary color
     *
     * @return \Color\Value\Complementary
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getComplementary(): Complementary
    {
        return new Complementary($this->getHSL());
    }
}
