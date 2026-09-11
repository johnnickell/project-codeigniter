# WF-005 — Authentication and Account Security Contract

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Gate:** Symfony authentication contract
**Map:** [CodeIgniter AccessControl Starter Application](../codeigniter-access-control-application-map.md)
**Depends on:** WF-003, WF-004

## Question

What complete JWT and secure refresh-session authentication contract should the CodeIgniter adapters enforce for browser and API
account lifecycle workflows without weakening released AccessControl semantics?

## Must decide

- Define asymmetric access-JWT issuance and verification, claims, key identifiers and rotation, clocks,
  issuer/audience, short lifetime, and authoritative user/session revalidation.
- Define the HttpOnly refresh-cookie lifecycle: issuance, domain/path/same-site/security attributes, single-use
  rotation, concurrent reuse detection, family revocation, expiry, and audit behavior.
- Define CodeIgniter services and filters for authentication entry points, stateless/stateful boundaries, denial
  responses, trusted proxies, and request-scoped security state.
- Define exact methods, content types, CSRF/origin/fetch-metadata defenses, and the allowed CORS boundary for
  refresh, logout, and every cookie-authenticated mutation.
- Define login, logout, invitation and account activation, password reset, email-change request/confirmation,
  credential change, session inspection/revocation, and enumeration-resistant response semantics.
- Define delivery credentials, lifetimes, one-time use, replay behavior, throttling, generic responses, secure
  handling, and retry-safe failure outcomes.
- Keep short-lived access tokens in client memory and refresh credentials in Secure, HttpOnly cookies; rotate on
  use, detect reuse, reject expired/revoked/replayed/concurrent losers, and protect cookie-backed operations from
  CSRF and untrusted origins.
- Rate-limit authentication and recovery by appropriate account/source dimensions and forbid credentials, bearer
  tokens, secrets, or raw sensitive request material in logs.

## Resolution boundary

This ticket settles security behavior and adapter responsibilities. It may not implement filters, routes,
cookies, mail, keys, throttles, or persistence; assign fine-grained resource permissions; or finalize the
operation matrix.

## Resolution

Open. Blocked by WF-003 and WF-004.
