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
- "Add link" form
- Index page view switching (Switch Statement)
- Display list of user links
- Parse links to predict the title
- Parse links to try and get keywords
 
##Handy Functions
spit( string ); // encases the string in paragraph tags then echoes it. Best for tracking errors.
$output .= file_get_contents("some.html"); // adds the html to the output varable.

##Issues
- "config/install.php" fails to run. For now, use "config/temp.sql" to build database instead.

## Important Variable Names
- $conn = Database connection
- $output - Added/declared in index.php. This is going to contain most of the page's HTML, so don't re-declare in view files.
