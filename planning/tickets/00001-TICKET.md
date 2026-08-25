---
id: T-00001
parent: PRD-00001
title: Establish the Governed CodeIgniter Starter Foundation
status: done
---

# Establish the Governed CodeIgniter Starter Foundation

## Acceptance

- Repository-local planning, architecture, triage, and public-source guidance are canonical.
- Docker-backed Composer, PHPUnit, lifecycle, exec, and Spark wrappers exist.
- `./bin/build` validates governance and the hello-world foundation; hosted CI invokes that exact command for push and pull-request events on `develop`, `main`, and `release/**`.
- MIT, contribution, and security policies are present.

## Exclusions

No login, persistence, browser UAT, client, realtime, release, tag, Packagist publication, template enablement, or create-project distribution is included.

## Bootstrap receipt

`johnnickell/project-codeigniter` is public source. Foundation commit
`fadb34e245007f159085ab40cc75b6810e700010` supplies the canonical local planning, native CodeIgniter
composition, and production-install verification. The canonical `./bin/build` passed from an independent clean
clone at that commit on 2026-08-19, including governance, six PHPUnit tests with nine assertions, and the
production Composer public-dependency contract. Hosted [Build run 32234095998](https://github.com/johnnickell/project-codeigniter/actions/runs/32234095998)
passed on the `develop` merge commit; [project-codeigniter PR #1](https://github.com/johnnickell/project-codeigniter/pull/1)
records the merged handoff. This bootstrap does not authorize a release tag, Packagist publication, template
enablement, or create-project distribution.
