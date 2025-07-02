<?php

use Color\Value\RGB;

require '../vendor/autoload.php';

$color = new RGB(150, 50, 50);
$complementary = $color->getComplementary()->getRGB();

echo '<div style="background-color: rgba('.$color->getRGBA().')">'.
    $color->getSystem()->getColorSystemPrefix().' '.
    $color->getName().' '.
    $color->getSystem()->getColorSystemSuffix().
    '</div>'.PHP_EOL
;

echo '<div style="background-color: rgba('.$complementary->getRGBA().')">'.
    $complementary->getSystem()->getColorSystemPrefix().' '.
    $complementary->getName().' '.
    $complementary->getSystem()->getColorSystemSuffix().
    '</div>'.PHP_EOL
;
