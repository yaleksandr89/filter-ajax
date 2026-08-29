# 安全策略

## 选择语言

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](https://github.com/yaleksandr89/filter-ajax/blob/master/.github/SECURITY.md) | [English](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_en.md) | [Español](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_es.md) | **中文** | [Français](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_fr.md) | [Deutsch](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_de.md) |

## 支持的版本

安全修复会针对 `master` 的当前状态以及最新发布的 release 进行评估。

| 版本 | 支持 |
|---|---|
| `master` | 是 |
| 最新发布的 release | 是 |

## 哪些情况属于漏洞

安全问题包括但不限于：

- SQL injection，或绕过筛选 allowlist 的方式；
- XSS，或在缺少正确 HTML escaping 的情况下输出用户/动态数据；
- 绕过预期 route 限制，或不安全地处理请求 path；
- 通过外部输入替换模板名、文件路径或其他内部标识符；
- 泄露数据库密码、cookie、session data、本地或 production 配置；
- 通过错误消息或日志泄露应用内部细节；
- 不安全的 Docker/Nginx/PHP 配置改动，使内部文件或服务暴露到外部。

没有 security impact 的普通错误请通过 [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues) 报告。问题和较宽泛的想法更适合在 [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions) 中讨论。

## 如何报告漏洞

如果仓库启用了 GitHub Private Vulnerability Reporting，优先使用该方式：

1. 打开 **Security** 标签页。
2. 进入 **Advisories**。
3. 选择 **Report a vulnerability**。
4. 提交报告，不要在普通 Issue 或 Discussion 中发布敏感细节。

如果 Private Vulnerability Reporting 不可用，请创建一个不包含漏洞技术细节的最小公开 Issue，并请求建立私密沟通渠道。

修复发布前请勿公开：

- 真实密码或 token；
- cookie 或 session data；
- production 配置；
- 真实个人数据；
- 完整 production logs；
- 可工作的 exploit，或无需额外分析即可复现攻击的详细信息。

## 报告中应包含什么

如条件允许，请提供：

- 受影响的 release、branch 或 commit；
- 可能影响的说明；
- 最小复现步骤；
- 预期行为和实际行为；
- 有助于诊断的已清理 request/response/log 片段；
- 如果已知，可能的修复方案。

只使用合成数据或匿名化数据。

## 报告处理

报告会在条件允许时进行检查；项目不承诺固定 SLA。

在公开细节之前，请与项目维护者协调披露。确认漏洞后，修复以及受影响版本的信息会按照 coordinated disclosure 的方式发布。

项目没有声明漏洞奖励计划。
