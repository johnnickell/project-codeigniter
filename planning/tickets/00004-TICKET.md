---
id: TICKET-00004
epic: EPIC-00002
title: Retire recurring framework-support certification
status: done
---

# Retire recurring framework-support certification

## Problem statement

Receipt machinery, dependency-lane certification, and tests of verifiers distract from application and important
consumer integration behavior. The maintainer explicitly approved retiring that obligation rather than moving
its tests elsewhere.

## Solution and boundaries

Remove recurring receipt generation/validation and lowest/latest certification, keep dependency preparation
outside `./bin/build`, and retain meaningful behavior and direct safe runtime checks. Preserve CodeIgniter-native
layout/discovery and the application Composer manifest/lock. This requirement does not upgrade packages or
introduce new coverage/static-analysis policy.

## Use cases and validation

The developer prepares dependencies explicitly and runs the same canonical gate locally and in CI. Commands
are repository tools, not business messages; queries/events and new runtime permissions are N/A. Invalid metadata
or failed behavior still fails the gate. Do not add fake Composer fixtures or tests of gate scripts.

## Acceptance and evidence

No active receipt/lane pipeline or verifier-only tests remain; home, transaction, queue, and important provider
integration evidence remains. The gate does not install/update dependencies. Historical certification is clearly
superseded rather than rewritten as a current result.

## TASKs

<!-- planning:children -->
| ID | Title | Status |
|---|---|---|
| [TASK-00007](../tasks/00007-TASK.md) | Retire Framework Support Certification | done |
<!-- /planning:children -->

## Decisions and progress

[TASK-00007](../tasks/00007-TASK.md) delivered this approved slice in commit `2699ceb`: local gate green with
13 tests / 69 assertions. Its independent review and hosted verification remain pending. `done` does not mean
merged, released, or broader Agent OS adoption completed.
