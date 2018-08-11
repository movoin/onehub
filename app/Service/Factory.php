<?php
/**
 * This file is part of the One package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     One\Hub\Service
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */

namespace One\Hub\Service;

use One\Config;
use One\Redis\Manager as Redis;

abstract class Factory
{
    /**
     * 创建服务管理器对象
     *
     * @return \One\Hub\Service\Manager
     */
    public static function newManager(): Manager
    {
        return new Manager(
            new Redis(Config::get('service', []))
        );
    }
}
