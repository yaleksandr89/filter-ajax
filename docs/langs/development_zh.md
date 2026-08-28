# 开发

## 选择语言

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../development.md) | [English](development_en.md) | [Español](development_es.md) | **已选** | [Français](development_fr.md) | [Deutsch](development_de.md) |

## 主机要求

主要 Docker 工作流需要：

- Git；
- 支持 Compose v2 的 Docker Engine；
- `make`。

无需在主机上单独安装 PHP、MariaDB 或 Xdebug。PHP 容器使用 PHP 8.5.9-FPM、`pdo_mysql` 和 Xdebug 3.5.3；stack 中还包含 Nginx 和 MariaDB。

## 不使用 Docker 运行

项目可以连接到现有 MariaDB，并使用 PHP 8.5、PDO MySQL 扩展和 PHP-FPM。创建数据库，执行 [`docker/mariadb/schema.sql`](../../docker/mariadb/schema.sql)，如有需要再执行 [`docker/mariadb/demo-data.sql`](../../docker/mariadb/demo-data.sql)，然后配置 `config/database.php` 或 `DB_*` 环境变量。

Web 服务器的 document root 必须指向 `public/`。如果 Nginx 使用本地 PHP-FPM Unix socket，请调整[参考配置](../examples/nginx-configuration.conf)：它会把普通 URI 路由到 front controller，并阻止直接访问 PHP URI。

## 首次使用 Docker 启动

| 命令 | 用途 |
|---|---|
| `make build` | 构建本地 Docker 镜像。 |
| `make up` | 启动 stack 并等待服务就绪。 |
| `make down` | 停止服务并保留数据库数据。 |

服务就绪后，可通过 [http://127.0.0.1:8080](http://127.0.0.1:8080) 访问应用。

> [!NOTE]
> 默认情况下，应用监听 `127.0.0.1:8080`。如需使用其他端口，可在启动时传入 `HTTP_PORT`，例如：`make up HTTP_PORT=18080`。
>
> 如果不想在当前 shell session 的每条 Make 命令中重复传入端口，可以先执行 `export HTTP_PORT=18080`。之后普通的 `make up`、`make smoke` 和其他命令都会使用该值。

## 何时需要重新构建

修改 `docker/php/`、`docker/mariadb/` 或 `docker/nginx/` 中的 Dockerfile 或镜像配置后，请重新构建镜像。对已有 volume 修改数据库模式不会重新初始化数据。

## Makefile 命令

| 命令 | 用途 |
|---|---|
| `make help` | 显示帮助。 |
| `make config` | 输出最终 Compose 配置。 |
| `make build` | 构建本地镜像。 |
| `make up [DB_MODE=schema\|demo] [HTTP_PORT=8080]` | 启动 stack 并等待就绪。 |
| `make down` | 停止服务并保留数据库 volume。 |
| `make restart [SERVICE=php\|nginx\|db]` | 重启整个 stack 或单个服务。 |
| `make ps` / `make log [SERVICE=…]` | 查看容器或日志。 |
| `make in SERVICE=php\|nginx\|db` | 在服务中打开 non-root shell。 |
| `make php CMD="…"` | 以 `www-data` 身份执行 PHP。 |
| `make xdebug` | 输出 Xdebug 信息。 |
| `make db-check` | 显示数据表和记录数量。 |
| `make smoke` | 检查已经运行的 stack。 |
| `make db-reinit CONFIRM=filter_ajax_db [DB_MODE=schema\|demo]` | 重新初始化本项目的数据库 volume。 |

## Schema 与演示数据库模式

`DB_MODE=schema` 只创建数据表。`DB_MODE=demo` 先创建 schema，再加载演示数据。默认值为 `demo`。

该模式只在初始化新的 MariaDB volume 时读取。如果 volume 已经存在，修改 `DB_MODE` 不会改变其内容。如果明确需要一套全新的数据库，请使用 `db-reinit`。

## 安全地重新初始化数据库

`make db-reinit` 会停止 stack，只删除当前 Compose 项目的数据库 volume，然后重新启动服务并执行 `db-check`。该 volume 中的数据会永久删除。

命令要求精确确认 `CONFIRM=filter_ajax_db`，只接受 `schema` 或 `demo`，并在删除前检查已有 volume 的 Compose labels。示例：`make db-reinit CONFIRM=filter_ajax_db DB_MODE=demo`。

不要用它进行普通重启：`make down` 会保留 volume，`make up` 会继续使用它。

## Xdebug

PHP 镜像已经包含 Xdebug 3.5.3。配置为 `xdebug.mode=debug`、`xdebug.start_with_request=trigger`、`xdebug.client_host=host.docker.internal` 和 `xdebug.client_port=9003`。

使用 `make xdebug` 可查看实际生效的配置。

## 检查

无需启动服务，`make config` 即可检查最终 Compose 配置。

对于已经运行的 stack：

| 检查 | 命令 |
|---|---|
| PHP 回归测试 | `make php CMD="tests/run.php"` |
| Runtime smoke | `make smoke` |

`make smoke` 会检查主要 HTTP 路由和一个静态 asset、`pdo_mysql` 是否存在、Xdebug 版本以及数据库状态。CI 会针对 `master` 的 push 和 pull request 运行，并检查 PHP 与 JavaScript 语法、回归测试、Docker 配置，以及 `schema` 和 `demo` 两种模式下的 smoke 场景。

## 数据库配置与优先级

在非 Docker 模式下，将 [`config/database.php.example`](../../config/database.php.example) 复制为 `config/database.php`。这个本地文件已被 Git 忽略。命令：`cp config/database.php.example config/database.php`。

`host`、`port` 和 `charset` 已有基础值：`127.0.0.1`、`3306` 和 `utf8mb4`。数据库名称、用户和密码必须通过 `config/database.php` 或环境变量提供。

如果同一参数在多个位置定义，则使用优先级更高的来源：

1. `DB_*` 环境变量；
2. `config/database.php`，如果文件存在；
3. `host`、`port` 和 `charset` 的基础值。

环境变量优先级最高：

- `DB_HOST`；
- `DB_PORT`；
- `DB_NAME`；
- `DB_USER`；
- `DB_PASSWORD`；
- `DB_CHARSET`。

连接前会验证主要值：

- `host`、`name`、`user` 和 `charset` 必须是非空字符串；
- `password` 必须是字符串；
- `port` 必须是 1 到 65535 之间的整数；
- `charset` 只能包含字母、数字和 `_`。
