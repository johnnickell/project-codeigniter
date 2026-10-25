# Shared Pi workflow binding

Apply this binding when a shared skill operates on this repository. The skill's installation is the **provider**;
this checkout is the **target**. Local [AGENTS.md](../../AGENTS.md), [architecture](../../ARCHITECTURE.md) and
[planning conventions](../CONVENTIONS.md) prevail over provider application examples.

## Resolve capabilities, not installation guesses

Use the actual skill name/description/location supplied in the session. Read the selected `SKILL.md` and resolve
its links relative to that resource, including its project-context and engineering references; apply this binding
through nested references. `pi list` reports configured packages, not every loaded skill or working capability.
If necessary, inspect only resource declarations/filters in the effective Pi settings (agent directory, optionally
`PI_CODING_AGENT_DIR`, and trusted project settings); relative paths resolve from their settings directory.
Never inspect authentication files. No target `.pi/` directory, copied suite, symlink or private installation path
is required. Missing optional profiles are not blockers. Hidden automatic invocation of `next`/`build` is intentional;
confirm their explicit commands from installed metadata rather than declaring them absent from the model's catalog.

If a required skill, reference or runtime API is unavailable or ambiguous, stop that action and name the missing
resource and operator/provider owner. Do not guess a command, install/update resources, edit global settings,
enroll, access credentials or make a paid probe to resolve it. Discovery, matching versions and provider receipts
are not target runtime qualification.

## Target substitutions and boundaries

| Shared concern | CodeIgniter authority |
|---|---|
| Framework and packages | `App\\` stays in `app/`; CodeIgniter owns config/services, HTTP/routes/controllers/views, Spark and future adapters. Fight packages remain public Composer dependencies. Do not import provider `src/`, Slim, database, frontend or container examples. |
| Planning and selection | EPIC → TICKET → TASK; records own state. [Board](../tasks/BOARD.md) selects execution; [Roadmap](../ROADMAP.md#current-decomposition-handoffs) owns planning handoffs. `next` follows [lightweight routing](../CONVENTIONS.md#lightweight-work-routing): read-only validator, all active work or first executable ready TASK, recommend and stop. Stale validation is a planning-owner hold, never automatic `--write`. `done` is not independent acceptance. |
| Uncertain/planning work | Wayfinder owns unresolved decisions; grill writes an approved EPIC only, then accepted TICKET and TASK decomposition are separate. Research supplies cited evidence to its owner; design/prototype are disposable, design-review challenges that evidence. Inspection/adopt/audit/architecture/security-audit are not repair authority; fix diagnoses and prepares a bug TASK for human acceptance before work. Graph queries are read-only; refresh requires explicit scope. No scope expansion or production implementation follows from these artifacts. |
| Runtime and commands | Use target `./bin/up`, `./bin/down`, `./bin/composer`, `./bin/exec`, `./bin/phpunit`, `./bin/build`. Prepare explicitly; build does not install/update. Check Compose project, source mounts and port ownership before startup. Git isolation is not runtime isolation. [WF-002](../wayfinder/tickets/WF-002-codeigniter-local-development-runtime-contract.md) remains gated on the external proxy contract; do not implement it or infer availability. |
| Checkout and branch | Ask current checkout versus isolated worktree unless already chosen. New `feature/task-NNNNN-<slug>` branches start at `develop`; never commit to `develop`/`main`. Preserve established branches/unrelated work. Worktrees: `.runs/worktrees/`; extra scratch: `.runs/<YYYY-MM-DD>-<slug>/`. |
| Canonical evidence | Resolve the base worktree through Git common-directory/registered-worktree metadata. Provider report schemas apply at `<base>/.runs/reviews/<TASK-ID>/review.md` and `<base>/.runs/qa/<TASK-ID>/qa.md`; only the independent owners write them. Engineer evidence: `.runs/tasks/<TASK-ID>/runs/`; Build coordination: `.runs/build/<TASK-ID>/`. Unknown/stale report subjects need evidence-owner reconciliation, not inferred acceptance or repairs. Runtime/session state is not a report. |
| Completion and gates | Target `done` means accepted-scope implementation plus required local verification, not self-issued independent acceptance. Record warnings/limits and pending Review/QA/delivery separately. Apply [automatic parent completion](../CONVENTIONS.md#automatic-parent-completion) in the same operation; refresh views, validate read-only, inspect frontiers and diff. `./bin/build` is mandatory before every commit/PR. Hosted checks are optional unless explicitly required by accepted TASK/policy. Test product behavior, not these instructions/tools; validate them directly. |
| Delivery and authority | Work commits, then independent Review; accepted changed behavior needs applicable independent QA (including executable instructions), then Land within publication authority. A skill is not permission. Explicit `/skill:build` delegates its defined coordination through work, fresh Review, QA and Land to an open PR; stage roles remain narrower. `./bin/build` only runs local checks. Recommending either does not invoke it. No automatic push, PR, merge, release, deploy, enrollment or archive follows from `next`, a gate, or TASK closure. |

Investigation completion can close its narrowed parent, not unfinished adoption. Preserve TICKET-00008/00009's
maintainer decisions and EPIC-00002's `needs-info` state; TASK-00005 remains reserved. Review findings return to
work; missing QA prerequisites go to evidence recovery. Accepted work with QA satisfied routes to authorized Land;
missing publication authority goes to the human. Required-hosted-only evidence and administrative-closeout cases
follow the provider's handoff/landing definitions with target semantics, not invented implementation changes.

## Native Pi and retained workspace

Select `/skill:<name>` interactively in native Pi after confirming availability; carry the chosen TASK/checkout
using the selected skill's documented arguments. The operator/trusted launcher selects workflow authority; a model
or RPC prompt cannot promote itself. Inspect `/file-screening` (or the available `file_screening_status` tool):
`workflow.skill/effect/taskId/checkout/mode` identify selection; `phase` alone does not (`build` uses `qa` phase).
Jev is optional; native tools require neither enrollment nor a provider request. Roles and discovery are not
OS isolation. Keep configured model identity separate from any actually reported execution identity.

The retained `fight-terminal` RPC client refuses **every** `/skill:...` and `/file-screening` input locally,
even if discovered. For an existing persistent session: exit it with Ctrl+Q, open `pi --session PATH` in the same
checkout using its displayed exact session path, select the intended workflow in native Pi and verify
`/file-screening`, exit native Pi, then `fight-terminal --session PATH`. Do not fork/clone, copy launcher flags or
relaunch children. Resume alone does not select authority; an in-memory session cannot resume. If the command is
not installed, name that operator prerequisite rather than installing it. Retain session, ownership and accounting
state. Follow the actual installed provider's `harness/pi/WORKSPACE.md` and `README.md` resolved from its resources
for supported options/recovery; do not infer full native parity from RPC command discovery.

Optional native Herdr `/fight-workspace` companions need actual supported context/APIs and ownership proof.
The provider currently describes a child-observation candidate and a placeholder log companion, not implemented
native Docker-log observation. Retained RPC child/log readers have separate admission/source-binding contracts.
Do not claim this checkout's children, logs, visual behavior or native-selection/resume were observed unless
actually probed safely. Missing observation leaves ordinary Pi usable; no automatic RPC fallback or runtime startup.

`/var/terminal/` and `/var/herdr-workspace/` are ignored operator/runtime state; unrelated application `var/` is
not blanket-ignored. Preserve existing files and inspect ignores/status/staged paths before committing.
Label source walkthroughs, actual discovery/status observations and live probes separately; record unavailable
qualifications without turning inherited receipts into target acceptance.
