---
id: T-00002
prd: PRD-00002
title: Adopt Fight Common 1.2
status: ready-for-agent
blocked_by: T-00004
---

# Adopt Fight Common 1.2

## Outcome

Resolve a 1.2 candidate through CodeIgniter's Composer installation, activate only supported local capabilities,
run lowest/latest booted journeys, and commit the canonical support receipt.

## Acceptance Criteria

- [ ] The CodeIgniter Complete Platform Profile (T-00004) is complete and its pinned candidate is recorded.
- [ ] Lowest/latest journeys boot selected service delegates, queued messages, transactions, response/routing, and selected adapters.
- [ ] `evidence/framework-support/receipt-v1.json`, `./bin/planning-check`, and `./bin/build` pass before receipt commit.

## Verification

Run documented lowest/latest Composer and booted journeys, receipt canonicalization, `./bin/planning-check`, and `./bin/build`.
