# WF-002 — CodeIgniter Local Development Runtime Contract

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Frontier:** Current
**Gate:** Fight Agent OS proxy contract: ingress network, hostname conventions, and TLS ownership
**Map:** [CodeIgniter AccessControl Starter Application](../codeigniter-access-control-application-map.md)
**Depends on:** —

## Question

What local-development runtime contract makes the complete CodeIgniter starter understandable, healthy,
and persistent where intended, with one runtime per project behind the Fight Agent OS proxy?

The original concurrent-worktree runtime requirement is explicitly deferred to a future upgrade; it is not
part of this decision's current scope.

## Must decide

- Define the Compose services and responsibilities for Nginx, PHP-FPM, PHP-CLI workers, MySQL, Redis, Cron scheduling,
  private Mercure, Dockerized Node asset development, and one-shot maintenance commands.
- Define the `.env.example` contract, safe local defaults, secret placeholders, generated-key handling, and which
  values are shared by containers, browser tooling, wrappers, and host-facing documentation.
- Define startup ordering, health checks, readiness criteria, restart behavior, graceful shutdown, and
  operator-visible failure modes for each long-running service.
- Define host ports, internal networks, bind mounts, named volumes, persistence and cleanup policy, source and
  asset mounts, and cross-container ownership/permission behavior.
- Define clean-clone bootstrap and the contracts of `./bin/composer`, `./bin/phpunit`, `./bin/up`, `./bin/down`,
  `./bin/exec`, and `./bin/build` for one runtime per project. Defer special worktree containers, identities,
  hostnames, ports, and data isolation to a future upgrade.
- Separate local-development certification from production deployment, distribution, and availability claims.
- Keep Swagger UI and operational dashboards local-only by default and fail closed outside development.

## Resolution boundary

This ticket may settle the local Docker topology and operator contract without knowing the package API surface.
It may not add services, images, environment variables, volumes, runtime code, or wrappers. It does not select or
certify production infrastructure.

## Resolution

Open. The maintainer accepted the following policy checkpoint in the WF-002 interview and approved recording
it while keeping this decision open pending the external Fight Agent OS proxy contract. This remains the
current Wayfinder frontier, not an implementation authorization or a claim of runtime readiness.

### Accepted runtime policy

1. **Complete default startup.** `./bin/up` starts project Nginx, PHP-FPM, MySQL, Redis, PHP-CLI workers,
   Cron scheduling, and private Mercure together. Node's development server is opt-in; asset builds and
   maintenance commands run as one-shot containers.
2. **Shared proxy ingress.** A Fight Agent OS–owned Nginx proxy supplies project hostnames. Assume that it
   reaches project Nginx through a shared external Docker ingress network. Only project Nginx joins that
   shared network; application infrastructure stays on project-private networks. Publish no project host
   ports by default. Browser traffic, including API, private Mercure, and optional frontend development
   traffic, goes through the project's hostname and Nginx. Exact ingress-network naming, hostname conventions,
   and TLS ownership await the external proxy contract; no such contract is claimed implemented or verified.
3. **One runtime per project.** Worktree-specific containers, Compose identities, hostnames, and data isolation
   are deferred. The proposed checkout-path hash and per-worktree ingress aliases were not adopted. Git
   worktrees remain available for code isolation; concurrent isolated runtimes are not promised.
4. **Persistent data and explicit cleanup.** Ordinary `./bin/down` preserves local application data. MySQL data
   survives shutdown, and generated dependencies/assets survive container recreation. Deletion requires an
   explicit destructive operation, not ordinary shutdown. Redis durability depends on whether it owns
   disposable cache or durable queue state and remains with
   [WF-007](WF-007-async-scheduling-realtime-contract.md).
5. **Separate startup, setup, and verification.** `./bin/up` builds/starts containers and reports readiness or
   actionable failures. Dependency installation, migrations, key generation, and administrator bootstrap are
   explicit setup commands, never hidden startup side effects. `./bin/build` verifies an already-prepared
   environment without installing dependencies or repairing state.
6. **Explicit configuration and secrets.** A committed `.env.example` will document safe development defaults
   and clearly marked secret placeholders. Actual secrets and generated keys stay ignored by Git. A clean
   clone requires explicit secret setup before security-dependent services become ready; missing required
   secrets produce actionable errors rather than insecure fallbacks. Swagger UI and operational dashboards
   remain development-only and disabled outside development.
7. **Visible failures and graceful shutdown.** Use service-specific health checks and a bounded startup wait.
   Failure to reach required readiness returns nonzero, identifies unhealthy services, and explains how to
   inspect logs. Permit bounded retries for transient failures, not endless restart loops concealing bad
   configuration. Normal shutdown lets workers finish in-flight work within a documented grace period.
   Exact probes, thresholds, and timings require implementation verification.
8. **Containerized developer tooling.** Repository-owned wrappers are the supported entry points; no host PHP,
   Composer, or Node installation is required. FPM, workers, scheduling, and maintenance use a consistent PHP
   version and extension set. Bind-mount editable source, retain editable `client/` source and assets under
   `public/dist/`, and avoid root-owned generated files so host users can edit them.
9. **Deliberate image upgrades.** Retain the current PHP 8.5 baseline unless package qualification requires a
   change. Pin runtime images to reviewed versions/digests rather than floating `latest` tags. Image upgrades
   are deliberate, verified maintenance, not silent normal-startup changes. Select and verify exact versions
   for added services during implementation compatibility checks; none are qualified by this decision.

### Remaining gate and follow-up

- Obtain the Fight Agent OS proxy contract for ingress-network naming, hostname conventions, and TLS ownership;
  reconcile it with the accepted ingress assumptions before asking to close WF-002. Implementing that proxy
  is outside this repository's decision scope.
- Concrete image pins, environment variable names, mounts/ownership mechanics, clean-clone command sequence,
  readiness probes/timings, and destructive-cleanup syntax must be documented and verified in later authorized
  implementation. The accepted policies above constrain those details; this checkpoint does not invent them.
- Redis durability remains a downstream WF-007 decision, not an implied cache-only or durable-queue guarantee.
- Worktree-runtime isolation is explicitly excluded from the current handoff, not remaining WF-002 fog.
- No EPIC, requirement TICKET, implementation TASK, runtime configuration, dependency, wrapper, or service was
  created or changed by this interview. No runtime test, package qualification, or deployment readiness is
  claimed. The existing two-service Compose runtime is not evidence that this future policy is implemented.
