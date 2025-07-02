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

use Color\ColorValueTrait;
use Color\System\Enum\HKS as HKSEnum;
use Color\Value\Exception\InvalidValue;
use Color\Value\ValueInterface;
use Color\Value\Collection;
use Color\Value\HKS as HKSColor;

/**
 * Class HKS
 * 
 * @package Color\System
 */
class HKS implements SystemInterface
{
    use ColorValueTrait;
    
    /**
     * All color data
     *
     * @var array<string, array<string, mixed>>
     */
    private $colors;
    
    /**
     * The color system
     *
     * @var HKSEnum
     */
    private $colorSystem;

    /**
     * @var string
     */
    private $colorSystemPrefix;

    /**
     * @var string
     */
    private $colorSystemSuffix;

    /**
     * Sets up the HKS system
     *
     * @param \Color\System\Enum\HKS $colorSystem
     * @throws \Color\System\Exception\InvalidSystem
     * @throws \Color\Value\Exception\InvalidInputLengthException
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function __construct(HKSEnum $colorSystem)
    {
        $colorSystemFileName = strtolower($colorSystem);
        $colorSystemFileName = str_replace(' ', '-', $colorSystemFileName);
        
        $colorFile = dirname(__FILE__, 3).DIRECTORY_SEPARATOR.
            'data'.DIRECTORY_SEPARATOR.
            $colorSystemFileName.'.json';
        
        if (!file_exists($colorFile)) {
            throw new Exception\InvalidSystem($colorSystem);
        }

        $colorFile = (string) file_get_contents($colorFile);
        $file = json_decode($colorFile, true);

        $this->colors = $file['values'];
        $this->colorSystem = $file['name']['system'];
        $this->colorSystemPrefix = $file['name']['prefix'];
        $this->colorSystemSuffix = $file['name']['suffix'];

        $this->colors = $this->prepareColors($this->colors); 
    }

    /**
     * Returns a color
     *
     * @param string $colorName
     * @return \Color\Value\ValueInterface
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getColor(string $colorName): ValueInterface
    {
        $color = $this->getColorInformation($colorName);
        return new HKSColor((string) $color['name'], $this);
    }

    /**
     * Returns all color information
     *
     * @param string $colorName
     * @return array<string, mixed>
     * @throws InvalidValue
     */
    public function getColorInformation(string $colorName): array
    {
        foreach ($this->colors as $color) {
            if ($colorName === $color['name']) {
                return $color;
            }
        }
        
        throw new InvalidValue($colorName);
    }

    /**
     * Returns a collection of all colors
     *
     * @return \Color\Value\Collection<ValueInterface>
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function getAllColors(): Collection
    {
        $collection = new Collection();
                
        foreach ($this->colors as $color) {
            $HKS = new HKSColor((string) $color['name'], $this);
            $collection->add($HKS);
        }
        
        return $collection;
    }

    /**
     * Returns a collection of matching colors
     *
     * @param ValueInterface $color
     * @param int $tolerance
     * @return \Color\Value\Collection<ValueInterface>
     * @throws \Color\Value\Exception\InvalidValue
     */
    public function findColor(ValueInterface $color, int $tolerance = 0): Collection
    {
        $collection = new Collection();
        $originColor = $color->getCIELab();

        foreach ($this->colors as $colorExisting) {
            /**
             * @var ValueInterface $colorValue
             */
            $colorValue = array_values($colorExisting['values'])[0];
            $colorValue = $colorValue->getCIELab();
            
            $lMin = $colorValue->getValue('L') - $tolerance;  
            $lMax = $colorValue->getValue('L') + $tolerance;     
            
            $aMin = $colorValue->getValue('A') - $tolerance;  
            $aMax = $colorValue->getValue('A') + $tolerance;     

            $bMin = $colorValue->getValue('B') - $tolerance;  
            $bMax = $colorValue->getValue('B') + $tolerance;     
                        
            $L = $originColor->getValue('L');
            $A = $originColor->getValue('A');
            $B = $originColor->getValue('B');
            
            if ($lMax >= $L && $lMin <= $L 
                && $aMax >= $A && $aMin <= $A 
                && $bMax >= $B && $bMin <= $B
            ) {                
                $HKS = new HKSColor($colorExisting['name'], $this);
                $collection->add($HKS);
            }
        }
        
        return $collection;
    }

    /**
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
     * Returns the prefix of a color name
     *
     * @return string
     */
    public function getColorSystemPrefix(): string
    {
        return $this->colorSystemPrefix;
    }

    /**
     * Returns the suffix of a color name
     *
     * @return string
     */
    public function getColorSystemSuffix(): string
    {
        return $this->colorSystemSuffix;
    }
}
