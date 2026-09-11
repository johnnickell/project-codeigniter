# WF-002 — CodeIgniter Local Development Runtime Contract

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Frontier:** Current
**Gate:** —
**Map:** [CodeIgniter AccessControl Starter Application](../codeigniter-access-control-application-map.md)
**Depends on:** —

## Question

What local-development runtime contract makes the complete CodeIgniter starter understandable, healthy,
persistent where intended, and safe to run concurrently from isolated worktrees?

## Must decide

- Define the Compose services and responsibilities for Nginx, PHP-FPM, PHP-CLI workers, MySQL, Redis, Cron scheduling,
  private Mercure, Dockerized Node asset development, and one-shot maintenance commands.
- Define the `.env.example` contract, safe local defaults, secret placeholders, generated-key handling, and which
  values are shared by containers, browser tooling, wrappers, and host-facing documentation.
- Define startup ordering, health checks, readiness criteria, restart behavior, graceful shutdown, and
  operator-visible failure modes for each long-running service.
- Define host ports, internal networks, bind mounts, named volumes, persistence and cleanup policy, source and
  asset mounts, and cross-container ownership/permission behavior.
- Define deterministic Compose project naming, per-worktree ports and volumes, clean-clone bootstrap, and the
  contracts of `./bin/composer`, `./bin/phpunit`, `./bin/up`, `./bin/down`, `./bin/exec`, and `./bin/build`.
- Separate local-development certification from production deployment, distribution, and availability claims.
- Keep Swagger UI and operational dashboards local-only by default and fail closed outside development.

## Resolution boundary

This ticket may settle the local Docker topology and operator contract without knowing the package API surface.
It may not add services, images, environment variables, volumes, runtime code, or wrappers. It does not select or
certify production infrastructure.

## Resolution

Open. This is the current Wayfinder frontier.
