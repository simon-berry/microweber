# Tech-Trac UK: first admin hardening patch

## Scope

This patch removes the installed-site middleware fallback that allowed requests through when no administrator record existed. Guests and non-administrators now follow the existing login redirect unless their named route matches the login/reset exceptions. Route exceptions use anchored Laravel wildcard matching rather than unanchored regular expressions.

This does not implement customer editor permissions, tenant isolation, provisioning readiness checks, or protection for endpoints that do not use this middleware. Existing admin event dispatch and update behaviour are unchanged.

## Recovery and rollout

An installed site without an administrator must be repaired through trusted server-side administration, not by opening the admin interface to unauthenticated visitors. Provision websites privately and verify an administrator before exposing them. Test login and password-reset flows on staging before rollout.

## Validation

Added tests cover route-exception matching only. They do not exercise the complete middleware request lifecycle or database state.

Run with installed project dependencies:

```sh
vendor/bin/phpunit tests/Unit/TechTrac/AdminRouteExceptionsTest.php
```

The tests have not been executed by the authoring assistant. Required integration cases before deployment: installed site with no administrator; guest with an administrator present; ordinary user; authenticated administrator; uninstalled site; login/reset endpoints; direct API access; and authentication suspension behaviour.
