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
 * Holds RGBA values
 */
class RGBA implements ValueInterface
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
     * @var array<string, float|int>
     */
    private $rgba;
    
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
     * @param float $A The alpha value
     * @param \Color\System\RGB|null $colorSystem
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function __construct(int $R, int $G, int $B, float $A, RGBSystem $colorSystem = null)
    {
        $this->validateNumber($R, 0, 255);
        $this->validateNumber($G, 0, 255);
        $this->validateNumber($B, 0, 255);
        $this->validateNumber($A, 0, 1);

        $this->rgba = [
            'R' => $R,
            'G' => $G,
            'B' => $B,
            'A' => $A,
        ];
        $this->colorSystem = $colorSystem ?? new RGBSystem();
        $this->converter = new Converter();
        $this->name = implode(
            ';', 
            array_map(
                static function($key, $value) {
                    return $key.'='.$value;
                }, 
                array_keys($this->rgba), 
                array_values($this->rgba)
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
     * @return int|float
     */    
    public function getValue(string $value)
    {
        return $this->rgba[$value];
    }

    /**
     * Returns color values in RGBA
     *
     * @return RGBA
     */
    public function getRGBA(): self 
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
        $RGBA = $this->getRGBA();
        return $this->converter->getRGBFromRGBA($RGBA);
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
     * @throws \Color\Value\Exception\InvalidInputNumberException
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
        return implode(', ', $this->rgba);
    }

    /**
     * Returns the color value as a formatted string
     *
     * @param string $format
     * @return string
     */
    public function getFormattedValue(string $format): string
    {
        return sprintf($format, ...array_values($this->rgba));
    }

    /**
     * Returns all color values
     *
     * @return array<string, float|int>
     */
    public function getValues(): array
    {
        return $this->rgba;
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
