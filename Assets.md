
---


## Add ##
_Fields:_
  * Asset Tag
  * Serial Number
  * Unique Identifiers - _two available, along with custom field labels_
  * Brand
  * Model Number
  * Name
  * Description
  * Category
  * Department
  * In-Service Date - _or purchase date, if in-service date not known_
  * Cost
  * [Flat Depreciation Value](Depreciation.md) - _if [Super Admin](Users#Super_Admin.md) and Flat-Rate depreciation method for [Category](Categories.md)_

_Log:_
  * entry date
  * entry user

When the form submits, the form should load with the previous values by default (maybe two buttons, one "Add" and a default "Add and Add Another") with the unique fields (asset tag, serial, etc.) cleared. That should speed up repeated entry. It also couldn't hurt to have the unique data fields grouped together at the top of the form.

It might be a nice touch to have the model number, onblur, perform an Ajax request to fill in the name/description fields based on the most recent matching model number. Adding an AutoComplete on Brand/model# would be a nice touch, too.

Note that these fields will often be scanned in with a barcode reader. Most of these barcode readers emulate a keyboard typing out the barcode value and pressing enter. Obviously, the asset tag field is a premature position to submit the form, so we will need to interrupt the _Enter_ key, and instead push the focus to the next field.


---


## Edit ##
_Fields:_
  * All above fields
  * Status - _sold, disposed, or current_
  * Status date

_Log:_
  * Changes to Asset Tag or Status


---


## Delete ##
This page should suggest adjusting the Asset's status rather than deleting it outright. Items should only be deleted if they're accidental entry. Otherwise, assets still must be accounted for.

> _Should this be restricted to admin only?_


---


## List ##
If the [User](Users.md) is a [Super Admin](Users#Super_Admin.md), this should list all Assets. If the [User](Users.md) is a [Location Admin](Users#Location_Admin.md), this should list all Assets mapped to a [Department](Departments.md) in the appropriate [Locations](Locations.md) (maybe the [Locations](Locations.md) should be in a `<select>` at the top, so only one is being pulled at a time?).

_Precision:_

The Asset lists should be able to be focused on a single [Department](Departments.md) or a single [Category](Categories.md), and should be able to be further confined to a certain status.


---


## View ##
The view page for Assets should display the full [Log](Logs.md) for the given item, plus the complete [Depreciation](Depreciation.md) schedule and all Asset-specific data. The full hierarchy of the Asset's [Category](Categories.md) should also be provided.