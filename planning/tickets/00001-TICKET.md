---
id: TICKET-00001
epic: EPIC-00001
legacy_id: PRD-00001
title: CodeIgniter Starter Product and Walking-Slice Acceptance
status: done
---

# CodeIgniter Starter Product and Walking-Slice Acceptance

Migrated from PRD-00001 under [TASK-00008](../tasks/00008-TASK.md); the accepted foundation scope is unchanged.

## Problem Statement

A new CodeIgniter starter project needs governed boundaries: native configuration, service discovery, HTTP, Spark console, presentation composition, and explicit Fight Common/Fight AccessControl Composer dependencies.

## Solution

The bootstrap establishes a governed hello-world foundation with Docker-backed tooling, a canonical `./bin/build` gate, hosted CI, and public-source guidance.

## Implementation Decisions

- Repository-local planning, architecture, triage, and public-source guidance are canonical.
- Docker-backed Composer, PHPUnit, lifecycle, and build wrappers exist.
- `./bin/build` is the single noninteractive local and hosted gate.
- MIT, contribution, and security policies are present.

## Testing Decisions

- `./bin/build` validates governance and the hello-world foundation; hosted CI invokes that exact command.
- A native controller/view integration check verifies the CodeIgniter composition seam.

## Out of Scope

- Login, persistence, browser journeys, releases, tags, Packagist publication, template enablement, create-project distribution.

## Further Notes

## Use cases and validation

The public hello-world request must render through native CodeIgniter routing, services, and views. Business
commands, events, authentication, and persistence are N/A for this bootstrap. Tooling must fail closed on invalid
planning/governance; it does not establish production deployment or package publication authority.

## TASKs

<!-- planning:children -->
| ID | Title | Status |
|---|---|---|
| [TASK-00001](../tasks/00001-TASK.md) | Establish the Governed CodeIgniter Starter Foundation | done |
<!-- /planning:children -->

## Progress

[TASK-00001](../tasks/00001-TASK.md) preserves the original local/hosted verification and merged bootstrap evidence.