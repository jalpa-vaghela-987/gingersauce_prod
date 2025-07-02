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
 * Class HKS
 * 
 * @package Color\System\Enum
 * @method static HKS HKS_E_PROCESS()
 * @method static HKS HKS_E()
 * @method static HKS HKS_K_PROCESS()
 * @method static HKS HKS_K()
 * @method static HKS HKS_N_PROCESS()
 * @method static HKS HKS_N()
 * @method static HKS HKS_Z_PROCESS()
 * @method static HKS HKS_Z()
 * @extends Enum<string>
 */
final class HKS extends Enum
{
    
    private const HKS_E_PROCESS = 'hks-e-process';
    private const HKS_E = 'hks-e';
    private const HKS_K_PROCESS = 'hks-k-process';
    private const HKS_K = 'hks-k';
    private const HKS_N_PROCESS = 'hks-n-process';
    private const HKS_N = 'hks-n';
    private const HKS_Z_PROCESS = 'hks-z-process';
    private const HKS_Z = 'hks-z';
}