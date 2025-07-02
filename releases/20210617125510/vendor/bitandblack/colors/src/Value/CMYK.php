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

use Color\System\CMYK as CMYKSystem;
use Color\System\SystemInterface;

/**
 * Holds CMYK values
 */
class CMYK implements ValueInterface
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
    private $cmyk;
    
    /**
     * @var \Color\System\CMYK
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
     * @param float $K The Black value
     * @param \Color\System\CMYK|null $colorSystem
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function __construct(float $C, float $M, float $Y, float $K, CMYKSystem $colorSystem = null)
    {
        $this->validateNumber($C, 0, 100);
        $this->validateNumber($M, 0, 100);
        $this->validateNumber($Y, 0, 100);
        $this->validateNumber($K, 0, 100);

        $this->cmyk = [
            'C' => $C,
            'M' => $M,
            'Y' => $Y,
            'K' => $K,
        ];
        $this->colorSystem = $colorSystem ?? new CMYKSystem();
        $this->converter = new Converter();
        $this->name = implode(
            ';',
            array_map(
                static function($key, $value) {
                    return $key.'='.$value;
                },
                array_keys($this->cmyk),
                array_values($this->cmyk)
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
        return $this->cmyk[$value];
    }

    /**
     * Returns color values in RGB
     *
     * @return RGB
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */    
    public function getRGB(): RGB
    {        
        $CMYK = $this->getCMYK();
        return $this->converter->getRGBFromCMYK($CMYK);
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
     * Returns color values in CMYK
     *
     * @return CMYK
     */
    public function getCMYK(): CMYK
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
        return implode('/', $this->cmyk);
    }

    /**
     * Returns the color value as a formatted string
     *
     * @param string $format
     * @return string
     */
    public function getFormattedValue(string $format): string 
    {
        return sprintf($format, ...array_values($this->cmyk));
    }

    /**
     * Returns color values in RGBA
     *
     * @return RGBA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBA(): RGBA
    {
        $CMYK = $this->getCMYK();
        $RGB = $this->converter->getRGBFromCMYK($CMYK);
        
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
        return $this->cmyk;
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
