
---


## Add ##
_Fields:_
  * Name


---


## Edit ##
_Fields:_
  * Name


---


## Delete ##
This page should check for existing [Departments](Departments.md) mapped to this Location, and display an error if some exist, along with a link to the appropriate mapped [Departments](Departments.md).
`You cannot delete this Location until <a href='whatever'>this Department</a> is mapped to another Location.`


---


## List ##
If the user is a [Super Admin](Users#Super_Admin.md), display a list of all Locations. Else, if the user is a [Location Admin](Users#Location_Admin.md) of one or more Locations, display a list of all appropriate Locations. Else, display a list of Locations based on the user's mapped [Departments](Departments.md).

_Links:_
Each list item should link to the appropriate [Department List](Departments#List.md).


---


## View ##
The view page for Locations should display counts of mapped [Users](Users.md), [Location Admins](Users#Location_Admin.md), and [Assets](Assets.md), as well as a summary of [asset](Assets.md) values.