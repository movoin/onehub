<?php
/**
 * This file is part of the One package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     One\Hub\Service\Providers
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */

namespace One\Hub\Service\Providers;

use One\Hub\Service\Factory;
use One\Swoole\Provider;

class ManagerProvider extends Provider
{
    /**
     * 注册服务
     */
    public function register()
    {
        $this->bind('hub', function ($server) {
            return Factory::newManager();
        });
    }
}
