## What changed / Что изменено

<!-- Describe the problem or goal and the change that addresses it. / Опишите проблему или цель и изменение, которое её закрывает. -->

## Why / Зачем

<!-- Explain why this change is needed. / Объясните, зачем нужно это изменение. -->

## How to verify / Как проверить

<!-- List the checks, tests, and manual verification you ran. / Перечислите выполненные проверки, тесты и ручную проверку. -->

## Runtime, database, security and UI / Runtime, база данных, безопасность и интерфейс

<!-- Describe Docker/runtime changes, database impact, security-sensitive changes, or UI impact when relevant. / Опишите изменения Docker/runtime, влияние на БД, безопасность или интерфейс, если это применимо. -->

## Checklist / Чек-лист

- [ ] `make config` passes when Docker Compose or container configuration is affected. / `make config` проходит, если затронуты Docker Compose или конфигурация контейнеров.
- [ ] `make php CMD="tests/run.php"` passes when PHP application behavior changes. / `make php CMD="tests/run.php"` проходит при изменении поведения PHP-приложения.
- [ ] `make smoke` passes when HTTP or runtime behavior changes. / `make smoke` проходит при изменении HTTP- или runtime-поведения.
- [ ] Relevant tests were added or updated when behavior changed. / При изменении поведения добавлены или обновлены релевантные тесты.
- [ ] No secrets, local configuration, personal data, or sensitive logs are included. / Секреты, локальная конфигурация, персональные данные и чувствительные логи не добавлены.
- [ ] UI changes include screenshots or a described manual check. / Для изменений интерфейса приложены скриншоты или описана ручная проверка.
- [ ] Documentation was updated when commands, architecture, or observable behavior changed. / Документация обновлена при изменении команд, архитектуры или наблюдаемого поведения.
- [ ] Translated documentation stays semantically aligned when an already translated source document changes. / Переведённая документация синхронизирована, если менялся уже переведённый исходный документ.
- [ ] The Pull Request is limited to one coherent task and contains no unrelated refactoring or formatting. / Pull Request ограничен одной связной задачей и не содержит несвязанных рефакторингов или форматирования.
