# Latest stable Fight baseline — 2026-10-24

## Question and short answer

For [TASK-00009](../../tasks/00009-TASK.md) / [TICKET-00006](../../tickets/00006-TICKET.md), which latest
published stable releases can this CodeIgniter consumer install, and what must a subsequent upgrade preserve?

**Recommend Common v1.4.0 + AccessControl v0.8.0 for human acceptance, not automatic adoption.** Both are the
latest stable versions observed on 2026-10-24 UTC in their publishers' GitHub release/tag inventories and
Packagist stable metadata ([Common][C-release], [AccessControl][A-release], [registries]). An isolated registry
installation of the exact pair against this project's copied constraints succeeded. AccessControl's breaking pre-v1 minor is Composer-stable,
not a promise of API stability. No Common 2.x tag/release was present in the inspected inventories; the
[TASK-00003](../../tasks/00003-TASK.md) ownership/artifact gate is therefore not triggered or satisfied.

**Adoption remains unresolved:** the maintainer must accept the bounded upgrade and the inherited security
refresh described below. This report does not qualify application journeys, implement repositories, allocate an
upgrade TASK, or close any Wayfinder decision. No older fallback pair is proposed or needed.

## Release authority, exact references and constraints

All external sources below were accessed **2026-10-24 UTC**. GitHub release publication times are distinct from
Packagist's source-commit `time`. Stable metadata, published releases and downloaded artifact references agree:

| Package | Latest stable / GitHub publication | Source and distribution commit | Runtime requirements |
| --- | --- | --- | --- |
| `johnnickell/fight-common` | v1.4.0 / 2026-10-12 15:10:25Z | `87b9580c072f3149d574e09865daa79620c92118` | PHP `>=8.5`; PSR cache `^3.0`, container `^2.0`, HTTP client/factory/server-handler/server-middleware `^1.0`, HTTP message `^2.0`, log `^3.0` |
| `johnnickell/fight-access-control` | v0.8.0 / 2026-10-21 18:19:50Z | `319738255e682d587642b67856039f882b9588d6` | PHP `>=8.5`; Common `^1.3` |

Sources: [release authorities][C-release], [AccessControl authority][A-release], registry metadata [registries],
and exact [Common manifest][C-manifest] / [AccessControl manifest][A-manifest]. Both are MIT-licensed. Common
1.4.0 satisfies `^1.3`; the project requires/resolves PHP `^8.5.12` / `8.5.12`, within both ranges. Library dev
requirements are not consumer requirements: AccessControl's PHPUnit 13 and Symfony Process `^7.0` dev tools do
not conflict with this consumer's PHPUnit 10 and Process `^8.1`. Common adapters have optional provider
requirements, not an implicit all-framework installation. This consumer already explicitly requires CodeIgniter
`^4.7`, Queue `^1.0`, DBAL `^4.4`, Guzzle `^7.10`, JWT `^5.6`, Flysystem, Symfony Mailer/Filesystem/Process
`^8.1`, Mercure, Twig and Twilio; the isolated solve retained those constraints, not library dev packages.

**Documentation discrepancy:** the immutable v0.8.0 README/overview still say “prepared” and call v0.7.0 latest.
The published [v0.8.0 release][A-release] explicitly explains that truthful preparation snapshot and says not to
retag it. The live release, registry references and successful exact-artifact installation establish publication;
preparation prose does not justify a silent downgrade. No local signature/maintainer-key verification was run;
this report does not independently attest the release's signing or upstream certification claims.

### Current project versus proposal

At base `64e0b398eecd4a7b34054b45917ec177addb5e45`:

| Layer | Common | AccessControl |
| --- | --- | --- |
| [Manifest](../../../composer.json) | `dev-develop#fad24ae9fdcf4ac00fa55c59ef7d35f7c7531911 as 1.2.0-dev` | `dev-develop` |
| [Lock](../../../composer.lock) and installed metadata | `dev-develop@fad24ae9fdcf4ac00fa55c59ef7d35f7c7531911` | `dev-develop@7f55c0adb8fade06d03ec92212111eb6060d48ec` |
| Isolated proposed pair | `v1.4.0@87b9580c072f3149d574e09865daa79620c92118` | `v0.8.0@319738255e682d587642b67856039f882b9588d6` |

