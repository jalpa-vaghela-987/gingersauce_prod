[![PHP from Packagist](https://img.shields.io/packagist/php-v/bitandblack/colors)](http://www.php.net)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/cc3558be7b0540bfb4960d10e10b1806)](https://www.codacy.com?utm_source=git@bitbucket.org&amp;utm_medium=referral&amp;utm_content=wirbelwild/colors&amp;utm_campaign=Badge_Grade)
[![Latest Stable Version](https://poser.pugx.org/bitandblack/colors/v/stable)](https://packagist.org/packages/bitandblack/colors)
[![Total Downloads](https://poser.pugx.org/bitandblack/colors/downloads)](https://packagist.org/packages/bitandblack/colors)
[![License](https://poser.pugx.org/bitandblack/colors/license)](https://packagist.org/packages/bitandblack/colors)

# Colors

Handle colors and their systems easily. Based on Adobe InDesigns color books. Included libraries are: 

*   HKS E Process
*   HKS E
*   HKS K Process
*   HKS K
*   HKS N Process
*   HKS N
*   HKS Z Process
*   HKS Z
*   PANTONE+ CMYK Coated
*   PANTONE+ CMYK Uncoated
*   PANTONE+ Color Bridge Coated
*   PANTONE+ Color Bridge Uncoated
*   PANTONE+ Metallic Coated
*   PANTONE+ Pastels + Neons Coated
*   PANTONE+ Pastels + Neons Uncoated
*   PANTONE+ Premium Metallics Coated
*   PANTONE+ Solid Coated
*   PANTONE+ Solid Uncoated
*   RAL

## Attention

This repository is meant to get values of PANTONE, HEX or RAL colors. 
The conversion into other systems isn't 100% perfect, because there are different methods to convert from one system into another. 
Don't take these values too serious.

## Installation 

This library is made for the use with [Composer](https://packagist.org/packages/bitandblack/colors). Add it to your project by running `$ composer require bitandblack/colors`.

## Usage 

You can use color values or color systems, depending on your needs.

### Color values in different color systems

Set up a color like that:

```php
<?php

use Color\Value\CMYK;

$red = new CMYK(0, 100, 90, 0);
```

Or when the color is based on a library:

```php
<?php

use Color\Value\PANTONE as PANTONEValue;
use Color\System\PANTONE as PANTONESystem;
use Color\System\Enum\PANTONE as PANTONEEnum;

$pantoneSolidCoated = new PANTONESystem(
    PANTONEEnum::PANTONE_PLUS_SOLID_COATED()
);

$red = new PANTONEValue('200', $pantoneSolidCoated);
```

Available color systems are:

*   `CIELab` 
*   `CMY` 
*   `CMYK` 
*   `HEX` 
*   `HKS` 
*   `HSL` 
*   `HSLA`
*   `PANTONE` 
*   `RAL` 
*   `RGB` 
*   `RGBA` 
*   `XYZ` 

Get values from another color system by calling 

```php
<?php

$sameRedDifferentValue = $red->getRGB(); 
``` 

### Color systems and similar values 

In the color systems of PANTONE, HKS and RAL you can find (similar) colors based on RGB, HEX or CMYK values by calling 

```php
<?php

use Color\Value\CMYK as CMYKValue;
use Color\System\PANTONE as PANTONESystem;
use Color\System\Enum\PANTONE as PANTONEEnum;

$pantoneSolidCoated = new PANTONESystem(
    PANTONEEnum::PANTONE_PLUS_SOLID_COATED()
);

$red = new CMYKValue(0, 100, 90, 0);

$redsInPantone = $pantoneSolidCoated->findColor($red, 0); 
```

The second parameter in `findColor()` defines the tolerance in percent. For example `0` returns only a 100% match and `5` allows to return colors that differ about 5% in every single color value.

### Complementary color

You can get the complementary color by calling `getComplementary()`. This will return a `HSL` color which you can convert as usual into other systems.

## Help 

If you have questions feel free to contact us under `colors@bitandblack.com`. 

## Thanks 

A special thank goes to Thomas Gottuck for helping by dealing with the color values.
