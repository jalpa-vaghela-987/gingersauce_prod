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

use Color\System\RGB as RGBSystem;
use Color\System\SystemInterface;

/**
 * Holds RGB values
 */
class RGB implements ValueInterface
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
     * @var array<string, int>
     */
    private $rgb;
    
    /**
     * @var \Color\System\RGB
     */
    private $colorSystem;
    
    /**
     * @var string
     */
    private $name;

    /**
     * Set up a color
     *
     * @param int $R The red value
     * @param int $G The green value
     * @param int $B The blue value
     * @param \Color\System\RGB|null $colorSystem
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function __construct(int $R, int $G, int $B, RGBSystem $colorSystem = null)
    {
        $this->validateNumber($R, 0, 255);
        $this->validateNumber($G, 0, 255);
        $this->validateNumber($B, 0, 255);
        
        $this->rgb = [
            'R' => $R,
            'G' => $G,
            'B' => $B,
        ];
        
        $this->colorSystem = $colorSystem ?? new RGBSystem();
        $this->converter = new Converter();
        $this->name = implode(
            ';', 
            array_map(
                static function($key, $value) {
                    return $key.'='.$value;
                }, 
                array_keys($this->rgb), 
                array_values($this->rgb)
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
     * @return int
     */    
    public function getValue(string $value): int
    {
        return $this->rgb[$value];
    }

    /**
     * Returns color values in RGB
     *
     * @return RGB
     */
    public function getRGB(): RGB
    {
        return $this;
    }

    /**
     * Returns color values in RGBA
     *
     * @return RGBA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBA(): RGBA
    {
        return new RGBA(
            $this->getValue('R'),
            $this->getValue('G'),
            $this->getValue('B'),
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
        $RGB = $this->getRGB();
        $CMY = $this->converter->getCMYFromRGB($RGB);
        return $this->converter->getCMYKFromCMY($CMY);
    }

    /**
     * Returns color values in HEX
     *
     * @return HEX
     * @throws \Color\Value\Exception\InvalidInputLengthException
     */    
    public function getHEX(): HEX
    {        
        $RGB = $this->getRGB();
        return $this->converter->getHEXFromRGB($RGB);
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
        return implode(', ', $this->rgb);
    }

    /**
     * Returns the color value as a formatted string
     *
     * @param string $format
     * @return string
     */
    public function getFormattedValue(string $format): string
    {
        return sprintf($format, ...array_values($this->rgb));
    }

    /**
     * Returns all color values
     *
     * @return array<string, int>
     */
    public function getValues(): array
    {
        return $this->rgb;
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
