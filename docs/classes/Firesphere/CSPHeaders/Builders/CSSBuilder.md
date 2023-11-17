---
title: \Firesphere\CSPHeaders\Builders\CSSBuilder
footer: false
---

# CSSBuilder

Class Firesphere\CSPHeaders\Builders\CSSBuilder



* Full name: `\Firesphere\CSPHeaders\Builders\CSSBuilder`
* Parent class: [\Firesphere\CSPHeaders\Builders\BaseBuilder](./BaseBuilder.md)
* This class implements: \Firesphere\CSPHeaders\Interfaces\BuilderInterface



## Methods

### __construct

CSSBuilder constructor.

```php
public CSSBuilder::__construct(\Firesphere\CSPHeaders\View\CSPBackend $backend): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `backend` | **\Firesphere\CSPHeaders\View\CSPBackend** |  |


**Return Value:**





---
### buildTags



```php
public CSSBuilder::buildTags(string $file, array $attributes, array $requirements, string $path): array
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `file` | **string** |  |
| `attributes` | **array** |  |
| `requirements` | **array** |  |
| `path` | **string** |  |


**Return Value:**





---
### getSriBuilder



```php
public CSSBuilder::getSriBuilder(): \Firesphere\CSPHeaders\Builders\SRIBuilder
```









**Return Value:**





---
### setSriBuilder



```php
public CSSBuilder::setSriBuilder(\Firesphere\CSPHeaders\Builders\SRIBuilder $sriBuilder): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `sriBuilder` | **\Firesphere\CSPHeaders\Builders\SRIBuilder** |  |


**Return Value:**





---
### getHeadTags



```php
public CSSBuilder::getHeadTags(array& $requirements): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `requirements` | **array** |  |


**Return Value:**





---
### getCustomTags



```php
public CSSBuilder::getCustomTags(array $requirements = []): array
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `requirements` | **array** |  |


**Return Value:**





---
### getOwner



```php
public CSSBuilder::getOwner(): \Firesphere\CSPHeaders\View\CSPBackend
```









**Return Value:**





---
### setOwner



```php
public CSSBuilder::setOwner(\Firesphere\CSPHeaders\View\CSPBackend $owner): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `owner` | **\Firesphere\CSPHeaders\View\CSPBackend** |  |


**Return Value:**





---


## Inherited methods

### getBaseHeadTags



```php
protected BaseBuilder::getBaseHeadTags(array& $requirements, array $scripts, string $type = &#039;&#039;): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `requirements` | **array** |  |
| `scripts` | **array** |  |
| `type` | **string** |  |


**Return Value:**





---
### getNonce



```php
public static BaseBuilder::getNonce(array& $options): void
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `options` | **array** |  |


**Return Value:**





---
### getBaseCustomTags



```php
protected BaseBuilder::getBaseCustomTags(array& $requirements = [], array $scripts = [], string $type = &#039;&#039;): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `requirements` | **array** |  |
| `scripts` | **array** |  |
| `type` | **string** |  |


**Return Value:**





---
### getCurrentRequest



```php
public static BaseBuilder::getCurrentRequest(): \SilverStripe\Control\HTTPRequest|null
```



* This method is **static**.





**Return Value:**





---
### setCurrentRequest



```php
public static BaseBuilder::setCurrentRequest(\SilverStripe\Control\HTTPRequest $currentRequest): void
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `currentRequest` | **\SilverStripe\Control\HTTPRequest** |  |


**Return Value:**





---


---
> Automatically generated from source code comments on 2023-11-14 using [phpDocumentor](http://www.phpdoc.org/) and [dmarkic/phpdoc3-template-md](https://github.com/dmarkic/phpdoc3-template-md)
