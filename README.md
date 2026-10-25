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

## Stable package baseline

TASK-00014 adopts exact `johnnickell/fight-common` **1.4.0** and `johnnickell/fight-access-control` **0.8.0**,
rechecked against GitHub releases/tags and Packagist on 2026-10-25. The lock also narrowly refreshes
`symfony/http-foundation` **8.1.6 → 8.1.9** for CVE-2026-108082 and its follow-up parsing correction; no other
package entries change. Composer audit reported no advisories at that check, not a permanent security guarantee.
Registry packages replace the development VCS overrides/alias; `minimum-stability: stable` now rejects accidental
development selections. Exact pins intentionally require a separately reviewed refresh. Composer warns about
the Common exact constraint; the existing validator now recognizes that warning instead of the obsolete commit pin.

Native `app/`, service discovery, HTTP/routes/views and Spark stay unchanged. Existing factories fit the released
public contracts; installation does **not** enable AccessControl handlers, repositories, login or authorization
journeys. See [composition limits](ARCHITECTURE.md) and [consumer verification](tests/README.md).

**Migration exception:** Common's `StreamId` now compares/hashes the full tuple and JSON-encodes as a canonical
`stream:v1:<base64 aggregate>:<base64 identifier>` string instead of `{}`. Equal tuples deduplicate/replace keys
in hash collections. Rebuild legacy serialized hash collections where present; persisted stream-name/ID columns
are unchanged. This starter has no owned persisted AccessControl data/schema to migrate. Data-bearing deployments
need a separately accepted migration design, not a destructive reset or compatibility shim.

## Runtime security baseline and refresh

The owned images select PHP `8.5.12-fpm-bookworm` and NGINX `1.30.6-alpine`. Composer requires PHP
`^8.5.12` and resolves against `8.5.12`; this does not upgrade locked packages. These selections address the
[October PHP critical fixes](https://www.php.net/archive/2026.php#2026-10-21-5) and the
[NGINX advisory ranges](https://nginx.org/en/security_advisories.html), checked on 2026-10-24.
Explicit patch tags need ongoing security review; numerically newer tags are not automatically qualified.

PHP's [October 23 follow-up](https://www.php.net/archive/2026.php#2026-10-23-1) (CVE-2026-115560) is not fixed
by 8.5.12. The image disables `session.upload_progress.enabled` in startup INI, before request parsing.
No serializer switch was found in the owned application or the locked CodeIgniter Session implementation.
The locked Symfony `NativeSessionStorage` can change the serializer through caller-supplied options, but the
starter does not instantiate it. The observed FPM serializer is `php`; the advisory requires a non-default
initial serializer followed by a runtime switch to `php` before `session_start()`. This trigger was not
observed in the hello-world starter. We disable unused upload-progress tracking defensively, including for
future configuration changes. Do not replace startup mitigation with application `ini_set()` or `.user.ini`;
reassess it only against an upstream fix.

Before refreshing, verify the Compose project, source mount and port ownership (`docker compose ls`,
`docker compose config`, `docker compose ps -a`, and `docker ps --filter publish=18085`). Do not recreate another
checkout's services. In an isolated checkout, export a unique `COMPOSE_PROJECT_NAME` for **every** preparation,
wrapper and verification command; the fixed port must still be free. Shared proxy/worktree port design is not
provided here. For the selected, owned project:

```sh
# Fetch current base images even when local build layers are cached.
docker compose build --pull
# Recreate every FPM/NGINX worker; restarting old containers does not adopt new images.
./bin/up --force-recreate
./bin/composer install --no-interaction --prefer-dist --no-progress
./bin/exec php -v
./bin/exec php-fpm -tt
./bin/exec sh -c 'php-fpm -i | grep -E "PHP Version|Loaded Configuration|Scan this dir|session.upload_progress.enabled|session.serialize_handler"'
docker compose exec -T web nginx -v
docker compose exec -T web nginx -t
curl --fail http://localhost:18085/
./bin/build
```

Require PHP 8.5.12+ within the declared support range, NGINX 1.30.6 on the selected stable line, and effective
FPM `session.upload_progress.enabled` Off. Inspect `docker compose exec -T web nginx -T` and the FPM startup
configuration for overrides. CLI version/INI output or cached image metadata alone does not prove the settings
of a running FPM request worker; verify the recreated process/image identity and, when needed, query the owned
FPM worker with a temporary non-public diagnostic outside `public/`, removing it afterward. Never publish
`phpinfo()` or use exploit payloads. Revalidate local overrides and all actual deployment workers separately.
These local checks are not deployment, external exposure, incident-response, or host-wide patch evidence.

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
[TASK-00007](planning/tasks/00007-TASK.md); historical adoption records do not impose ongoing certification.
The gate no longer certifies a separate `--no-dev` installation or lowest/latest package resolutions.

## Planning and unfinished adoption

Planning uses **EPIC → TICKET → TASK**. Start with the [TASK Board](planning/tasks/BOARD.md) for executable work
and the [adoption EPIC](planning/epics/00002-EPIC.md) for scope and unresolved decisions. The
[migration map](planning/MIGRATION.md) preserves former PRD/T identities.

Adoption of shared engineering, delivery and Pi/skill conventions is approved by default, with explicit
CodeIgniter adaptations. Upgrading both Fight packages to their **latest mutually compatible stable releases**
is the destination; exact releases must be qualified before implementation. TASK-00014 implements the accepted
stable pair and security refresh with local consumer verification; candidate A has independent Review acceptance
and applicable non-visual QA PASS, while delivery publication and final remote-head verification remain separate
Land work. Engineering enforcement is **not complete**. The [shared Pi binding](planning/agents/shared-workflows.md) supplies target
substitutions, native selection/retained RPC boundaries and runtime-file hygiene;
[TASK-00013](planning/tasks/00013-TASK.md#current-delivery-status) records accepted local delivery evidence;
[PR #16](https://github.com/johnnickell/project-codeigniter/pull/16) awaits human review/merge. Native capability
qualification remains limited as recorded there.
The [current planning handoffs](planning/ROADMAP.md#current-decomposition-handoffs)
separate completed package implementation from unfinished engineering decisions. Planning migration and
certification removal alone were not package adoption.

This repository is MIT-licensed source, not a release or package-distribution claim. Do not add copied shared source, credentials, production data, login, persistence, browser journeys, tags, Packagist publication, template enablement, or create-project distribution without a separately approved local TASK.
