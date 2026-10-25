# CodeIgniter Architecture Boundary

CodeIgniter owns application configuration, `Config\\Services` discovery, routing, controllers, views, Spark console entry points, and future framework adapters. Fight Common and Fight AccessControl remain public Composer dependencies; copied Domain or Application trees and unpublished-package internals are prohibited.

The bootstrap exposes only a public hello-world HTTP seam. Authentication, authorization flows, persistence, browser journeys, and production integrations require separately approved local TASKs and evidence.

`App\\` remains mapped to `app/`; CodeIgniter-native controllers, configuration, and service discovery are not
relocated to another framework's layout. The named `home` route supplies URL-generation integration evidence;
the certification-only `/framework-support/receipt` alias is retired.

TASK-00007 retires framework-support receipt and dependency-lane certification. The starter verifies its behavior
and important public-package integrations, not a separate package-release receipt authority. Dependency
preparation is explicit; `./bin/build` checks the prepared runtime without installing or updating packages.
Production-profile checks use safe test credentials and intercepted provider transports; they are not evidence
of live delivery, deployment readiness, or a clean `--no-dev` installation.

## Stable consumer composition

The selected baseline is Common **1.4.0** / AccessControl **0.8.0**, with HttpFoundation **8.1.9**.
`Config\\Services::fightTransactionalUnitOfWork()` passes the selected shared `db_connect()` connection to the
released `TransactionalUnitOfWork` adapter; no legacy `UnitOfWork` shim is needed. The tests demonstrate actual
SQLite commit/rollback and selected-connection transaction depth, not shared AccessControl repositories (none
are composed), SQL concurrency, or production database guarantees. Do not nest future AccessControl handlers
inside another transaction: their required mutations/audit must use the same actual connection and fences.

Only publish success after confirmed commit. Subscriber failure after commit cannot undo committed state.
The released adapter attempts rollback/status reset on callback failures and false status/commit returns,
preserving the original callback throwable even when cleanup fails. Thrown begin/status/commit errors propagate
without rollback/reset; a thrown commit clears only adapter activity, not connection state or an uncertain
outcome. Failed cleanup or lost acknowledgement requires connection recovery and authorized authoritative-state
reconciliation, not blind replay. Queue submission is not an atomic outbox; retries repeat full event fan-out.

The released native JSend adapter preserves selected status/headers, but with this CodeIgniter version its body
is a JSON **string containing the envelope**, not a top-level object. This inherited limitation is explicitly
verified, not repaired with a shim or exposed as a new API. Only hello-world is public. A future API task must
resolve the representation contract and sanitize arbitrary diagnostics before exposing errors. Provider wrappers
preserve causes and can retain diagnostic text; intercepted failure tests do not establish safe public errors.

StreamId tuple/hash/JSON migration consequences are documented in the [README](README.md#stable-package-baseline).
No repositories, schema/data migrations, new package capabilities or Wayfinder decisions are selected here.

## Maintained native dependency checks

TASK-00015 enforces the current responsibility map through `deptrac.yaml`: controllers depend on framework,
logging and presentation support; `StarterGreeting` has no outward dependencies; configuration is the concrete
composition root; views and native procedural registration remain explicit outer seams. Common Domain,
Application and Adapter contracts are separate external layers, not a universal `Fight\\` allowance. There is no
owned Domain/Application layer today. New unclassified source fails the unassigned-token check and needs a
reviewed responsibility/ruleset rather than a catch-all collector.

Reusable router, Guzzle, Twig and local-storage collaborators now use native shared registrations. Queue delivery
still traverses the synchronous pipelines; selected connection/request/response lifecycles remain native.
Dependency analysis cannot resolve dynamic service/view names or prove transaction, authorization or package
ownership semantics. Review these explicitly. [PHP standards](planning/agents/php-standards.md) owns scan paths,
precise tool adaptations/exceptions and their revisit triggers. No runtime analysis shim or second container is
introduced.
