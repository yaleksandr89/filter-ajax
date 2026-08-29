# Politique de sécurité

## Choisir la langue

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](https://github.com/yaleksandr89/filter-ajax/blob/master/.github/SECURITY.md) | [English](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_en.md) | [Español](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_es.md) | [中文](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_zh.md) | **Français** | [Deutsch](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_de.md) |

## Versions prises en charge

Les correctifs de sécurité sont examinés pour l'état actuel de `master` et pour la dernière release publiée.

| Version | Prise en charge |
|---|---|
| `master` | Oui |
| Dernière release publiée | Oui |

## Ce qui constitue une vulnérabilité

Les problèmes de sécurité comprennent notamment :

- SQL injection ou possibilité de contourner l'allowlist des filtres ;
- XSS ou sortie de données utilisateur/dynamiques sans HTML escaping correct ;
- contournement des restrictions de routes attendues ou traitement non sûr du path de requête ;
- possibilité de substituer un nom de template, un chemin de fichier ou un autre identifiant interne via une entrée externe ;
- divulgation de mots de passe de base de données, cookies, session data ou configuration locale/production ;
- fuite de détails internes de l'application via les messages d'erreur ou les logs ;
- modifications non sûres de la configuration Docker/Nginx/PHP exposant des fichiers ou services internes vers l'extérieur.

Les bugs ordinaires sans security impact doivent être signalés via [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues). Les questions et idées générales sont mieux discutées dans [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).

## Signaler une vulnérabilité

La méthode privilégiée est GitHub Private Vulnerability Reporting lorsqu'elle est disponible pour le dépôt :

1. Ouvrez l'onglet **Security**.
2. Accédez à **Advisories**.
3. Choisissez **Report a vulnerability**.
4. Envoyez le rapport sans publier de détails sensibles dans un Issue ou une Discussion ordinaire.

Si Private Vulnerability Reporting n'est pas disponible, créez un Issue public minimal sans détails techniques sur la vulnérabilité et demandez un canal de communication privé.

Ne publiez pas avant la mise à disposition d'un correctif :

- mots de passe ou tokens réels ;
- cookies ou session data ;
- configuration de production ;
- données personnelles réelles ;
- logs complets de production ;
- exploit fonctionnel ou détails permettant de reproduire l'attaque sans analyse supplémentaire.

## Contenu du rapport

Si possible, indiquez :

- release, branch ou commit affectés ;
- description de l'impact possible ;
- étapes minimales de reproduction ;
- comportement attendu et comportement réel ;
- fragments request/response/log nettoyés lorsqu'ils facilitent le diagnostic ;
- proposition de correctif, si elle est connue.

Utilisez uniquement des données synthétiques ou anonymisées.

## Traitement du rapport

Les rapports sont examinés selon les disponibilités ; aucun SLA fixe n'est annoncé.

Avant de publier des détails, veuillez coordonner la divulgation avec le mainteneur du projet. Après confirmation d'une vulnérabilité, le correctif et les informations sur les versions affectées sont publiés dans le cadre d'une coordinated disclosure.

Le projet ne déclare aucun programme de récompense pour les vulnérabilités.
