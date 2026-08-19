---
id: T-00001
parent: PRD-00001
title: Establish the Governed CodeIgniter Starter Foundation
status: in-review
---

# Establish the Governed CodeIgniter Starter Foundation

## Acceptance

- Repository-local planning, architecture, triage, and public-source guidance are canonical.
- Docker-backed Composer, PHPUnit, lifecycle, exec, and Spark wrappers exist.
- `./bin/build` validates governance and the hello-world foundation; hosted CI invokes that exact command for push and pull-request events on `develop`, `main`, and `release/**`.
- MIT, contribution, and security policies are present.

## Exclusions

No login, persistence, browser UAT, client, realtime, release, tag, Packagist publication, template enablement, or create-project distribution is included.
