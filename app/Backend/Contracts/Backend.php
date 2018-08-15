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

interface Backend
{
    /**
     * Redis 存储
     */
    const BASE_ON_REDIS = 'redis';
    /**
     * MySQL 存储
     */
    const BASE_ON_MYSQL = 'mysql';
    /**
     * MongoDB 存储
     */
    const BASE_ON_MONGODB = 'mongodb';
    /**
     * ElasticSearch 存储
     */
    const BASE_ON_ELASTIC = 'elasticsearch';
}
