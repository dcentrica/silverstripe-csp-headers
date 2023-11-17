---
title: \Firesphere\CSPHeaders\Models\SRI
footer: false
---

# SRI

Class \Firesphere\CSPHeaders\Models\SRI



* Full name: `\Firesphere\CSPHeaders\Models\SRI`
* Parent class: [DataObject](../../../../classes.md)
* This class implements: \SilverStripe\Security\PermissionProvider



## Methods

### findOrCreate



```php
public static SRI::findOrCreate( $file): \Firesphere\CSPHeaders\Models\SRI
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `file` | **** |  |


**Return Value:**





---
### canCreate

Created on request

```php
public SRI::canCreate(null|\SilverStripe\Security\Member $member = null, array $context = array()): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `member` | **null|\SilverStripe\Security\Member** |  |
| `context` | **array** |  |


**Return Value:**





---
### canEdit

If it needs to be edited, it should actually be recreated

```php
public SRI::canEdit(null|\SilverStripe\Security\Member $member = null): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `member` | **null|\SilverStripe\Security\Member** |  |


**Return Value:**





---
### canDelete



```php
public SRI::canDelete(null|\SilverStripe\Security\Member $member = null): bool|int
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `member` | **null|\SilverStripe\Security\Member** |  |


**Return Value:**





---
### onBeforeWrite

Generate the SRI for the file given

```php
public SRI::onBeforeWrite(): mixed
```









**Return Value:**





---
### providePermissions

Return a map of permission codes to add to the dropdown shown in the Security section of the CMS.

```php
public SRI::providePermissions(): mixed
```

array(
  'VIEW_SITE' => 'View the site',
);







**Return Value:**





---
### onAfterBuild

If configured, this deletes the Sub-resource integrity values on build of the database
so they're regenerated next time that file is used.

```php
public SRI::onAfterBuild(): mixed
```

Note that this hook only exists in silverstripe-framework 4.7+







**Return Value:**





---


---
> Automatically generated from source code comments on 2023-11-14 using [phpDocumentor](http://www.phpdoc.org/) and [dmarkic/phpdoc3-template-md](https://github.com/dmarkic/phpdoc3-template-md)
