# 参与开发

## 选择语言

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](https://github.com/yaleksandr89/filter-ajax/blob/master/.github/CONTRIBUTING.md) | [English](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_en.md) | [Español](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_es.md) | **中文** | [Français](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_fr.md) | [Deutsch](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_de.md) |

感谢你关注 AJAX Filter。项目规模较小，因此改动应保持范围明确、可复现并且易于审查。

## 开始之前

- 可复现的错误请通过 [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues) 报告。
- 问题和较宽泛的想法最好先在 [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions) 中讨论。
- 不要发布密码、token、production 配置、个人数据或其他敏感信息。
- 在进行较大改动前，请确认它符合项目目标，并且不会在缺少明确需要时增加基础设施或依赖。

## 项目契约

- AJAX Filter 是一个小型 PHP Web 应用，不使用 PHP framework、ORM 或 Composer 依赖。
- 客户端使用原生 JavaScript，不使用 frontend framework 或第三方 JavaScript 依赖。
- 应用处理两个业务 route：`/` 和 `/ajax-filter`。
- 筛选使用 `category`、`color` 和 `weight`；活动条件保存在 PHP session 中。
- 数据访问使用 PDO；筛选值传入 native prepared statements，SQL 标识符只从允许集合中选择。
- `public/index.php` 保持为 composition root，并显式组装应用依赖。
- 主要本地工作流基于 Docker Compose 和 Makefile。
- `schema` 和 `demo` 模式只在初始化新的 MariaDB volume 时应用。
- 未经单独决策，改动不得增加 framework layer、ORM、DI container、独立 API、自动 retry/cache/fallback 或其他新子系统。

应用结构见[架构说明](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/architecture_zh.md)，本地启动与检查见[开发指南](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/development_zh.md)。

## 分支

使用能够反映改动目的的简短名称，例如：

```text
fix/filter-validation
docs/update-development-guide
chore/update-ci
```

## Commit

推荐使用 Conventional Commits。示例：

```text
fix: 修复筛选处理
docs: 说明本地启动方式
test: 覆盖筛选回归
chore: 更新 CI 配置
```

## 本地检查

提交 Pull Request 前，请执行与改动相关的检查：

| 改动内容 | 检查 |
|---|---|
| Docker Compose 或容器配置 | `make config` |
| PHP 应用行为 | `make php CMD="tests/run.php"` |
| 已启动 stack 的 HTTP/runtime 行为 | `make smoke` |

项目启动和完整 Make 命令列表见[开发指南](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/development_zh.md)。

如果改动影响数据库模式或数据库初始化，请使用新的 volume 验证。`make db-reinit` 只删除当前 Compose 项目的数据库 volume 数据，必须有意识地使用。

## Pull Request

Pull Request 描述中请包含：

- 改动要解决的问题或目标；
- 具体修改内容；
- 已执行的检查；
- 行为发生变化时新增或更新的测试；
- 如适用，对 Docker、数据库、安全、界面或文档的影响。

提交前请确认：

- 改动仅包含一个连贯任务；
- 不包含无关的 refactoring 或格式化；
- commit 中不包含 secret、本地配置或敏感数据；
- 测试和 runtime 检查与受影响行为相匹配；
- 命令、契约或可观察行为变化时已更新文档；
- 已翻译文档发生变化时，各语言版本保持同步。
