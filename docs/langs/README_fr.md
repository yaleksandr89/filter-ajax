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
- CSS natif
- Nginx + PHP-FPM pour l'exemple de serveur fourni

## Démarrage rapide

1. Créez une base de données et importez [`docs/mysql-dump/ajax-filter.sql`](../mysql-dump/ajax-filter.sql).
2. Copiez [`config/database.php.example`](../../config/database.php.example) vers `config/database.php`.
3. Remplacez les espaces réservés de `config/database.php` par les valeurs locales de la base de données. Ce fichier est ignoré par Git.
4. Vous pouvez aussi définir `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` et `DB_CHARSET` ; les valeurs d'environnement remplacent les valeurs du fichier.
5. Adaptez à votre environnement local le document root du serveur web et `fastcgi_pass`. Un exemple Nginx se trouve dans [`docs/examples/nginx-configuration.conf`](../examples/nginx-configuration.conf).
6. Ouvrez l'application via l'hôte local configuré.

## Fonctionnement du filtrage

Lorsqu'un filtre change, le navigateur envoie une requête vers `/ajax-filter`. Le serveur accepte uniquement les champs `category`, `color` et `weight`, conserve les filtres actifs dans la session et exécute une requête PDO paramétrée.

<details>
  <summary>Démonstration du filtrage</summary>

![AJAX Filter demo](../img/ajax-filter-main.gif)
</details>

## Changement de thème

L'interface prend en charge les thèmes clair, sombre et système avec le CSS propre au projet et JavaScript natif ; le thème système suit la préférence de l'OS.

<details>
  <summary>Démonstration du changement de thème</summary>

![AJAX Filter theme demo](../img/ajax-filter-theme-color.gif)
</details>

## Vérifications

GitHub Actions vérifie :

- la syntaxe PHP ;
- la syntaxe JavaScript ;
- les regression tests propriétaires de la normalisation des filtres et de la sémantique de session, de l'allowlisting/de la paramétrisation SQL et de son contrat déterministe, de la priorité/validation de la configuration de base de données, de l'échappement HTML et de l'autoload natif.

## Licence

Le projet est distribué sous licence [MIT](../../LICENSE.md).
