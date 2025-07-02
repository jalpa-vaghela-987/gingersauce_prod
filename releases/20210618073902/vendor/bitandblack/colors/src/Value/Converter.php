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

/**
 * Converts colors from one color system into another
 */
class Converter
{  
    /**
     * The number of decimals to round to
     *
     * @var int
     */
    private $decimals = 0; 
    
    /**
     * Init
     */
    public function __construct()
    {
        if (defined('COLOR_VALUES_ROUND')) {
            $this->decimals = COLOR_VALUES_ROUND;
        }
    }

    /**
     * Converts a RGB color to XYZ
     *
     * @param RGB $RGB
     * @return XYZ
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getXYZFromRGB(RGB $RGB): XYZ
    {
        $R = $RGB->getValue('R') / 255;
        $G = $RGB->getValue('G') / 255;
        $B = $RGB->getValue('B') / 255;
        
        if ($R > 0.04045) {
            $R = (($R + 0.055) / 1.055) ** 2.4;
        } else {
            $R /= 12.92;
        }
        
        if ($G > 0.04045) {
            $G = (($G + 0.055) / 1.055) ** 2.4;
        } else {
            $G /= 12.92;
        }
        
        if ($B > 0.04045) {
            $B = (($B + 0.055) / 1.055) ** 2.4;
        } else {
            $B /= 12.92;
        }
        
        $R *= 100;
        $G *= 100;
        $B *= 100;
        
        $X = $R * 0.4124 + $G * 0.3576 + $B * 0.1805;
        $Y = $R * 0.2126 + $G * 0.7152 + $B * 0.0722;
        $Z = $R * 0.0193 + $G * 0.1192 + $B * 0.9505;
        
        $X = round($X, 3);
        $Y = round($Y, 3);
        $Z = round($Z, 3);

        if ($X > 100) {
            $X = 100;
        }
        
        if ($Y > 100) {
            $Y = 100;
        }
        
        if ($Z > 100) {
            $Z = 100;
        }

        return new XYZ($X, $Y, $Z);
    }

    /**
     * Converts a HEX color to RGB
     *
     * @param HEX $HEX
     * @return RGB
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBFromHEX(HEX $HEX): RGB
    {
        $hex = str_replace('#', '', $HEX->getValue('HEX'));
        
        $R = hexdec(substr($hex, 0, 2));
        $G = hexdec(substr($hex, 2, 2));
        $B = hexdec(substr($hex, 4, 2));

        if (strlen($hex) === 3) {
            $R = hexdec($hex[0].$hex[0]);
            $G = hexdec($hex[1].$hex[1]);
            $B = hexdec($hex[2].$hex[2]);
        }

        $R = round($R, $this->decimals);
        $G = round($G, $this->decimals);
        $B = round($B, $this->decimals);

        return new RGB(
            (int) $R,
            (int) $G,
            (int) $B
        );
    }

    /**
     * Converts a RGB color to HEX
     *
     * @param RGB $RGB
     * @return HEX
     * @throws \Color\Value\Exception\InvalidInputLengthException
     */
    public function getHEXFromRGB(RGB $RGB): HEX
    {
        $HEX = '';
        
        $HEX.= str_pad(
            dechex($RGB->getValue('R')), 
            2, 
            '0', 
            STR_PAD_LEFT
        );
        $HEX.= str_pad(
            dechex($RGB->getValue('G')), 
            2, 
            '0', 
            STR_PAD_LEFT
        );
        $HEX.= str_pad(
            dechex($RGB->getValue('B')), 
            2, 
            '0', 
            STR_PAD_LEFT
        );
        
        return new HEX($HEX);
    }

