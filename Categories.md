
---


## Add ##
_Fields:_
  * Parent - _listed as a `<select>` with a hierarchy (by means of CSS, not characters) of existing Categories, along with a 'Top Level' option_
  * Name


---


## Edit ##
_Fields:_
  * Parent - _same as above_
  * Name
This page should mention that changing the Parent also changes the children accordingly.


---


## Delete ##
This page should check for existing child Categories, and display an error if some exist, along with a link to the appropriate Categories.

`You cannot delete this Category until <a href='somelink'>its child Categories</a> are placed under a different parent.`

It should also check for existing mapped [Assets](Assets.md), and display the appropriate error if some are found.


---


## List ##
Only [Super Admins](#Super_Admin.md) should be able to view the full list of Categories.

_Links:_

Each list item should link to the appropriate [Asset List](Assets#List.md).

_Precision:_

The Category lists should be able to be focused on a single [Location](Locations.md), [Department](Departments.md).


---


## View ##
The view page for Categories should display counts for [Departments](Departments.md)/[Assets](Assets.md) mapped to the given Category, along with combined [Asset](Assets.md) values.

The page should be presented in a manner to communicate the context (parent/children) of the focused Category with the ability to navigate accordingly.


---


## Assign ##
This page should assign Categories to [Departments](Departments.md). A checkbox/toggle should be sufficient for each [Department](Departments.md).