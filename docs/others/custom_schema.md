# 自定义结构

> `自定义结构` 使用 `JSON` 格式定义，`字段名` 必须使用全小写字母（以 _ 分隔），`字段描述` 尽量简短精要。

**支持类型**

- `Array`
- `Datetime`
- `Float`
- `Integer`
- `String`

**默认值**

!> 只支持具体的值或者 Null，`固定结构` 中的 `自动生成` 只是功能说明，并不是支持参数。

**示例**

```json
{
    "array_field": {
        "description": "Array Field",
        "type": "Array",
        "default": "Null"
    },
    "datetime_field": {
        "description": "Datetime Field",
        "type": "Datetime"
    },
    "float_field": {
        "description": "Float Field",
        "type": "Float",
        "default": 1.0
    },
    "integer_field": {
        "description": "Integer Field",
        "type": "Integer",
        "default": 1
    },
    "string_field": {
        "description": "String Field",
        "type": "String",
        "default": "default value"
    }
}
```

!> 不填写 `default` 等同于 `Null`