    /**
     * Converts a CMYK color to RGB
     *
     * @param CMYK $CMYK
     * @return RGB
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBFromCMYK(CMYK $CMYK): RGB
    {
        $C = $CMYK->getValue('C') / 100;
        $M = $CMYK->getValue('M') / 100;
        $Y = $CMYK->getValue('Y') / 100;
        $K = $CMYK->getValue('K') / 100;
        	
        $R = 1 - ($C * (1 - $K)) - $K;
        $G = 1 - ($M * (1 - $K)) - $K;
        $B = 1 - ($Y * (1 - $K)) - $K;
        
        $R = round($R * 255, $this->decimals);
        $G = round($G * 255, $this->decimals);
        $B = round($B * 255, $this->decimals);

        return new RGB(
            (int) $R,
            (int) $G,
            (int) $B
        );
    }
    
    /**
     * Converts a XYZ color to CIELab
     *
     * @param XYZ $XYZ
     * @return CIELab
     */
    public function getCIELabFromXYZ(XYZ $XYZ): CIELab
    {
        $Xn = 95.047;
        $Yn = 100.000;
        $Zn = 108.883;

        $X = $XYZ->getValue('X') / $Xn;
        $Y = $XYZ->getValue('Y') / $Yn;
        $Z = $XYZ->getValue('Z') / $Zn;

        if ($X > 0.008856) {
            $X = $X ** (1 / 3);
        } else {
            $X = (7.787 * $X) + (16 / 116);
        }
        
        if ($Y > 0.008856) {
            $Y = $Y ** (1 / 3);
        } else {
            $Y = (7.787 * $Y) + (16 / 116);
        }
        
        if ($Z > 0.008856) {
            $Z = $Z ** (1 / 3);
        } else {
            $Z = (7.787 * $Z) + (16 / 116);
        }
        
        if ($Y > 0.008856) {
            $L = (116 * $Y) - 16;
        } else {
            $L = 903.3 * $Y;
        }
        
        $A = 500 * ($X - $Y);
        $B = 200 * ($Y - $Z);

        $L = round($L, $this->decimals);
        $A = round($A, $this->decimals);
        $B = round($B, $this->decimals);

        return new CIELab($L, $A, $B);
    }

    /**
     * Converts a XYZ color to RGB
     *
     * @param XYZ $XYZ
     * @return RGB
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBFromXYZ(XYZ $XYZ): RGB
    {
        $X = $XYZ->getValue('X') / 100;
        $Y = $XYZ->getValue('Y') / 100;
        $Z = $XYZ->getValue('Z') / 100;

        $R = $X * 3.2406 + $Y * -1.5372 + $Z * -0.4986;
        $G = $X * -0.9689 + $Y * 1.8758 + $Z * 0.0415;
        $B = $X * 0.0557 + $Y * -0.2040 + $Z * 1.0570;

        if ($R > 0.0031308) {
            $R = 1.055 * ($R ** (1 / 2.4)) - 0.055;
        } else {
            $R = 12.92 * $R;
        }
        
        if ($G > 0.0031308) {
            $G = 1.055 * ($G ** (1 / 2.4)) - 0.055;
        } else {
            $G = 12.92 * $G;
        }
        
        if ($B > 0.0031308) {
            $B = 1.055 * ($B ** (1 / 2.4)) - 0.055;
        } else {
            $B = 12.92 * $B;
        }
        
        $R *= 255;
        $G *= 255;
        $B *= 255;

        if ($R > 255) {
            $R = 255;
        }

        if ($G > 255) {
            $G = 255;
        }

        if ($B > 255) {
            $B = 255;
        }

        if ($R < 0) {
            $R = 0;
        }

        if ($G < 0) {
            $G = 0;
        }

        if ($B < 0) {
            $B = 0;
        }
        
        $R = round($R, $this->decimals);
        $G = round($G, $this->decimals);
        $B = round($B, $this->decimals);

        return new RGB(
            (int) $R,
            (int) $G,
            (int) $B
        );
    }

    /**
     * Converts a XYZ color to CMY
     *
     * @param CMYK $CMYK
     * @return CMY
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getCMYFromCMYK(CMYK $CMYK): CMY
    {
        $originalC = $CMYK->getValue('C') / 100;
        $originalM = $CMYK->getValue('M') / 100;
        $originalY = $CMYK->getValue('Y') / 100;
        $originalK = $CMYK->getValue('K') / 100;
        
        $C = ($originalC * (1 - $originalK) + $originalK);
        $M = ($originalM * (1 - $originalK) + $originalK);
        $Y = ($originalY * (1 - $originalK) + $originalK);
        
        $C *= 100;
        $M *= 100;
        $Y *= 100;

        $C = round($C, $this->decimals);
        $M = round($M, $this->decimals);
        $Y = round($Y, $this->decimals);

        return new CMY($C, $M, $Y);
    }

    /**
     * Converts a RGB color to CMY
     *
     * @param RGB $RGB
     * @return CMY
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getCMYFromRGB(RGB $RGB): CMY
    {
        $C = 1 - ($RGB->getValue('R') / 255);
        $M = 1 - ($RGB->getValue('G') / 255);
        $Y = 1 - ($RGB->getValue('B') / 255);

        $C*= 100;
        $M*= 100;
        $Y*= 100;

        $C = round($C, $this->decimals);
        $M = round($M, $this->decimals);
        $Y = round($Y, $this->decimals);

        return new CMY($C, $M, $Y);
    }

    /**
     * Converts a CIELab color to XYZ
     *
     * @param CIELab $CIELab
     * @return XYZ
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getXYZFromCIELab(CIELab $CIELab): XYZ
    {
        $Y = ($CIELab->getValue('L') + 16) / 116;
        $X = $CIELab->getValue('A') / 500 + $Y;
        $Z = $Y - $CIELab->getValue('B') / 200;
        
        if ($Y ** 3  > 0.008856) {
            $Y = $Y ** 3;
        } else {
            $Y = ($Y - 16 / 116) / 7.787;
        }
        
        if ($X ** 3  > 0.008856) {
            $X = $X ** 3;
        } else {
            $X = ($X - 16 / 116) / 7.787;
        }
        
        if ( $Z ** 3  > 0.008856) {
            $Z = $Z ** 3;
        } else {
            $Z = ($Z - 16 / 116) / 7.787;
        }

        /**
         * D65 / 10°
         */
        $X *= 94.811;
        $Y *= 100;
        $Z *= 107.304;

