---
id: T-00004
prd: PRD-00002
title: Establish the Complete CodeIgniter Platform Profile
status: done
blocked_by:
---

# Establish the Complete CodeIgniter Platform Profile

## Outcome

This ticket established the preliminary project-owned `Config\\Services` foundation for the complete profile.
T-00002 owns the completed, authority-validated receipt and lowest/latest certification. Application developers
continue to supply only their Domain/Application services, application configuration, routes, templates, and
secrets.

## Acceptance Criteria

- [x] Composer resolves `johnnickell/fight-common` from the public VCS repository as `dev-develop` at
  `4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16`, using the required `1.2.0-dev` candidate alias and no local
  path repository.
- [x] `Config\\Services` registers usable defaults for validation, security, cache, persistence/event store,
  Queue plus synchronous/async messaging, HTTP/PSR-18, request/response, filesystem/storage/transfer,
  process, scheduler, routing, mail, templating, observability, SMS, Mercure/private publication, and each
  selected provider fallback.
- [x] Project-owned defaults keep credentials, routes, templates, and Domain/Application behavior configurable.
- [x] Focused profile tests, `./bin/planning-check`, and `./bin/build` pass.

## Verification

Record the Composer-resolved package version and candidate reference, boot every registered service in focused
coverage, then run the planning and canonical build gates. This preliminary foundation was verified with the
focused profile suite (4 tests, 48 assertions), `./bin/planning-check`, and `./bin/build` (10 tests, 57 assertions).
T-00002 records the subsequent complete-profile receipt evidence.

## Exclusions

Do not copy Fight Common source, use a local path repository, create a runtime bridge, publish a package, or
embed application secrets or application-specific Domain/Application behavior.

## Documentation Impact

This ticket documents the preliminary, project-owned `Config\\Services` profile foundation. The completed
receipt authority and final lowest/latest dependency-lane certification remain documented by T-00002.

## Completion Notes

Completed as the preliminary CodeIgniter profile foundation. Its focused profile coverage, planning gate, and
canonical build were green at completion; final immutable 1.2 receipt and dependency-lane evidence are owned
by T-00002.
