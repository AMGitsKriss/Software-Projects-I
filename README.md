##Roadmap
- "Add link" form
- Login with cookies?
- Index page view switching (Switch Statement)
	- Landing/Login
	- Home
	- Registration
	- Settings (inc. group edit/making)
	- Group List
	- Personal List
- Display list of user links
	- Parse links to predict the title
	- Parse links to try and get keywords
	- Edit links
- Create group form
- Edit group page


##Done
- Database Schema
- Database setup PHP file
- db_connect.php
- Registration form HTML page 
- Registration php script
- Tweak create_user.php so errors are displayed on the form, rather than blank page.
- Login form
- Login sessions
- Header/navigation bar
- HTAccess navigation (allowing /login instead of /?page=login)

##Handy Functions
spit( string ); // encases the string in paragraph tags then echoes it. Best for tracking errors.

##Issues
- "config/install.php" fails to run. For now, use "config/temp.sql" to build database instead.

## Important Variable Names
- $conn = Database connection