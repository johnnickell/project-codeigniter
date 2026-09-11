# WF-007 — Async, Scheduling, and Realtime Contract

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Gate:** Symfony realtime contract
**Map:** [CodeIgniter AccessControl Starter Application](../codeigniter-access-control-application-map.md)
**Depends on:** WF-002, WF-004, WF-005, WF-006

## Question

What reliable local contract connects committed AccessControl work to Redis Queue workers, CodeIgniter Tasks,
mail delivery, and authorized private Mercure SSE topics?

## Must decide

- Define Redis Queue routing, serialization/versioning, consumer identity, concurrency, acknowledgement,
  retry/backoff, failed-job retention, replay, poison-message handling, and operator-facing Spark commands.
- Define transaction-to-dispatch ordering and whether a durable handoff is required so rolled-back work is never
  delivered and failed publication remains recoverable without overstating Redis guarantees.
- Require a transactional outbox or equivalently durable post-commit handoff so committed state cannot be silently
  lost before Redis/Mercure publication.
- Define CodeIgniter Tasks schedules, cadence and timezone authority, overlap prevention, missed-run behavior,
  worker or cron execution, graceful shutdown, and observable failure semantics.
- Classify mail and other external delivery as synchronous or asynchronous, with retry safety, idempotency,
  correlation, credential custody, and test seams.
- Define Mercure hub composition, versioned allowlisted envelopes, private topic naming, subscription
  authorization, reconnection, last-event behavior, and authoritative client refetch.
- Define which released package events are external, internal-only, coalesced, or deliberately absent from
  realtime delivery, and how every path behaves after transaction commit.
- Carry only minimal invalidation data on authorized private topics, reject unauthorized subscription, and require
  authoritative API refetch.

## Resolution boundary

This ticket settles async, scheduling, mail, and realtime contracts for local development. It may not install or
configure queue/task packages, run workers, create schedules, send mail, publish events, or make production
durability and availability claims.

## Resolution

Open. Blocked by WF-002, WF-004, WF-005, and WF-006 so realtime follows settled authentication and authorization.
