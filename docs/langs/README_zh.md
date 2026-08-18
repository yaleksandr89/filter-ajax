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
- Bootstrap 5.3.3
- Nginx + PHP-FPM，用于提供的服务器配置示例

## 快速开始

1. 创建数据库并导入 [`docs/mysql-dump/ajax-filter.sql`](../mysql-dump/ajax-filter.sql)。
2. 将 [`docs/examples/db-config.php.example`](../examples/db-config.php.example) 复制到 `app/models/database.php`。
3. 在 `app/models/database.php` 中填写本地数据库连接参数。
4. 将 Web 服务器的 document root 设置为 `public/` 目录。Nginx 示例位于 [`docs/examples/nginx-configuration.conf`](../examples/nginx-configuration.conf)。
5. 如果本机 PHP-FPM socket 不同，请调整示例中的 `fastcgi_pass` 路径。
6. 通过配置好的本地域名打开应用。

`app/models/database.php` 已被 Git 忽略，不应将生产环境凭据提交到仓库。

## 筛选工作原理

筛选项发生变化时，浏览器向 `/ajax-filter` 发送请求。服务器只接受 `category`、`color` 和 `weight` 字段，将活动筛选条件保存在 session 中，并执行参数化 PDO 查询。

<details>
  <summary>筛选演示</summary>

![AJAX Filter demo](../img/ajax-filter-main.gif)
</details>

## 主题切换

界面通过 Bootstrap 支持浅色、深色和系统主题。

<details>
  <summary>主题切换演示</summary>

![AJAX Filter theme demo](../img/ajax-filter-theme-color.gif)
</details>

## 检查

GitHub Actions 会检查：

- PHP 语法；
- JavaScript 语法；
- 筛选、SQL 参数化、controller validation 和 HTML escaping 的回归测试。

## 许可证

项目采用 [MIT](../../LICENSE.md) 许可证发布。
