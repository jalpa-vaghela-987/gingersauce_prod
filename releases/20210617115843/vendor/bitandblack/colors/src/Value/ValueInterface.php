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

use Color\System\SystemInterface;

/**
 * Holds color values
 */
interface ValueInterface 
{
    /**
     * Allows to simply echo the color to receive its values
     * 
     * @return string
     */
    public function __toString(): string;

    /**
     * Returns the colors name
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Returns a single color value
     *
     * @param string $value
     * @return mixed
     */
    public function getValue(string $value);

    /**
     * Returns all color values
     *
     * @return array<int|string, mixed>
     */
    public function getValues(): array;

    /**
     * Returns the color value as a formatted string
     *
     * @param string $format
     * @return string
     */
    public function getFormattedValue(string $format): string;

    /**
     * Returns the color system
     *
     * @return \Color\System\SystemInterface
     */
    public function getSystem(): SystemInterface;

    /**
     * Returns color values in RGB
     *
     * @return RGB
     */
    public function getRGB(): RGB;

    /**
     * Returns color values in RGBA
     *
     * @return RGBA
     */
    public function getRGBA(): RGBA;
    
    /**
     * Returns color values in CMYK
     *
     * @return CMYK
     */    
    public function getCMYK(): CMYK;
    
    /**
     * Returns color values in HEX
     *
     * @return HEX
     */    
    public function getHEX(): HEX;
    
    /**
     * Returns color values in CIELab
     *
     * @return CIELab
     */    
    public function getCIELab(): CIELab;

    /**
     * Returns color values in HSL
     *
     * @return \Color\Value\HSL
     */
    public function getHSL(): HSL;

    /**
     * Returns color values in HSLA
     *
     * @return \Color\Value\HSLA
     */
    public function getHSLA(): HSLA;

    /**
     * Returns the complementary color
     * 
     * @return \Color\Value\Complementary
     */
    public function getComplementary(): Complementary;
}
