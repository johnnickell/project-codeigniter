# Fight CodeIgniter Starter

Public CodeIgniter 4 application composition for Fight Common and Fight AccessControl. It consumes those libraries only through their public Composer packages; CodeIgniter owns service discovery, configuration, HTTP, console, and presentation composition.

Prepare the runtime and locked dependencies explicitly:

```sh
./bin/up
./bin/composer install --no-interaction --prefer-dist --no-progress
./bin/build
```

Open <http://localhost:18085/> for the hello-world runtime. `./bin/build` checks the already-running runtime;
it does not build images, install/update dependencies, or certify lowest/latest dependency lanes. GitHub Actions
performs the same preparation and delegates verification to that exact command for pushes and pull requests
targeting `develop`, `main`, and `release/**`.

## Commands

- `./bin/composer install` installs dependencies in the CodeIgniter runtime.
- `./bin/phpunit` runs the PHPUnit application/integration suite in the prepared runtime.
- `./bin/exec php spark list` runs the CodeIgniter-native Spark console.
- `./bin/build` is the complete noninteractive quality gate used locally and by GitHub Actions. It checks
  planning, Composer metadata/platform/runtime policy, governance, application/integration behavior, the safe
  production profile, and public dependency boundaries.
- `./bin/down` stops the complete Compose runtime.

Dependency upgrades and compatibility exploration are explicit maintenance operations, not pre-submit tests.
Framework-support receipts and their certification machinery were retired by
[T-00007](planning/tickets/00007-TICKET.md); historical adoption records do not impose ongoing certification.
The gate no longer certifies a separate `--no-dev` installation or lowest/latest package resolutions.

This repository is MIT-licensed source, not a release or package-distribution claim. Do not add copied shared source, credentials, production data, login, persistence, browser journeys, tags, Packagist publication, template enablement, or create-project distribution without a separately adopted local ticket.
