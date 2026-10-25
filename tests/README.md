# Application and Integration Tests

Prepare the CodeIgniter runtime and locked dependencies before testing:

```sh
./bin/up
./bin/composer install --no-interaction --prefer-dist --no-progress
./bin/build
```

PHPUnit 10 uses CodeIgniter's native test bootstrap and helpers. `./bin/phpunit` is a focused iteration tool;
only `./bin/build` is the complete local/hosted gate. Neither command installs or updates dependencies.
The gate runs PHPUnit exactly once, unfiltered. Optional focused iteration is separate, not a canonical phase:

```sh
./bin/phpunit --filter 'FightCommonIntegrationTest|FightTransactionIntegrationTest|HelloWorldTest'
```

Tests use `Tests\\Feature`, `Tests\\Database`, `Tests\\Session` and `Tests\\Unit` namespaces while preserving
native discovery and the existing single-suite layout. The two Fight integration files retain scenario-local
doubles. See [PHP standards](../planning/agents/php-standards.md) for analysis boundaries and narrow exceptions.
TASK-00015 retains every existing test and integration outcome; its extra assertions establish usable native
query results before inspecting them. This is not a coverage claim or suite reorganization.

## Test boundaries

Keep tests of application behavior and important consumer/package integration outcomes. The existing
`FightCommonIntegrationTest` exercises configured services, transaction commit/rollback, database queue
command/event envelopes and retries, local storage/process/scheduling effects, and safe provider transports.
`HelloWorldTest` proves the public home response. Named URL generation uses the real `home` route, not a
certification-only production route. On Common 1.4.0 / AccessControl 0.8.0 / HttpFoundation 8.1.9, the
consumer tests also verify StreamId tuple deduplication/key replacement and canonical JSON, selected JSend
status/headers/body, and intercepted PSR-18 network failure. The released JSend adapter double-encodes its envelope
with this CodeIgniter version; tests disclose that inherited limitation, not a top-level JSend object guarantee.

`FightTransactionIntegrationTest` uses the real selected SQLite connection to prove the factory's connection
choice, callback result after commit, original-error rollback, nested rejection, and synchronous publication after
commit (subscriber failure leaves committed state intact). Connection doubles separately cover false versus
thrown begin/status/commit, closed rejection, and cleanup failures without masking the original error. They prove
adapter branching only, not database commit uncertainty, SQL concurrency, shared AccessControl repositories or
safe retry. A thrown commit does not guarantee rollback/reset; connection recovery and authoritative-state
reconciliation remain required. No AccessControl handler/repository journey is composed or accepted.

Do not test receipt machinery, Composer output parsing, quality-tool behavior, build wrappers, or tests themselves
in the product suite. Do not manufacture fake Composer executables or invalid tool fixtures. TASK-00007 removes the
framework-support receipt and verifier-wrapper tests rather than moving them to another test suite.

The gate invokes `scripts/verify-production-profile.php` directly to check production credential rejection and
safe configured provider behavior. Its transports are intercepted/local: no external provider delivery is
claimed. The production check also verifies intercepted Twilio 503 and public/private Mercure failures propagate
with their causes rather than being reported as success. These errors are not approved public diagnostics.
PHPUnit does not invoke that checker to assert its stdout or exit status. Composer/runtime policy,
governance, planning, and public dependency boundaries are likewise checked by their owning tools.

## Coverage and limits

The current wrappers explicitly use `--no-coverage`; XML report settings alone do not establish coverage.
There is no measured unit-coverage result or numeric coverage gate in this slice. Existing scaffold tests remain;
this retirement is not a wholesale suite reorganization or an upstream-package correctness claim.

The gate no longer generates or validates framework-support receipts, resolves lowest/latest dependencies, or
installs a separate `--no-dev` dependency tree. Dependency compatibility exploration and production deployment
qualification require separately scoped maintenance work. Historical certification records remain in planning
and Git history, but are not current verification obligations.
