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
use Color\Value\Exception\InvalidValue;

/**
 * Class NullColor
 * 
 * @package Color\Value
 */
class NullColor implements ValueInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * NullColor constructor.
     * 
     * @param string $colorName
     */
    public function __construct(string $colorName)
    {
        $this->name = $colorName;
    }

    /**
     * Allows to simply echo the color to receive its values
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * Returns the colors name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns a single color value
     *
     * @param string $value
     * @return mixed
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getValue(string $value)
    {
        throw new InvalidValue('null');
    }

    /**
     * Returns the color system
     *
     * @return \Color\System\SystemInterface
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getSystem(): SystemInterface
    {
        throw new InvalidValue('null');
    }

    /**
     * Returns color values in RGB
     *
     * @return RGB
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getRGB(): RGB
    {
        throw new InvalidValue('null');
    }

    /**
     * Returns color values in CMYK
     *
     * @return CMYK
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getCMYK(): CMYK
    {
        throw new InvalidValue('null');
    }

    /**
     * Returns color values in HEX
     *
     * @return HEX
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getHEX(): HEX
    {
        throw new InvalidValue('null');
    }

    /**
     * Returns color values in CIELab
     *
     * @return CIELab
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getCIELab(): CIELab
    {
        throw new InvalidValue('null');
    }

    /**
     * Returns the color value as a formatted string
     *
     * @param string $format
     * @return string
     */
    public function getFormattedValue(string $format): string
    {
        return sprintf($format, '');
    }

    /**
     * Returns color values in RGBA
     *
     * @return RGBA
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getRGBA(): RGBA
    {
        throw new InvalidValue('null');
    }

    /**
     * Returns all color values
     *
     * @return array<int, string>
     */
    public function getValues(): array
    {
        return [];
    }

    /**
     * Returns color values in HSL
     *
     * @return \Color\Value\HSL
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getHSL(): HSL
    {
        throw new InvalidValue('null');
    }

    /**
     * Returns color values in HSLA
     *
     * @return \Color\Value\HSLA
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getHSLA(): HSLA
    {
        throw new InvalidValue('null');
    }

    /**
     * Returns the complementary color
     *
     * @return \Color\Value\Complementary
     * @throws \Color\Value\Exception\InvalidInputNumberException
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getComplementary(): Complementary
    {
        return new Complementary($this->getHSL());
    }
}