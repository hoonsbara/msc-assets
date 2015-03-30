
---


## Add ##
_Fields:_
  * [Location](Locations.md)
  * Name
Once the Department is created, a link to the [Assign Categories](Categories#Assign.md) page should be displayed prominently to remind admins to set them up if needed.


---


## Edit ##
_Fields:_
  * [Location](Locations.md) - _I'm still wondering if we should make this even possible. Is there any justification for changing a Department's Location?_
  * Name


---


## Delete ##
This page should check for existing [Assets](Assets.md) mapped to this Department, and display an error if some exist, along with a link to the appropriate mapped [Assets](Assets.md).

`You cannot delete this Department until <a href='whatever'>these 5 Assets</a> are mapped to another Department.`


---


## List ##
If the user is a [Super Admin](Users#Super_Admin.md), display a list of all Departments grouped by [Location](Locations.md). Else, if the user is a [Location Admin](Users#Location_Admin.md) of one or more [Locations](Locations.md), display a list of all Departments in the appropriate [Locations](Locations.md), grouped by [Location](Locations.md). Else, display a list of departments mapped to the user.

_Links:_

Each list item hould link to the appropriate [Asset](Assets#List.md) and [Category](Categories#List.md) list.

_Precision:_

The Department lists should be able to be focused on a single [Location](Locations.md) or a single [Category](Categories.md).


---


## View ##
The view page for departments should display counts of mapped [Users](Users.md) and [Assets](Assets.md), as well as a summary of [asset](Assets.md) values.