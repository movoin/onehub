<?php
/**
 * This file is part of the One package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     One\Hub\Contracts
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */

namespace One\Hub\Contracts;

interface Engine
{
    /**
     * LOG 引擎
     */
    const LOG = 'log';
    /**
     * TRACE 引擎
     */
    const TRACE = 'trace';
    /**
     * STATS 引擎
     */
    const STATS = 'stats';
}
