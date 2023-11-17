---
title: \Firesphere\CSPHeaders\Extensions\ControllerCSPExtension
footer: false
---

# ControllerCSPExtension

Class \Firesphere\CSPHeaders\Extensions\ControllerCSPExtension



* Full name: `\Firesphere\CSPHeaders\Extensions\ControllerCSPExtension`
* Parent class: [Extension](../../../../classes.md)



## Methods

### addJS



```php
public static ControllerCSPExtension::addJS(string $js): mixed
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `js` | **string** |  |


**Return Value:**





---
### addCSS



```php
public static ControllerCSPExtension::addCSS(string $css): mixed
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `css` | **string** |  |


**Return Value:**





---
### getInlineJS



```php
public static ControllerCSPExtension::getInlineJS(): array
```



* This method is **static**.





**Return Value:**





---
### getInlineCSS



```php
public static ControllerCSPExtension::getInlineCSS(): array
```



* This method is **static**.





**Return Value:**





---
### onBeforeInit

Add the needed headers from the database and config

```php
public ControllerCSPExtension::onBeforeInit(): void
```









**Return Value:**





---
### checkCookie



```php
public static ControllerCSPExtension::checkCookie(\SilverStripe\Control\HTTPRequest $request): bool
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `request` | **\SilverStripe\Control\HTTPRequest** |  |


**Return Value:**





---
### addCSPHeaders



```php
private ControllerCSPExtension::addCSPHeaders(mixed $ymlConfig, \SilverStripe\Control\Controller|null $owner): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `ymlConfig` | **mixed** |  |
| `owner` | **\SilverStripe\Control\Controller|null** |  |


**Return Value:**





---
### addCSP



```php
protected ControllerCSPExtension::addCSP(\ParagonIE\CSPBuilder\CSPBuilder $policy, \SilverStripe\Control\Controller $owner): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `policy` | **\ParagonIE\CSPBuilder\CSPBuilder** |  |
| `owner` | **\SilverStripe\Control\Controller** |  |


**Return Value:**





---
### addInlineJSPolicy



```php
protected ControllerCSPExtension::addInlineJSPolicy(\ParagonIE\CSPBuilder\CSPBuilder $policy, array $config): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `policy` | **\ParagonIE\CSPBuilder\CSPBuilder** |  |
| `config` | **array** |  |


**Return Value:**





---
### getNonce



```php
public ControllerCSPExtension::getNonce(): null|string
```









**Return Value:**





---
### addInlineCSSPolicy



```php
protected ControllerCSPExtension::addInlineCSSPolicy(\ParagonIE\CSPBuilder\CSPBuilder $policy, array $config): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `policy` | **\ParagonIE\CSPBuilder\CSPBuilder** |  |
| `config` | **array** |  |


**Return Value:**





---
### addResponseHeaders



```php
protected ControllerCSPExtension::addResponseHeaders(array $headers, \SilverStripe\Control\Controller $owner): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `headers` | **array** |  |
| `owner` | **\SilverStripe\Control\Controller** |  |


**Return Value:**





---
### addPermissionsHeaders

Add the Permissions-Policy header

```php
private ControllerCSPExtension::addPermissionsHeaders(array $ymlConfig, \SilverStripe\Control\Controller $controller): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `ymlConfig` | **array** |  |
| `controller` | **\SilverStripe\Control\Controller** |  |


**Return Value:**





---
### ymlToPolicy



```php
private ControllerCSPExtension::ymlToPolicy(mixed $key, mixed $yml): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `key` | **mixed** |  |
| `yml` | **mixed** |  |


**Return Value:**





---
### isAddPolicyHeaders



```php
public ControllerCSPExtension::isAddPolicyHeaders(): bool
```









**Return Value:**





---
### trimDomain

Remove https://, trailing slash, etc.

```php
private ControllerCSPExtension::trimDomain( $domain): string
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `domain` | **** |  |


**Return Value:**





---
### createACMHeaders



```php
protected ControllerCSPExtension::createACMHeaders(mixed $cors, \SilverStripe\Control\Controller $owner): array
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `cors` | **mixed** |  |
| `owner` | **\SilverStripe\Control\Controller** |  |


**Return Value:**





---


---
> Automatically generated from source code comments on 2023-11-14 using [phpDocumentor](http://www.phpdoc.org/) and [dmarkic/phpdoc3-template-md](https://github.com/dmarkic/phpdoc3-template-md)
