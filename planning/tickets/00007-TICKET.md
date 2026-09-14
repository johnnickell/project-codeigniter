---
id: T-00007
prd: PRD-00002
title: Establish the Lean CodeIgniter Pre-Submit Quality Gate
status: ready-for-agent
blocked_by:
---

# Establish the Lean CodeIgniter Pre-Submit Quality Gate

## Outcome

Replace the certification-heavy topology with one CodeIgniter-owned `./bin/build` pre-submit gate, following
Fight Common [T-00087](https://github.com/johnnickell/fight-common/blob/develop/planning/tickets/00087-TICKET.md)
and [ADR 0026](https://github.com/johnnickell/fight-common/blob/develop/planning/adr/0026-lean-pre-submit-and-release-qualification.md).

## Scope

- Require `johnnickell/fight-common:^1.2`, the installed `FightCommon` PHPCS standard, and repository-owned scan
  paths/exclusions.
- `./bin/build` is the sole local and hosted pre-submit gate: each retained Unit, Integration, Functional,
  frontend, and browser suite runs once alongside Composer validation, syntax/formatting, PHPCS, PHPStan,
  Deptrac, and Rector dry-run.
- Direct Unit tests use `#[CoversClass]` and alone provide exact 100% owned-production statement coverage;
  retained boundary and journey suites use `#[CoversNothing]`.
- Retain framework-native CodeIgniter boundary coverage and valuable application journeys; framework types stay in
  Adapter/composition under Adapter -> Application -> Domain.

## Exclusions and Cleanup

- Replace the monolithic test topology and remove stock framework, receipt, and profile tests that certify rather
  than protect owned behavior.
- Remove candidate validation, lowest/latest lanes, receipt authorities, auxiliary locks/digests, clean
  production-install inspection, and Fight Common certification journeys from ordinary builds.
- Do not test build scripts, CI, configuration, coverage tooling, certification-only fixtures, receipts, or docs.
  Hosted CI calls `./bin/build` only and hosted status is separately recorded.

## Acceptance Criteria

- [ ] One canonical gate runs retained suites once and all retained quality checks.
- [ ] Package/standard integration, local paths/exclusions, and direct Unit-only exact coverage are enforced.
- [ ] Coverage metadata differentiates direct units from retained boundary/journey suites without masking gaps.
- [ ] The CodeIgniter-native boundaries and useful journeys remain while stock, receipt, profile, and monolithic
      certification topology is gone from ordinary builds.

## Verification

- Run focused retained checks, then `./bin/build`.
- Verify hosted CI delegates only to that command and report its result separately.
