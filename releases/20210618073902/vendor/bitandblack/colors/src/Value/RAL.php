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

use Color\System\RAL as RALSystem;
use Color\System\SystemInterface;

/**
 * Holds RAL values
 */
class RAL implements ValueInterface
{    
    /**
     * Instance of converter
     *
     * @var \Color\Value\Converter
     */
    private $converter;
    
    /**
     * @var \Color\System\RAL
     */
    private $colorSystem;
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var array<string, string>
     */
    private $colorInformation;

    /**
     * Set up a color
     *
     * @param string $colorName The name of the color
     * @param \Color\System\RAL $colorSystem
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function __construct(string $colorName, RALSystem $colorSystem)
    {
        $this->colorSystem = $colorSystem;
        $this->colorInformation = $this->colorSystem->getColorInformation($colorName);
        $this->converter = new Converter();
        $this->name = $colorName;
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
     * @return mixed
     */    
    public function getValue(string $value) 
    {
        return $this->colorInformation[$value];
    }
    
    /**
     * Returns color values in RGB
     *
     * @return RGB
     */    
    public function getRGB(): RGB
    {
        $colorValues = $this->getValue('values');

        if (array_key_exists('RGB', $colorValues)) {
            return $colorValues['RGB'];
        }

        return array_values($colorValues)[0]->getRGB();
    }

    /**
     * Returns color values in RGBA
     *
     * @return RGBA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBA(): RGBA
    {
        $colorValues = $this->getValue('values');

        if (array_key_exists('RGB', $colorValues)) {
            $RGB = $colorValues['RGB'];
        } else {
            $RGB = array_values($colorValues)[0]->getRGB();
        }

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
     */    
    public function getCMYK(): CMYK
    {
        $colorValues = $this->getValue('values');

        if (array_key_exists('CMYK', $colorValues)) {
            return $colorValues['CMYK'];
        }

        return array_values($colorValues)[0]->getCMYK();
    }
    
    /**
     * Returns color values in HEX
     *
     * @return HEX
     */
    public function getHEX(): HEX
    {
        $colorValues = $this->getValue('values');

        if (array_key_exists('HEX', $colorValues)) {
            return $colorValues['HEX'];
        }

        return array_values($colorValues)[0]->getHEX();
    }
    
    /**
     * Returns color values in CIELab
     *
     * @return CIELab
     */
    public function getCIELab(): CIELab
    {
        $colorValues = $this->getValue('values');

        if (array_key_exists('CIELab', $colorValues)) {
            return $colorValues['CIELab'];
        }

        return array_values($colorValues)[0]->getCIELab();
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
        return $this->getName();
    }

    /**
     * Returns the color value as a formatted string
     *
     * @param string $format
     * @return string
     */
    public function getFormattedValue(string $format): string
    {
        return sprintf($format, $this->getName());
    }

    /**
     * Returns all color values
     *
     * @return array<int, string>
     */
    public function getValues(): array
    {
        return [$this->name];
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
