# AJAX Filter

[![Source Code](https://img.shields.io/badge/source-yaleksandr89%2Ffilter--ajax-blue.svg?style=flat-square)](https://github.com/yaleksandr89/filter-ajax)
[![CI](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml/badge.svg)](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](../../LICENSE.md)

<p align="center">
  <img
    src="../img/filter-ajax-readme-cover.png"
    alt="AJAX Filter — 面向 PHP 的安全动态 AJAX 筛选与数据库列表过滤"
    width="100%"
  >
</p>

## 选择语言

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../../README.md) | [English](README_en.md) | [Español](README_es.md) | **已选** | [Français](README_fr.md) | [Deutsch](README_de.md) |

## 描述

`AJAX Filter` 是一个小型 PHP 演示项目，可按类别、颜色和重量筛选商品，并且无需重新加载页面。客户端使用原生 JavaScript 和 `fetch()`，服务端使用 PHP 和 PDO。

项目有意不使用 Composer 或 JavaScript 库，并保持简单的结构，便于学习基础 AJAX 筛选流程。

## 技术栈

- PHP 8.5
- 通过 PDO 使用 MySQL / MariaDB
- 原生 JavaScript
- 原生 CSS
- Nginx + PHP-FPM，用于提供的服务器配置示例

## 快速开始

1. 创建数据库并导入 [`docs/mysql-dump/ajax-filter.sql`](../mysql-dump/ajax-filter.sql)。
2. 将 [`config/database.php.example`](../../config/database.php.example) 复制到 `config/database.php`。
3. 用本地数据库值替换 `config/database.php` 中的占位符。该文件已被 Git 忽略。
4. 或者设置 `DB_HOST`、`DB_PORT`、`DB_NAME`、`DB_USER`、`DB_PASSWORD` 和 `DB_CHARSET`；环境变量会覆盖文件值。
5. 请根据本地环境同时调整 Web 服务器的 document root 和 `fastcgi_pass`。Nginx 示例位于 [`docs/examples/nginx-configuration.conf`](../examples/nginx-configuration.conf)。
6. 通过配置好的本地域名打开应用。

## 筛选工作原理

筛选项发生变化时，浏览器向 `/ajax-filter` 发送请求。服务器只接受 `category`、`color` 和 `weight` 字段，将活动筛选条件保存在 session 中，并执行参数化 PDO 查询。

<details>
  <summary>筛选演示</summary>

![AJAX Filter demo](../img/ajax-filter-main.gif)
</details>

## 主题切换

界面使用项目自有 CSS 和原生 JavaScript 支持浅色、深色和系统主题；系统主题遵循操作系统偏好。

<details>
  <summary>主题切换演示</summary>

![AJAX Filter theme demo](../img/ajax-filter-theme-color.gif)
</details>

## 检查

GitHub Actions 会检查：

- PHP 语法；
- JavaScript 语法；
- 关于筛选规范化和 session 语义、SQL 白名单/参数化及其确定性查询契约、数据库配置优先级/验证、HTML 转义和原生 autoload 的第一方回归测试。

## 许可证

项目采用 [MIT](../../LICENSE.md) 许可证发布。
