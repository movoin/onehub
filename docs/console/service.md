# 服务操作

------

## 注册服务

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


## 启用服务

```bash
Usage:
  ./onehub enable <service>

Arguments:
  service                服务名称
```


## 停用服务

```bash
Usage:
  ./onehub disable <service>

Arguments:
  service                服务名称
```


## 删除服务

```bash
Usage:
  ./onehub remove <service>

Arguments:
  service                服务名称
```


## 显示服务状态

```bash
Usage:
  ./onehub status <service>

Arguments:
  service                服务名称
```


## 显示服务信息

```bash
Usage:
  ./onehub info <service>

Arguments:
  service                服务名称
```


## 显示服务列表

```bash
Usage:
  ./onehub ls
```