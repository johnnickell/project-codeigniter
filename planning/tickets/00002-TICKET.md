---
id: TICKET-00002
epic: EPIC-00001
legacy_id: PRD-00002
title: Fight Common Version Adoption and Support Evidence
status: done
---

# Fight Common Version Adoption and Support Evidence

Migrated from PRD-00002 under [TASK-00008](../tasks/00008-TASK.md). This requirement owns the historical 1.2
candidate integration, not adoption of current stable releases. [MIGRATION.md](../MIGRATION.md) maps historical
IDs. Future Common 2.0 research is separated into [TICKET-00003](00003-TICKET.md); certification retirement is
[TICKET-00004](00004-TICKET.md). Their scope and evidence are not lost or duplicated here.

## Problem Statement

The starter must verify its Fight Common integration through its own Composer graph and booted CodeIgniter composition.

## Current Decision — Certification Retirement

The maintainer approved [TASK-00007](../tasks/00007-TASK.md) on 2026-09-27: retire recurring framework-support
receipts, lowest/latest dependency certification, and certification-only/tool-verifier tests. Dependency
installation and updates become explicit preparation/maintenance outside `./bin/build`. Preserve native
CodeIgniter discovery/layout and meaningful integration behavior, with direct safe production-profile checks.

This decision supersedes the ongoing certification requirements described below. Those sections record the
historical adoption, not requirements to regenerate deleted evidence. Package versions and locks are unchanged;
this is neither a stable-release adoption nor a Fight Common 2.0 migration.

## Historical Adoption Solution

Adopt the immutable 1.2 candidate through
`dev-develop#4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16 as 1.2.0-dev` and commit the data-only,
authority-validated `evidence/framework-support/receipt-v1.json`; keep 2.0 non-executable until its owning
authority exists.

## Historical Implementation Decisions

- The lockfile, candidate identity, selected capabilities, booted journeys, and both lock SHA-256 values are
  adoption evidence.
- CodeIgniter owns service delegates and native configuration; Fight Common remains a Composer dependency only.
- No speculative 2.0 breaking changes are defined here.
- T-00004 establishes the complete project-owned CodeIgniter profile before T-00002 records its receipt.

## Historical Testing Decisions

- Lowest/latest resolutions, booted journeys, receipt canonicalization, the installed exact candidate's
  `StarterSupportReceiptAuthority`, `./bin/planning-check`, and `./bin/build` prove a receipt.

## Out of Scope

- Copied source, nested applications, central builds, releases, and publication.

## Historical Terminal Scope Rationale

This PRD is terminal because it owns the completed additive 1.2 adoption and its support evidence. Local
tickets are the execution authority and portfolio provenance, not a second status system: T-00002 and T-00004
complete that 1.2 scope. T-00003 remains a separately deferred 2.0 migration discovery ticket in `needs-info`
until Fight Common supplies its contract, deprecation-removal inventory, and migration guide; it does not reopen
or extend this completed requirement.

## TASKs

<!-- planning:children -->
| ID | Title | Status |
|---|---|---|
| [TASK-00002](../tasks/00002-TASK.md) | Adopt the historical Fight Common 1.2 candidate | done |
| [TASK-00004](../tasks/00004-TASK.md) | Establish the Complete CodeIgniter Platform Profile | done |
| [TASK-00006](../tasks/00006-TASK.md) | Re-certify Rewritten Fight Common Candidate | done |
<!-- /planning:children -->

## Progress

- TASK-00002/TASK-00004 completed the original 1.2 candidate adoption and service profile.
- TASK-00006 completed rewritten-candidate re-certification.
- [TASK-00007](../tasks/00007-TASK.md), now under TICKET-00004, retired recurring certification with a green local
  gate (13 tests / 69 assertions). Its independent review and hosted verification remain pending.
- [TASK-00003](../tasks/00003-TASK.md), now under TICKET-00003, remains `needs-info`; neither retirement nor the
  hierarchy migration makes it executable.
- This TICKET remains done for its historical candidate-integration outcome. Current stable package adoption
  is unqualified under [TICKET-00006](00006-TICKET.md).

## Use cases and validation

Consumer configuration composes public Fight capabilities through native CodeIgniter services. Observable
integration outcomes include commit/rollback and queue delivery/retry. This requirement adds no business
commands, HTTP authentication policy, or live-provider authority. Runtime behavior is tested at the consumer
boundary; the historical recurring certification obligations are explicitly retired, not current gates.

## Further Notes

The 2026-09-09 authorship-only Fight Common rewrite changed the certified candidate identity without changing its
tree. T-00006 records the exact mapping, regenerated consumer evidence, and replacement certification while
preserving the original ticket's historical statements.

Historical related work: T-00002, T-00003, T-00004, T-00006, T-00007 (see the migration map).
Historical receipt schema authority: Fight Common T-00075.
