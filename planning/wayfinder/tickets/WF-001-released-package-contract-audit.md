# WF-001 — Released Package Contract Audit

**Labels:** `wayfinder:research`
**Mode:** AFK
**Status:** Open
**Gate:** Installable Fight Common v1.2.0 and Fight AccessControl v0.2.0 release tags
**Map:** [CodeIgniter AccessControl Starter Application](../codeigniter-access-control-application-map.md)
**Depends on:** —

## Question

What complete public contract do the requested released package versions expose, and which capabilities belong at
an HTTP, CLI, worker, or composition-only boundary in this CodeIgniter starter?

## Must decide

- Audit installed release artifacts, public documentation, and exported symbols without treating package
  internals, development revisions, or another starter's interpretation as consumer authority.
- Inventory every public authentication, account lifecycle, user, role, permission, grant, session,
  managed-policy, Agent, notification, audit, transaction, and publication capability.
- Record every public command, query, service, port, value object, event, result, error, and semantic guarantee
  that downstream CodeIgniter adapters must preserve.
- Classify each capability as HTTP, CLI, worker, composition-only, or deliberately unsupported, with an explicit
  reason for any unsupported surface.
- Identify package-version compatibility constraints and genuine omissions without inventing project-owned
  Domain or Application behavior to fill them.

## Resolution boundary

This ticket may settle the authoritative released consumer surface and its initial boundary classification. It
may not choose CodeIgniter routes, Spark commands, persistence mappings, filters, queue topology, UI coverage, or
implementation tickets. It cannot close from a branch, alias, candidate commit, unpublished tree, or inferred
future release contents.

## Resolution

Open. Begin only after both requested release tags are installable.
