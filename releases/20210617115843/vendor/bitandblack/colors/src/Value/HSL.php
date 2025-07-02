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

use Color\System\HSL as HSLSystem;
use Color\System\SystemInterface;

/**
 * Class HSL
 * 
 * @package Color\Value
 */
class HSL implements ValueInterface
{
    use ValueValidationTrait;
    
    /**
     * @var array<string, int>
     */
    private $hsl;
    
    /**
     * @var \Color\System\HSL
     */
    private $colorSystem;
    
    /**
     * @var \Color\Value\Converter
     */
    private $converter;
    
    /**
     * @var string
     */
    private $name;

    /**
     * HSL constructor.
     *
     * @param int $H
     * @param int $S
     * @param int $L
     * @param \Color\System\HSL|null $colorSystem
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function __construct(int $H, int $S, int $L, HSLSystem $colorSystem = null)
    {
        $this->validateNumber($H, 0, 360);
        $this->validateNumber($S, 0, 100);
        $this->validateNumber($L, 0, 100);

        $this->hsl = [
            'H' => $H,
            'S' => $S,
            'L' => $L,
        ];
        $this->colorSystem = $colorSystem ?? new HSLSystem();
        $this->converter = new Converter();
        $this->name = implode(
            ';',
            array_map(
                static function($key, $value) {
                    return $key.'='.$value;
                },
                array_keys($this->hsl),
                array_values($this->hsl)
            )
        );
    }

    /**
     * Allows to simply echo the color to receive its values
     *
     * @return string
     */
    public function __toString(): string
    {
        return implode(', ', $this->hsl);
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
     * @return int
     */
    public function getValue(string $value): int
    {
        return $this->hsl[$value];
    }

    /**
     * Returns all color values
     *
     * @return array<string, int>
     */
    public function getValues(): array
    {
        return $this->hsl;
    }

    /**
     * Returns the color value as a formatted string
     *
     * @param string $format
     * @return string
     */
    public function getFormattedValue(string $format): string
    {
        return sprintf($format, ...array_values($this->hsl));
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
     * Returns color values in RGB
     *
     * @return RGB
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGB(): RGB
    {
        $HSL = $this->getHSL();
        return $this->converter->getRGBFromHSL($HSL);
    }

    /**
     * Returns color values in RGBA
     *
     * @return RGBA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBA(): RGBA
    {
        $HSL = $this->getHSL();
        $RGB = $this->converter->getRGBFromHSL($HSL);
        return $this->converter->getRGBAFromRGB($RGB);
    }

    /**
     * Returns color values in CMYK
     *
     * @return CMYK
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getCMYK(): CMYK
    {
        $HSL = $this->getHSL();
        $RGB = $this->converter->getRGBFromHSL($HSL);
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
        $HSL = $this->getHSL();
        $RGB = $this->converter->getRGBFromHSL($HSL);
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
        $HSL = $this->getHSL();
        $RGB = $this->converter->getRGBFromHSL($HSL);
        $XYZ = $this->converter->getXYZFromRGB($RGB);
        return $this->converter->getCIELabFromXYZ($XYZ);
    }

    /**
     * Returns color values in HSL
     *
     * @return \Color\Value\HSL
     */
    public function getHSL(): HSL
    {
        return $this;
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