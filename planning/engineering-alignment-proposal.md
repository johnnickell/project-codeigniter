# CodeIgniter engineering alignment — proposal

**2026-10-24 · TASK-00010 · historical proposal, not implemented enforcement.**

## Current decision overlay

The maintainer subsequently accepted the engineering direction in
[TICKET-00009's decision record](tickets/00009-TICKET.md#maintainer-decision--recorded-2026-10-24):
run the complete suite exactly once, collect coverage in that run and aim for 100% meaningful owned-behavior
coverage, primarily from units with integration contribution allowed. Keep CodeIgniter native. Use Fight Common's
PHPCS standard, Deptrac, PHPStan and Rector, and inventory/adapt Fight Agent OS's existing and planned checks.
Build on the already implemented package baseline and shared binding rather than redo them.

That decision supersedes this proposal's unresolved coverage choice and acceptance questions. In particular,
exact Unit-only 100% and a separate hard Domain/Application-only threshold are not the selected policy. Concrete
versions, driver, analysis settings and exceptions below remain recommendations to qualify, not individually
approved facts. The maintainer subsequently approved
[TASK-00015/00016/00017](tickets/00009-TICKET.md#approved-task-decomposition), now written for coding checks,
single-run coverage and complete read-only orchestration respectively. Implementation has not started; select
execution through the TASK Board. The original proposal below is retained as evidence of its original scope and
recommendations.

Read this with [TICKET-00009](tickets/00009-TICKET.md)'s current engineering contract, not as permission to
change code or install tools. At proposal delivery, adoption by default was approved but concrete choices awaited
maintainer acceptance. [TICKET-00007](tickets/00007-TICKET.md) owns this artifact;
[TASK-00010](tasks/00010-TASK.md) records its original local verification; current enforcement planning is owned
by TICKET-00009 and its new TASKs.
Local [architecture](../ARCHITECTURE.md), [instructions](../AGENTS.md) and
[planning conventions](CONVENTIONS.md) remain canonical.

## 1. Inspected baseline and evidence limits

Target base: `a187726fd2b48d7e6ed12f41a29a75092e43bbd1`, merged TASK-00009, on 2026-10-24 UTC.
Agent OS was clean at **`d70253377033e852d0281c1066f47f49504a42d6`** when inspected. Sources at that revision:
[Standards][os-standards], [ownership ADR][os-ownership], [quality][os-quality], [backend coverage][os-tests],
[build][os-build], [execution][os-execution], [PHPCS configuration][os-phpcs] and [tool lock][os-lock].
These are comparison sources, not target authority. No dirty provider guidance is incorporated.

| Observed local practice | Consequence for this proposal |
| --- | --- |
| [Composer](../composer.json) maps `App\\` to `app/`, `Config\\` to `app/Config/`; PHP `^8.5.12`, CodeIgniter `^4.7`, PHPUnit `^10.5.16` | Keep framework layout and bootstrap. No `src/` transplant or PHPUnit-major upgrade is required here. |
| [Services](../app/Config/Services.php) uses native shared factories/delegates, Queue buses and synchronous delivery services | Preserve discovery and delegate ownership. Inner routers/clients/template dependencies are sometimes constructed inline; stronger shared-registration rules would need bounded changes, not a claim of present compliance. |
| [Home](../app/Controllers/Home.php) resolves `starterGreeting`; [StarterGreeting](../app/Services/StarterGreeting.php) supplies two strings | A tiny native starter, not a demonstrated owned business Domain/Application layer. Keep it; do not invent handlers for the greeting. Framework service location here is an adapter seam, not precedent for future inner layers. |
| [PHPUnit XML](../phpunit.dist.xml) has one `App` suite across `tests/`; source filter includes `app/` except Views and Routes | Directory names are not suite/coverage attribution. Existing XML is not the proposed meaningful-behavior denominator. |
| [Integration suite](../tests/feature/FightCommonIntegrationTest.php) exercises cache, files, transactions, native URLs/JSend, Queue envelopes/retries and intercepted providers | Preserve useful consumer outcomes, not every service-resolution/type assertion as an immutable test obligation. Names containing “receipt” do not alone make a behavioral assertion certification. |
| [HelloWorldTest](../tests/feature/HelloWorldTest.php) uses CodeIgniter's controller helper | Useful rendered-response evidence; not a real routed network/browser journey. Retain it without overstating its reach. |
| Health, example database and example session tests are stock configuration/framework demonstrations | Propose retirement after tracing unique owned contracts; do not move them into a new suite or delete them in this TASK. |
| [Build](../bin/build) checks planning, Composer/platform/runtime policy, governance, PHPUnit `--no-coverage`, safe production profile and public boundaries | None of PHPCS/PHPStan/Deptrac/Rector/coverage enforcement is implemented. Keep current checks until an accepted outcome replaces them without losing required evidence. |
| [Hosted workflow](../.github/workflows/build.yml) explicitly starts runtime, installs lock, calls `./bin/build`, tears down | Existing entrypoint parity, not evidence that hosted execution occurred. No frontend/package.json or browser suite exists in this starter. |

Runtime was explicitly prepared with `./bin/up`; CLI PHP **8.5.12**, Composer **2.10.2**. Existing locked
dependencies were checked with a dry-run, then explicitly prepared with `./bin/composer install --no-scripts
--no-interaction --prefer-dist --no-progress`: nothing to install/update/remove. Both Xdebug and PCOV are absent.
Coverage remains **unmeasured**, not zero or 100%; this TASK neither installs a driver nor changes the XML.
The current gate verifies the current installation, not proposed tools or the qualified stable pair.

### Qualified public packages, not installed adoption

Consume the [TASK-00009 qualification](wayfinder/research/2026-10-24-latest-stable-fight-baseline.md), not an
assumed upgrade: Common **v1.4.0** (`87b9580c072f3149d574e09865daa79620c92118`) and AccessControl **v0.8.0**
(`319738255e682d587642b67856039f882b9588d6`) installed together in isolated scratch. The root still pins older
development contracts. The proposed three-package lock change includes HttpFoundation **8.1.6 → 8.1.9** for the
inherited advisory; the security refresh was resolution-only, not installed-consumer qualification.

The released AccessControl transaction port fits Common's CodeIgniter `TransactionalUnitOfWork` adapter, unlike
the older legacy `UnitOfWork` requirement. No consumer shim is justified. Type fit does not establish repository
composition, SQL concurrency, no-op fences, reliable rollback or safe replay. Shared actual connections, uncertain
commit recovery, post-commit publication failures and at-least-once provider effects retain the report's limits.
Do not add outer/nested transactions, assume an outbox or assert exactly-once delivery. The starter has no owned
AccessControl schema/handler graph to migrate. Package upgrade acceptance belongs to TICKET-00008; application
HTTP/authentication/persistence choices stay with the open Wayfinder owners, whose frontier remains WF-002.

## 2. Rule disposition (recommendations)

“Adopt” preserves shared intent; “adapt” changes a concrete mechanism for this consumer; “reject” identifies a
conflict/non-applicable transplant; “defer” names missing evidence or a separately owned decision. None means
implemented enforcement. Automation catches structural errors; review still establishes semantics.

| Rule | Proposed disposition and CodeIgniter rationale | Future evidence / owner |
| --- | --- | --- |
| Public package ownership; no copied Domain/Application trees, aliases or forwarding wrappers | **Adopt.** Use public package messages, Views, ports and helpers directly where they express the capability. | Imports, caller traces and independent review; public boundary checker. |
| Genuine owned orchestration only | **Adopt.** Apply the four-part test below; no speculative contexts/handlers. | Use-case requirements, observable behavior tests, review. |
| Adapter → Application → Domain | **Adapt.** Preserve inward dependencies but classify native controllers/configuration/discovery by responsibility, not by moving them. | Deptrac collectors plus unassigned-dependency inventory; review of dynamic discovery. |
| `App\\` → `src/`, Slim Actions/Responders, Doctrine/PostgreSQL/Symfony Console stack | **Reject** as a transplant. `App\\` → `app/`, native controllers/views/routes and Spark remain. Separate presentation can be justified by a real interaction, not mandatory extra wrappers. | Native route/controller/Spark evidence when changed; architecture review. |
| Shared graph and constructor injection | **Adapt.** Native `Config\Services` shared factories are the composition root; no second container/module-glob loader. Inject inner capabilities; isolate request state. | Factory/caller review and meaningful behavior where identity/isolation affects outcomes. No product wiring tests. |
| Every command/query traverses its configured pipeline, including nested package work | **Adopt.** Inject buses for message dispatch, not handlers. Never infer permission from a void dispatch or empty filters. | Review routing and filters; outcome/failure/effect tests for approved use cases. |
| Provider `config/{parameters,common,application}` registration globs and `scripts/console.php` | **Reject** their concrete paths/loaders; **adopt** one coherent HTTP/Spark graph and lazy composition intent. | Native service/discovery checks, not a duplicate manifest. |
| Commands are intent, queries nonmutating, events facts; domain owner decides policy | **Adopt.** CQRS supplies no transaction/delivery guarantees by itself. | Contract review and relevant effects/rejections. |
| Safe Views, server-side authorization, sanitized public errors | **Adopt** intent; **defer** endpoint/status/permission mechanisms to accepted application decisions. No raw untrusted package-message forwarding. | Future protected entry-path behavior; no invented login/API here. |
| PHP and names | **Adapt** shared conventions as specified below, with narrow discovery/inheritance exceptions. | FightCommon PHPCS, PHPStan, Rector dry-run and review. |
| Meaningful unit/integration/functional tests, regression-first confirmed bug repair | **Adopt.** Preserve actual contracts, failure/rejection and effects; no tests of tools or upstream algorithms. | Tests and independent contract-derived expectations. |
| All-suite 100% meaningful Domain/Application lines, separate unit attribution | **Adapt** as the recommended coverage option in §4; it is not equivalent to Unit-only exact 100%. | One measured execution, source inventory, attribution and gaps; maintainer decision. |
| Common PHPCS, PHPStan, Deptrac, Rector dry-run | **Adopt** intent; **adapt** paths/versions below to this native consumer. No tool installed by this proposal. | Future explicit resolution, tool-native checks and behavior-preserving source changes. |
| One nonmutating local/hosted gate; explicit preparation | **Adopt.** Propose PHP-owned phase graph in the running Compose `app` service; retain Python planning validator as its owning tool. | Same `./bin/build` locally/hosted; inspect source/index stability. |
| Provider frontend/Storybook/Pi/browser phases, TLS/database-reset preparation | **Defer** until target-owned capabilities require them. No corresponding installed target suite or accepted product journey exists; do not add provider tests as target evidence. | Actual target requirement and compatible setup, not fabricated placeholders. |
| Recurring receipts, lowest/latest certification, clean-clone/no-dev certification and hidden pre-submit installs/updates | **Reject** as already retired/conflicting. Keep meaningful safe production checks, not certification authorities. | Direct owning tools; local limitations reported. |
| Shared skills and delivery/report substitutions | **Defer** implementation to TICKET-00010/TASK-00013. Keep target wrappers, hierarchy, paths and native stack; reference portable provider guidance, never copy its skill suite or private filesystem paths. | Accepted target binding and its own verification; no binding created here. |

## 3. Ownership, PHP and composition details

### Direct package use versus orchestration

Use a package command/query and its safe result directly when it already expresses the use case. For example,
a future user listing would dispatch the public `ListUsers` and present `UserView`, not introduce equivalent
`App` messages/Views. This is an ownership example, not authorization to implement that endpoint. Implement a
package repository port directly in a future adapter rather than define an identical consumer interface.
A direct public synchronous capability (for example a hasher or documented authentication service) need not be
wrapped in a fabricated message; the pipeline rule applies to actual command/query dispatch.

An owned Application orchestrator is justified only if **all** hold:

1. No owning package already supplies the behavior.
2. It enforces actual starter/application policy or coordinates demonstrated ownership boundaries.
3. Its transport-neutral input, result/event, failures and effects have a real requirement and meaningful tests.
4. It depends on injected inward contracts, not concrete adapters or a container.

A forwarding handler, renamed package View or constructor-shape shim fails this test. A state invariant belongs
with its Domain concept, not a controller or a handler reconstructing policy from getters. Deep interfaces hide
mechanism without hiding authorization, transaction or recovery obligations; no generic Manager/Helper buckets.

### Native namespace and dependency map

- Future `App\Domain` under `app/Domain/`: owned business policy/values only; stable public package Domain types
  may participate in its language. No framework/container, HTTP, SQL, provider, Application or Adapter imports.
- Future `App\Application` under `app/Application/`: owned orchestration and inward ports; may use owned Domain
  and public package Domain/Application capabilities. No CodeIgniter or concrete adapter/provider imports.
- Native `App\Controllers`, `App\Commands`, views and future adapters are outer delivery concerns. Future
  `App\Adapter` can hold demonstrated persistence/provider implementations; do not relocate native seams there.
- `Config\` / `app/Config/`, bootstrap and route registration may reference concrete types to compose the graph.
  This exception is not permission for business policy or arbitrary service location.
- Existing `App\Services\StarterGreeting` is a small owned presentation-support capability, not a reason to
  invent Domain/Application. Classify it explicitly in the dependency/coverage inventory. New service types
  need a named responsibility, not a miscellaneous `Services` dumping ground.

Deptrac should collect these native roles, package Domain/Application contracts, framework/provider adapters and
composition separately. Disallow inner-to-outer edges, avoid a blanket `Fight\\.*` allow rule that admits adapters
into inner layers, and report unclassified owned source. Namespace rules cannot detect forwarding aliases,
misplaced policy, dynamic service location, correct authorization or transactional coupling: review must.
Empty future layers are N/A, not evidence of enforced architecture or a reason to generate dummy source.

### Shared graph and bus pipelines

Keep native `$getShared = true` factories and `getSharedInstance`; shared means one instance in the relevant
runtime container/lifecycle, not immortal static business state. Construct registered stateless collaborators
from the same shared registrations. Inline immutable values/messages and genuinely private implementation details
can stay local; independently used clients/routers/handlers must not be duplicated in parallel graphs. Inventory
current inline construction before changing it. CodeIgniter's controller initialization/discovery may require an
adapter-level factory/init seam instead of a constructor incompatible with the framework; document each exception.

No `service()`/`config()`/container access from future Domain or Application. Adapters may resolve at the framework
entry seam; prefer explicit injected capabilities thereafter. HTTP and Spark consume the same graph. Lazy
registration does not authorize execution or resolve delivery keys/principals during unrelated boot/help. Explicit
stateful request/worker scope needs reset/cleanup on success and failure; native static service caches alone do not
prove isolation in long-running workers. Queue delivery must enter its registered synchronous pipeline, preserving
full envelope and event fan-out/retry semantics. The present unmapped synchronous router is not a complete
AccessControl pipeline; no query-bus/handler graph is inferred from it.

### PHP and naming

Propose strict types in owned PHP, constructor injection, guard clauses, precise types, final concrete classes
and readonly properties where compatible; readonly value objects. Keep framework-extensible base classes and
mutable native configuration/response lifecycles as justified exceptions, not forced `final`/readonly conversions.
Use capability names without `Interface`, PascalCase types, camelCase methods/properties, intent/fact messages
(`RegisterUser`, `GetUserById`, `UserRegistered`) and `Handler` suffixes. Follow FightCommon enum/formatting rules.
Map external snake_case fields explicitly; do not rename framework-discovered methods/configuration keys.

Use multiline docblocks, capitalized active-verb summaries without terminal periods, `Constructs ClassName` for
constructors and multiline `@inheritDoc` for inherited behavior. Helpers are useful only when clearer, not a
mandatory wrapper around PHP. Keep snake_case descriptive `test_...` names as a test-only PHPCS exception,
matching current behavioral tests; leave production camelCase enforced. Native overrides, framework-required
signatures and template conventions need rule-specific exceptions with a reason, owner, scope and revisit trigger.
Do not globally exclude `app/Config/` from syntax/style merely because composition is excluded from coverage.

## 4. Tests and the explicit coverage decision

### Responsibilities

- **Unit:** isolated meaningful owned policy, values, orchestration and adapter/support logic. Assert results,
  state and required absence/presence of effects, not just mock call sequences. `StarterGreeting` is a possible
  small direct unit contract, without pretending its two strings establish a business Domain.
- **Integration:** native routes/URL generation/JSend, Common service-delegate outcomes, callback commit/rollback,
  Queue serialization/retry fan-out and storage/provider boundaries. Keep intercepted providers clearly labeled.
  Do not assert upstream algorithms as though the consumer owned them, or retain mere configuration/type checks
  solely to increase counts.
- **Functional:** actual approved entry interactions and safe observable responses. Keep home rendering evidence;
  add real routed/wire evidence only when a scoped interaction needs it. No test-only routes or invented browser
  journeys. Future persistence/concurrency needs a guarded real database contract, not these scaffold fixtures.

Propose named, mutually exclusive Unit/Integration/Functional test membership within one PHPUnit invocation.
Every retained test runs once. Trace useful existing assertions before split/removal; replace unique valuable
behavior evidence in the same accepted slice. Health/configuration, stock session and example model behavior are
not owned product contracts; propose removal rather than preserving framework tests for a percentage. Tools,
configuration, migrations, docs, wrappers and deliberately invalid tool fixtures stay outside product suites.
Validate those directly with their owning commands. No reorganization or deletion occurs in TASK-00010.

### Competing requirements — not equivalent metrics

| Choice | Denominator and attribution | Consequence |
| --- | --- | --- |
| **A: upstream legacy T-00007, exact 100% direct Unit-only** | Every owned production executable statement; direct units with `#[CoversClass]` (or `CoversFunction`); Integration/Functional `#[CoversNothing]` contribute nothing | Strong direct-unit obligation including adapters, but forcing composition/framework entry code into units encourages wiring/mock tests. Any meaningful-behavior exclusion changes the literal requirement and needs acceptance. PHPUnit's executable-line metric is not proof that every statement/branch/path ran. |
| **B: Agent OS meaningful all-suite policy — recommended adaptation** | 100% meaningful Domain/Application executable **lines** from one all-suite run; separately report Unit, Integration and Functional attribution. Adapter/support behavior remains counted with a practical 100% goal and visible gaps | Real boundary evidence can cover inner lines, but cannot be described as unit coverage. No blanket `CoversNothing` on integration/functional tests that contribute. Native outer/support code is reported separately, not hidden to achieve 100%. |

**Recommend B**, plus a practical aim of 100% direct-unit coverage of meaningful unit-testable owned behavior,
with all unit gaps explained. This adapts, rather than silently satisfies, upstream A. Exact Unit-only 100% is
**not rejected as an already superseded requirement**: maintainer choice D1 below must resolve it before any gate
is changed. Keep A as the alternative; do not claim both policies hold. The older proposal's word “statement”
must not be quietly relabeled as measured branch/path coverage.

For B, inventory every owned production PHP file under `app/` by responsibility, not coverage convenience:

- Required denominator: future owned Domain/Application behavior. Include unexecuted files. Empty required layers
  currently yield **N/A/no owned layer**, never a vacuous 100% pass; fail an accidentally omitted/nonempty required
  layer or absent report after it exists. Do not create source solely to populate a denominator.
- Outer/support denominator: meaningful controllers, `StarterGreeting`, future adapters and executable presentation
  logic. Count uncovered behavior and report gaps by file/line. Plain templates need rendered-output evidence;
  do not count static markup as executable PHP or blanket-exclude behavior moved into a view.
- Exclude vendor/framework source, tests/support, generated files/caches, bootstrap/entrypoint wiring, pure native
  configuration/discovery/route registration, wrappers/scripts and migrations from product-behavior percentages.
  For mixed files, identify exact non-behavioral executable lines and reasons; do not exclude real policy merely
  because it is currently in Config. Maintain a raw source inventory and explicit exclusions alongside adjusted
  reports; no coverage-ignore escapes hiding behavior. Existing XML exclusions are not accepted wholesale.
- Report numerator/denominator, unexecuted files, driver/version/mode, per-file uncovered lines, suite attribution
  and exclusions. Lane counts overlap: do not sum them. Use unrounded counts for exact 100% requirements.
  No report/driver means incomplete measurement, not a warning converted into success.

Use PHPUnit 10's `CoversClass`/`CoversFunction` for intentional direct unit targets. Its `CoversNothing` disables
coverage collection, so reserve it for genuinely non-contributing tests under B, not every boundary test. Collect
boundary coverage over the actual owned source and preserve per-test identities for attribution, with metadata
configuration that does not require intentionally absent `CoversClass` on every integration test. `UsesClass`
allows dependencies without attributing them as covered targets; it cannot substitute for measuring them.
Out-of-process HTTP workers do not automatically contribute PHPUnit coverage; report that limit, never infer
coverage from a green request. Metadata/attribution must be verified with actual target reports in implementation.

**Driver recommendation:** Xdebug **3.5.0**, explicitly enabled with `XDEBUG_MODE=coverage` only for the test
phase. Its publisher announces PHP 8.5 support and the exact configure script accepts PHP 8.0 through <8.6;
PHPUnit 10 documents Xdebug coverage mode and line/branch distinctions ([driver][xdebug], [configure][xdebug-config],
[PHPUnit coverage][phpunit-coverage]). Propose line coverage initially, not branch/path collection. PCOV is a
possible line-only alternative, **deferred** absent PHP 8.5 compatibility qualification here. Neither is installed.
The missing driver and intentionally disabled coverage justify an unmeasured baseline; they do not justify
lowering an accepted threshold or claiming a percentage. No numeric enforcement is added by this document.

## 5. Analysis tools: sourced candidate set, not a solved target installation

All external sources in this document were accessed **2026-10-24 UTC**. Recommend the coherent exact versions
below, also present together in the inspected Agent OS lock, rather than blindly selecting today's newest tool.
Registry metadata is minified; inherited manifest fields were expanded before comparison. Version ranges allow
PHP 8.5.12; a declared range is not proof of every PHP 8.5 syntax feature, framework inference or target scan.
No candidate package/driver was installed or executed, and no target Composer solve was run for these tools.
**Compatibility is supported at the declared-constraint/reference-consumer level; target resolution and actual
analysis are outstanding**, not guessed green. Requalify at accepted implementation time.

| Recommendation / exact source | Primary compatibility evidence | Proposed applicability and remaining check |
| --- | --- | --- |
| PHPCS **4.0.4**, [manifest][phpcs-manifest] / [registry][phpcs-registry] | PHP `>=7.2.0`; libxml, SimpleXML, tokenizer, XMLWriter required. Common v1.4.0 itself develops against PHPCS `^4.0`. | Scan owned PHP including configuration/tests/scripts, not vendor/cache/generated output. Load Common's installed standard explicitly; run tool-native standard listing/scan later. Runtime extension presence alone is not a successful sniff run. |
| Slevomat **8.31.1**, [manifest][slevomat-manifest] / [registry][slevomat-registry] | PHP `^7.4 \|\| ^8.0`, PHPCS `^4.0.1`, phpdoc-parser `^2.3.3`; compatible with PHPCS 4.0.4. Requires installer plugin package `^0.7 \|\| ^1.2.1`. | Explicit local standard paths; recommend plugin execution disabled and verify standard discovery explicitly, not a global PHPCS setting or new trust grant. Confirm custom sniff/API loading with actual target tools. |
| PHPStan **2.2.16**, [manifest][phpstan-manifest] / [registry][phpstan-registry] | PHP `^7.4\|^8.0`; meets Rector `^2.2.14` and Deptrac `^2.0`. Provider manifest `^2.1` admits this version. | Propose level 7 on meaningful owned source and tests, with narrow stubs for native discovery as needed. Do not blanket-ignore dynamic calls or generate a universal baseline. Actual PHP 8.5 syntax/type inference remains a target scan check. |
| Deptrac **4.7.2**, [manifest][deptrac-manifest] / [registry][deptrac-registry] | PHP `^8.2`, parser `^5`, PHPStan `^2.0`, Symfony components `^6.4 \|\| ^7.4 \|\| ^8.0`; permits target Symfony 8.1 line. | Model native roles from §3; graph/violations/unassigned inventory, no placeholder architecture tests. Exact new transitive resolution against the target lock is unverified. |
| Rector **2.6.7**, [manifest][rector-manifest] / [registry][rector-registry] | PHP `^7.4\|^8.0`, PHPStan `^2.2.14`; permits 2.2.16. [Publisher release][rector-release] documents `process --dry-run`. | Narrow accepted rule set and target PHP version; dry-run only, no framework conversion/preset copying. Current source may require behavior-preserving adjustments; broad automated modernization is not approved. |

Common's [v1.4.0 manifest][common-manifest] makes PHPCS/Slevomat **suggested/optional consumer tools**; package
`require-dev` does not install them in this application. Its [shipped standard][common-standard] is named
`FightCommon`, with PSR12 adjustments, Slevomat sniffs and custom strict-types/member-spacing/docblock/enum rules.
Propose a local ruleset referencing `vendor/johnnickell/fight-common/src/Standards/Phpcs/ruleset.xml`, explicit
owned scan paths/exclusions and local Slevomat resolution. Do not copy the standard, run `phpcbf` in acceptance,
rely on the provider's global installed paths, or assume its relative Slevomat configuration resolves correctly
in this consumer without a real standard-load check. The incoming Common `^1.2` floor is historically compatible
with 1.4.0, but not the maintainer's latest-mutually-compatible-stable destination or permission to keep dev pins.

Proposed PHPCS/syntax scan inventory: `app/`, `tests/`, `scripts/`, `public/`, `spark`, `preload.php` and any
accepted PHP analysis configuration files. Exclude `vendor/`, `.runs/`, `writable/`, `build/`, `builds/`, `var/`,
generated output and embedded non-PHP assets. Treat mixed PHP templates explicitly rather than exempting all
views from syntax. PHPStan starts with owned `app/` and `tests/` plus applicable owned scripts; Deptrac's product
graph is `app/`, with Config/composition collected separately and tests/vendor implementations outside the owned
graph. Rector scans only explicitly accepted owned PHP paths with narrow rules; discovery-sensitive configuration,
templates and entrypoints require reviewed applicability, not blind preset conversion. A path excluded from
coverage is not automatically excluded from syntax, style or boundary checks.

Known cost: new dev/transitive tool packages and explicit plugin policy, future driver/image setup, cold-analysis
memory/cache requirements, style/docblock and dynamic-discovery adjustments, and native dependency collectors.
No target solve, timing, violation count or memory budget was measured here. Do not promise a zero-change lock or
copy provider resource limits as measured target requirements. Proposed thresholds/tool choices require D1–D3.

## 6. Proposed nonmutating gate and parity

Prepare runtime, locked dependencies and accepted coverage/tool installation **explicitly before verification**.
Never hide install/update/audit, image rebuild, autoformat, metadata export or repair inside `./bin/build`.
A future thin host entrypoint can call a PHP-owned phase graph in the already running Compose **`app`** service
(not Agent OS's `web` PHP service). Keep current target wrappers; do not transplant orchestration source.

Proposed fail-fast sequence, subject to acceptance and a complete outcome slice:

1. Prepared-runtime/tool availability and Composer manifest/lock/platform/runtime-policy checks; retain the
   explicit existing warning policy until the package upgrade removes its reason. No registry maintenance.
2. Read-only planning/governance/public-package boundaries through existing owning tools; no `--write` in gate.
3. PHP syntax and local namespace/discovery inventory; Common PHPCS; PHPStan; Deptrac; Rector **dry-run**. Cache and
   reports may write only ignored paths. Style fixes are a separate explicit developer operation.
4. **One** unfiltered PHPUnit execution over every retained, mutually exclusive suite, coverage enabled under the
   accepted policy. Derive coverage policy/attribution from that run, not an extra Unit pass followed by all suites.
5. Direct safe production-profile check with test credentials/intercepted transports, retaining its current real
   rejection/outcome assertions. No production/no-dev installation, live delivery or dependency-lane certification.
6. Compare tracked/unignored source content, index/status and executable modes before/after, even on failure;
   fail rather than restore others' work. Separate ignored logs/cache from mutation of owned source. Protect
   shared run outputs from concurrent phases and disclose interrupted/incomplete verification.

Keep hosted explicit setup → **same `./bin/build`** → teardown. Do not weaken existing required checks, turn
warnings into hidden success, or add a duplicate focused-suite job. Frontend/browser phases are currently N/A:
retain any future approved suites exactly once when those capabilities exist, not invented React/Storybook tests.
Current build uses its existing shell orchestration and `--no-coverage`; this document does not change it.
Local success, hosted status, independent review, QA, PR and merge are separate facts.

## 7. Reconcile the two distinct legacy inputs

### Legacy T-00005: separate unmerged proposal, not upstream T-00007

[Migration](MIGRATION.md) reserves TASK-00005; [retirement completion](tasks/00007-TASK.md#completion-notes)
records its earlier read-only inspection and conflict with certification/clean-clone assumptions. At this
inspection, `git worktree list` registered **only the selected checkout**. Branch
`feature/t00005-canonical-quality-gate` exists at `34481cb46f8dbf575de6a41f1d5a17dbc81235ac`, but its committed tree
has **no** `planning/tickets/00005-TICKET.md`. The separate dirty proposal/patch and its exact coverage
configuration were unavailable through that registered tree. No checkout, registration, cleanup or mutation of
that worktree/branch was performed. Do not claim to have freshly audited its uncommitted content.

- **Reject** known recurring certification, clean-clone/production-install gate assumptions, receipt authorities
  and hidden dependency preparation, based on the accepted local retirement, not a reconstruction of missing bytes.
- **Adapt** any coverage proposal only through §4's explicit denominator/driver/attribution decision; no inherited
  exact percentage or exclusions are accepted from unavailable legacy configuration.
- **Defer** reuse/merge of the actual dirty implementation until its owner supplies a read-only diff and reconciles
  it with the accepted contract. This evidence limit does not justify editing/recovering that worktree here.

### Upstream legacy T-00007: fully preserved incoming requirements

The [reconciliation record](UPSTREAM-RECONCILIATION.md) and its immutable original at
`91734b84179d37131650a0f51449e155b5a6a350` were inspected. This was “Establish the Lean CodeIgniter Pre-Submit
Quality Gate,” `ready-for-agent`, parent PRD-00002, no blockers. It is **not** retirement TASK-00007, and its status
is provenance, not current execution authority.

| Preserved incoming requirement | Proposed disposition, not enforcement |
| --- | --- |
| Common `^1.2`, installed FightCommon, owned paths/exclusions | **Adapt** to qualified latest-stable package acceptance plus explicitly installed compatible consumer tools and local scan rules (§5). Do not retain obsolete floor/dev aliases as the destination. |
| One gate, Composer/syntax/formatting/PHPCS/PHPStan/Deptrac/Rector, retained suites once | **Adopt** nonmutating phases; **adapt** native service/suite paths. Frontend/browser are **deferred/N/A today**, not silently removed from future applicable requirements. |
| Exact 100% direct Unit-only owned-production statements | **Adapt recommended, decision outstanding:** option B versus preserved A (§4/D1). No claim that all-suite 100% satisfies Unit-only 100%. |
| `CoversClass` units; `CoversNothing` boundary/journey suites | **Adopt** precise direct-unit intent; **adapt** blanket boundary exclusion for B because PHPUnit suppresses its coverage. If A is accepted instead, retain the blanket rule and its strict direct-unit obligation. |
| Framework-native useful boundaries and Adapter → Application → Domain | **Adopt** intent with explicit native collectors/composition exception; keep `app/`, routes/controllers/views/Spark and important integration outcomes. |
| Remove stock/receipt/profile certification and monolithic topology | **Adapt:** retire stock/framework/tool-only assertions after loss analysis, split meaningful responsibilities, preserve actual profile effects and Queue/transaction/HTTP behavior. Do not delete valuable tests by filename alone. |
| Remove candidate/lowest/latest/receipts/auxiliary locks/clean production-install/certification journeys | **Adopt** already approved retirement. No new recurring certification surface. Ordinary Composer lock remains required, not an auxiliary certification lock. |
| No product tests of build/CI/config/coverage/docs/tools; hosted invokes canonical gate and reports separately | **Adopt.** Direct owning commands, no fabricated failures, and truthful separate hosted evidence. |

This proposal dispositions every preserved requirement; it neither marks upstream enforcement done nor rewrites
historical approval records. TICKET-00009 keeps the unresolved acceptance/enforcement requirement unfinished.

## 8. Decisions, exceptions and outcome-based implementation boundaries

**Original maintainer questions under TICKET-00009 (subsequently resolved by the current decision overlay):**

- **D1 — Coverage:** accept B's exact meaningful Domain/Application line threshold, separate unit attribution and
  practical counted outer/support goal, or retain A's stricter Unit-only obligation. Accept denominator/exclusions,
  empty-layer N/A, metadata and Xdebug 3.5.0 line-only driver together. Missing baseline is disclosed, not a waiver.
- **D2 — Native scope/style:** accept native dependency collectors and composition/inheritance/test-name exceptions;
  trace stock-test evidence before retirement. Require narrow recorded exceptions, not global suppressions.
- **D3 — Tools/gate:** accept the sourced exact candidate set and level-7 analysis intent, explicit plugin policy,
  future driver preparation and nonmutating phases; require actual target solve/scan and resource measurement.
- **D4 — Coordination:** package-sensitive tooling/composition must use the accepted upgrade outcome from
  TICKET-00008; the qualification is not adoption. Binding/report-path substitutions stay under TICKET-00010.
  Keep the legacy dirty proposal deferred unless its owner supplies usable evidence; no enforcement TASK now.

Exceptions should identify rule, exact path/member/scope, CodeIgniter/public-contract reason, evidence, owner and
revisit trigger (framework/package change or touched behavior). No time-unbounded catch-all ignore, invented
behavior or lowered required threshold to obtain green. Backward compatibility includes native discovery,
controller/worker lifecycles, package messages/results and retained useful tests, not just namespace compilation.

After acceptance, these are **possible outcome boundaries**, not allocated TASKs or approved implementation:

1. **Contributors can check native ownership and PHP rules without changing behavior.** Combine accepted dev-tool
   resolution/plugin policy, local standards/dependency configuration, necessary scoped source/docblock fixes,
   native service-composition adjustments and retained behavior tests. Run real scans and canonical gate, document
   exceptions/transitive changes. Package-standard-sensitive changes follow accepted TICKET-00008 adoption.
2. **Contributors receive honest meaningful coverage and suite attribution.** Combine explicit compatible driver
   setup, accepted denominator/report policy, meaningful missing direct units, preservation/split of integration
   and functional behavior, stock-test retirement with no valuable evidence loss, and testing documentation.
   Verify measured numerator/denominator/attribution and exclusions through the owning tools; never test reports
   or coverage mechanisms in product suites. No artificial inner layer to manufacture a threshold result.
3. **The complete gate enforces accepted outcomes once, identically locally and hosted.** Combine prepared-runtime
   checks, named PHP phase orchestration, existing-check preservation, one test/report execution, nonmutation and
   concurrency/error handling, hosted caller parity and developer setup docs. Validate directly with actual tools
   and the complete gate; no seeded invalid sources, gate-self-tests or claimed hosted proof before it exists.

Each eventual slice includes necessary configuration, code/tests, documentation and verification in a passing
vertical outcome; none is a configuration-only layer leaving the starter failing its new rules. Sequence/size can
change after accepted scans reveal actual cost. Styling/strictness changes may touch many native files; classify
those costs explicitly rather than sneak in bulk moves or product features. Pi bindings, package migration,
Wayfinder decisions, credentials, login, persistence and browser journeys remain separately owned.

## Sources

Provider references below are pinned to the exact clean revision inspected. External registry/manifests and
publisher docs are primary sources, not a claim that the proposed tools executed here. Private acquisition and
runtime evidence lives under ignored `.runs/tasks/TASK-00010/runs/initial/`; durable decisions do not depend on
that scratch remaining available. Full local gate evidence and warnings belong to TASK-00010.

[os-standards]: https://github.com/johnnickell/fight-agent-os/blob/d70253377033e852d0281c1066f47f49504a42d6/docs/engineering/STANDARDS.md
[os-ownership]: https://github.com/johnnickell/fight-agent-os/blob/d70253377033e852d0281c1066f47f49504a42d6/planning/adr/0001-application-ownership-and-orchestration.md
[os-quality]: https://github.com/johnnickell/fight-agent-os/blob/d70253377033e852d0281c1066f47f49504a42d6/docs/engineering/QUALITY.md
[os-tests]: https://github.com/johnnickell/fight-agent-os/blob/d70253377033e852d0281c1066f47f49504a42d6/docs/engineering/BACKEND_TESTS.md
[os-build]: https://github.com/johnnickell/fight-agent-os/blob/d70253377033e852d0281c1066f47f49504a42d6/docs/engineering/BUILD.md
[os-execution]: https://github.com/johnnickell/fight-agent-os/blob/d70253377033e852d0281c1066f47f49504a42d6/docs/engineering/EXECUTION.md
[os-phpcs]: https://github.com/johnnickell/fight-agent-os/blob/d70253377033e852d0281c1066f47f49504a42d6/phpcs.xml
[os-lock]: https://github.com/johnnickell/fight-agent-os/blob/d70253377033e852d0281c1066f47f49504a42d6/composer.lock
[common-manifest]: https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/composer.json
[common-standard]: https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/src/Standards/Phpcs/ruleset.xml
[phpcs-manifest]: https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/bbdc3d0532623e21838b7041a4364383a8126f96/composer.json
[phpcs-registry]: https://repo.packagist.org/p2/squizlabs/php_codesniffer.json
[slevomat-manifest]: https://github.com/slevomat/coding-standard/blob/0a40807a48873948bfa7ffce2a4e69ba40cf5e76/composer.json
[slevomat-registry]: https://repo.packagist.org/p2/slevomat/coding-standard.json
[phpstan-manifest]: https://github.com/phpstan/phpstan/blob/46a6d9060e5a7763adfcc21ebcb8b504ebdbcb92/composer.json
[phpstan-registry]: https://repo.packagist.org/p2/phpstan/phpstan.json
[deptrac-manifest]: https://github.com/deptrac/deptrac/blob/060c7edca50331129c866e6c5d5687edfea03c5f/composer.json
[deptrac-registry]: https://repo.packagist.org/p2/deptrac/deptrac.json
[rector-manifest]: https://github.com/rectorphp/rector/blob/f4aa224edb9b0630fb43826d4cb6a49b62e48d4c/composer.json
[rector-registry]: https://repo.packagist.org/p2/rector/rector.json
[rector-release]: https://github.com/rectorphp/rector/releases/tag/2.6.7
[xdebug]: https://github.com/xdebug/xdebug/releases/tag/3.5.0
[xdebug-config]: https://github.com/xdebug/xdebug/blob/3.5.0/config.m4
[phpunit-coverage]: https://github.com/sebastianbergmann/phpunit-documentation-english/blob/10.5/src/code-coverage.rst
