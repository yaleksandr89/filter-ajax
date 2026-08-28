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
    alt="AJAX Filter — catalogue de produits avec filtrage AJAX en PHP natif"
    width="100%"
  >
</p>

## Choisir la langue

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../../README.md) | [English](README_en.md) | [Español](README_es.md) | [中文](README_zh.md) | **Sélectionné** | [Deutsch](README_de.md) |

`AJAX Filter` est un petit catalogue PHP dans lequel les produits sont filtrés par catégorie, couleur et poids sans recharger la page. C'est un exemple compact réunissant PHP, PDO, MariaDB et JavaScript natif, sans Composer ni bibliothèque frontend.

## Fonctionnalités

- Filtrage des produits par catégorie, couleur et poids via `fetch()` sans rechargement de page.
- Les filtres sélectionnés sont conservés dans la session PHP.
- Réinitialisation asynchrone de tous les filtres actifs.
- Deux modes de base de données : schéma vide et données de démonstration.
- Stack Docker local avec Nginx, PHP-FPM, MariaDB et Xdebug.

## Démarrage rapide

Git, Docker avec Compose v2 et `make` sont nécessaires.

| Étape | Commande | Objectif |
|---|---|---|
| 1 | `git clone https://github.com/yaleksandr89/filter-ajax.git` | Cloner le dépôt. |
| 2 | `cd filter-ajax` | Entrer dans le répertoire du projet. |
| 3 | `make build` | Construire les images Docker locales. |
| 4 | `make up` | Démarrer le stack et attendre que les services soient prêts. |

Ouvrez [http://127.0.0.1:8080](http://127.0.0.1:8080). `DB_MODE=demo` est utilisé par défaut ; pour un schéma vide, exécutez `make up DB_MODE=schema` avec un nouveau volume. La gestion des volumes, la configuration et le diagnostic sont décrits dans le [guide de développement](development_fr.md).

## Architecture et structure du projet

La structure de l'application, le flux des requêtes, les filtres, la session, PDO et les templates sont décrits dans le [guide d'architecture](architecture_fr.md).

## Vérifications

Les principales vérifications sont disponibles via le Makefile :

| Vérification | Commande |
|---|---|
| Configuration Compose résolue | `make config` |
| Tests de régression PHP | `make php CMD="tests/run.php"` |
| Runtime smoke du stack déjà démarré | `make smoke` |

Le CI des pushes et pull requests vers `master` vérifie PHP et JavaScript, les tests de régression, la configuration Docker et les deux modes de base de données.

## Ce qui reste volontairement simple

- Pas de framework PHP ni d'ORM.
- Pas de packages Composer.
- Pas de dépendances JavaScript ni de framework frontend.
- Pas de couche API séparée.

L'objectif du projet est de montrer un petit flux de filtrage complet en utilisant les possibilités de base de PHP, PDO et JavaScript natif.

## Retours

- Bugs reproductibles : [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues).
- Questions et idées : [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).

---

<p align="center">
  Si le projet vous a été utile, ajoutez-lui une étoile sur GitHub afin que d'autres développeurs puissent le trouver plus facilement.<br>
  🤘
</p>
