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
use Color\Value\ValueInterface;

/**
 * Holds color systems
 */
interface SystemInterface 
{
    /**
     * Allows to display the name of the system by echoing it
     * 
     * @return string
     */
    public function __toString(): string;

    /**
     * Returns a color
     *
     * @param string $colorName
     * @return ValueInterface
     */
    public function getColor(string $colorName): ValueInterface;

    /**
     * Returns the prefix of a color name
     * 
     * @return string
     */
    public function getColorSystemPrefix(): string;

    /**
     * Returns the suffix of a color name
     * 
     * @return string
     */
    public function getColorSystemSuffix(): string;

    /**
     * Returns color information
     *
     * @param string $colorName
     * @return array<string, string>
     */
    public function getColorInformation(string $colorName): array;
    
    /**
     * Returns a collection of all colors
     *
     * @return \Color\Value\Collection<ValueInterface>
     */
    public function getAllColors(): Collection;
    
    /**
     * Returns a collection of matching colors
     *
     * @param ValueInterface $color
     * @param int $tolerance
     * @return \Color\Value\Collection<ValueInterface>
     */
    public function findColor(ValueInterface $color, int $tolerance = 0): Collection;
}
