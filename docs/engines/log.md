# 日志服务

> Engine: `log`  
> Backends: `redis`, `mysql`, `mongodb`, `elasticsearch`  
> Version: `0.1`  
> Updated: `2018-08-11`

------


## 数据结构

> 服务的数据结构由 `固有结构` 和 `自定义结构` 组成。

### 固有结构

| 字段名      | 描述     | 类型    | 默认值 |
| :--------: | :------: | :-----: | :----: |
| id         | 日志编号  | Uuid | 自动生成   |
| tag        | 日志标签  | Array | Null   |
| message    | 日志内容  | String | Null   |
| created_at | 创建日期  | Datetime | 自动生成 |

### 自定义结构

> Test

------

## 写入日志

```bash
POST /<service>
```