The root manifest uses VCS repositories, `minimum-stability: dev`, `prefer-stable: true`; none of these development
pins/aliases qualifies a stable installation. No root manifest, lock or vendor file was changed by this work.

## Isolated installability and security evidence

Private evidence root: `.runs/tasks/TASK-00009/runs/initial/`, relative to the canonical checkout. Public
release facts remain reproducible through the URLs below; private logs are not required reading for the decision.

1. Verified the Compose project/source mount and free port 18085, then started only this checkout with `./bin/up`.
   Existing project vendor was already present; **no root install/update** was run. PHP CLI was 8.5.12 and Composer
   2.10.2. Artifact operations ran through `./bin/exec` in this owned runtime, with isolated `COMPOSER_HOME` and
   `COMPOSER_CACHE_DIR` beneath the evidence root; no credentials, provider or business operations were used.
2. `probe/composer.json` copied the root requirements including dev/platform constraints, replaced only the two
   Fight requirements with exact `1.4.0` / `0.8.0`, selected `minimum-stability: stable`, and removed VCS overrides
   and root scripts. With no lock/vendor initially, this registry-only command installed **80 packages**:

   ```sh
   ./bin/exec env COMPOSER_HOME=/app/.runs/tasks/TASK-00009/runs/initial/composer-home \
     COMPOSER_CACHE_DIR=/app/.runs/tasks/TASK-00009/runs/initial/composer-cache \
     composer --working-dir=/app/.runs/tasks/TASK-00009/runs/initial/probe --no-plugins \
     update --no-scripts --no-interaction --prefer-dist --no-progress
   ```

   Exit **0**, archives downloaded/extracted, lock and installed source/dist references match the table. No
   advisory reported; 51 suggestions and 54 funding notices are informational. `check-platform-reqs` on this
   same scratch installation passed **16 rows**, exit **0**, including actual PHP 8.5.12 (not only platform emulation).
   This freely resolved other dependencies too; it is not evidence of a two-package-only project upgrade.
3. `locked-probe/` copied that probe manifest plus the **root lock**, without vendor. A targeted wrapper command
   `update johnnickell/fight-common johnnickell/fight-access-control --no-install --no-scripts --no-interaction
   --prefer-dist --no-progress` (same isolated environment/global `--no-plugins`) resolved exactly **2 updates**,
   **0 additions/removals**, with 52 runtime / 28 dev package entries in total; only the two Fight entries changed,
   and the obsolete alias disappeared. Exit **0**, but **one inherited advisory** remained.
4. `audit --locked --format=json --no-interaction` in `locked-probe/` exited **1** for
   `symfony/http-foundation v8.1.6`, **CVE-2026-108082 / PKSA-xmwy-rmx5-m7h4**. The [publisher advisory][security]
   describes header-parsing ReDoS, fixed in the 8.1 line at 8.1.7, with a whitespace-separator regression corrected
   at **8.1.9**. No exploit or application reachability proof was attempted. Do not describe the existing lock as
   vulnerability-free merely because the product gate passes.
5. `security-probe/` started from the same copied root lock and probe manifest. Adding
   `symfony/http-foundation` to that targeted update resolved exactly **3 updates**: the two Fight packages plus
   HttpFoundation **8.1.6 → 8.1.9**, **0 additions/removals**, exit **0**, no advisory reported. This is a
   **resolution-only** proposal, not a third installation or runtime qualification. Accept this narrow security
   refresh in the future upgrade scope instead of copying all unrelated fresh-solve versions or suppressing audit.

Logs and exit files: `probe-update.log` / `probe-update.exit`, `probe-platform.log` / `probe-platform.exit`,
`locked-probe.log` / `locked-probe.exit`, `locked-probe-audit.json` / `locked-probe-audit.exit`,
`security-probe.log` / `security-probe.exit`. Before/after SHA-256 inventories of the root manifest,
lock and **every vendor file** are retained as `dependencies-before.json` / `dependencies-after.json` with the
comparison result. Scratch dependency downloads are inspection material, never committed package source.

## Transaction contract: historical mismatch resolved, composition still required

