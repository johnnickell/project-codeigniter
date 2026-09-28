# Application and Integration Tests

Prepare the CodeIgniter runtime and locked dependencies before testing:

```sh
./bin/up
./bin/composer install --no-interaction --prefer-dist --no-progress
./bin/phpunit
./bin/phpunit --filter FightCommonIntegrationTest
./bin/build
```

PHPUnit 10 uses CodeIgniter's native test bootstrap and helpers. `./bin/phpunit` is a focused iteration tool;
only `./bin/build` is the complete local/hosted gate. Neither command installs or updates dependencies.

## Test boundaries

Keep tests of application behavior and important consumer/package integration outcomes. The existing
`FightCommonIntegrationTest` exercises configured services, transaction commit/rollback, database queue
command/event envelopes and retries, local storage/process/scheduling effects, and safe provider transports.
`HelloWorldTest` proves the public home response. Named URL generation uses the real `home` route, not a
certification-only production route.

Do not test receipt machinery, Composer output parsing, quality-tool behavior, build wrappers, or tests themselves
in the product suite. Do not manufacture fake Composer executables or invalid tool fixtures. T-00007 removes the
framework-support receipt and verifier-wrapper tests rather than moving them to another test suite.

The gate invokes `scripts/verify-production-profile.php` directly to check production credential rejection and
safe configured provider behavior. Its transports are intercepted/local: no external provider delivery is
claimed. PHPUnit does not invoke that checker to assert its stdout or exit status. Composer/runtime policy,
governance, planning, and public dependency boundaries are likewise checked by their owning tools.

## Coverage and limits

The current wrappers explicitly use `--no-coverage`; XML report settings alone do not establish coverage.
There is no measured unit-coverage result or numeric coverage gate in this slice. Existing scaffold tests remain;
this retirement is not a wholesale suite reorganization or an upstream-package correctness claim.

The gate no longer generates or validates framework-support receipts, resolves lowest/latest dependencies, or
installs a separate `--no-dev` dependency tree. Dependency compatibility exploration and production deployment
qualification require separately scoped maintenance work. Historical certification records remain in planning
and Git history, but are not current verification obligations.
