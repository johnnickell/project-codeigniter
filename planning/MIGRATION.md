# EPIC → TICKET → TASK migration

Approved by the maintainer and implemented under [TASK-00008](tasks/00008-TASK.md), starting from repository
revision `2699ceb` on 2026-09-27. Planning is the first adoption priority; the migration grants no dependency,
production behavior, release, or deployment changes.

## Identity map

The old `T-` records were executable work, so they become TASKs, not new requirement TICKETs. PRDs were requirements,
so they become TICKETs. Numbers and gaps are preserved within their new independent sequences. `legacy_id`
metadata and this table preserve provenance; old Git revisions retain the original paths and bytes.

| Former identity/path | Canonical record | Current parent / disposition |
|---|---|---|
| PRD-00001 · `specs/00001-PRD.md` | [TICKET-00001](tickets/00001-TICKET.md) | EPIC-00001; completed foundation requirement |
| PRD-00002 · `specs/00002-PRD.md` | [TICKET-00002](tickets/00002-TICKET.md) | EPIC-00001; completed candidate integration, not current stable adoption |
| T-00001 · `tickets/00001-TICKET.md` | [TASK-00001](tasks/00001-TASK.md) | TICKET-00001; done, historical verification preserved |
| T-00002 · `tickets/00002-TICKET.md` | [TASK-00002](tasks/00002-TASK.md) | TICKET-00002; done; completed blocker edge to TASK-00004 retained |
| T-00003 · `tickets/00003-TICKET.md` | [TASK-00003](tasks/00003-TASK.md) | Separated into TICKET-00003; still needs-info for Common 2.0 |
| T-00004 · `tickets/00004-TICKET.md` | [TASK-00004](tasks/00004-TASK.md) | TICKET-00002; done, service-profile evidence preserved |
| T-00005 in a separate unmerged worktree | TASK-00005 reserved; no canonical live record imported | Worktree untouched; scope/status/certification assumptions need explicit reconciliation |
| T-00006 · `tickets/00006-TICKET.md` | [TASK-00006](tasks/00006-TASK.md) | TICKET-00002; done, historical re-certification preserved |
| T-00007 from `2699ceb` · `tickets/00007-TICKET.md` | [TASK-00007](tasks/00007-TASK.md) | Reparented to TICKET-00004; approved retirement, local implementation done, review pending |
| `tickets/BOARD.md` | [TASK Board](tasks/BOARD.md) | Generated from TASK metadata, not a hand-maintained frontier |

Historical bodies retain old IDs/terms where they describe the original decision or verification. Their migration
notes point here; those names are not active metadata or a second planning system. In particular, TASK-00007's
original note that no EPIC existed describes its pre-migration completion, not the new hierarchy.

Some old executable-ticket filenames are now occupied by requirement TICKETs in the independent sequence. Use
the explicit old-ID mapping above—not an old path alone—to resolve historical references. Current repository
links are migrated; external links must use their historical Git revision or the mapped canonical TASK.

## Later upstream reconciliation

Upstream `91734b8` independently used legacy T-00007 for a lean quality-gate handoff. It is **not** retirement
TASK-00007. Its original identity/status and complete requirement disposition are preserved in
[UPSTREAM-RECONCILIATION.md](UPSTREAM-RECONCILIATION.md), under TICKET-00007/TASK-00010 for pending decisions.
The user authorized that reconciliation for publication after this migration; no incoming requirements were
silently marked complete. The upstream dependency lock is preserved, not qualified as stable adoption.

## Current hierarchy

- [EPIC-00001 — Governed starter and package integration](epics/00001-EPIC.md)
  - TICKET-00001 → TASK-00001: foundation, done.
  - TICKET-00002 → TASK-00002, TASK-00004, TASK-00006: historical candidate integration, done.
  - TICKET-00003 → TASK-00003: future Common 2.0 authority, needs-info.
- [EPIC-00002 — Fight packages and Agent OS conventions adoption](epics/00002-EPIC.md)
  - TICKET-00004 → TASK-00007: approved certification retirement, implemented; review pending.
  - TICKET-00005 → TASK-00008: approved first-priority planning migration.
  - TICKET-00006 → TASK-00009: qualification scope/creation approved; execution not started, requirement needs-info.
  - TICKET-00007 → TASK-00010: engineering proposal scope/creation approved; waiting on TASK-00009, requirement needs-info.

These relationships are recorded in frontmatter and projected into generated tables. This explanatory map does
not replace record-owned status or authorize the unqualified requirements.

## Preserved and deliberately changed

- Existing record statuses and historical evidence are preserved; unfinished work is not marked done by migration.
- New parent EPICs classify existing/declared work, not invented approvals. TICKET-00003 separates a deferred
  requirement from the completed candidate integration; TICKET-00004 puts retirement under the adoption EPIC.
- No package manifest/lock, CodeIgniter runtime layout/discovery, or application behavior changes in this slice.
- The old PRD layer and executable T-ticket convention are retired, not maintained as duplicate writable records.
- No archive operation is run. Empty archive indexes support future explicit operations only.
- Wayfinder map/decision identities, open statuses, evidence gates, and WF-002 frontier are preserved. Dependencies
  become explicit links and tables become generated. Its older v0.2.0 target needs a later deliberate decision.
- The remaining adoption destination is tracked, not certified: the installed development candidates are unchanged.

## Guidance/tooling baseline

Fight Agent OS `a39bfc3b24ee1d7e8b782d0713b06c34ca544c6d`: planning conventions, templates, generated views, and
explicit-only archive semantics. See [SOURCE-NOTICE.md](SOURCE-NOTICE.md) for provenance and the retained license.
The hierarchy/tools are adapted; no source-project product planning, IDs, approvals, or runtime policy is imported.
