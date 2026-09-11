# WF-008 — Complete API and CLI Operation Matrix

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Gate:** Symfony operation matrix
**Map:** [CodeIgniter AccessControl Starter Application](../codeigniter-access-control-application-map.md)
**Depends on:** WF-003, WF-005, WF-006, WF-007

## Question

How does the starter account for every public AccessControl command, query, and service across HTTP, Spark CLI,
worker, composition-only, or deliberately unsupported boundaries?

## Must decide

- Reconcile every item in the WF-001 inventory, including authentication, invitation, activation, account,
  credential, user, role, permission, grant, session, managed-policy, Agent, notification, audit, transaction, and
  publication operations.
- For every HTTP operation, define method and `/api/v1` path, inputs, output envelope, success/error status,
  authentication, authorization, audit outcome, and information-disclosure boundary.
- For every CLI, worker, or composition-only operation, define its CodeIgniter-owned entry point, actor,
  preconditions, result/failure contract, observability, and why HTTP exposure is inappropriate.
- Define idempotency, concurrency, conditional updates, pagination, filtering, sorting, stable cursors, limits,
  throttling, and asynchronous acceptance where applicable.
- Mark every released capability as accounted for or deliberately unsupported with a reason and owning decision;
  do not equate complete coverage with a screen or HTTP route for every capability.
- Map human operations to SPA journeys and define operation IDs and schema ownership so the OpenAPI artifact is
  complete and mechanically reviewable.
- Map each HTTP row to a CodeIgniter Action/Responder pair, Fight Common CQRS dispatch, package command/query or
  synchronous security service, transaction owner, audit effect, and post-commit side effects.
- Record denied, unauthenticated, invalid, missing, conflicting, expired, revoked, replayed, throttled, and concurrent
  outcomes wherever they can occur.

## Resolution boundary

This ticket may settle the complete interface matrix. It may not implement routes, Spark commands, jobs, schemas,
or screens, and it may not expose package internals merely to claim completeness.

## Resolution

Open. Blocked by WF-003, WF-005, WF-006, and WF-007.
