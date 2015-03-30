
---


## Add ##
_Fields:_
  * Email Address
  * Name
  * Password - _to be stored as a salted hash (sha512, or something else with hash()), of course_
  * Super Admin - _see below_


---


## Edit ##
_Fields:_
  * Email Address
  * Name
  * Super Admin
  * Active/Inactive


---


## Delete ##
This page should suggest setting the user as Inactive rather than deleting it altogether. If any log data exists for the user, it should emphasize that deleting the user would result in bad data. We should require a confirmation checkbox before deleting a User to prevent accidental deletion.

If the user is deleted anyway, the appropriate [Assets](Assets.md) and [Logs](Logs.md) records should be updated to have a user\_id of 0.


---


## List ##
Only [Super Admins](#Super_Admin.md) should be able to view the list of Users.

_Links:_

Each list item hould link to the appropriate [Asset](Assets#List.md) and [Category](Categories#List.md) list.

_Precision:_

The Department lists should be able to be focused on a single [Location](Locations.md) or a single [Category](Categories.md).


---


## View ##
The view page for Users should display counts of entered [AssetsAssets](AssetsAssets.md), as well as recent [Logs](Logs.md).


---


## Forgot Password ##
This should include a form with only an email address. Upon submission, this should generate a new password and email a copy of it to the registered user with the given email. No indication of failure should be given if no email matches are made.


---


## Department Mappings ##
This page should define which [Departments](Departments.md) are available to the given User. A series of checkboxes (or prettier toggles in some form) should be sufficient.


---


## Other Notes ##

### Super Admin ###
Super Admin Users have the ability to govern all aspects of the application, regardless of [Department](Departments.md) or [Location](Locations.md). Think of them as **root** accounts.

Only Super Admins should be able to create and manage Users.

### Location Admin ###
Location Admin Users have the ability to manage all aspects of their own location. Specifically, they can view/manage all [Departments](Departments.md) and [Categories](Categories.md). They cannot, however, manage Users.