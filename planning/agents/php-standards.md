# Maintained PHP standards

Apply this guidance when changing PHP, native composition, tests or analysis configuration. Run the prepared
`./bin/build` before committing. Prepare explicitly with `./bin/up` and `./bin/composer install --no-interaction
--prefer-dist --no-progress`; verification never installs, updates, formats or applies Rector changes.

## Checks and source boundaries

| Check | Maintained scope / contract |
|---|---|
| `php scripts/check-php.php` | Native PHP lint, strict types and named-type namespace/path agreement: `app/`, `tests/`, `scripts/`, `public/`, `spark`, `preload.php`, `rector.php`. Includes mixed templates. |
| Fight Common PHPCS | Same paths through `phpcs.xml`; the installed package ruleset is referenced, never copied. All 79 shipped sniffs load, including 11 custom sniffs and Slevomat. |
| PHPStan | Level **7**, same PHP paths except the four native HTML error templates listed below. Includes configuration, scripts, tests and other templates. Memory allowance: `512M`. No generated ignore baseline. |
| Deptrac | `app/`: class, function, function-call, file and import dependencies. `analyse --report-uncovered --fail-on-uncovered` **and** `debug:unassigned` must pass; the latter rejects isolated unclassified tokens too. |
| Rector | Same owned PHP paths via `rector.php`, **dry-run only**. Only `SimplifyIfReturnBoolRector` is enabled; no framework conversion, broad preset or automatic modernization. |

Vendor, `.runs/`, writable/cache/build output and non-PHP assets are outside these scans. Coverage exclusions do
not exclude configuration or templates from syntax/style. Python/shell/configuration tools are validated directly
by their owners, not by PHP product tests. Product suites must not test tooling or deliberately invalid fixtures.

Focused commands (inside the prepared runtime, **not additional PHPUnit phases**):

```sh
./bin/exec php scripts/check-php.php
./bin/exec php vendor/bin/phpcs -s
./bin/exec php vendor/bin/phpstan analyse --no-progress --memory-limit=512M
./bin/exec php vendor/bin/deptrac analyse --no-progress --report-uncovered --fail-on-uncovered --cache-file=.runs/cache/deptrac.cache
./bin/exec php vendor/bin/deptrac debug:unassigned --cache-file=.runs/cache/deptrac.cache
./bin/exec php vendor/bin/rector process --dry-run --no-progress-bar
```

## Native ownership and review rules

Keep `App\\` in `app/`. Controllers may depend on presentation support, CodeIgniter and the PSR logging
contract. `StarterGreeting` is explicitly presentation support and has no outward dependencies. Configuration
is the composition root and may reference concrete public package adapters/providers. Templates may reference
the framework. `app/Common.php` and language registration remain native procedural seams. New unclassified
source must receive a responsibility and reviewed collector/rules, not a catch-all `App\\` layer.

The package graph separates Common Domain, Application and Adapter namespaces. There is no blanket `Fight\\`
allow rule and no owned Domain/Application layer today. Add inward rules with a future accepted owned use case;
do not manufacture classes or claim empty-layer enforcement. Dynamic `service()`/view discovery, package
ownership, misplaced business policy, authorization, forwarding aliases and transaction coupling still require
source/caller review; a static dependency pass cannot prove them.

Use native shared registrations for reusable collaborators. The router, Guzzle client, Twig environment and
Flysystem now have registrations used by their parent adapters. Inline immutable values and private leaf
mechanisms (loader, local storage adapter, null transport) need no parallel container. Request/response caches
and `db_connect()` remain framework-owned. HTTP/Spark use this graph; these registrations do not configure
AccessControl handlers or establish long-running-worker isolation.

Use strict types, precise types, camelCase production members, final concrete classes and readonly state where
compatible. Preserve extensible controller bases, inherited configuration signatures, mutable native config and
response lifecycles. Required docblocks use the shipped grammar: `Class Name`, active-verb method summaries,
`Constructs Name`, or multiline `@inheritDoc`. Name capabilities for responsibility; no speculative wrappers.

## Qualified exceptions

These are rule-specific, not directory-wide waivers. The PHP/composition maintainer owns them. Revisit an
exception when its named member/path is changed, when the framework/package/tool changes, or when a future
use case introduces behavior in that scope. Keep configuration and this inventory synchronized.

