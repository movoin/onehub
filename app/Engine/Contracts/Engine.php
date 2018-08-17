<?php
/**
 * This file is part of the One package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     One\Hub\Engine\Contracts
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */

namespace One\Hub\Engine\Contracts;

interface Engine
{
    /**
     * 获得引擎名称
     *
     * @return string
     */
    public function getName(): string;
}