Released [TransactionalUnitOfWork][transaction] exposes `commitTransactional(callable $operation): mixed` and
`isClosed(): bool`. Deprecated [UnitOfWork][legacy-transaction] **extends** it and adds `commit(): void`. An object
implementing only the narrower interface is not a legacy `UnitOfWork`. The released [CodeIgniter adapter][ci-uow]
implements only `TransactionalUnitOfWork`, with a required `BaseConnection` constructor argument.

The current installed AccessControl `RenameCustomRoleHandler` still requires the **legacy** `UnitOfWork` and a
`RoleAdministrationAuthorization` port. The released [v0.8.0 handler][rename-handler] instead requires
`(RoleRepository, Clock, TransactionalUnitOfWork, EventDispatcher)`; its public `handle(CommandMessage): void`
uses the callback transaction. `AuthenticationService`, disable/delete and reset-delivery signatures were also
inspected from the installed release. Read-only reflection of **19 named classes/interfaces** confirmed the
released adapter satisfies the new transaction port and not the old one. The existing
[`fightTransactionalUnitOfWork`](../../../app/Config/Services.php) factory's type therefore fits the released
handlers **without a compatibility shim**, but the starter has no AccessControl handler/repository composition.
This is a resolved type question, not evidence of a working login or Role endpoint.

Adapter semantics from the exact source [ci-uow]:

- Reject a closed connection and nested adapter execution or an already active CodeIgniter transaction.
- Begin explicitly; invoke the callback and return its value only after a successful transaction status and commit.
- On callback failure, attempt rollback/reset status and rethrow the original throwable. Failed status or commit
  also attempts rollback and throws. Rollback/reset failures are swallowed; the adapter does not prove the
  database's outcome after an uncertain acknowledgement or failed rollback.
- Track whether a connection was established; an unopened connection is not yet considered closed.

AccessControl owns the callback's coupled business mutation and required audit, not the consumer's outer HTTP
transaction. Its [operation outcomes][outcomes], [Role revision guide][roles] and sampled handlers require the
**same actual connection** and transaction-duration fences across all relevant repositories/writers, including
validated no-ops. CodeIgniter `db_connect()` sharing alone does not establish this for adapters on another
connection. Keep the consistent User-before-reset-grant lock order. Do not wrap these handlers in an additional
native transaction or replace final compare-and-swap admission with prior reads/ORM identity maps.

Success publication follows confirmed commit. A subsequent subscriber failure still throws but cannot undo
committed state. Failure notification is best effort, constant and cannot replace the primary throwable; the
throwable itself still needs response/log sanitation. Only recoverable Agent provision/rotation have the typed
committed-result publication-warning exception. Lost provider/commit acknowledgements require authorized
current-state reconciliation, not blind replay. Provider calls occur outside transactions after committed claims,
with at-least-once delivery; neither an outbox, guaranteed replay nor exactly-once external effects is supplied.

## Relevant released capability and migration inventory

This is a **bounded qualification inventory**, not WF-001's every-symbol/signature/transport audit. Names below
were located in the exact installed artifact; detailed semantic inspection focused on transaction, Role and
recovery contracts. Commands/queries/events are package capability, not selected routes, permission policies,
Spark names or enabled features. Domain names use `Fight\AccessControl\Domain\AccessControl\<area>`;
application services use `Fight\AccessControl\Application\AccessControl\<area>`. See the immutable
[Domain surface][A-domain], [Application surface][A-application] and [integration overview][A-overview].

