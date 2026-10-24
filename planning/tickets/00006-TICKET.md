---
id: TICKET-00006
epic: EPIC-00002
title: Qualify the latest stable Fight package upgrade
status: done
---

# Qualify the latest stable Fight package upgrade

## Problem statement

The installed development candidates do not establish the latest stable Fight Common or Fight AccessControl
baseline. The former Common 1.2+/AccessControl 0.4+ targets are historical floors, not current version selections.
A matching version label or branch name does not prove compatible public capabilities.

## Proposed solution and boundaries

Inspect installable stable artifacts and release/migration documentation; select exact mutually compatible
versions, inspect public handler/capability signatures, and inventory changes to CodeIgniter composition and
important consumer behavior. Obtain human acceptance before creating an upgrade implementation TASK.

Inspect the latest stable release of each package across release lines and date the evidence. If the latest
pair cannot be qualified, report the blocker instead of silently choosing older releases. Reconcile the older
v0.2.0 WF-001 gate with the actual latest-stable findings explicitly. A latest-major finding overlapping
TASK-00003 requires its existing contract/migration evidence and an ownership decision, not competing research
or an implicit major-version implementation. Do not copy source, conceal incompatibilities with aliases, or infer
release availability from another consumer.

This requirement now owns the qualification report (including a concrete blocked outcome), not upgrade
implementation or acceptance of an unproven pair. [TICKET-00008](00008-TICKET.md) retains those outstanding
obligations so automatic completion of this investigation's parent cannot close the broader adoption EPIC.

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
| [TASK-00009](../tasks/00009-TASK.md) | Qualify the latest stable Fight package baseline | done |
<!-- /planning:children -->

## Decisions and progress

The maintainer explicitly authorized [TASK-00009](../tasks/00009-TASK.md) execution through Build and selected
the main checkout. Its [2026-10-24 qualification report](../wayfinder/research/2026-10-24-latest-stable-fight-baseline.md)
locally completes this narrowed investigation: latest stable Common v1.4.0 / AccessControl v0.8.0 install together;
released `TransactionalUnitOfWork` contracts fit the native adapter. Relevant capability/migration inventory,
transaction semantics, consumer verification and the proposed WF-001 reconciliation are recorded. This TICKET
closes under automatic parent completion, not independent review or acceptance of an actual upgrade.

The maintainer must accept the exact pair, bounded consumer scope and narrow HttpFoundation 8.1.9 security refresh
before upgrade TASK decomposition under TICKET-00008. The two-package-only copied-lock solve retains an inherited
CVE-2026-108082 advisory; it is not silently waived or repaired here. Project dependencies/runtime source are
unchanged. TICKET-00008 and EPIC-00002 remain unfinished; independent review/QA and hosted evidence are separate.
No Wayfinder decision closes from this report, and no Common 2.x investigation was expanded.

The planning migration itself authorized no package research or upgrade. Subsequent maintainer-approved
[upstream reconciliation](../UPSTREAM-RECONCILIATION.md) preserves `develop`'s lock: Common
`dev-develop@fad24ae9fdcf` and AccessControl `dev-develop@7f55c0adb8fade`. The previous AccessControl
`ecc1c251db56` signature sample is historical; TASK-00009 must inspect the actual current/released contracts.
Neither development reference establishes the requested stable baseline.
