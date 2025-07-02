<?php

/**
 * Colors.
 *
 * @author Tobias Köngeter
 * @copyright Copyright © 2020 Bit&Black
 * @link https://www.bitandblack.com
 * @license MIT
 */

namespace Color\System;

use Color\Value\Collection;
use Color\Value\NullColor;
use Color\Value\ValueInterface;

/**
 * Class HSL
 * 
 * @package Color\System
 */
class HSL implements SystemInterface
{
    /**
     * @var string
     */
    private $colorSystem;

    /**
     * HSL constructor.
     */
    public function __construct()
    {
        $this->colorSystem = 'HSL';
    }

    /**
     * Allows to display the name of the system by echoing it
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getColorSystem();
    }

    /**
     * @return string
     */
    public function getColorSystem(): string
    {
        return $this->colorSystem;
    }

    /**
     * Returns a color
     *
     * @param string $colorName
     * @return \Color\Value\ValueInterface
     */
    public function getColor(string $colorName): ValueInterface
    {
        return new NullColor($colorName);
    }

    /**
     * Returns the prefix of a color name
     *
     * @return string
     */
    public function getColorSystemPrefix(): string
    {
        return '';
    }

    /**
     * Returns the suffix of a color name
     *
     * @return string
     */
    public function getColorSystemSuffix(): string
    {
        return '';
    }

    /**
     * Returns color information
     *
     * @param string $colorName
     * @return array<string, string>
     */
    public function getColorInformation(string $colorName): array
    {
        return [
            'name' => $colorName
        ];
    }

    /**
     * Returns a collection of all colors
     *
     * @return \Color\Value\Collection<ValueInterface>
     */
    public function getAllColors(): Collection
    {
        return new Collection();
    }

    /**
     * Returns a collection of matching colors
     *
     * @param ValueInterface $color
     * @param int $tolerance
     * @return \Color\Value\Collection<ValueInterface>
     */
    public function findColor(ValueInterface $color, int $tolerance = 0): Collection
    {
        return new Collection();
    }
}