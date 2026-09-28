---
id: TICKET-00005
epic: EPIC-00002
title: Adopt the EPIC TICKET TASK planning structure
status: done
---

# Adopt the EPIC TICKET TASK planning structure

## Problem statement

The old PRD → executable T-ticket model obscures the distinction between package adoption, engineering adoption,
and individual completed changes. The maintainer prioritized fixing planning before further adoption work.

## Solution and boundaries

Use Agent OS's EPIC → TICKET → TASK structure with record-owned metadata, generated boards/indexes/frontiers,
independent ID sequences, and explicit-only archive operations. Migrate local content and identities rather than
copying source-project plans. Preserve historical outcomes, gaps, unfinished work, and the existing Wayfinder.

## Use cases and validation

A human or agent identifies an active TASK, executable frontier, and unresolved planning decision without
inferring execution permission from a requirement. `planning-check --write` refreshes views; the read-only check
rejects stale views, broken links, invalid parents/IDs, and cycles. No new business messages, events, HTTP
permissions, or runtime side effects apply.

## Acceptance and evidence

Existing PRDs become requirement TICKETs; executable T-tickets become TASKs with a documented identity mapping.
An adoption EPIC clearly separates approved slices from unqualified packages and engineering work. Templates,
instructions, governance, validation, and archive commands agree. No records are archived; dependencies and
production code remain unchanged. The canonical gate is green and does not rewrite planning.

## TASKs

<!-- planning:children -->
| ID | Title | Status |
|---|---|---|
| [TASK-00008](../tasks/00008-TASK.md) | Migrate planning to the EPIC TICKET TASK structure | done |
<!-- /planning:children -->

## Decisions and progress

[TASK-00008](../tasks/00008-TASK.md) completed the approved first-priority migration with repeatable generated
views and a green local gate (13 tests / 69 assertions). Independent review and hosted verification remain pending.
This completes planning structure, not the broader adoption EPIC. The number 00005 here belongs to the independent
requirement TICKET sequence; it is not the legacy executable T-00005 in the untouched worktree.
