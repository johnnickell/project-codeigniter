# Fight CodeIgniter Starter

Public CodeIgniter 4 application composition for Fight Common and Fight AccessControl. It consumes those libraries only through their public Composer packages; CodeIgniter owns service discovery, configuration, HTTP, console, and presentation composition.

Run `./bin/up`, then open <http://localhost:18085/> for the hello-world runtime. Use `./bin/build` before review; GitHub Actions delegates to that exact command for pushes and pull requests targeting `develop`, `main`, and `release/**`.

## Commands

- `./bin/composer install` installs dependencies in the CodeIgniter runtime.
- `./bin/phpunit` runs the PHPUnit application suite.
- `./bin/exec php spark list` runs the CodeIgniter-native Spark console.
- `./bin/build` is the complete noninteractive quality gate used locally and by GitHub Actions.
- `./bin/down` stops the complete Compose runtime.

This repository is MIT-licensed source, not a release or package-distribution claim. Do not add copied shared source, credentials, production data, login, persistence, browser journeys, tags, Packagist publication, template enablement, or create-project distribution without a separately adopted local ticket.
