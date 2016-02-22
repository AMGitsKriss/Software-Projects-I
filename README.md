##Roadmap
- "Add link" form
- Login with cookies?
- Index page view switching (Switch Statement)
	- Home
	- Settings (inc. group edit/making)
	- Group List (Kriss is working on)
	- Personal List
- Display list of user links
	- Parse links to predict the title
	- Parse links to try and get keywords
	- Edit links


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
- Index View switching
	- Landing/Login/Registration
- Group Management

##Handy Functions
spit( string ); // encases the string in paragraph tags then echoes it. Best for tracking errors.
$output .= file_get_contents("some.html"); // adds the html to the output varable.

##Issues
- "config/install.php" fails to run. For now, use "config/temp.sql" to build database instead.

## Important Variable Names
- $conn = Database connection
- $output - Added/declared in index.php. This is going to contain most of the page's HTML, so don't re-declare in view files.
