##Roadmap
- Removes echoes from create_user.php

##Done
- Database Schema
- Database setup PHP file
- db_connect.php
- Registration form HTML page 
- Registration php script
- Tweak create_user.php so errors are displayed on the form, rather than blank page.

##Handy Functions
spit( string ); // encases the string in \*<p></p>\* tags then echoes it. Best for tracking errors.

##Issues
- "config/install.php" fails to run. For now, use "config/temp.sql" to build database instead.