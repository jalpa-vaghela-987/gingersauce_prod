<?php

use Color\System\Enum\HKS;
use Color\System\Enum\PANTONE;
use Color\System\Enum\RAL;
use Color\Value\ValueInterface;

error_reporting(E_ALL|E_NOTICE);

require '../vendor/autoload.php';


/**
 * When you need decimals
 */
//define('COLOR_VALUES_ROUND', 2);


/**
 * Create new color value
 */

$red = new Color\Value\CMYK(0, 100, 90, 0); 


/**
 * Find related color values in PANTONE system 
 */

$PANTONESystem = new Color\System\PANTONE(PANTONE::PANTONE_PLUS_SOLID_COATED());

$redsInPantone = $PANTONESystem->findColor($red, 20); 

foreach ($redsInPantone as $color) {
    printColor($color);
}


/**
 * Find related color values in HKS system 
 */

$HKSSystem = new Color\System\HKS(HKS::HKS_K());

$redsInHKS = $HKSSystem->findColor($red, 20); 

foreach ($redsInHKS as $color) {
    printColor($color);
}


/**
 * Find related color values in RAL system 
 */

$RALSystem = new Color\System\RAL(RAL::RAL());

$redsInRAL = $RALSystem->findColor($red, 20); 

foreach ($redsInRAL as $color) {
    printColor($color);
}

/**
 * @param \Color\Value\ValueInterface $color
 */
function printColor(ValueInterface $color)
{
    echo '<div style="background-color: rgba('.$color->getRGBA().')">'.
            $color->getSystem()->getColorSystemPrefix().' '.
            $color->getName().' '.
            $color->getSystem()->getColorSystemSuffix().
        '</div>'.PHP_EOL
    ;
}

