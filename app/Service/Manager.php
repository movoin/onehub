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

use One\Hub\Service\Exceptions\ServiceException;
use One\Redis\Manager as Redis;
use One\Support\Helpers\Arr;
use One\Support\Helpers\DateTime;

/**
 * 服务管理对象
 *
 * @package     One\Hub\Service
 * @author      Allen Luo <movoin@gmail.com>
 * @since       0.1
 */
class Manager
{
    /**
     * 服务对象
     *
     * @var \One\Redis\Manager
     */
    private $manager;

    /**
     * 构造
     *
     * @param \One\Redis\Manager $manager
     */
    public function __construct(Redis $manager)
    {
        $this->manager = $manager;
    }

    /**
     * 析构
     */
    public function __destruct()
    {
        $this->manager = null;
    }

    /**
     * 判断服务是否存在
     *
     * @param string $name
     *
     * @return bool
     */
    public function exists(string $name): bool
    {
        return $this->manager->service->exists($name);
    }

    /**
     * 获得全部服务
     *
     * @return array
     */
    public function all(): array
    {
        return $this->manager->service->mGet(
            $this->manager->service->keys('*')
        );
    }

    /**
     * 获得服务总数
     *
     * @return int
     */
    public function count()
    {
        return count($this->manager->service->keys('*'));
    }

    /**
     * 注册服务
     *
     * @param  array $service
     *
     * @return bool
     * @throws \One\Hub\Service\Exceptions\ServiceException
     */
    public function register(array $service): bool
    {
        $name = strtolower(trim(Arr::get($service, 'name', '')));

        if ($name === '') {
            throw new ServiceException('服务名称未定义');
        }

        $service = $this->normalize($service);

        if ($this->manager->service->get($name) !== false) {
            throw new ServiceException(sprintf('服务名称 %s 已经注册', $name));
        }

        if ($this->manager->service->set($name, $service)) {
            return true;
        }

        return false;
    }

    /**
     * 删除服务
     *
     * @param  string $name
     *
     * @return bool
     * @throws \One\Hub\Service\Exceptions\ServiceException
     */
    public function remove(string $name): bool
    {
        if (! $this->exists($name)) {
            throw new ServiceException(sprintf('服务名称 %s 不存在', $name));
        }

        return $this->manager->service->del($name) > 0;
    }

    /**
     * 设置服务状态
     *
     * @param  string $name
     * @param  string $status
     *
     * @return bool
     */
    public function setStatus(string $name, string $status): bool
    {
        if (! $this->exists($name)) {
            throw new ServiceException(sprintf('服务名称 %s 不存在', $name));
        }

        if (! in_array($status, ['on', 'off'])) {
            throw new ServiceException(
                sprintf('服务状态 %s 不在允许范围: %s, %s', $name, 'on', 'off')
            );
        }

        $service = $this->info($name);
        $service['status'] = $status;

        if ($this->manager->service->set($name, $service)) {
            return true;
        }

        return false;
    }

    /**
     * 获得服务信息
     *
     * @param string $name
     *
     * @return array
     * @throws \One\Hub\Service\Exceptions\ServiceException
     */
    public function info(string $name): array
    {
        if ($name === '') {
            throw new ServiceException('服务名称不能为空');
        }

        if (($service = $this->manager->service->get($name)) === false) {
            throw new ServiceException(sprintf('服务名称 %s 未注册', $name));
        }

        return $this->normalize($service);
    }

    /**
     * 标准化服务定义
     *
     * @param array $service
     *
     * @return array
     */
    protected function normalize(array $service): array
    {
        return [
            'name'          => Arr::get($service, 'name', ''),
            'description'   => Arr::get($service, 'description', ''),
            'engine'        => Arr::get($service, 'engine', ''),
            'backend'       => Arr::get($service, 'backend', ''),
            'schema'        => Arr::get($service, 'schema', []),
            'status'        => Arr::get($service, 'status', 'on'),
            'created'       => Arr::get($service, 'created', DateTime::now())
        ];
    }
}
