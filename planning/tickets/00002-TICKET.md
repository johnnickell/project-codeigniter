---
id: T-00002
prd: PRD-00002
title: Adopt Fight Common 1.2
status: done
blocked_by: T-00004
---

# Adopt Fight Common 1.2

## Outcome

Resolve the immutable 1.2 candidate through CodeIgniter's Composer installation, boot the complete default
profile in lowest/latest lanes, and commit an authority-validated canonical support receipt.

## Acceptance Criteria

- [x] The preliminary profile foundation from T-00004 is completed by the receipt-certified default profile,
  pinned as `dev-develop#4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16 as 1.2.0-dev`; Composer locks the package as
  `dev-develop` at that exact reference.
- [x] Lowest/latest journeys boot the selected service delegates, database Queue command/event delivery,
  transactions, response/routing, and provider-backed fallbacks.
- [x] `evidence/framework-support/receipt-v1.json` records the actual latest lock SHA-256
  `81ef00c77c057ae6921cbcffb3619e9fa1aeb80399137395d55ca48118307ba9` and lowest lock SHA-256
  `dd85773a8e0f97cf64ed501ce9388e4708b9ff7ecddbed6a1171017eaeac653e`, with canonical content and receipt
  hashes, passed journeys, and no next action.
- [x] The exact candidate's installed `StarterSupportReceiptAuthority`, `./bin/planning-check`, and
  `./bin/build` validate the committed receipt.

## Verification

Verified through `php scripts/verify-framework-support-lanes.php`,
`php scripts/generate-framework-support-receipt.php`,
`php scripts/verify-framework-support-receipt.php`, `./bin/planning-check`, and `./bin/build`.
