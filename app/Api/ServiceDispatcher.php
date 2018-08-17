<?php
/**
 * This file is part of the One package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     One\Hub\Api
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */

namespace One\Hub\Api;

use One\Context\Action;
use One\Context\Payload;
use One\Protocol\Contracts\Request;

/**
 * 服务访问接口，用于代理服务接口
 *
 * @methods ["GET", "POST"]
 * @route /{service:\w+}[/{param}]
 */
class ServiceDispatcher extends Action
{
    /**
     * 响应请求
     *
     * @param  \One\Protocol\Contracts\Request  $request
     *
     * @return \One\Context\Contracts\Payload
     */
    protected function run(Request $request)
    {
    }
}