| Area | Commands and queries / public services | Results, events, ports and consumer consequences |
| --- | --- | --- |
| Users / account authority | `InvitePendingUser`, `CorrectPendingInvitation`, `RegisterUser`, `RecoverPendingRegistration`, `DisableUser`, `EnableUser`, `DeleteUser`, `RestoreUser`, `AssignRoleToUser`, `RemoveRoleFromUser`; `GetUserById`, `ListUsers`; `User\Security\AuthenticationService::{activate,login,refresh,logout,changePassword,resetPassword,confirmEmail}` | `UserView`, `TokenSet`, `AccessToken`, `RefreshResult` (`RefreshOutcome::ROTATED/CONFLICT`); `UserInvited/Registered/Activated/Disabled`, `PasswordChanged/PasswordResetCompleted`, `RedactedCommandFailed`. Supply `UserRepository`, `AuditEvidenceRepository`, `Clock`, password/token ports and `LoginThrottle`; no public registration enablement follows from installation. |
| Roles / Permissions / policy | `CreateCustomRole`, `RenameCustomRole`, `RemoveCustomRole`, `GrantPermissionToCustomRole`, `RevokePermissionFromCustomRole`; `GetRoleById`, `ListRoles`, `GetPermissionById`, `ListPermissions`; `PreviewManagedPolicy`, `ReconcileManagedPolicy` | `RoleView`, `PermissionView`, `ManagedPolicyPlan`, `RoleRevision`, non-null `PermissionTier`; `CustomRoleRenamed/Removed`, `ManagedPolicyReconciled`. `RoleRepository`, `PermissionRepository` and shared planner with User/Agent references. Actor IDs are provenance, not authorization. |
| Human credential delivery / sessions | `DeliverUserInvitation`, `RetryInvitationDelivery`, `ResendInvitationDelivery`, `ExpireInvitationDelivery`; `RequestPasswordReset`, `DeliverPasswordReset`, `ExpirePasswordResetDelivery`; `RequestEmailChange`, `CancelEmailChange`, `DeliverEmailChange`, `ExpireEmailChange`; `RevokeSession`; `FindInvitationDeliveryStatus`, `FindCredentialDeliveryStatus`, `FindDueCredentialDeliveries`, `FindExpiredCredentialDeliveries`, `ListActiveSessions` | Protected `InvitationDeliveryStatusView` / `CredentialDeliveryStatusView`, `SessionView`, `DueCredentialDelivery`; `InvitationDeliveryRetryRequested`, `UserInvitationDelivered`, `PasswordResetDeliveryConfirmed`, `EmailChangeDelivered`, `RefreshSessionRevoked`. Grant/session repositories, ciphers/generators, `CredentialDeliveryProvider` and administration authorization ports; preserve generations, claims, leases, retry/expiry and cancellation. |
| Agents | `GrantPermissionToAgent`, `RevokePermissionFromAgent`, `ReplaceAgentPermissions`, `UpdateAgent`; `GetAgentById`, `ListAgents`, `GetAgentProfile`, `GetAgentOperation`, `ListDueAgentDeliveries`, `ListAgentDeliveryMaintenance`, `CountAgentDeliveryKeyReferences`; provisioning, rotation, lifecycle, delivery, recovery and maintenance services; protected profile MCP Tools | `AgentView/ProfileView/OperationView`, `AgentProvisioningResult`, `AgentCredentialRotationResult`, `AgentDeliveryResult`, `AgentMaintenanceResult`, `AgentPublicationWarning`; `AgentProvisioned`, `AgentCredentialRotated/Revoked`, `AgentCredentialLifecycleFailed`. `AgentRepository`, HMAC verification/replay, cipher/sink/lookup and operation/delivery/maintenance authorization ports; direct Permissions, never Roles. No enrollment or credential issuance is authorized here. |
| Features / principals | `CreateFeature`, `ProvisionFeatures`, `RemoveFeature`, `SetFeaturePermission`, `SetFeatureStatus`; `GetFeatureById`, `ListFeatures`, `ValidateFeaturePreparation`; `FeatureAvailability`, `SecurityContext`, `CurrentPrincipalProvider`, `AuthoritativePrincipalResolver` | `FeatureView`, `FeaturePreparationResult/Issue/Problem`, `FeatureStatus`; `FeatureCreated/Removed/StatusChanged/PermissionChanged`. `FeatureRepository`, `FeatureReferenceDiscovery`, `AuthenticationContextProvider`, `ExactPermissionResolver`; availability is not action authorization. Fresh request scope and authoritative resolution remain consumer-owned. |

Representative public failures that must remain distinguishable without exposing arbitrary diagnostics:
`RoleConflictException`, `RoleRevisionException`, `CustomRoleException`, `DuplicateEmailException`,
`LoginRejectedException`, `PasswordResetRejectedException`, `RefreshSessionConflictException`,
`ActivationDeliveryNotRetryableException`, `RegistrationRecoveryAuthorizationException`,
`AgentOperationCollisionException`, `AgentDeliveryCommitUncertainException`, `FeatureConflictException` and
`PrincipalResolutionException`. These are semantic categories, **not chosen HTTP status/error envelopes**.

