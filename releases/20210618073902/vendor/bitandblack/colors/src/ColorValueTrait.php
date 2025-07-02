<?php

/**
 * Colors.
 *
 * @author Tobias Köngeter
 * @copyright Copyright © 2020 Bit&Black
 * @link https://www.bitandblack.com
 * @license MIT
 */

namespace Color;

use Color\Value\CIELab;
use Color\Value\CMYK;
use Color\Value\HEX;

/**
 * Trait ColorValueTrait
 * 
 * @package Color
 */
trait ColorValueTrait
{
    /**
     * Changed color values into color objects
     *
     * @param array<string, mixed> $colors
     * @return array<string, mixed>
     * @throws \Color\Value\Exception\InvalidInputLengthException
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    private function prepareColors(array $colors): array
    {
        foreach ($colors as &$color) {
            if (isset($color['lightness'], $color['a-chrominance'], $color['b-chrominance'])) {
                $color['values']['CIELab'] = new CIELab(
                    $color['lightness'],
                    $color['a-chrominance'],
                    $color['b-chrominance']
                );

                unset($color['lightness'], $color['a-chrominance'], $color['b-chrominance']);
            }

            if (isset($color['cyan'], $color['magenta'], $color['yellow'], $color['black'])) {
                $color['values']['CMYK'] = new CMYK(
                    $color['cyan'],
                    $color['magenta'],
                    $color['yellow'],
                    $color['black']
                );

                unset($color['cyan'], $color['magenta'], $color['yellow'], $color['black']);
            }
            
            if (isset($color['hex'])) {
                $color['values']['HEX'] = new HEX($color['hex']);
                unset($color['cyan'], $color['magenta'], $color['yellow'], $color['black']);
            }
        }

        return $colors;
    }
}