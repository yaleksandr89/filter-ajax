# Contribuer

## Choisir la langue

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](https://github.com/yaleksandr89/filter-ajax/blob/master/.github/CONTRIBUTING.md) | [English](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_en.md) | [Español](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_es.md) | [中文](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_zh.md) | **Français** | [Deutsch](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_de.md) |

Merci de votre intérêt pour AJAX Filter. Le projet est petit ; les changements doivent donc rester limités, reproductibles et faciles à relire.

## Avant de commencer

- Signalez les bugs reproductibles via [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues).
- Les questions et idées générales sont mieux discutées d'abord dans [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).
- Ne publiez pas de mots de passe, tokens, configuration de production, données personnelles ou autres informations sensibles.
- Avant une modification importante, assurez-vous qu'elle correspond à l'objectif du projet et n'ajoute pas d'infrastructure ou de dépendances sans besoin clair.

## Contrat du projet

- AJAX Filter est une petite application web PHP sans framework PHP, ORM ni dépendances Composer.
- Le client utilise JavaScript natif sans framework frontend ni dépendances JavaScript tierces.
- L'application gère deux routes applicatives : `/` et `/ajax-filter`.
- Le filtrage utilise `category`, `color` et `weight` ; les critères actifs sont conservés dans la session PHP.
- L'accès aux données utilise PDO ; les valeurs des filtres sont transmises aux native prepared statements et les identifiants SQL sont choisis uniquement dans l'ensemble autorisé.
- `public/index.php` reste le composition root et assemble explicitement les dépendances de l'application.
- Le workflow local principal repose sur Docker Compose et le Makefile.
- Les modes `schema` et `demo` ne sont appliqués que lors de l'initialisation d'un nouveau volume MariaDB.
- Les changements ne doivent pas ajouter de framework layer, ORM, conteneur DI, API séparée, retry/cache/fallback automatiques ou autre nouveau sous-système sans décision distincte.

La structure de l'application est décrite dans le [guide d'architecture](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/architecture_fr.md), tandis que le démarrage local et les vérifications sont détaillés dans le [guide de développement](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/development_fr.md).

## Branches

Utilisez un nom court reflétant le but de la modification, par exemple :

```text
fix/filter-validation
docs/update-development-guide
chore/update-ci
```

## Commits

Le format Conventional Commits est recommandé. Exemples :

```text
fix: corriger le traitement du filtre
docs: préciser le démarrage local
test: couvrir une régression du filtrage
chore: mettre à jour la configuration CI
```

## Vérification locale

Avant un Pull Request, exécutez les vérifications liées à votre modification :

| Élément modifié | Vérification |
|---|---|
| Docker Compose ou configuration des conteneurs | `make config` |
| Comportement PHP de l'application | `make php CMD="tests/run.php"` |
| Comportement HTTP/runtime du stack démarré | `make smoke` |

Pour le démarrage du projet et la liste complète des commandes Make, consultez le [guide de développement](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/development_fr.md).

Si la modification touche le mode de base ou son initialisation, vérifiez-la avec un nouveau volume. `make db-reinit` ne supprime que les données du volume de base du projet Compose courant et doit être utilisé volontairement.

## Pull Request

Dans la description du Pull Request, indiquez :

- le problème ou l'objectif de la modification ;
- ce qui a été modifié exactement ;
- les vérifications effectuées ;
- les tests ajoutés ou mis à jour si le comportement change ;
- l'impact sur Docker, la base de données, la sécurité, l'interface ou la documentation, le cas échéant.

Avant l'envoi, vérifiez que :

- la modification est limitée à une seule tâche cohérente ;
- aucun refactoring ou formatage sans rapport n'est inclus ;
- aucun secret, configuration locale ou donnée sensible n'est inclus dans le commit ;
- les tests et vérifications runtime correspondent au comportement affecté ;
- la documentation est mise à jour si les commandes, contrats ou comportements observables changent ;
- les traductions restent synchronisées lorsqu'un document déjà traduit est modifié.
