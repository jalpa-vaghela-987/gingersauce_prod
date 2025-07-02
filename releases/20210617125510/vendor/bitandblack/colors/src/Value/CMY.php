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

use Color\System\CMY as CMYSystem;
use Color\System\SystemInterface;

/**
 * Holds CMY values
 */
class CMY implements ValueInterface
{    
    use ValueValidationTrait;
    
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
    private $cmy;
    
    /**
     * @var \Color\System\CMY
     */
    private $colorSystem;
    
    /**
     * @var string
     */
    private $name;

    /**
     * Set up a color
     *
     * @param float $C The Cyan value
     * @param float $M The Magenta value
     * @param float $Y The Yellow value
     * @param \Color\System\CMY|null $colorSystem
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function __construct(float $C, float $M, float $Y, CMYSystem $colorSystem = null)
    {
        $this->validateNumber($C, 0, 100);
        $this->validateNumber($M, 0, 100);
        $this->validateNumber($Y, 0, 100);

        $this->cmy = [
            'C' => $C,
            'M' => $M,
            'Y' => $Y,
        ];
        $this->colorSystem = $colorSystem ?? new CMYSystem();
        $this->converter = new Converter();
        $this->name = implode(
            ';',
            array_map(
                static function($key, $value) {
                    return $key.'='.$value;
                },
                array_keys($this->cmy),
                array_values($this->cmy)
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
        return $this->cmy[$value];
    }

    /**
     * Returns color values in RGB
     *
     * @return RGB
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */    
    public function getRGB(): RGB
    {        
        $CMY = $this->getCMY();
        return $this->converter->getRGBFromCMY($CMY);
    }

    /**
     * Returns color values in CIELab
     *
     * @return CIELab
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */    
    public function getCIELab(): CIELab
    {
        $RGB = $this->getRGB();
        $XYZ = $this->converter->getXYZFromRGB($RGB);
        return $this->converter->getCIELabFromXYZ($XYZ);
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
        $RGB = $this->getRGB();
        return $this->converter->getHEXFromRGB($RGB);
    }

    /**
     * @return \Color\Value\CMYK
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getCMYK(): CMYK
    {
        $CMY = $this->getCMY();
        return $this->converter->getCMYKFromCMY($CMY);
    }

    /**
     * Returns color values in CMY
     *
     * @return CMY
     */
    public function getCMY(): CMY
    {
        return $this;
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
        return implode('/', $this->cmy);
    }

    /**
     * Returns the color value as a formatted string
     *
     * @param string $format
     * @return string
     */
    public function getFormattedValue(string $format): string
    {
        return sprintf($format, ...array_values($this->cmy));
    }

    /**
     * Returns color values in RGBA
     *
     * @return RGBA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBA(): RGBA
    {
        $CMY = $this->getCMY();
        $RGB = $this->converter->getRGBFromCMY($CMY);
        
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
        return $this->cmy;
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
