# WF-004 — MySQL Persistence and Bootstrap Contract

**Labels:** `wayfinder:prototype`
**Mode:** HITL
**Status:** Open
**Gate:** —
**Map:** [CodeIgniter AccessControl Starter Application](../codeigniter-access-control-application-map.md)
**Depends on:** WF-001, WF-002

## Question

How should this project own CodeIgniter-native MySQL persistence and initial administration while preserving
package semantics, transactional integrity, concurrency safety, audit history, and repeatable local setup?

## Must decide

- Prototype project-owned records and repositories with CodeIgniter Models, Query Builder, or a justified mix,
  including type conversion, indexes, and service composition for every released persistence port.
- Define transaction ownership, isolation, compare-and-save or locking behavior, unique-conflict handling,
  rollback guarantees, and atomic audit persistence.
- Define managed-policy reconciliation ownership, convergence, conflict behavior, safe deletion boundaries, and
  its relationship to authored roles, permissions, and grants.
- Define CodeIgniter migration authority and ordering, clean-clone database bootstrap, isolated test databases,
  fixtures, schema verification, and recovery from interrupted or failed migrations.
- Define an idempotent Spark administrator bootstrap that is invitation-led, auditable, explicitly configurable,
  safe to retry, and never exposed as a public first-user route.

## Resolution boundary

This ticket may use disposable MySQL prototypes against the WF-002 topology. It may not add repositories, Models,
migrations, tables, bootstrap commands, or seed data, and it may not reproduce package-owned Domain or
Application behavior.

## Resolution

Open. Blocked by WF-001 and WF-002.