### Required AccessControl migration inventory

The exact [0.8 overview][A-overview], [outcomes][outcomes], [Roles][roles] and [published release history][A-history]
establish these differences from the installed older development contract:

- Transaction constructors now take `TransactionalUnitOfWork`; actor-only Role/assignment/Agent authorization
  ports were removed. Protect **every** consumer entry point and no-op explicitly; do not recreate removed ports
  as implicit authorization. Retain ownership-sensitive invitation/session/email checks.
- Non-null Permission tiers and reserved managed `ROLE_SUPER_ADMIN`; only authoritative `ADMIN_SAFE` Permissions
  are eligible for custom Role/direct Agent grants. All reference/tier writers must share transaction fences.
- Current Role Views require `RoleRevision`; rename takes `(actorId, roleId, name, expectedRevision)`, removal
  `(actorId, roleId, expectedRevision)`. Carry canonical `expected_revision` from displayed state, reject malformed
  or stale tokens and require reconfirmation. Persist incarnation/sequence; implement
  `RoleRepository::validateCurrent(Role $expected): bool` held through completion, complete-state replace/remove,
  and `validateCustomPermissionGrant(Permission $expected): bool`.
- `UserRepository::addWithRoleAssignments(User $user, array $expectedRoles): bool`,
  `replacePendingRegistration(User $expected, User $replacement): bool`, and
  `validateRecoveryAuthority(User $expected): bool` are required. Registration includes Role revision/reference
  fencing; reset grants persist immutable `RecoveryAuthority` (issuing authentication version/canonical-email
  revision), never values inferred from a later User. Disable/delete revoke reset material atomically with audit.
- `DeliverPasswordResetHandler` ends with required shared `UserRepository` after the dispatcher;
  `DisableUserHandler` / `DeleteUserHandler` end with shared `PasswordResetGrantRepository`. Invitation retry
  requires `Clock` before its dispatcher. `CredentialDeliveryInvocation` requires the fifth nullable
  `ActivationOrigin` argument (stored origin for activation, explicit null otherwise); issuance/hydration persist
  that origin, and invitation status includes `activation_delivery_id`.
- Provider-neutral delivery replaces old invokers; removed raw-return Agent issuance/old reset confirmation
  commands must not be resurrected. Agent operation keys, correlation/cohorts, restoration readiness, protected
  delivery and maintenance are explicit contracts, not an instruction to enable those workflows.
- The formerly named v0.3/v0.4 migration documents in this artifact are **retired** pointers to current contracts.
  There are no package-owned backfills, historical readers or compatibility defaults. This starter has no owned
  AccessControl schema/data/handler factories to migrate; an actual data-bearing deployment would need a separate
  accepted data-migration design, never a destructive reset assumed by the dependency upgrade.

### Common and currently selected CodeIgniter capabilities

[Common changelog][C-changelog] and [CodeIgniter guide][C-ci] preserve the existing service-delegate composition:
cache, named routing, callback transactions, Queue command/event envelopes and synchronous handlers, Symfony Mailer,
Twig, filesystem, Guzzle/PSR-18, Flysystem, Process/Scheduler, JWT/passwords, SMS, Mercure and observability. Queue
redelivery repeats full event fan-out; every subscriber must tolerate duplicates. Queue submission is not an atomic
outbox. `CacheServices::cache`, `RoutingServices::urlGenerator`, native JSend, ProcessBuilder and
`Scheduler::withProcessRunner` public signatures in the 19-symbol sample match the current installed versions.

Common 1.3 adds opt-in MCP Tools/Resources/Skills, interactions/progressive delivery and OAuth resource-server
boundaries, not routes, authentication policy or a hosted endpoint. Common 1.4 adds strict pagination, immutable
JSON snapshots/StrictJson, IP/E.164 and calendar/instant/duration values, Decimal/Currency/Money, and eleven
transport-neutral application-failure categories with safe PSR-15/Symfony/Laravel error presentation. These are
optional capability, not new CodeIgniter runtime requirements or permission to add a blanket safe-error adapter.
Legacy arbitrary-message error presentation remains unsafe for untrusted clients; consumer error sanitation is
still needed. No safe native CodeIgniter error handler is inferred from those other-framework handlers.

