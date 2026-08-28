# AJAX Filter

[![Source Code](https://img.shields.io/badge/source-yaleksandr89%2Ffilter--ajax-blue.svg?style=flat-square)](https://github.com/yaleksandr89/filter-ajax)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4.svg?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![JavaScript](https://img.shields.io/badge/JavaScript-Native-F7DF1E.svg?style=flat-square&logo=javascript&logoColor=F7DF1E)](https://developer.mozilla.org/docs/Web/JavaScript)
[![MariaDB](https://img.shields.io/badge/MariaDB-12.3-003545.svg?style=flat-square&logo=mariadb&logoColor=white)](https://mariadb.org/)
[![Docker](https://img.shields.io/badge/Docker-Compose-2496ED.svg?style=flat-square&logo=docker&logoColor=white)](https://www.docker.com/)
[![CI](https://img.shields.io/github/actions/workflow/status/yaleksandr89/filter-ajax/ci.yml?style=flat-square&label=CI)](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](../../LICENSE.md)

<p align="center">
  <img
    src="../img/filter-ajax-readme-cover.png"
    alt="AJAX Filter — 使用纯 PHP 实现 AJAX 筛选的商品目录"
    width="100%"
  >
</p>

## 选择语言

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../../README.md) | [English](README_en.md) | [Español](README_es.md) | **已选** | [Français](README_fr.md) | [Deutsch](README_de.md) |

`AJAX Filter` 是一个小型 PHP 商品目录，可以按类别、颜色和重量筛选商品，无需重新加载页面。项目以紧凑的形式展示 PHP、PDO、MariaDB 与原生 JavaScript 的协作，不使用 Composer 或前端库。

## 功能

- 通过 `fetch()` 按类别、颜色和重量筛选商品，无需刷新页面。
- 选中的筛选条件保存在 PHP session 中。
- 异步重置所有活动筛选条件。
- 两种数据库模式：空 schema 和演示数据。
- 本地 Docker stack，包含 Nginx、PHP-FPM、MariaDB 和 Xdebug。

## 快速开始

需要 Git、支持 Compose v2 的 Docker，以及 `make`。

| 步骤 | 命令 | 用途 |
|---|---|---|
| 1 | `git clone https://github.com/yaleksandr89/filter-ajax.git` | 克隆仓库。 |
| 2 | `cd filter-ajax` | 进入项目目录。 |
| 3 | `make build` | 构建本地 Docker 镜像。 |
| 4 | `make up` | 启动 stack 并等待服务就绪。 |

打开 [http://127.0.0.1:8080](http://127.0.0.1:8080)。默认使用 `DB_MODE=demo`；如果需要空 schema，请在新 volume 上执行 `make up DB_MODE=schema`。volume、配置和诊断的说明见[开发指南](development_zh.md)。

## 架构与项目结构

应用结构、请求流程、筛选条件、session、PDO 和模板的工作方式见[架构说明](architecture_zh.md)。

## 检查

主要检查通过 Makefile 提供：

| 检查 | 命令 |
|---|---|
| 最终 Compose 配置 | `make config` |
| PHP 回归测试 | `make php CMD="tests/run.php"` |
| 已运行 stack 的 runtime smoke 检查 | `make smoke` |

针对 `master` 的 push 和 pull request，CI 会检查 PHP 和 JavaScript、回归测试、Docker 配置以及两种数据库模式。

## 有意保持简单的部分

- 不使用 PHP framework 或 ORM。
- 不使用 Composer package。
- 不使用 JavaScript 依赖或 frontend framework。
- 不增加独立 API 层。

项目目标是使用 PHP、PDO 和原生 JavaScript 的基础能力展示一个小而完整的筛选流程。

## 反馈

- 可复现的错误：[GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues)。
- 问题和想法：[GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions)。

---

<p align="center">
  如果这个项目对你有帮助，请在 GitHub 上点一颗 Star，让其他开发者更容易找到它。<br>
  🤘
</p>
