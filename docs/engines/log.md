# 日志引擎

------

- Engine: `log`
- Backends: `mysql`, `mongodb`, `elasticsearch`
- Version: `0.1.1`
- Updated: `2018-08-22`

------


## 使用引擎

> `注册服务` 需要在服务器上通过命令行工具 `onehub` 进行操作。

[命令行工具 > 服务操作](console/service.md)

### 命令行

```bash
./onehub register -s /path/to/schema.json log_service "只是一个日志服务" log elasticsearch
```

------


## 数据结构

> 服务的数据结构由 `固有结构` 和 `自定义结构` 组成。

[其它 > 自定义数据结构](others/custom_schema.md)

### 固有结构

| 字段名      | 描述     | 类型    | 默认值 |
| :--------: | :------: | :-----: | :----: |
| id         | 日志编号  | Uuid | 自动生成   |
| tag        | 日志标签  | Array | Null   |
| message    | 日志内容  | String | Null   |
| created_at | 创建日期  | Datetime | 自动生成 |

------


## 写入日志

> 向服务中写入日志时，会校验参数的类型并返回异常信息，如果验证成功则返回成功，这时日志将以异步的方式写入服务后端。

### 请求

```http
POST https://onehub.io/log/log_service
```

### 参数

> 依照 `数据结构` 定义的字段填写，`id`，`created_at` 即使填写也会被忽略。

### 参数格式

- `JSON` 格式
- `x-www-form-urlencoded` 格式

### 响应

```json
{
    "code": 200,
    "message": "Ok"
}
```

!> 写入日志数据类型与结构定义不一至时，将返回异常信息。

```json
{
    "code": 400,
    "error": "field_name must be string"
}
```

### 示例

**x-www-form-urlencoded 请求**

```http
POST https://onehub.io/log/log_service HTTP/1.1
Accept: application/json

tag[]=a_tag
message=Log text here
custom_field=Custom field
```

**JSON 请求**

```http
POST https://onehub.io/log/log_service HTTP/1.1
Accept: application/json
Content-Type: application/json

{"tag":["a_tag"],"message":"Log text here","custom_field":"Custom field"}
```

------


## 查询日志

> 所有 `固有结构` 及 `自定义数据结构` 中的字段均支持作为查询字段。

### 请求

```http
POST https://onehub.io/log/log_service/search
```

### 查询条件

```json
{
    "search": {
        "field_1": "value"
    },
    "limit": 20,
    "sort": {
        "created_at": "DESC"
    },
    "page": 1
}
```

### 参数格式

- `JSON` 格式
- `x-www-form-urlencoded` 格式

### 响应

```json
{
    "code": 200,
    "message": "Ok",
    "data": [],
    "total": 1000,
    "limit": 20,
    "page": 1
}
```

!> 查询日志时，如果查询条件错误，将返回错误信息。

```json
{
    "code": 400,
    "error": "field_name was not defined"
}
```

### 示例

**x-www-form-urlencoded 请求**

```http
POST https://onehub.io/log/log_service/search HTTP/1.1
Accept: application/json

tag[]=a_tag
message=Log text here
custom_field=Custom field
```

**JSON 请求**

```http
POST https://onehub.io/log/log_service/search HTTP/1.1
Accept: application/json
Content-Type: application/json

{"tag":["a_tag"],"message":"Log text here","custom_field":"Custom field"}
```


------


## 获取特定日志

> 只接受 `id` 作为查询条件。

### 请求

```http
GET https://onehub.io/log/log_service/00c04fd430c8
```

### 响应

```json
{
    "code": 200,
    "message": "Ok",
    "data": {
        "id": "00c04fd430c8",
        "tag": [],
        "message": ""
    }
}
```

!> 获取特定日志时，如果日志不存在或 `id` 规则错误，将返回错误信息。

```json
{
    "code": 404,
    "error": "log id #00c04fd430c8 was not found"
}
```

### 示例

```http
GET https://onehub.io/log/log_service/00c04fd430c8 HTTP/1.1
Accept: application/json
```


------


## 统计日志

> 所有 `固有结构` 及 `自定义数据结构` 中的字段均支持作为查询字段。

### 请求

```http
POST https://onehub.io/log/log_service/count
```

### 查询条件

```json
{
    "search": {
        "field_1": "value"
    }
}
```

### 参数格式

- `JSON` 格式
- `x-www-form-urlencoded` 格式

### 响应

```json
{
    "code": 200,
    "message": "Ok",
    "data": 1000
}
```

!> 查询日志时，如果查询条件错误，将返回错误信息。

```json
{
    "code": 400,
    "error": "field_name was not defined"
}
```

### 示例

**x-www-form-urlencoded 请求**

```http
POST https://onehub.io/log/log_service/count HTTP/1.1
Accept: application/json

tag[]=a_tag
message=Log text here
custom_field=Custom field
```

**JSON 请求**

```http
POST https://onehub.io/log/log_service/count HTTP/1.1
Accept: application/json
Content-Type: application/json

{"tag":["a_tag"],"message":"Log text here","custom_field":"Custom field"}
```