**Migration exception:** StreamId tuple equality/hash/JSON now changes collection deduplication/key replacement
and JSON from `{}` to a canonical string. Rebuild old serialized hash collections if present and inspect consumers;
persisted stream-name/ID columns are unchanged ([release][C-release], [changelog][C-changelog]). This starter only
samples StreamId in an unmapped in-memory event-store test, not an owned persisted stream journey. Legacy `Pagination` construction
is documentation-deprecated, still functional without runtime notice in 1.x. Validation reuse and quoted-email
extraction fixes are release changes, not proof of new application behavior. Common's changelog scheduler narrative
must not override the sampled artifact: this release still exposes the legacy constructor and the selected
`withProcessRunner` factory; use exact signatures rather than mechanically rewriting working factories.

## Bounded upgrade and meaningful consumer verification proposal

For [TICKET-00008](../../tickets/00008-TICKET.md), after maintainer acceptance and rechecking latest releases:

1. Pin the qualified stable pair deliberately (Common 1.4.0; AccessControl 0.8.0 / a deliberately bounded 0.8
   line), remove superseded dev aliases/VCS overrides as justified, and accept the narrow HttpFoundation 8.1.9
   security refresh. The isolated lock solve supports a three-package change, not an unrestricted update. Inspect
   the actual final manifest/lock/vendor/platform agreement and advisory result through repository wrappers.
2. Retain `app/`, `Config\Services`, native routes/HTTP/Spark and current public hello-world boundary. Reverify
   every selected service's real output, native named URL and JSend response status/headers/body, complete Queue
   envelopes/retry fan-out, intercepted production profile, unmapped handler/event rejection and provider failure
   paths. Existing integration tests are useful starting coverage, not release adoption evidence until run on the
   upgraded installation. Do not instantiate new AccessControl journeys solely to make an upgrade look broader.
3. Verify callback return/commit, original-error rollback, closed/nested/failed-commit behavior and publication
   ordering at the owned integration boundary. Type-fit reflection here is not that behavioral proof. If later
   persistence is selected, bind real shared-connection Role/recovery conformance, both concurrent winner orders,
   no-op fences, stale revisions, uncertain commits, restart/hydration and delayed provider outcomes. Such future
   application work remains outside this dependency-only scope and the current green starter baseline.
4. Update README, relevant composition/testing docs and planning with exact supported versions, StreamId exception,
   security refresh, capability exclusions and fresh verification limits. No receipts, dependency-lane matrix,
   package release tooling, copied source, shims, live provider work or product tests of these research tools.

## Proposed WF-001 reconciliation — not accepted here

Ask the map owner to replace **only the baseline selection** of Common v1.2.0 / AccessControl v0.2.0 with the exact
v1.4.0 / v0.8.0 references above (or requalify if releases advance before acceptance). Update the map's destination,
WF-001 Gate and linked baseline summaries together in that separately accepted decision operation; retain the old
baseline as historical context. Installation evidence is now available for the proposed pair, but **does not
close the current gate/decision automatically**.

Preserve WF-001's complete commands/queries/services/ports/values/events/results/errors and semantic-guarantee
audit, with HTTP/CLI/worker/composition-only or justified-unsupported classification. This report is input, not a
replacement. Keep optional registration/MCP/Feature capabilities visible while preserving the map's explicit
exclusion of public self-registration unless its owner separately amends that decision. Do not select routes,
Spark commands, persistence or queue policy here. Keep every downstream dependency and Open state; **WF-002 remains
the authored frontier**, blocked on the external ingress-network/hostname/TLS proxy contract; Symfony wire/client
gates and all other independent prerequisites are unchanged.

## Open questions and evidence limits

- Maintainer: accept the exact pair, narrow security refresh and dependency-only upgrade boundary before allocating
  an implementation TASK under TICKET-00008. No release absence, mutual version conflict or Common-major ownership
  blocker was found; installed-consumer behavior of the proposed pair remains **unverified**, not failed or accepted.
