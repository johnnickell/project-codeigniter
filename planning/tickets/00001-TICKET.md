---
id: T-00001
prd: PRD-00001
title: Establish the Governed CodeIgniter Starter Foundation
status: done
blocked_by:
---

# Establish the Governed CodeIgniter Starter Foundation

## Outcome

Repository-local planning, architecture, triage, and public-source guidance are canonical. Docker-backed Composer, PHPUnit, lifecycle, exec, and Spark wrappers exist. `./bin/build` validates governance and the hello-world foundation; hosted CI invokes that exact command for push and pull-request events on `develop`, `main`, and `release/**`.

## Scope

- In scope: local planning authority, Docker-backed tooling, `./bin/build` gate, hosted CI, MIT/CONTRIBUTING/SECURITY policies.
- Out of scope: login, persistence, browser UAT, client, realtime, release, tag, Packagist publication, template enablement, create-project distribution.

## Acceptance Criteria

- [x] Repository-local planning, architecture, triage, and public-source guidance are canonical.
- [x] Docker-backed Composer, PHPUnit, lifecycle, exec, and Spark wrappers exist.
- [x] `./bin/build` validates governance and the hello-world foundation; hosted CI invokes that exact command.
- [x] MIT, contribution, and security policies are present.

## Verification

- `./bin/build` passes locally and in hosted CI.

## Bootstrap receipt

`johnnickell/project-codeigniter` is public source. Foundation commit
`fadb34e245007f159085ab40cc75b6810e700010` supplies the canonical local planning, native CodeIgniter
composition, and production-install verification. The canonical `./bin/build` passed from an independent clean
clone at that commit on 2026-08-19, including governance, six PHPUnit tests with nine assertions, and the
production Composer public-dependency contract. Hosted [Build run 32234095998](https://github.com/johnnickell/project-codeigniter/actions/runs/32234095998)
passed on the `develop` merge commit; [project-codeigniter PR #1](https://github.com/johnnickell/project-codeigniter/pull/1)
records the merged handoff. This bootstrap does not authorize a release tag, Packagist publication, template
enablement, or create-project distribution.

## Completion Notes

Local and hosted `./bin/build` receipts are green. The governed bootstrap handoff is accepted.