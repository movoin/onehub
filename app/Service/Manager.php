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

use RuntimeException;
use InvalidArgumentException;
use One\Redis\Client;
use One\Support\Helpers\Arr;

class Manager
{
    const HASH_KEY = 's';

    const STATUS_ON = 'on';
    const STATUS_OFF = 'off';

    /**
     * 服务对象
     *
     * @var \One\Redis\Client
     */
    private $client;

    /**
     * 构造
     *
     * @param \One\Redis\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 析构
     */
    public function __destruct()
    {
        $this->client->close();
        $this->client = null;
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
        return $this->client->hExists(self::HASH_KEY, $name);
    }

    /**
     * 获得全部服务
     *
     * @return array
     */
    public function all(): array
    {
        return $this->client->hGetAll(self::HASH_KEY);
    }

    /**
     * 获得服务总数
     *
     * @return int
     */
    public function count()
    {
        return count($this->all());
    }

    /**
     * 注册服务
     *
     * @param  array $service
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function register(array $service): bool
    {
        $name = strtolower(trim(Arr::get($service, 'name', '')));

        if ($name === '') {
            throw new InvalidArgumentException('服务名称未定义');
        }

        $service = $this->normalize($service);

        if ($this->client->hget(self::HASH_KEY, $name) !== false) {
            throw new RuntimeException(sprintf('服务名称 %s 已经注册', $name));
        }

        if ($this->client->hset(self::HASH_KEY, $name, $service)) {
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
     * @throws \InvalidArgumentException
     */
    public function info(string $name): array
    {
        if ($name === '') {
            throw new InvalidArgumentException('服务名称未定义');
        }

        if (($service = $this->client->hget(self::HASH_KEY, $name)) === false) {
            throw new RuntimeException(sprintf('服务名称 %s 未注册', $name));
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
            'status'        => Arr::get($service, 'status', self::STATUS_ON)
        ];
    }
}