- Map owner: accept/revise the proposed WF-001 baseline and perform the broader audit. No decisions were closed.
- This inspected release inventories, manifests, relevant symbol names, 19 reflected contracts, selected exact
  sources and migration docs; it did not audit every exported method or prove SQL concurrency, providers, keys,
  browser journeys, deployment, or Common/AccessControl upstream tests. AccessControl test namespaces are dev
  autoload only; using conformance support later requires an explicit supported consumer test-loading/tool decision,
  not an assumed production autoload or automatic PHPUnit 13 upgrade.
- The canonical local gate runs the **unchanged project installation**, not this scratch installation. Its results
  and warnings are recorded in [TASK-00009](../../tasks/00009-TASK.md); independent review, QA and hosted evidence
  remain separate. SHA-256 inventories protect dependency-state claims, not provenance/signature attestation.

## Sources

- [Common published release][C-release] and explicit StreamId warning.
- [AccessControl published release][A-release], breaking contracts and preparation-prose explanation.
- Packagist stable metadata and publisher tag/release inventories (all returned fewer than 100 items):
  [Common p2](https://repo.packagist.org/p2/johnnickell/fight-common.json),
  [AccessControl p2](https://repo.packagist.org/p2/johnnickell/fight-access-control.json),
  [Common tags](https://api.github.com/repos/johnnickell/fight-common/tags?per_page=100),
  [Common releases](https://api.github.com/repos/johnnickell/fight-common/releases?per_page=100),
  [AccessControl tags](https://api.github.com/repos/johnnickell/fight-access-control/tags?per_page=100),
  [AccessControl releases][A-history].
- Exact artifacts: [Common archive](https://api.github.com/repos/johnnickell/fight-common/zipball/87b9580c072f3149d574e09865daa79620c92118),
  [AccessControl archive](https://api.github.com/repos/johnnickell/fight-access-control/zipball/319738255e682d587642b67856039f882b9588d6).
- [Common manifest][C-manifest], [changelog][C-changelog], [CodeIgniter guide][C-ci],
  [transaction interface][transaction], [legacy interface][legacy-transaction], [native adapter][ci-uow].
- [AccessControl manifest][A-manifest], [integration/migration overview][A-overview], [operation outcomes][outcomes],
  [Role revisions][roles], [sampled rename handler][rename-handler], [Domain surface][A-domain],
  [Application surface][A-application].
- [Symfony publisher security advisory][security].

[C-release]: https://github.com/johnnickell/fight-common/releases/tag/v1.4.0
[A-release]: https://github.com/johnnickell/fight-access-control/releases/tag/v0.8.0
[registries]: https://repo.packagist.org/p2/johnnickell/fight-common.json
[A-history]: https://api.github.com/repos/johnnickell/fight-access-control/releases?per_page=100
[C-manifest]: https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/composer.json
[A-manifest]: https://github.com/johnnickell/fight-access-control/blob/319738255e682d587642b67856039f882b9588d6/composer.json
[C-changelog]: https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/CHANGELOG.md
[C-ci]: https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/docs/codeigniter.md
[transaction]: https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/src/Application/Repository/TransactionalUnitOfWork.php
[legacy-transaction]: https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/src/Application/Repository/UnitOfWork.php
[ci-uow]: https://github.com/johnnickell/fight-common/blob/87b9580c072f3149d574e09865daa79620c92118/src/Adapter/Persistence/CodeIgniter/CodeIgniterTransactionalUnitOfWork.php
[A-overview]: https://github.com/johnnickell/fight-access-control/blob/319738255e682d587642b67856039f882b9588d6/docs/release-0.8.0.md
[outcomes]: https://github.com/johnnickell/fight-access-control/blob/319738255e682d587642b67856039f882b9588d6/docs/operation-outcomes.md
[roles]: https://github.com/johnnickell/fight-access-control/blob/319738255e682d587642b67856039f882b9588d6/docs/role-revisions.md
[rename-handler]: https://github.com/johnnickell/fight-access-control/blob/319738255e682d587642b67856039f882b9588d6/src/Application/AccessControl/Role/CommandHandler/RenameCustomRoleHandler.php
[A-domain]: https://github.com/johnnickell/fight-access-control/tree/319738255e682d587642b67856039f882b9588d6/src/Domain/AccessControl
[A-application]: https://github.com/johnnickell/fight-access-control/tree/319738255e682d587642b67856039f882b9588d6/src/Application/AccessControl
[security]: https://symfony.com/cve-2026-108082
