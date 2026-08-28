# 架构

## 选择语言

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../architecture.md) | [English](architecture_en.md) | [Español](architecture_es.md) | **已选** | [Français](architecture_fr.md) | [Deutsch](architecture_de.md) |

应用保持精简，但主要职责边界是明确的：entry point 负责组装依赖，controller 协调 HTTP 流程，filter 管理筛选条件和 session，repository 负责读取数据，template 只负责展示。

## 请求流程

```text
HTTP 请求
    ↓
Nginx
    ↓
public/index.php
    ↓
controller
    ↓
ProductFilter / ProductRepository / ViewRenderer
    ↓
HTML 响应
```

`/` 返回完整的商品目录页面。`/ajax-filter` 只渲染商品列表，浏览器用它替换当前的结果区域。

## 组件与职责

| 区域 | 组件 | 职责 |
|---|---|---|
| Entry point 与 composition root | [`public/index.php`](../../public/index.php) | 加载 bootstrap、启动 session、解析 route，并创建 [`DatabaseConfig`](../../app/Database/DatabaseConfig.php)、PDO、[`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php)、[`ProductRepository`](../../app/Database/ProductRepository.php)、[`ProductFilter`](../../app/Filter/ProductFilter.php)、[`ViewRenderer`](../../app/View/ViewRenderer.php) 和 controller。 |
| Autoload | [`app/bootstrap.php`](../../app/bootstrap.php) | 为 `App\` 注册原生 autoloader，只允许合法的类名片段，并将它们映射到 `app/` 内的文件。不使用 Composer。 |
| 首页 | [`HomeController::index()`](../../app/Controller/HomeController.php) | 从 session 读取活动条件，获取商品和筛选值，然后渲染 `products`、`home` 和 `layout`。 |
| AJAX 筛选 | [`FilterController::filter()`](../../app/Controller/FilterController.php) | 规范化 query 参数，更新筛选状态，并仅返回 `products` HTML fragment。 |
| 筛选状态 | [`ProductFilter`](../../app/Filter/ProductFilter.php) | 只接受 `category`、`color` 和 `weight`，在 session 中保存活动条件，并将 `all` 视为清除对应的单个筛选条件。 |
| 数据访问 | [`ProductRepository`](../../app/Database/ProductRepository.php) | 通过 PDO 获取商品、类别、颜色和重量。 |
| SQL 构建 | [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php) | 只为允许的标识符 `category`、`color` 和 `weight` 构建条件；值单独传入 prepared statement。 |
| 数据库连接 | [`DatabaseConfig`](../../app/Database/DatabaseConfig.php)、[`ConnectionFactory`](../../app/Database/ConnectionFactory.php) | 按 defaults → 本地文件 → `DB_*` 的优先级构建配置，验证值，并创建启用异常、associative fetch mode 且禁用模拟 prepare 的 PDO。 |
| 展示层 | [`ViewRenderer`](../../app/View/ViewRenderer.php)、[`templates/`](../../templates/) | 只允许已注册的 `layout`、`home` 和 `products` 模板；动态 scalar 值使用 UTF-8 的 `htmlspecialchars` 转义。 |
| 客户端 AJAX | [`public/assets/js/ajax-filter.js`](../../public/assets/js/ajax-filter.js) | 监听筛选项，通过 `AbortController` 取消上一个尚未完成的请求，调用 `/ajax-filter` 并替换结果 HTML。 |
| 客户端 UI | [`public/assets/js/ui.js`](../../public/assets/js/ui.js) | 管理界面主题和语言，将偏好保存在 `localStorage` 中，并在 AJAX 响应后更新文本。 |
| 错误 | [`templates/error/404.php`](../../templates/error/404.php)、全局异常处理 | 未知 route 返回 `404`；未处理异常记录在服务器日志中，客户端只收到不包含异常细节的 `500`。 |

## 路由

| 路径 | 处理器 | 响应 |
|---|---|---|
| `/` | [`HomeController::index()`](../../app/Controller/HomeController.php) | 完整的商品目录 HTML 页面。 |
| `/ajax-filter` | [`FilterController::filter()`](../../app/Controller/FilterController.php) | 仅返回商品列表 HTML fragment。 |

应用不处理其他业务 route。

## AJAX 筛选流程

1. 用户修改类别、颜色或重量。
2. [`ajax-filter.js`](../../public/assets/js/ajax-filter.js) 在前一个请求仍未完成时将其取消。
3. 浏览器将修改后的条件发送到 `/ajax-filter`。
4. [`ProductFilter`](../../app/Filter/ProductFilter.php) 只接受允许的参数，并更新它们在 PHP session 中的状态。
5. [`ProductRepository`](../../app/Database/ProductRepository.php) 通过 [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php) 和 PDO 获取结果。
6. [`FilterController`](../../app/Controller/FilterController.php) 渲染 `products`，随后浏览器只替换结果区域。

未发送的筛选条件会保持活动状态。`all` 只清除对应条件；重置按钮会对三个字段都发送 `all`。

## 关键边界

| 边界 | 方案 | 效果 |
|---|---|---|
| 依赖组装 | 所有 concrete dependencies 都在 [`public/index.php`](../../public/index.php) 中创建。 | Controller 不会在内部隐藏 PDO、repository 或 renderer 的创建。 |
| 筛选输入 | [`ProductFilter`](../../app/Filter/ProductFilter.php) 只处理 `category`、`color`、`weight`；空值和非 scalar 值会被忽略。 | HTTP 参数不会直接变成任意查询条件。 |
| SQL | 筛选标识符来自 allowlist，值传入 native prepared statement。 | 用户输入值不会通过字符串拼接进入 SQL。 |
| 数据库配置 | [`DatabaseConfig`](../../app/Database/DatabaseConfig.php) 在连接前验证 key、必填 string、port 和 `charset`。 | 错误的本地配置会在执行查询之前以可预期方式失败。 |
| 模板 | [`ViewRenderer`](../../app/View/ViewRenderer.php) 只允许已知模板并转义动态 scalar 值。 | 请求不能提供任意模板名，数据也不会在缺少上下文 escaping 的情况下写入 HTML。 |
| 错误 | 异常细节只保留在 server log 中；HTTP 客户端只收到简短的 `500`。 | 应用内部细节不会暴露给用户。 |

已经渲染的内部 HTML fragment，例如 `$content` 和商品列表，会作为 trusted rendered HTML 在模板之间传递。

## 有意不添加的内容

- 独立 router class；
- DI container；
- ORM；
- PHP framework；
- Composer 依赖；
- frontend framework；
- 独立 API 层。

依赖组装保持在 entry point 中显式完成，使整个演示流程可以直接通过代码追踪，无需额外基础设施。
