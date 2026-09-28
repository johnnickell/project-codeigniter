# CodeIgniter Architecture Boundary

CodeIgniter owns application configuration, `Config\\Services` discovery, routing, controllers, views, Spark console entry points, and future framework adapters. Fight Common and Fight AccessControl remain public Composer dependencies; copied Domain or Application trees and unpublished-package internals are prohibited.

The bootstrap exposes only a public hello-world HTTP seam. Authentication, authorization flows, persistence, browser journeys, and production integrations require separately approved local TASKs and evidence.

`App\\` remains mapped to `app/`; CodeIgniter-native controllers, configuration, and service discovery are not
relocated to another framework's layout. The named `home` route supplies URL-generation integration evidence;
the certification-only `/framework-support/receipt` alias is retired.

TASK-00007 retires framework-support receipt and dependency-lane certification. The starter verifies its behavior
and important public-package integrations, not a separate package-release receipt authority. Dependency
preparation is explicit; `./bin/build` checks the prepared runtime without installing or updating packages.
Production-profile checks use safe test credentials and intercepted provider transports; they are not evidence
of live delivery, deployment readiness, or a clean `--no-dev` installation.
