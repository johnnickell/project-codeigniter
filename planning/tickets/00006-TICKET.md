---
id: TICKET-00006
epic: EPIC-00002
title: Qualify and adopt the current stable Fight package baseline
status: needs-info
---

# Qualify and adopt the current stable Fight package baseline

## Problem statement

The installed development candidates do not prove adoption of stable Fight Common 1.2+ or Fight AccessControl
0.4+. A matching version label or branch name does not prove compatible public capabilities.

## Proposed solution and boundaries

Inspect installable stable artifacts and release/migration documentation; select exact mutually compatible
versions, inspect public handler/capability signatures, and inventory changes to CodeIgniter composition and
important consumer behavior. Obtain human acceptance before creating an upgrade implementation TASK.

Reconcile the application Wayfinder's older v0.2.0 WF-001 gate with the requested 0.4+ baseline explicitly. Keep
Common 2.0 research separate. Do not copy package source, add aliases to conceal incompatibilities, or claim a
release is available merely because another consumer names it.

## Use cases and validation

A maintainer qualifies a dependency baseline and reviews consumer migration consequences before approving it.
Business commands/queries/events and runtime permissions remain package/use-case-specific and must be inventoried,
not invented here. Check exact transaction contracts, shared-connection behavior, and failure/compatibility paths.
Dependency installation/updates are explicit maintenance, not hidden pre-submit side effects.

## Acceptance and evidence to settle

Record exact versions/references from the target installation and lock, release authority, public capability and
migration inventory, safe consumer verification, and documentation impact. Resolve the sampled `UnitOfWork`
versus `TransactionalUnitOfWork` binding against those releases. Acceptance must distinguish package support,
consumer composition, and actual application journeys; no blanket full-capability claim is authorized.

## TASKs

<!-- planning:children -->
| ID | Title | Status |
|---|---|---|
| [TASK-00009](../tasks/00009-TASK.md) | Qualify the stable Fight package baseline | ready-for-agent |
<!-- /planning:children -->

## Decisions and progress

The maintainer approved creation of [TASK-00009](../tasks/00009-TASK.md), the bounded qualification chore proposed
for this TICKET. It is ready for an agent but has not started; execution requires separate authorization. The
approval does not accept a release pair or authorize an upgrade TASK. Exact release/compatibility evidence and
human acceptance of the migration scope remain outstanding, so this TICKET stays `needs-info`.

The planning migration itself authorized no package research or upgrade. Current lock remains Common
`dev-develop@fad24ae9fdcf` and AccessControl `dev-develop@ecc1c251db56`.
