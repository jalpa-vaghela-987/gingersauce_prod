<?php

/**
 * Colors.
 *
 * @author Tobias Köngeter
 * @copyright Copyright © 2020 Bit&Black
 * @link https://www.bitandblack.com
 * @license MIT
 */

namespace Color\System\Enum;

use MyCLabs\Enum\Enum;

/**
 * Class PANTONE
 * 
 * @package Color\System\Enum
 * @method static PANTONE PANTONE_PLUS_CMYK_COATED()
 * @method static PANTONE PANTONE_PLUS_CMYK_UNCOATED()
 * @method static PANTONE PANTONE_PLUS_CMYK_BRIDGE_COATED()
 * @method static PANTONE PANTONE_PLUS_CMYK_BRIDGE_UNCOATED()
 * @method static PANTONE PANTONE_PLUS_METALLIC_COATED()
 * @method static PANTONE PANTONE_PLUS_PASTELS_AND_NEONS_COATED()
 * @method static PANTONE PANTONE_PLUS_PASTELS_AND_NEONS_UNCOATED()
 * @method static PANTONE PANTONE_PLUS_PREMIUM_METALLICS_COATED()
 * @method static PANTONE PANTONE_PLUS_SOLID_COATED()
 * @method static PANTONE PANTONE_PLUS_SOLID_UNCOATED()
 * @extends Enum<string>
 */
final class PANTONE extends Enum
{
    private const PANTONE_PLUS_CMYK_COATED = 'pantone+-cmyk-coated';
    private const PANTONE_PLUS_CMYK_UNCOATED = 'pantone+-cmyk-uncoated';
    private const PANTONE_PLUS_CMYK_BRIDGE_COATED = 'pantone+-color-bridge-coated';
    private const PANTONE_PLUS_CMYK_BRIDGE_UNCOATED = 'pantone+-color-bridge-uncoated';
    private const PANTONE_PLUS_METALLIC_COATED = 'pantone+-metallic-coated';
    private const PANTONE_PLUS_PASTELS_AND_NEONS_COATED = 'pantone+-pastels-+-neons-coated';
    private const PANTONE_PLUS_PASTELS_AND_NEONS_UNCOATED = 'pantone+-pastels-+-neons-uncoated';
    private const PANTONE_PLUS_PREMIUM_METALLICS_COATED = 'pantone+-premium-metallics-coated';
    private const PANTONE_PLUS_SOLID_COATED = 'pantone+-solid-coated';
    private const PANTONE_PLUS_SOLID_UNCOATED = 'pantone+-solid-uncoated';
}