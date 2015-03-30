## Search Fields ##
The following fields should be searchable per the given restrictions:
  * Asset Tag - _asset tags must be matched in full_ (`tag='string'`)
  * Name - _the name value should allow partial matches_ (`name LIKE '%string%'`)
  * Serial - _the serial number should allow partial matches_ (`serial LIKE '%string%'`)
  * Model - _the model number should allow partial matches_ (`model LIKE '%string%'`)
  * Unique 1 & 2 - _the special unique tags should allow partial matches_ (`unique_1_value LIKE '%text%'`)

## Additional Notes ##
With any of the above, if only one match returns, the browser should be automatically redirected (`header('Location: foo.php');`) to the appropriate View Asset page.