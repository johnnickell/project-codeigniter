---
id: TICKET-00007
epic: EPIC-00002
title: Decide the remaining engineering and quality-gate alignment
status: needs-info
---

# Decide the remaining engineering and quality-gate alignment

## Problem statement

The initial comparison and certification retirement do not establish complete adoption of Agent OS ownership,
PHP, testing, coverage, static-analysis, HTTP, and delivery practices.

## Proposed solution and boundaries

After planning is trustworthy, settle target-owned decisions for direct package use, genuine orchestration,
inward dependency boundaries, PHP/naming conventions, meaningful unit/integration/functional coverage, and
appropriate PHPCS/PHPStan/Deptrac/Rector/build phases. Preserve CodeIgniter-native discovery, `app/` layout, HTTP
and Spark seams. Use the qualified package baseline rather than importing another application's concrete stack.

Keep the already approved exclusion of tool-self-tests, fabricated tool failures, recurring receipts, and
pre-submit dependency maintenance. Do not revive the separate legacy T-00005 proposal wholesale; its exact
coverage and certification assumptions conflict with newer decisions and need explicit reconciliation.

## Use cases and validation

A maintainer chooses enforceable local engineering rules and their evidence before implementation decomposition.
No business commands/queries/events or runtime permissions are introduced here. HTTP/authorization decisions
remain in their Wayfinder/use-case owners; no speculative handlers, test-only routes, or bulk source moves.

## Acceptance and evidence to settle

Define the accepted rule set, applicability/exceptions, compatible tooling versions, meaningful coverage denominator
and driver, enforcement versus review responsibilities, migration/backward-compatibility cost, and independently
verifiable TASK boundaries. Keep hosted gate parity and report warnings/limits. A green current gate is not proof
that absent static analysis or unmeasured unit coverage has been adopted.

## TASKs

<!-- planning:children -->
| ID | Title | Status |
|---|---|---|
| [TASK-00010](../tasks/00010-TASK.md) | Define the CodeIgniter engineering alignment contract | ready-for-agent |
<!-- /planning:children -->

## Decisions and progress

The maintainer approved creation of [TASK-00010](../tasks/00010-TASK.md), a decision/documentation chore blocked
by [TASK-00009](../tasks/00009-TASK.md)'s qualification findings. Its scope is approved, but execution has not been
authorized or started. No rule set, tooling/coverage policy or enforcement implementation is accepted by this
record-creation approval; this TICKET remains `needs-info`.

Review TASK-00010's proposal before allocating enforcement TASKs. If TASK-00009 cannot qualify a package pair,
package-sensitive decisions remain unresolved rather than treating blocker completion as compatibility evidence.
[TICKET-00004](00004-TICKET.md) and [TICKET-00005](00005-TICKET.md) remain the locally completed alignment slices.
