# WF-010 — Implementation Handoff Acceptance Contract

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Gate:** Human approval of the handoff
**Map:** [CodeIgniter AccessControl Starter Application](../codeigniter-access-control-application-map.md)
**Depends on:** WF-002, WF-003, WF-004, WF-005, WF-006, WF-007, WF-008, WF-009

## Question

What evidence and planning handoff make a clean clone a complete, secure, documented, and independently
verifiable CodeIgniter reference starter rather than a collection of unproved components?

## Must decide

- Produce the eventual epic, coherent PRDs, independently verifiable vertical implementation tickets,
  dependency order, documentation impact, acceptance demonstrations, and explicit exclusions.
- Define exact production-code Unit coverage, meaningful Integration boundaries, limited high-value Functional
  and browser journeys, concurrency probes, negative security cases, and the boundary between behavioral tests
  and owning-tool verification.
- Define static analysis, architecture, formatting, migration, frontend, OpenAPI, dependency, secret-scan, and
  vulnerability gates, including honest handling of warnings, skips, and unavailable infrastructure.
- Define clean-clone setup, deterministic Compose boot, migrations, administrator bootstrap, worker/task/hub
  health, build, teardown, intended persistence, worktree isolation, and human UAT evidence.
- Define complete documentation for environment variables, URLs, credentials/bootstrap, API/OpenAPI, workers,
  schedules, failures, Mercure subscriptions, SPA development, troubleshooting, and safe cleanup.
- Define security acceptance for tokens, cookies, origin/CSRF, principals, authorization, enumeration,
  throttling, secrets, audit, retries/replay, Mercure subscriptions, and package dependency boundaries.
- Define the repository-owned `./bin/build` acceptance role while keeping release, publication, deployment, and
  production-readiness qualification separate.
- Require one valid checked-in CodeIgniter-generated OpenAPI document and rendered local Swagger UI, normalized
  Symfony parity, generated-client compilation, unauthorized operation/private-subscription rejection, refresh
  rotation/reuse, invitation-led bootstrap, queue/outbox recovery, scheduler overlap, client-source drift, and
  failure-recovery journeys.

## Resolution boundary

This ticket may settle and link the implementation handoff. It may not implement runtime behavior, commit
generated runtime evidence, publish, release, deploy, or archive this map as a completion side effect.

## Resolution

Open. Blocked by WF-002 through WF-009.
