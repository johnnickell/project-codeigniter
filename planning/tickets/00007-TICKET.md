---
id: TICKET-00007
epic: EPIC-00002
title: Specify the CodeIgniter-adapted engineering contract
status: needs-info
---

# Specify the CodeIgniter-adapted engineering contract

## Problem statement

The initial comparison and certification retirement do not establish complete adoption of Agent OS ownership,
PHP, testing, coverage, static-analysis, HTTP, and delivery practices.

## Proposed solution and boundaries

Specify a concrete local contract for adoption by default: direct package use, genuine orchestration, inward
dependency boundaries, shared composition, PHP/naming conventions, meaningful unit/integration/functional
coverage and compatible PHPCS/PHPStan/Deptrac/Rector/build phases. Justify every adaptation, deferral or exclusion
against CodeIgniter's native approach or public-package evidence. Preserve `app/`, configuration/discovery,
controllers, routing, views and Spark; do not import another application's concrete stack.

This TICKET owns the sourced contract proposal and explicit unresolved choices, not acceptance of every detail
or enforcement implementation. [TICKET-00009](00009-TICKET.md) owns those remaining obligations. Pi/shared-skill
bindings and runtime hygiene belong to [TICKET-00010](00010-TICKET.md), not speculative application refactoring.

Keep the already approved exclusion of tool-self-tests, fabricated tool failures, recurring receipts, and
pre-submit dependency maintenance. Do not revive the separate legacy T-00005 proposal wholesale; its exact
coverage and certification assumptions conflict with newer decisions and need explicit reconciliation.

## Incoming upstream quality-gate handoff

The maintainer authorized carrying `develop`'s independently created legacy T-00007 into this requirement for
explicit reconciliation. [Provenance and requirement disposition](../UPSTREAM-RECONCILIATION.md) preserve its
original `ready-for-agent` status, Common `^1.2`/FightCommon PHPCS requirement, full tooling phases, exact 100%
Unit-only coverage proposal, `CoversClass`/`CoversNothing` metadata, native boundaries and cleanup exclusions.
These are inputs TASK-00010 must resolve, not completed or newly accepted enforcement. This upstream identity
is distinct from retirement TASK-00007; do not infer acceptance from the shared old number.

## Use cases and validation

A maintainer chooses enforceable local engineering rules and their evidence before implementation decomposition.
No business commands/queries/events or runtime permissions are introduced here. HTTP/authorization decisions
remain in their Wayfinder/use-case owners; no speculative handlers, test-only routes, or bulk source moves.

## Acceptance and evidence to settle

Deliver the proposed rule set, applicability/exceptions, compatible tooling versions, meaningful coverage
denominator and driver, enforcement versus review responsibilities, migration/backward-compatibility cost and
independently verifiable follow-on boundaries. Identify any missing compatibility evidence or human choice
explicitly. Keep hosted gate parity and report warnings/limits. A green current gate is not proof that absent
static analysis or unmeasured unit coverage has been adopted.

## TASKs

<!-- planning:children -->
| ID | Title | Status |
|---|---|---|
| [TASK-00010](../tasks/00010-TASK.md) | Define the CodeIgniter engineering alignment contract | ready-for-agent |
<!-- /planning:children -->

## Decisions and progress

The maintainer approved creation of [TASK-00010](../tasks/00010-TASK.md), a decision/documentation chore blocked
by [TASK-00009](../tasks/00009-TASK.md)'s qualification findings. Its scope is approved, but execution has not been
authorized or started. No concrete tooling/coverage choices or enforcement implementation were accepted by that
original record-creation approval; this TICKET remains `needs-info` pending the amended proposal below.

The 2026-10-24 amendment approves adoption by default, not an unexamined coverage metric, tooling version or
framework transplant. Review TASK-00010's concrete proposal under TICKET-00009 before allocating enforcement
TASKs. A completed proposal can close this artifact requirement while TICKET-00009 remains unfinished; no
parent-completion exemption is needed. If TASK-00009 cannot qualify a package pair, package-sensitive decisions
remain unresolved rather than treating blocker completion as compatibility evidence. TICKET-00004 and
TICKET-00005 remain the locally completed retirement/planning slices.
