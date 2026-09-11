# WF-009 — React SPA Adaptation and Journeys

**Labels:** `wayfinder:prototype`
**Mode:** HITL
**Status:** Open
**Gate:** Immutable accepted Symfony client reference
**Map:** [CodeIgniter AccessControl Starter Application](../codeigniter-access-control-application-map.md)
**Depends on:** WF-005, WF-008

## Question

How should the completed Symfony AccessControl client be adapted into a portable CodeIgniter-owned React SPA
without importing Symfony runtime assumptions or weakening the settled security and authorization boundaries?

## Must decide

- Record the immutable accepted Symfony source reference and exact copy manifest, identify portable versus
  framework-specific seams, and define the one-time adoption/provenance procedure.
- Prototype source topology under `client/`, React and TypeScript boundaries, Dockerized ESBuild entrypoints and
  chunks, Sass ownership, static assets, development workflow, and deterministic `public/dist/*` output.
- Define in-memory access-token ownership, startup refresh, single-flight refresh, bounded request replay, logout,
  expiry, tab behavior, and navigation after auth-state changes; bearer tokens never enter browser storage.
- Define routing, authenticated and permission-aware layouts, loading/error/empty states, form validation,
  accessibility, responsive behavior, and CodeIgniter server fallback for client-side routes.
- Enumerate human journeys for login, invitation/activation, accounts and credentials, sessions, users, roles,
  permissions, grants, managed policy, and the human-relevant portion of Agent administration.
- Regenerate typed API-client bindings from CodeIgniter's own one-pass spec; define OpenAPI drift checks, private
  Mercure subscription/refetch behavior, frontend
  verification, and API/CLI-only machine/operator exclusions.
- Limit adaptations to environment/configuration and CodeIgniter-facing integration; require a source-drift review
  for substantive divergence from the accepted Symfony client.

## Resolution boundary

This ticket may use disposable prototypes after its local and external gates close. It may not create the
production client or compiled assets, copy an unfinished client, add package dependencies, create a shared
frontend runtime, or require decorative screens for machine/operator-only capabilities.

## Resolution

Open. Blocked by WF-005, WF-008, and the completed Symfony AccessControl client reference.
