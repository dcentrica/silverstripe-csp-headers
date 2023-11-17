---
title: \Firesphere\CSPHeaders\View\CSPBackend
footer: false
---

# CSPBackend

Class Firesphere\CSPHeaders\View\Backend



* Full name: `\Firesphere\CSPHeaders\View\CSPBackend`
* Parent class: [Requirements_Backend](../../../../classes.md)



## Constants

| Constant | Type | Value |
|:---      |:---  |:---   |
|`\Firesphere\CSPHeaders\View\CSPBackend::SHA256`||&#039;sha256&#039;|
|`\Firesphere\CSPHeaders\View\CSPBackend::SHA384`||&#039;sha384&#039;|

## Methods

### __construct



```php
public CSPBackend::__construct(): mixed
```









**Return Value:**





---
### customScript



```php
public CSPBackend::customScript( $script,  $uniquenessID = null): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `script` | **** |  |
| `uniquenessID` | **** |  |


**Return Value:**





---
### customCSS



```php
public CSPBackend::customCSS( $script, null|string $uniquenessID = null): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `script` | **** |  |
| `uniquenessID` | **null|string** |  |


**Return Value:**





---
### insertHeadTags



```php
public CSPBackend::insertHeadTags(string $html, string|null $uniquenessID = null): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `html` | **string** | Custom HTML code |
| `uniquenessID` | **string|null** | A unique ID that ensures a piece of code is only added once |


**Return Value:**





---
### getTagType

Determine the type of the head tag if it's js or css

```php
public CSPBackend::getTagType(string $html): string|null
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `html` | **string** |  |


**Return Value:**





---
### getOptions



```php
protected CSPBackend::getOptions( $html): array
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `html` | **** |  |


**Return Value:**





---
### javascript

Register the given JavaScript file as required.

```php
public CSPBackend::javascript(string|null $file, array $options = []): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `file` | **string|null** | Either relative to docroot or in the form &quot;vendor/package:resource&quot; |
| `options` | **array** | List of options. Available options include:<br />- &#039;provides&#039; : List of scripts files included in this file<br />- &#039;async&#039; : Boolean value to set async attribute to script tag<br />- &#039;defer&#039; : Boolean value to set defer attribute to script tag<br />- &#039;type&#039; : Override script type= value. |


**Return Value:**





---
### isAsync



```php
protected CSPBackend::isAsync( $file,  $options): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `file` | **** |  |
| `options` | **** |  |


**Return Value:**





---
### isDefer



```php
protected CSPBackend::isDefer( $file,  $options): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `file` | **** |  |
| `options` | **** |  |


**Return Value:**





---
### includeInHTML

Copy-paste of the original backend code. There is no way to override this in a more clean way

```php
public CSPBackend::includeInHTML(string $content): string
```

Update the given HTML content with the appropriate include tags for the registered
requirements. Needs to receive a valid HTML/XHTML template in the $content parameter,
including a head and body tag.

We need to override the whole method to adjust for SRI in javascript






**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `content` | **string** | HTML content that has already been parsed from the $templateFile<br />through {@link SSViewer} |


**Return Value:**

HTML content augmented with the requirements tags



---
### shouldContinue



```php
protected CSPBackend::shouldContinue( $content): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `content` | **** |  |


**Return Value:**





---
### getJSRequirements



```php
protected CSPBackend::getJSRequirements(array $jsRequirements): string
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `jsRequirements` | **array** |  |


**Return Value:**





---
### getCSSRequirements



```php
protected CSPBackend::getCSSRequirements(array $requirements): array
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `requirements` | **array** |  |


**Return Value:**





---
### getHeadTags



```php
protected CSPBackend::getHeadTags(array $requirements = []): string
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `requirements` | **array** |  |


**Return Value:**





---
### insertContent



```php
protected CSPBackend::insertContent( $content, string $requirements, string $jsRequirements): string
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `content` | **** |  |
| `requirements` | **string** |  |
| `jsRequirements` | **string** |  |


**Return Value:**





---


## Inherited methods

### isJsSRI



```php
public static CSPBackendTrait::isJsSRI(): bool
```



* This method is **static**.





**Return Value:**





---
### setJsSRI



```php
public static CSPBackendTrait::setJsSRI(bool $jsSRI): void
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `jsSRI` | **bool** |  |


**Return Value:**





---
### isCssSRI



```php
public static CSPBackendTrait::isCssSRI(): bool
```



* This method is **static**.





**Return Value:**





---
### setCssSRI



```php
public static CSPBackendTrait::setCssSRI(bool $cssSRI): void
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `cssSRI` | **bool** |  |


**Return Value:**





---
### getHeadCSS



```php
public static CSPBackendTrait::getHeadCSS(): array
```



* This method is **static**.





**Return Value:**





---
### setHeadCSS



```php
public static CSPBackendTrait::setHeadCSS(array $headCSS): void
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `headCSS` | **array** |  |


**Return Value:**





---
### getHeadJS



```php
public static CSPBackendTrait::getHeadJS(): array
```



* This method is **static**.





**Return Value:**





---
### setHeadJS



```php
public static CSPBackendTrait::setHeadJS(array $headJS): void
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `headJS` | **array** |  |


**Return Value:**





---
### isUsesNonce



```php
public static CSPBackendTrait::isUsesNonce(): bool
```



* This method is **static**.





**Return Value:**





---
### setUsesNonce



```php
public static CSPBackendTrait::setUsesNonce(bool $useNonce): void
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `useNonce` | **bool** | static::isUseNonce() |


**Return Value:**





---
### getJsBuilder



```php
public CSPBackendTrait::getJsBuilder(): \Firesphere\CSPHeaders\Builders\JSBuilder
```









**Return Value:**





---
### setJsBuilder



```php
public CSPBackendTrait::setJsBuilder(\Firesphere\CSPHeaders\Builders\JSBuilder $jsBuilder): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `jsBuilder` | **\Firesphere\CSPHeaders\Builders\JSBuilder** |  |


**Return Value:**





---
### getCssBuilder



```php
public CSPBackendTrait::getCssBuilder(): \Firesphere\CSPHeaders\Builders\CSSBuilder
```









**Return Value:**





---
### setCssBuilder



```php
public CSPBackendTrait::setCssBuilder(\Firesphere\CSPHeaders\Builders\CSSBuilder $cssBuilder): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `cssBuilder` | **\Firesphere\CSPHeaders\Builders\CSSBuilder** |  |


**Return Value:**





---


---
> Automatically generated from source code comments on 2023-11-14 using [phpDocumentor](http://www.phpdoc.org/) and [dmarkic/phpdoc3-template-md](https://github.com/dmarkic/phpdoc3-template-md)
