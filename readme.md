# Tools

Collection d'outils simples pour les différents projets du labo

## Contenu

- JsonLoader [doc](./doc/jsonloader.md.html)
- HTMLTools [doc](./doc/htmltools.md.html)
- Locations [doc](./doc/locations.md.html)
- Arrays [doc](./doc/arrays.md.html)
- LoadFTP [doc](./doc/loadftp.md.html)

## Usage - via composer
Ajouter dans le `composer.json` de votre projet 

````json
{
    "require": {
        "ladromelaboratoire/tools": "^1",
    },
    "repositories" : [
        {
            "type": "vcs",
            "url" : "https://github.com/ladromelaboratoire/tools.git"
        }
    ],
    "config": {
      "github-oauth": {
        "github.com": "votre-jeton-oauth"
      }
    }
}

````
Faite un `composer update` à la racine de votre projet

## Usage seul
Copiez le dépôt dans un dossier de votre serveur web.  
Faite un `composer update` à la racine de du projet  
Connectez vous via http://localhost/dossier/tests/nom_du_fichier_test.php