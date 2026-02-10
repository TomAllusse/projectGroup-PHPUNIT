# <div align="center">projectGroup-PHPUNIT</div>

# Création des dossiers dans la racine
<br>
<summary> Création du dossier .github </summary>
<br>
<summary> Création du dossier workflows </summary>
<br>

# Création du fichier "ci.yml" dans le dossier workflows

```bash
name: Vérification PHPUnit

on: [push]

jobs:
  tests:
    runs-on: ubuntu-latest

    steps:
      - name: Recupération du code
        uses: actions/checkout@v3

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'

      - name: Installation dépendances
        run: composer install

      - name: Execution des tests
        run: ./vendor/bin/phpunit
```