        $X = round($X, 3);
        $Y = round($Y, 3);
        $Z = round($Z, 3);
        
        return new XYZ($X, $Y, $Z);
    }

    /**
     * Converts a CMY color to RGB
     *
     * @param \Color\Value\CMY $CMY
     * @return \Color\Value\RGB
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBFromCMY(CMY $CMY): RGB
    {
        $C = $CMY->getValue('C') / 100;
        $M = $CMY->getValue('M') / 100;
        $Y = $CMY->getValue('Y') / 100;

        $R = (1 - $C) * 255;
        $G = (1 - $M) * 255;
        $B = (1 - $Y) * 255;
        
        return new RGB(
            (int) $R,
            (int) $G,
            (int) $B
        );
    }

    /**
     * Converts a CMY color to CMYK
     *
     * @param \Color\Value\CMY $CMY
     * @return \Color\Value\CMYK
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getCMYKFromCMY(CMY $CMY): CMYK 
    {
        $key = 1;
        $cyan = $CMY->getValue('C') / 100;
        $magenta = $CMY->getValue('M') / 100;
        $yellow = $CMY->getValue('Y') / 100;
        
        if ($cyan < $key) {
            $key = $cyan;
        }
        
        if ($magenta < $key) {
            $key = $magenta;
        }
        
        if ($yellow < $key) {
            $key = $yellow;
        }
        
        if ($key === 1) {
            $cyan = 0;
            $magenta = 0;
            $yellow = 0;
        } else {
            $cyan = ($cyan - $key) / (1 - $key);
            $magenta = ($magenta - $key) / (1 - $key);
            $yellow = ($yellow - $key) / (1 - $key);
        }
        
        $black = $key;
        
        $cyan *= 100;
        $magenta *= 100;
        $yellow *= 100;
        $black *= 100;

        $cyan = round($cyan, $this->decimals);
        $magenta = round($magenta, $this->decimals);
        $yellow = round($yellow, $this->decimals);
        $black = round($black, $this->decimals);
        
        return new CMYK($cyan, $magenta, $yellow, $black);
    }

    /**
     * Converts a RGB color to RGBA
     *
     * @param \Color\Value\RGB $RGB
     * @return \Color\Value\RGBA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBAFromRGB(RGB $RGB): RGBA
    {
         return new RGBA(
             $RGB->getValue('R'),
             $RGB->getValue('G'),
             $RGB->getValue('B'),
             1)
         ;
    }

    /**
     * Converts a RGBA color to RGB
     *
     * @param \Color\Value\RGBA $RGBA
     * @return \Color\Value\RGB
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBFromRGBA(RGBA $RGBA): RGB
    {
        $R = $RGBA->getValue('R');
        $G = $RGBA->getValue('G');
        $B = $RGBA->getValue('B');
        $A = $RGBA->getValue('A');

        $R = (int) ($R * $A);
        $G = (int) ($G * $A);
        $B = (int) ($B * $A);

        return new RGB($R, $G, $B);
    }

    /**
     * Converts a RGB color to HSL.
     *
     * @param \Color\Value\RGB $RGB
     * @return \Color\Value\HSL
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getHSLFromRGB(RGB $RGB): HSL
    {
        $r = $RGB->getValue('R') / 255;
        $g = $RGB->getValue('G') / 255;
        $b = $RGB->getValue('B') / 255;

        $max = max( $r, $g, $b );
        $min = min( $r, $g, $b );

        $h = 0;
        $s = 0;
        $l = ( $max + $min ) / 2;
        $d = $max - $min;

        if( $d == 0 ){
            $h = $s = 0; // achromatic
        } else {
            $s = $d / ( 1 - abs( 2 * $l - 1 ) );

            switch( $max ){
                case $r:
                    $h = 60 * fmod( ( ( $g - $b ) / $d ), 6 );
                    if ($b > $g) {
                        $h += 360;
                    }
                    break;

                case $g:
                    $h = 60 * ( ( $b - $r ) / $d + 2 );
                    break;

                case $b:
                    $h = 60 * ( ( $r - $g ) / $d + 4 );
                    break;
            }
        }


        $H = round( $h, 2 );
        $S = round( $s, 2 ) * 100;
        $L = round( $l, 2 ) * 100;
        
        return new HSL(
            (int) $H,
            (int) $S,
            (int) $L
        );
    }

    /**
     * Converts a HSL color to RGB.
     *
     * @param \Color\Value\HSL $HSL
     * @return \Color\Value\RGB
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBFromHSL(HSL $HSL): RGB
    {
        $H = $HSL->getValue('H') / 360;
        $S = $HSL->getValue('S') / 100;
        $L = $HSL->getValue('L') / 100;
        
        if ($S === 0) { 
            $R = $L * 255;
            $G = $L * 255;
            $B = $L * 255;
        } else {
            if ($L < 0.5) {
                $var_2 = $L * (1 + $S);
            } else {
                $var_2 = ($L + $S) - ($S * $L);
            }
            
            $var_1 = 2 * $L - $var_2;
        
            $R = 255 * $this->getRGBFromHUE($var_1, $var_2, $H + (1 / 3));
            $G = 255 * $this->getRGBFromHUE($var_1, $var_2, $H );
            $B = 255 * $this->getRGBFromHUE($var_1, $var_2, $H - (1 / 3));
        }
        
        $R = round($R);
        $G = round($G);
        $B = round($B);
        
        return new RGB(
            (int) $R,
            (int) $G,
            (int) $B
        );
    }

    /**
     * @param float $v1
     * @param float $v2
     * @param float $vH
     * @return float
     */
    private function getRGBFromHUE(float $v1, float $v2, float $vH): float
    {
        if ($vH < 0) {
            ++$vH;
        }
        
        if ($vH > 1) {
            --$vH;
        }
        
        if ((6 * $vH) < 1) {
            return $v1 + ($v2 - $v1) * 6 * $vH;
        }
        
        if ((2 * $vH) < 1) {
            return $v2;
        }
        
        if ((3 * $vH) < 2) {
            return $v1 + ($v2 - $v1) * ((2 / 3) - $vH) * 6;
        }
        
        return $v1;
    }


    /**
     * Converts a HSL color to HSLA
     *
     * @param \Color\Value\HSL $HSL
     * @return \Color\Value\HSLA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getHSLAFromHSL(HSL $HSL): HSLA
    {
        return new HSLA(
            $HSL->getValue('H'),
            $HSL->getValue('S'),
            $HSL->getValue('L'),
            1
        );
    }

    /**
     * Converts a HSLA color to RGBA
     *
     * @param \Color\Value\HSLA $HSLA
     * @return \Color\Value\RGBA
     * @throws \Color\Value\Exception\InvalidInputNumberException
     */
    public function getRGBAFromHSLA(HSLA $HSLA): RGBA
    {
        $HSL = new HSL(
            (int) $HSLA->getValue('H'),
            (int) $HSLA->getValue('S'),
            (int) $HSLA->getValue('L')
        );
        $RGB = $this->getRGBFromHSL($HSL);
        
        return new RGBA(
            $RGB->getValue('R'),
            $RGB->getValue('G'),
            $RGB->getValue('B'),
            $HSLA->getValue('A')
        );
    }
}
