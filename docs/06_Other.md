# Other security headers

A few other security related headers are supported.
- Referer-policy
- X-Frame-Options
- X-Content-Type_Options

Note that X headers are often either experimental or being phased out, so this can change without notice.

## Configuration

```yaml
Firesphere\CSPHeaders\View\CSPBackend:
  referrer: same-origin
  frame-options: SAMEORIGIN
  content-type-options: nosniff
```

Note that the module (currently) does _NOT_ validate if the values in the YML are _valid_ values for the header!

## X-XSS-Protection

[X-Xss-Protection is an outdated header, that is not supported or used in any browser nowadays.](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection#browser_compatibility)

If you really need it because the client/pentester insists it's necessary, put it in your nginx or apache configuration.
