##Roadmap

- Login with cookies?
- Settings (inc. group edit/making)
	- User colours for entries?
	- Change email address
	- Accessability?
- Edit links
	- Update Form
	- Javascript to show/hide update form
	- update function
	- delete post
	- remove  from group
- Password Recovery
- EULA Support
- Masthead? 
- Dynamic Naviagtion Function
- Formatting returned posts
- CSS, Javascript & beatuifying. 
- Parse links to try and get keywords

##Done
- Database Schema (Kriss)
- Database setup PHP file (Kriss)
- db_connect.php (Kriss)
- Registration form HTML page  (Kriss)
- Registration php script (Kriss)
- Tweak create_user.php so errors are displayed on the form, rather than blank page. (Kriss)
- Login form (Adonay)
- Login sessions (Adonay)
- Header/navigation bar (Kam/Kriss)
- HTAccess navigation (allowing /login instead of /?page=login) (Kriss)
- Index View switching (Kam)
	- Landing/Login/Registration (Kriss)
- Group Management (Kriss)
- "Add link" form (Kriss)
- Display list of user links (Kriss)
- Parse links to predict the title (Kriss)

 
##Installation
Ensure server, username, password and database in db_config.php point to a valid database. The host variable also needs to be it's external address. Thus, if the site went in the root of mydomain.com then host would be "mydomain.com" but if it was in a subfolder named site, then host would be "bydomain.com/site"

Browse to config/installation.php

##Issues
- "config/install.php" fails to run. For now, use "config/temp.sql" to build database instead.

## Important Variable Names
- $conn = Database connection
- $output - Added/declared in index.php. This is going to contain most of the page's HTML, so don't re-declare in view files.