| Rule / exact scope | Reason and qualification |
|---|---|
| PHPCS `PSR1.Methods.CamelCapsMethodName`, `tests/*` | PHPUnit `test_...` discovery/behavior names are retained; production camelCase remains enforced. |
| PHPCS `Squiz.Commenting.FunctionComment.Missing`, `tests/*` and `scripts/verify-production-profile.php` | PHPUnit scenario names and inline protocol doubles need no redundant method summaries. Named helper methods still receive Common's custom docblock enforcement; production methods are not exempt. |
| PHPCS `PSR1.Classes.ClassDeclaration.MultipleClasses`, only the two `tests/feature/Fight*IntegrationTest.php` files | Scenario-local envelope/subscriber/recording doubles stay colocated. Their namespace is `Tests\\Feature`; other named types must match their path. |
| Namespace checker, timestamped `ExampleMigration` support file | CodeIgniter migration discovery uses its timestamp filename, not a PSR-4 class basename. Existing migration behavior is retained. |
| PHPCS `PSR1.Files.SideEffects.FoundWithSymbols`, `app/Config/Boot/*`, `public/index.php`, `spark`, `preload.php`, `scripts/verify-production-profile.php`, `scripts/analysis-bootstrap.php` | Native boots/entrypoints define constants while booting; the analysis bootstrap only declares static-analysis constants. No blanket configuration exclusion. |
| PHPCS missing namespace / PascalCase, `preload.php`'s global `preload` class | Retains CodeIgniter's optional native preloader identity; syntax checker recognizes only this global class. Preloading is not enabled or production-qualified here. |
| PHPCS `Generic.Files.LineLength`, `app/Config/DocTypes.php`, `app/Views/errors/html/error_exception.php`, `app/Views/welcome_message.php` | Native literal DTD tables, mixed debug markup, embedded SVG/CSS retain their lines. Other rules still scan them. |
| Inline PHPCS line-length annotations: `Publisher::$restrictions`, `validate-composer.php` exact warning/remediation text, integration `setUp()` SQL and final queue envelope/lifecycle expected tables | Preserve exact native regex/diagnostics and one-row-per-delivery fixture readability, not arbitrary long production code. |
| PHPStan four files: `app/Views/errors/html/{error_exception,error_400,error_404,production}.php` | Native renderer-injected variables, protected `static::` rendering context, translated scalar/array values and mixed assets are not standalone file scope. Syntax/style still scan them. Direct native render probes exercised 400/404/500 and production rendering; no new public error route. New owned behavior in these files requires revisiting this exception. |
| PHPStan CLI `error_exception.php`: `offsetAccess.notFound` ×2; `isset.offset` ×1; `arrayValues.list` ×1 | Native engine trace rows pair file/line and class/type; retain native defensive field/list handling despite broader PHPStan trace declarations. Direct native exception/backtrace rendering passed. Strict-types adaptation explicitly string-casts the displayed numeric frame index. |
| PHPStan `if.alwaysFalse` ×1 each, `public/index.php` and `spark`; three version-comparison identifiers ×1 each in `verify-composer-runtime-policy.php` | Retain executable runtime compatibility guards even though analysis already knows the locked PHP version. Exact identifiers/counts live in `phpstan.neon`; unmatched entries fail. |
| PHPStan `method.alreadyNarrowedType` ×1, `HealthTest::testIsDefinedAppPath()` | Existing scaffold runtime bootstrap assertion is statically known; scaffold/coverage retirement belongs to TASK-00016. |
| PHPStan `property.onlyWritten`, the private by-reference arrays in `RecordingReceiptEventSubscriber`, the transaction subscriber and production-profile Twilio double | External assertions read the referenced arrays. Local identifier annotations preserve private visibility instead of changing behavior to satisfy inference. |

PHPStan's two `Quality\\` extensions resolve **literal** native `service()`/`config()` names and shared-factory
branches from installed declared signatures without booting or executing factories. Unknown names keep the
native type and diagnostics. Installed native function contracts are used directly, including escaping;
no duplicate stub is needed. Dynamic constants keep environment-dependent branches analysed. Installed Kint source is scanned for
types, not added as product source. These adaptations are tool-only, never application runtime shims.

## Tool compatibility and remaining work

Qualified on PHP **8.5.12**, Composer **2.10.2**: PHPCS **4.0.4**, Slevomat **8.31.1**, PHPStan **2.2.16**,
Deptrac **4.7.2**, Rector **2.6.7**. Owned checker imports directly declare PHP-Parser **5.8.0** and Finder
**8.1.8**. Composer resolved 23 added dev/transitive packages; all 80 existing package entries remain unchanged,
including Common **1.4.0**, AccessControl **0.8.0**, HttpFoundation **8.1.9**. Required XML/tokenizer/libxml and
other platform extensions passed. Composer's preparation-time audit found no advisories; verification does not
audit or contact registries. This is target execution evidence, not a guarantee for every PHP 8.5 construct.

`dealerdirect/phpcodesniffer-composer-installer` is present transitively but explicitly **disabled** in
`allow-plugins`. No plugin/global standard installation is trusted implicitly. Plain `phpcs -i` lists only the
six bundled standards; it does not prove absence of Common. Explicit runtime paths list `SlevomatCodingStandard`
and **`Phpcs`** (the shipped directory basename), while direct ruleset loading names **`FightCommon`**.
`phpcs -e` using local configuration loads all 79 sniffs, including Common's 11 custom `Phpcs.*` sniffs.
Use the local ruleset, not a guessed globally installed `--standard=FightCommon`.

Measured local observations: PHPCS about 1.1–4.4 seconds / 20 MB; initial uncached PHPStan debug analysis
23.22 seconds / 172.5 MB peak, final debug reanalysis 5.91 seconds / 154.5 MB peak, with the finite 512M
allowance. First complete gate: 37.3 seconds, PHPUnit 1.2 seconds / 28 MB.
These are individual local observations, not enforced limits or hosted capacity guarantees. Compose has no new
resource caps; idle app/web snapshots were about 55/9 MiB. PCNTL remains absent (queue signal warning); PHPUnit
still proves bounded job processing/retry. Planned coverage and stronger read-only/concurrency orchestration stay
with TASK-00016/00017. TASK-00015 already passes the current complete gate with exactly one full PHPUnit run.
The [provider inventory](../tickets/00009-TICKET.md#existing-and-planned-provider-check-inventory) owns applicable,
N/A and deferred checks. Unavailable upstream AI advisors are not installed, simulated, called or required.
