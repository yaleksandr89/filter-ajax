# Architecture

## Choisir la langue

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../architecture.md) | [English](architecture_en.md) | [Español](architecture_es.md) | [中文](architecture_zh.md) | **Sélectionné** | [Deutsch](architecture_de.md) |

L'application reste petite, mais ses principales frontières de responsabilité sont explicites : le point d'entrée assemble les dépendances, les contrôleurs coordonnent le flux HTTP, le filtre gère les critères et la session, le repository lit les données et les templates ne s'occupent que de la présentation.

## Flux d'une requête

```text
requête HTTP
    ↓
Nginx
    ↓
public/index.php
    ↓
contrôleur
    ↓
ProductFilter / ProductRepository / ViewRenderer
    ↓
réponse HTML
```

`/` renvoie la page complète du catalogue. `/ajax-filter` ne rend que la liste des produits, que le navigateur utilise pour remplacer le bloc de résultats courant.

## Composants et responsabilités

| Zone | Composants | Responsabilité |
|---|---|---|
| Point d'entrée et composition root | [`public/index.php`](../../public/index.php) | Charge bootstrap, démarre la session, résout la route et crée [`DatabaseConfig`](../../app/Database/DatabaseConfig.php), PDO, [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php), [`ProductRepository`](../../app/Database/ProductRepository.php), [`ProductFilter`](../../app/Filter/ProductFilter.php), [`ViewRenderer`](../../app/View/ViewRenderer.php) et les contrôleurs. |
| Autoload | [`app/bootstrap.php`](../../app/bootstrap.php) | Enregistre l'autoloader natif pour `App\`, n'accepte que des segments valides de noms de classe et les associe aux fichiers dans `app/`. Composer n'est pas utilisé. |
| Page d'accueil | [`HomeController::index()`](../../app/Controller/HomeController.php) | Lit les critères actifs dans la session, charge les produits et les valeurs des filtres, puis rend `products`, `home` et `layout`. |
| Filtrage AJAX | [`FilterController::filter()`](../../app/Controller/FilterController.php) | Normalise les query parameters, met à jour l'état des filtres et renvoie uniquement le fragment HTML `products`. |
| État des filtres | [`ProductFilter`](../../app/Filter/ProductFilter.php) | N'accepte que `category`, `color` et `weight`, conserve les critères actifs en session et traite `all` comme la suppression d'un filtre précis. |
| Accès aux données | [`ProductRepository`](../../app/Database/ProductRepository.php) | Charge produits, catégories, couleurs et poids via PDO. |
| Construction SQL | [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php) | Construit les conditions uniquement pour les identifiants autorisés `category`, `color` et `weight` ; les valeurs sont transmises séparément au prepared statement. |
| Connexion à la base | [`DatabaseConfig`](../../app/Database/DatabaseConfig.php), [`ConnectionFactory`](../../app/Database/ConnectionFactory.php) | Construit la configuration avec la priorité defaults → fichier local → `DB_*`, valide les valeurs et crée PDO avec exceptions, associative fetch mode et émulation des prepare désactivée. |
| Présentation | [`ViewRenderer`](../../app/View/ViewRenderer.php), [`templates/`](../../templates/) | N'autorise que les templates enregistrés `layout`, `home` et `products` ; les valeurs scalar dynamiques sont échappées avec `htmlspecialchars` en UTF-8. |
| AJAX côté client | [`public/assets/js/ajax-filter.js`](../../public/assets/js/ajax-filter.js) | Surveille les filtres, annule la requête précédente encore en cours via `AbortController`, appelle `/ajax-filter` et remplace le HTML des résultats. |
| UI côté client | [`public/assets/js/ui.js`](../../public/assets/js/ui.js) | Gère le thème et la langue de l'interface, conserve les préférences dans `localStorage` et actualise les libellés après une réponse AJAX. |
| Erreurs | [`templates/error/404.php`](../../templates/error/404.php), gestion globale des exceptions | Une route inconnue renvoie `404` ; une exception non gérée est enregistrée côté serveur tandis que le client reçoit `500` sans détails internes. |

## Routes

| Chemin | Gestionnaire | Réponse |
|---|---|---|
| `/` | [`HomeController::index()`](../../app/Controller/HomeController.php) | Page HTML complète du catalogue. |
| `/ajax-filter` | [`FilterController::filter()`](../../app/Controller/FilterController.php) | Uniquement le fragment HTML de la liste des produits. |

L'application ne gère aucune autre route applicative.

## Déroulement du filtrage AJAX

1. L'utilisateur change la catégorie, la couleur ou le poids.
2. [`ajax-filter.js`](../../public/assets/js/ajax-filter.js) annule la requête précédente non terminée si elle est encore en cours.
3. Le navigateur envoie le critère modifié vers `/ajax-filter`.
4. [`ProductFilter`](../../app/Filter/ProductFilter.php) n'accepte que les paramètres autorisés et met à jour leur état dans la session PHP.
5. [`ProductRepository`](../../app/Database/ProductRepository.php) obtient le résultat via [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php) et PDO.
6. [`FilterController`](../../app/Controller/FilterController.php) rend `products`, puis le navigateur remplace uniquement le bloc de résultats.

Les filtres non envoyés restent actifs. La valeur `all` efface uniquement le critère correspondant ; le bouton de réinitialisation envoie `all` pour les trois champs.

## Frontières clés

| Frontière | Décision | Effet |
|---|---|---|
| Assemblage des dépendances | Toutes les concrete dependencies sont créées dans [`public/index.php`](../../public/index.php). | Les contrôleurs ne cachent pas la création de PDO, du repository ou du renderer. |
| Filtres d'entrée | [`ProductFilter`](../../app/Filter/ProductFilter.php) ne travaille qu'avec `category`, `color` et `weight` ; les valeurs vides ou non scalar sont ignorées. | Les paramètres HTTP ne deviennent pas directement des critères arbitraires de requête. |
| SQL | Les identifiants de filtres viennent d'un allowlist et les valeurs sont transmises aux native prepared statements. | Les valeurs utilisateur ne sont pas concaténées dans le SQL. |
| Configuration de la base | [`DatabaseConfig`](../../app/Database/DatabaseConfig.php) valide les clés, les strings obligatoires, le port et `charset` avant la connexion. | Une configuration locale incorrecte échoue de façon prévisible avant l'exécution d'une requête. |
| Templates | [`ViewRenderer`](../../app/View/ViewRenderer.php) n'autorise que les templates connus et échappe les valeurs scalar dynamiques. | Une requête ne peut pas fournir un nom de template arbitraire et les données ne sont pas écrites dans le HTML sans escaping contextuel. |
| Erreurs | Les détails d'exception restent dans le server log ; le client HTTP reçoit une réponse `500` courte. | Les détails internes de l'application ne sont pas exposés à l'utilisateur. |

Les fragments HTML internes déjà rendus, comme `$content` et la liste des produits, sont transmis entre templates en tant que trusted rendered HTML.

## Éléments volontairement non ajoutés

- classe router séparée ;
- conteneur DI ;
- ORM ;
- framework PHP ;
- dépendances Composer ;
- framework frontend ;
- couche API séparée.

L'assemblage des dépendances reste explicite dans l'entry point afin que tout le flux de démonstration puisse être suivi directement dans le code sans infrastructure supplémentaire.
