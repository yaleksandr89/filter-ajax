# Développement

## Choisir la langue

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../development.md) | [English](development_en.md) | [Español](development_es.md) | [中文](development_zh.md) | **Sélectionné** | [Deutsch](development_de.md) |

## Prérequis sur l'hôte

Le workflow Docker principal nécessite :

- Git ;
- Docker Engine avec Compose v2 ;
- `make`.

Il n'est pas nécessaire d'installer séparément PHP, MariaDB ou Xdebug sur l'hôte. Le conteneur PHP utilise PHP 8.5.9-FPM avec `pdo_mysql` et Xdebug 3.5.3 ; Nginx et MariaDB font également partie du stack.

## Exécution sans Docker

Le projet peut se connecter à une instance MariaDB disponible avec PHP 8.5, l'extension PDO MySQL et PHP-FPM. Créez une base, appliquez [`docker/mariadb/schema.sql`](../../docker/mariadb/schema.sql) puis, si nécessaire, [`docker/mariadb/demo-data.sql`](../../docker/mariadb/demo-data.sql), et configurez ensuite `config/database.php` ou les variables d'environnement `DB_*`.

Le document root du serveur web doit pointer vers `public/`. Pour Nginx avec un Unix socket PHP-FPM local, adaptez la [configuration de référence](../examples/nginx-configuration.conf) : elle dirige les URI ordinaires vers le front controller et n'expose pas les URI PHP directs.

## Premier démarrage avec Docker

| Commande | Objectif |
|---|---|
| `make build` | Construire les images Docker locales. |
| `make up` | Démarrer le stack et attendre que les services soient prêts. |
| `make down` | Arrêter les services en conservant les données de la base. |

Lorsque les services sont prêts, l'application est disponible à l'adresse [http://127.0.0.1:8080](http://127.0.0.1:8080).

> [!NOTE]
> Par défaut, l'application démarre sur `127.0.0.1:8080`. Pour utiliser un autre port, indiquez `HTTP_PORT`, par exemple : `make up HTTP_PORT=18080`.
>
> Pour éviter de transmettre le port à chaque commande Make de la session shell courante, exécutez d'abord `export HTTP_PORT=18080`. Les commandes ordinaires `make up`, `make smoke` et les autres utiliseront alors cette valeur.

## Quand reconstruire les images

Reconstruisez les images après toute modification d'un Dockerfile ou de la configuration des images dans `docker/php/`, `docker/mariadb/` ou `docker/nginx/`. Changer le mode de base sur un volume existant ne réinitialise pas ses données.

## Commandes du Makefile

| Commande | Objectif |
|---|---|
| `make help` | Afficher l'aide. |
| `make config` | Afficher la configuration Compose résolue. |
| `make build` | Construire les images locales. |
| `make up [DB_MODE=schema\|demo] [HTTP_PORT=8080]` | Démarrer le stack et attendre qu'il soit prêt. |
| `make down` | Arrêter les services en conservant le volume de base. |
| `make restart [SERVICE=php\|nginx\|db]` | Redémarrer tout le stack ou un service. |
| `make ps` / `make log [SERVICE=…]` | Afficher les conteneurs ou les logs. |
| `make in SERVICE=php\|nginx\|db` | Ouvrir un shell non-root dans un service. |
| `make php CMD="…"` | Exécuter PHP en tant que `www-data`. |
| `make xdebug` | Afficher les informations Xdebug. |
| `make db-check` | Afficher les tables et le nombre d'enregistrements. |
| `make smoke` | Vérifier un stack déjà démarré. |
| `make db-reinit CONFIRM=filter_ajax_db [DB_MODE=schema\|demo]` | Réinitialiser le volume de base de données de ce projet. |

## Modes schéma et base de démonstration

`DB_MODE=schema` crée uniquement les tables. `DB_MODE=demo` crée le schéma puis charge les données de démonstration. La valeur par défaut est `demo`.

Le mode n'est lu que lors de l'initialisation d'un nouveau volume MariaDB. Si le volume existe déjà, changer `DB_MODE` ne modifie pas son contenu. Utilisez `db-reinit` lorsque vous souhaitez volontairement repartir d'une base neuve.

## Réinitialisation sûre de la base

`make db-reinit` arrête le stack, supprime uniquement le volume de base du projet Compose courant, redémarre les services et exécute `db-check`. Les données de ce volume sont supprimées définitivement.

La commande exige la confirmation exacte `CONFIRM=filter_ajax_db`, n'accepte que `schema` ou `demo` et vérifie les labels Compose d'un volume existant avant sa suppression. Exemple : `make db-reinit CONFIRM=filter_ajax_db DB_MODE=demo`.

Ne l'utilisez pas pour un redémarrage normal : `make down` conserve le volume et `make up` le réutilise.

## Xdebug

L'image PHP contient déjà Xdebug 3.5.3. Ses réglages sont `xdebug.mode=debug`, `xdebug.start_with_request=trigger`, `xdebug.client_host=host.docker.internal` et `xdebug.client_port=9003`.

La configuration effective peut être affichée avec `make xdebug`.

## Vérifications

Sans démarrer les services, `make config` vérifie la configuration Compose résolue.

Pour un stack déjà démarré :

| Vérification | Commande |
|---|---|
| Tests de régression PHP | `make php CMD="tests/run.php"` |
| Runtime smoke | `make smoke` |

`make smoke` vérifie les principales routes HTTP et un asset statique, la présence de `pdo_mysql`, la version de Xdebug et l'état de la base. Le CI s'exécute pour les pushes et pull requests vers `master` ; il vérifie la syntaxe PHP et JavaScript, les tests de régression, la configuration Docker et les scénarios smoke dans les modes `schema` et `demo`.

## Configuration de la base et priorités

Pour une exécution sans Docker, copiez [`config/database.php.example`](../../config/database.php.example) vers `config/database.php`. Ce fichier local est ignoré par Git. Commande : `cp config/database.php.example config/database.php`.

Des valeurs de base sont déjà définies pour `host`, `port` et `charset` : `127.0.0.1`, `3306` et `utf8mb4`. Le nom de la base, l'utilisateur et le mot de passe doivent être fournis dans `config/database.php` ou via les variables d'environnement.

Si un même paramètre est défini à plusieurs endroits, la source de priorité la plus élevée est utilisée :

1. variables d'environnement `DB_*` ;
2. `config/database.php`, si le fichier existe ;
3. valeurs de base pour `host`, `port` et `charset`.

Les variables d'environnement ont la priorité la plus élevée :

- `DB_HOST` ;
- `DB_PORT` ;
- `DB_NAME` ;
- `DB_USER` ;
- `DB_PASSWORD` ;
- `DB_CHARSET`.

Les valeurs principales sont validées avant la connexion :

- `host`, `name`, `user` et `charset` doivent être des strings non vides ;
- `password` doit être une string ;
- `port` doit être un entier compris entre 1 et 65535 ;
- `charset` ne peut contenir que des lettres, des chiffres et `_`.
