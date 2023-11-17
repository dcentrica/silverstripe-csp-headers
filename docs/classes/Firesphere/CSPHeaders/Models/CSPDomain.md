---
title: \Firesphere\CSPHeaders\Models\CSPDomain
footer: false
---

# CSPDomain

Class \Firesphere\CSPHeaders\Models\CSPDomain



* Full name: `\Firesphere\CSPHeaders\Models\CSPDomain`
* Parent class: [DataObject](../../../../classes.md)
* This class implements: \SilverStripe\Security\PermissionProvider



## Methods

### getSourceMap



```php
protected static CSPDomain::getSourceMap(): array|string[]
```



* This method is **static**.





**Return Value:**





---
### setSourceMap



```php
public static CSPDomain::setSourceMap(array|string[] $sourceMap): void
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `sourceMap` | **array|string[]** |  |


**Return Value:**





---
### getTitle



```php
public CSPDomain::getTitle(): string
```









**Return Value:**





---
### getCMSFields



```php
public CSPDomain::getCMSFields(): \SilverStripe\Forms\FieldList
```









**Return Value:**





---
### canCreate



```php
public CSPDomain::canCreate(null|\SilverStripe\Security\Member $member = null, array $context = array()): bool|int
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `member` | **null|\SilverStripe\Security\Member** |  |
| `context` | **array** |  |


**Return Value:**





---
### canEdit



```php
public CSPDomain::canEdit(null|\SilverStripe\Security\Member $member = null): bool|int
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `member` | **null|\SilverStripe\Security\Member** |  |


**Return Value:**





---
### canView



```php
public CSPDomain::canView(null|\SilverStripe\Security\Member $member = null): bool|int
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `member` | **null|\SilverStripe\Security\Member** |  |


**Return Value:**





---
### canDelete



```php
public CSPDomain::canDelete(null|\SilverStripe\Security\Member $member = null): bool|int
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `member` | **null|\SilverStripe\Security\Member** |  |


**Return Value:**





---
### providePermissions

Return a map of permission codes to add to the dropdown shown in the Security section of the CMS.

```php
public CSPDomain::providePermissions(): mixed
```

array(
  'VIEW_SITE' => 'View the site',
);







**Return Value:**





---


---
> Automatically generated from source code comments on 2023-11-14 using [phpDocumentor](http://www.phpdoc.org/) and [dmarkic/phpdoc3-template-md](https://github.com/dmarkic/phpdoc3-template-md)
