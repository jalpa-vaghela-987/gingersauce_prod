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

use Color\System\HEX as HEXSystem;
use Color\System\SystemInterface;

/**
 * Holds HEX values
 */
class HEX implements ValueInterface
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
     * @var array<string, string>
     */
    private $hex;
    
    /**
     * @var \Color\System\HEX
     */
    private $colorSystem;
    
    /**
     * @var string
     */
    private $name;

    /**
     * Sets up a new HEX color. 
     *
     * @param string            $HEX         The HEX value. Without leading `#`!
     * @param \Color\System\HEX $colorSystem The color system.
     * @throws \Color\Value\Exception\InvalidInputLengthException
     */
    public function __construct(string $HEX, HEXSystem $colorSystem = null)
    {
        $this->validateLength($HEX, 3, 6);

        $this->hex = [
            'HEX' => $HEX,
        ];
        $this->colorSystem = $colorSystem ?? new HEXSystem();
        $this->converter = new Converter();
        $this->name = $HEX;
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
     * @return string
     */    
    public function getValue(string $value): string
    {
        return $this->hex[$value];
    }

    /**
     * Returns color values in RGB
     *
     * @return RGB
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGB(): RGB
    {
        $HEX = $this->getHEX();
        return $this->converter->getRGBFromHEX($HEX);
    }

    /**
     * Returns color values in RGBA
     *
     * @return RGBA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBA(): RGBA
    {
        $HEX = $this->getHEX();
        $RGB = $this->converter->getRGBFromHEX($HEX);
        
        return new RGBA(
            $RGB->getValue('R'),
            $RGB->getValue('G'),
            $RGB->getValue('B'),
            1
        );
    }

    /**
     * Returns color values in CMYK
     *
     * @return CMYK
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */    
    public function getCMYK(): CMYK
    {        
        $HEX = $this->getHEX();
        $RGB = $this->converter->getRGBFromHEX($HEX);
        $CMY = $this->converter->getCMYFromRGB($RGB);
        return $this->converter->getCMYKFromCMY($CMY);
    }
    
    /**
     * Returns color values in HEX
     *
     * @return HEX
     */
    public function getHEX(): HEX
    {
        return $this;
    }

    /**
     * Returns color values in CIELab
     *
     * @return CIELab
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getCIELab(): CIELab
    {
        $HEX = $this->getHEX();
        $RGB = $this->converter->getRGBFromHEX($HEX);
        $XYZ = $this->converter->getXYZFromRGB($RGB);
        return $this->converter->getCIELabFromXYZ($XYZ);
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
        return '#'.implode('', $this->hex);
    }

    /**
     * Returns the color value as a formatted string
     *
     * @param string $format
     * @return string
     */
    public function getFormattedValue(string $format): string
    {
        return sprintf($format, ...array_values($this->hex));
    }

    /**
     * Returns all color values
     *
     * @return array<string, string>
     */
    public function getValues(): array
    {
        return $this->hex;
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
