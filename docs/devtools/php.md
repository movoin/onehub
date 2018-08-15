# PHP SDK

## 安装

### 使用 Composer

```bash
composer require onelab/onehub-cli
```

### composer.json

```json
{
  "require": {
    "onelab/onehub-cli": "~0.1"
  }
}
```

------


## 客户端配置

| 配置         | 描述                           | 类型     | 默认值  |
| :----------: | :---------------------------: | :-----: | :----: |
| `server_url` | OneHub 服务器域名 (http[s]://)  | String  |  Null  |
| `timeout`    | 请求超时时间                    | Integer |   5    |
| `retries`    | 超时重试次数                    | Integer |   2    |
| `fallback`   | 失败备用回调                    | Closure |  Null  |
| `failed_log` | 失败日志路径                    | String  |  Null  |


### 示例代码

```php
<?php
require __DIR__ . '/vendor/autoload.php';

$config = [
    'server_url' => 'https://onehub.io',
    'timeout' => 5,
    'retries' => 2
];

$onehub = new \One\Hub\Client($config);
```

------

## 日志引擎

### 写入日志

```php
try {
    $onehub->log_service->push([
        'message' => 'log text here',
        'tags' => [ 'client' ]
    ]);
} catch (FailedException $e) {
    // Do something
}

```