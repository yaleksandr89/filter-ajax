# AJAX Filter

[![Source Code](https://img.shields.io/badge/source-yaleksandr89%2Ffilter--ajax-blue.svg?style=flat-square)](https://github.com/yaleksandr89/filter-ajax)
[![CI](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml/badge.svg)](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](../../LICENSE.md)

<p align="center">
  <img
    src="../img/filter-ajax-readme-cover.png"
    alt="AJAX Filter — filtrage dynamique sécurisé pour PHP avec AJAX et listes basées sur une base de données"
    width="100%"
  >
</p>

## Choisir la langue

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../../README.md) | [English](README_en.md) | [Español](README_es.md) | [中文](README_zh.md) | **Sélectionné** | [Deutsch](README_de.md) |

## Description

`AJAX Filter` est un petit projet de démonstration PHP qui filtre des produits par catégorie, couleur et poids sans recharger la page. Le client utilise JavaScript natif et `fetch()`, tandis que le serveur utilise PHP et PDO.

Le projet n'utilise volontairement ni Composer ni bibliothèque JavaScript et conserve une structure simple adaptée à l'apprentissage du filtrage AJAX.

## Stack

- PHP 8.5
- MySQL / MariaDB via PDO
- JavaScript natif
- Bootstrap 5.3.3
- Nginx + PHP-FPM pour l'exemple de serveur fourni

## Démarrage rapide

1. Créez une base de données et importez [`docs/mysql-dump/ajax-filter.sql`](../mysql-dump/ajax-filter.sql).
2. Copiez [`docs/examples/db-config.php.example`](../examples/db-config.php.example) vers `app/models/database.php`.
3. Renseignez les paramètres locaux de connexion à la base de données dans `app/models/database.php`.
4. Configurez le document root du serveur web sur le répertoire `public/`. Un exemple Nginx se trouve dans [`docs/examples/nginx-configuration.conf`](../examples/nginx-configuration.conf).
5. Adaptez le chemin `fastcgi_pass` de l'exemple si votre socket PHP-FPM est différent.
6. Ouvrez l'application via l'hôte local configuré.

`app/models/database.php` est ignoré par Git et ne doit pas contenir d'identifiants de production versionnés.

## Fonctionnement du filtrage

Lorsqu'un filtre change, le navigateur envoie une requête vers `/ajax-filter`. Le serveur accepte uniquement les champs `category`, `color` et `weight`, conserve les filtres actifs dans la session et exécute une requête PDO paramétrée.

<details>
  <summary>Démonstration du filtrage</summary>

![AJAX Filter demo](../img/ajax-filter-main.gif)
</details>

## Changement de thème

L'interface prend en charge les thèmes clair, sombre et système via Bootstrap.

<details>
  <summary>Démonstration du changement de thème</summary>

![AJAX Filter theme demo](../img/ajax-filter-theme-color.gif)
</details>

## Vérifications

GitHub Actions vérifie :

- la syntaxe PHP ;
- la syntaxe JavaScript ;
- les regression tests du filtrage, de la paramétrisation SQL, de la validation du contrôleur et de l'échappement HTML.

## Licence

Le projet est distribué sous licence [MIT](../../LICENSE.md).
