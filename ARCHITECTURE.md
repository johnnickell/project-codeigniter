# CodeIgniter Architecture Boundary

CodeIgniter owns application configuration, `Config\\Services` discovery, routing, controllers, views, Spark console entry points, and future framework adapters. Fight Common and Fight AccessControl remain public Composer dependencies; copied Domain or Application trees and unpublished-package internals are prohibited.

The bootstrap exposes only a public hello-world HTTP seam. Authentication, authorization flows, persistence, browser journeys, and production integrations require separate local tickets and evidence.
