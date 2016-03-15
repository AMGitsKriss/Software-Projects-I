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

 
##Handy Functions
spit( string ); // encases the string in paragraph tags then echoes it. Best for tracking errors.
$output .= file_get_contents("some.html"); // adds the html to the output varable.

##Issues
- "config/install.php" fails to run. For now, use "config/temp.sql" to build database instead.

## Important Variable Names
- $conn = Database connection
- $output - Added/declared in index.php. This is going to contain most of the page's HTML, so don't re-declare in view files.
