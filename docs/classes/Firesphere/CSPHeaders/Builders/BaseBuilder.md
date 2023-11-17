---
title: \Firesphere\CSPHeaders\Builders\BaseBuilder
footer: false
---

# BaseBuilder

Class Firesphere\CSPHeaders\Builders



* Full name: `\Firesphere\CSPHeaders\Builders\BaseBuilder`



## Methods

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
