# WF-003 — ADR HTTP and OpenAPI Contract

**Labels:** `wayfinder:prototype`
**Mode:** HITL
**Status:** Open
**Gate:** Symfony canonical wire contract
**Map:** [CodeIgniter AccessControl Starter Application](../codeigniter-access-control-application-map.md)
**Depends on:** WF-001

## Question

Which CodeIgniter-native request/response composition proves a consistent ADR API while preserving the released
package contracts and making attribute-generated OpenAPI mechanically trustworthy?

## Must decide

- Prototype controller-compatible invokable Action services, Application delegation, and separate Responders
  without moving CodeIgniter types across the Adapter boundary.
- Define request DTO construction, validation, normalization, unknown-field handling, content negotiation, and
  stable response-envelope rules using framework-native seams where they fit.
- Define `/api/v1`, route naming, status semantics, exception-to-problem mapping, correlation metadata, and safe
  error disclosure.
- Generate exactly one CodeIgniter-owned OpenAPI 3.1 document in one pass from installed Fight AccessControl
  `resources/openapi/` components plus Actions, request/response DTOs, routes, security declarations, and local
  components; never generate and merge separate specs.
- Own the generator command, checked-in artifact, Swagger UI, servers, tags, paths, operations, security schemes,
  status codes, framework errors, and drift check while matching Symfony's client-facing contract.
- Establish how authentication, authorization, pagination, idempotency, throttling, and asynchronous acceptance
  are represented consistently before WF-008 enumerates operations.

## Resolution boundary

This ticket may use disposable prototypes to settle the HTTP architecture and OpenAPI authority. It may not
implement production routes, choose persistence details, or claim an operation exists before WF-001 finds its
released contract and WF-008 assigns its supported boundary.

## Resolution

Open. Blocked by WF-001.
