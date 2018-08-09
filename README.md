# OneHub

![License](https://img.shields.io/badge/License-Apache_2.0-d33d3b.svg)
![PHP Version](https://img.shields.io/badge/PHP-7.2.7-8892be.svg)
![Swoole Version](https://img.shields.io/badge/Swoole-2.2.0-108cdd.svg)

---

## 命令行

**注册服务**

```bash
Usage:
  ./onehub register [-s|--schema [SCHEMA]] [--] <service> [<description> [<engine> [<backend>]]]

Arguments:
  service                服务名称
  description            服务描述
  engine                 服务引擎
  backend                存储后端

Options:
  -s, --schema[=SCHEMA]  数据结构

Help:
  支持服务引擎:
    + log
    + trace
    + stats

  支持存储后端:
    + mysql
    + redis
    + mongodb
    + elasticsearch

  示例:
    php ./onehub register service log redis
```


**启用服务**

```bash
Usage:
  ./onehub enable <service>

Arguments:
  service                服务名称
```


**停用服务**

```bash
Usage:
  ./onehub disable <service>

Arguments:
  service                服务名称
```


**删除服务**

```bash
Usage:
  ./onehub remove <service>

Arguments:
  service                服务名称
```


**显示服务状态**

```bash
Usage:
  ./onehub status <service>

Arguments:
  service                服务名称
```


**显示服务信息**

```bash
Usage:
  ./onehub info <service>

Arguments:
  service                服务名称
```


**显示服务列表**

```bash
Usage:
  ./onehub ls
```
