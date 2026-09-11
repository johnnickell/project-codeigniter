# WF-006 — Principal and Authorization Mapping

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Gate:** —
**Map:** [CodeIgniter AccessControl Starter Application](../codeigniter-access-control-application-map.md)
**Depends on:** WF-001, WF-004, WF-005

## Question

How do the released authorization capabilities map to distinct request-scoped User and Agent principals in
CodeIgniter without leaking authorization state across requests or long-running workers?

## Must decide

- Define distinct authenticated User and Agent principal shapes, credential purposes, lifecycle states, session
  relationships, resolution rules, and denial behavior.
- Map roles, permissions, direct and inherited grants, managed policy, resource context, and package decisions to
  CodeIgniter filters and authorization services without duplicating policy logic.
- Define administrator, self-service, support/operator, and machine-agent boundaries, including who may create,
  inspect, modify, grant, revoke, rotate, or impersonate each principal type.
- Define route-level and Application-operation enforcement so controllers are not the sole security boundary and
  Spark commands, queue jobs, scheduled tasks, and workers cannot bypass authorization.
- Define default-deny behavior, request-local caching, invalidation, immediate revocation visibility, audit
  requirements, and explicit state reset for reusable worker processes.

## Resolution boundary

This ticket may settle principal translation and authorization composition. It may not invent package roles or
permissions, implement filters or endpoints, require UI for machine/operator workflows, or reopen authentication
mechanics owned by WF-005.

## Resolution

Open. Blocked by WF-001, WF-004, and WF-005.
