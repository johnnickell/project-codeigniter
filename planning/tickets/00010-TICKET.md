---
id: TICKET-00010
epic: EPIC-00002
title: Integrate the shared Pi skills and next-work conventions
status: ready-for-agent
---

# Integrate the shared Pi skills and next-work conventions

## Problem statement

The installed shared skills and native Pi already operate in this checkout, but harness runtime files are not
ignored and target substitutions are scattered. Shared workflows must preserve CodeIgniter rules, execution
authority and truthful routing without copying the provider suite or importing its product/runtime assumptions.

## Solution and boundaries

The 2026-10-24 adoption direction includes Pi and the bundled skill suite. Provide a concise target-owned binding
reachable from AGENTS.md: resolve installed provider resources from actual capability metadata/settings, retain
provider-relative shared instructions, and use target-owned planning, standards, runtime, gates and completion.
Do not hardcode private installation paths or require a repository-local `.pi/` copy. Absence of an optional
profile is not by itself a blocker.

Cover planning/research/design/inspection skill boundaries and the delivery path through work, independent
review, applicable QA and land. Explicit `/skill:build` delegates its defined work-through-PR coordination;
`./bin/build` is only the local quality command. `next` recommends and stops. Confirm capabilities before printing
commands; `next` and `build` being hidden from automatic model invocation is intentional, not missing installation.

Keep native Pi as the workflow-selection path. Document the retained `fight-terminal` RPC client's refusal of
`/skill:...` commands and its native-selection/resume procedure, rather than claiming full native parity. Native
Herdr workspace companions are not proof of implemented child/log observation. Require actual runtime capability
checks, not version equality or inherited provider test receipts.

Narrowly ignore `/var/terminal/` and, for the optional native workspace, `/var/herdr-workspace/`, preserving existing
files and checking for intentional tracked content first. Do not blanket-ignore application `var/` or delete
session/ownership evidence. `.runs/` remains the ignored canonical review/QA/task-evidence location; runtime
state is not implementation evidence.

## Use cases

| Use case | Commands | Queries | Events | Expected side effects |
|---|---|---|---|---|
| Contributor routes current work without starting it | N/A: no business command | Board, selected metadata, Wayfinder inventory and capability metadata | N/A | Read-only recommendation or precise owner/prerequisite handoff |
| Contributor explicitly invokes a shared workflow | N/A: workflow is not an application command | Target context and current independent evidence | N/A | Only the selected skill's authorized outputs in the chosen checkout |
| Operator uses Pi without committing runtime material | N/A | Git ignore/status and native harness diagnostics | N/A | Runtime paths ignored; operator state preserved |

## Validation and permissions

Keep checkout choice explicit. Git worktree isolation does not imply concurrent isolated runtimes; the current
Compose port/runtime and WF-002's deferred runtime-isolation decision remain authoritative. Bind checks/logs to
the actual checkout and owned runtime. Do not start or replace another TASK's services.

Jev screening is optional; native tools need no enrollment or provider request. Roles/discovery are not OS
isolation. No global installation/settings changes, role promotion, credential inspection, enrollment, paid
probe, dependency update, publication or release is authorized by this requirement. Package release and retired
certification assumptions remain non-applicable to this starter unless separately approved.

## Acceptance and evidence

- A short, linked binding makes framework, command, evidence/report, branch, completion, hosted-check and
  publication substitutions clear without duplicating the provider's whole suite.
- Normal `next` routing selects current active work or the first executable ready TASK; stale validation,
  unknown evidence and gated Wayfinder frontiers produce precise holds, not automatic repair/execution.
- Inspection confirms runtime paths are ignored and untracked runtime content is not staged or deleted.
- Direct instruction walkthroughs cover ready work, blocked WF-002, missing provider capability, investigation
  completion and review/QA/publication handoffs. Label walkthroughs separately from actual Pi integration probes.
- Run planning validation, diff check and canonical build; record native discovery/status observations and
  unavailable runtime/visual/child-workflow qualification honestly. No product tests of these instructions/tools.

## TASKs

<!-- planning:children -->
| ID | Title | Status |
|---|---|---|
| None | — | — |
<!-- /planning:children -->

## Decisions and progress

Requirement scope is approved through [TASK-00011](../tasks/00011-TASK.md)'s planning amendment; implementation
has not started. The next planning phase is `/skill:to-tasks TICKET-00010`, with a proposed bounded compatibility
slice combining runtime ignores, target binding, routing walkthroughs and documentation. Present that TASK
scope for acceptance before creating/executing it. This requirement is independent of package release research;
package-specific engineering policy still belongs to TICKET-00007/00009.
