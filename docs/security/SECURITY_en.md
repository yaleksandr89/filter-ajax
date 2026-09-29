# Security Policy

## Choose a language

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](https://github.com/yaleksandr89/filter-ajax/blob/master/.github/SECURITY.md) | **English** | [Español](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_es.md) | [中文](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_zh.md) | [Français](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_fr.md) | [Deutsch](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_de.md) |

## Supported versions

Security fixes are considered for the current state of `master` and the latest published release.

| Version | Supported |
|---|---|
| `master` | Yes |
| Latest published release | Yes |

## What counts as a vulnerability

Security issues include, in particular:

- SQL injection or a way to bypass the filter allowlist;
- XSS or output of user/dynamic data without correct HTML escaping;
- bypassing expected route restrictions or unsafe request-path handling;
- the ability to substitute a template name, file path, or another internal identifier through external input;
- disclosure of database passwords, cookies, session data, local or production configuration;
- leakage of internal application details through error messages or logs;
- unsafe Docker/Nginx/PHP configuration changes that expose internal files or services externally.

Ordinary bugs without security impact should be reported through [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues). Questions and broad ideas are better discussed in [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).

## Reporting a vulnerability

The preferred method is GitHub Private Vulnerability Reporting when it is available for the repository:

1. Open the **Security** tab.
2. Go to **Advisories**.
3. Choose **Report a vulnerability**.
4. Submit the report without publishing sensitive details in a regular Issue or Discussion.

If Private Vulnerability Reporting is unavailable, create a minimal public Issue without technical vulnerability details and request a private communication channel.

Do not publish before a fix is released:

- real passwords or tokens;
- cookies or session data;
- production configuration;
- real personal data;
- full production logs;
- a working exploit or details that make the attack reproducible without additional analysis.

## What to include in the report

When possible, include:

- affected release, branch, or commit;
- description of the potential impact;
- minimal reproduction steps;
- expected and actual behavior;
- sanitized request/response/log fragments when they help diagnosis;
- a possible fix, if known.

Use only synthetic or anonymized data.

## Report handling

Reports are reviewed as availability allows; no fixed SLA is promised.

Please coordinate disclosure with the project maintainer before publishing details. After a vulnerability is confirmed, the fix and affected-version information are published as part of coordinated disclosure.

The project does not claim to operate a vulnerability reward program.
