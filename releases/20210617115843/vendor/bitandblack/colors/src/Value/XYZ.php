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

use Color\System\XYZ as XYZSystem;
use Color\System\SystemInterface;

/**
 * Holds XYZ values
 */
class XYZ implements ValueInterface
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
    private $xyz;
    
    /**
     * @var \Color\System\XYZ
     */
    private $colorSystem;
    
    /**
     * @var string
     */
    private $name;

    /**
     * Set up a color
     *
     * @param float $X The X value
     * @param float $Y The Y value
     * @param float $Z The Z value
     * @param \Color\System\XYZ|null $colorSystem
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function __construct(float $X, float $Y, float $Z, XYZSystem $colorSystem = null)
    {
        $this->validateNumber($X, 0, 100);
        $this->validateNumber($Y, 0, 100);
        $this->validateNumber($Z, 0, 100);

        $this->xyz = [
            'X' => $X,
            'Y' => $Y,
            'Z' => $Z,
        ];
        $this->colorSystem = $colorSystem ?? new XYZSystem();
        $this->converter = new Converter();
        $this->name = implode(
            ';',
            array_map(
                static function($key, $value) {
                    return $key.'='.$value;
                },
                array_keys($this->xyz),
                array_values($this->xyz)
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
        return $this->xyz[$value];
    }
    
    /**
     * Returns color values in XYZ
     *
     * @return XYZ
     */    
    public function getXYZ(): XYZ
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
        $XYZ = $this->getXYZ();
        return $this->converter->getRGBFromXYZ($XYZ);
    }
    
    /**
     * Returns color values in CIELab
     *
     * @return CIELab
     */    
    public function getCIELab(): CIELab
    {
        $XYZ = $this->getXYZ();
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
        $XYZ = $this->getXYZ();
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
        $XYZ = $this->getXYZ();
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
        return implode('/', $this->xyz);
    }

    /**
     * Returns the color value as a formatted string
     *
     * @param string $format
     * @return string
     */
    public function getFormattedValue(string $format): string
    {
        return sprintf($format, ...array_values($this->xyz));
    }

    /**
     * Returns color values in RGBA
     *
     * @return RGBA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBA(): RGBA
    {
        $XYZ = $this->getXYZ();
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
        return $this->xyz;
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
