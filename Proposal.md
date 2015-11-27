##What does it need to meet? (aims/objectives)

To create an online application whose core functionality is the recording of bookmarks (like a reading list). Will build on this with the implementation of groups and sharing links into/on them, along with tags for each link and user postable comments to allow for some discussion. This simpler focus would be to allow individuals to save their own bookmarks, and share pages with others. 

The website should be able to suggest things to the users based on the tags on their previous posts and bookmarks. Although any one can use the website our main target users will most likely be students. One of the reasons we are making this website is because most of the websites that are out there for students to use have poor usability (bad user interface) and this can discourage students from using these types of websites which can help them with their studies and help them further their learning capacity by interacting with other students that are having the same problems as them or interacting with other students that have solutions to problems that they are having difficulties solving.

##Data Gathering and Requirements

> Explain the computer science problems presented by your project, satisfying the programme learning outcome “Apply computational thinking to the design and implementation of moderately complex computing systems”.

KAM DID A SURVAY RIGHT? WHAT DID WE LEARN FROM WHAT?

PERSONA GOES IN HERE... PROBABLY... MAYBE... I GUESS....

##Ethical audit
> You should detail any issues of privacy, data protection or intellectual property rights that may arise, and how you will manage them. You should confirm that you will not be working with minors or vulnerable adults.

The only user information that will be saved by the application is a username, password and email address. Passwords and email addresses will be hashed for some basic security, and items users post will be set to private unless explicitly shared by the user. Optimistically, a user should be using a password that is different to their email address's password, and not holding any other information about them, we should be safe not implementing further backend security. That said, we certainly need to further consider what other security measures we can take and whether it's worth taking them. For example, actions like enouraging users to choose a unique password are easy to impliment and should be taken.

##Design
> Design concepts, alternatives considered, chosen design.

Kam used powerpoint/keynote to create an interactive prototype (based off of wireframes we created in a meeting) that demonstrates how users will navigate the site.

##Prototyping
> Describe the prototyping you did, and what you learned from this.

We drew wireframes on a whiteboard and discussed together what should go where and why. Considering what the users are going to need regularly, we've attempted to lay them out in a way that minimises user clicks, and discussed what features and settings people will need, and how we want to format the navigation system. Kam took this further and used powerpoint/keynote to determine how usable our layout ideas were.

We've also started considering how to structure the database tables.

Kriss's personal bookmarking app has similar functionality to some of the core features we want to implememnt: users can save links to view later. (http://qvvz.uk/)

POSSIBLE TABLE STRUCTURE DIAGRAM HERE

##Evaluation Plan
> How you intend to test and evaluate your software during and after development. It may be useful to specify individual test cases.

The following tests are the most likely measure of success, with the aim being for the application to satisfy all of them:

- Test 1: A User A can add a series of links, a number of which are on a single subject. The program should find tags from all included links, and trends should be visible based upon these tags. 

- Test 2: Expanding upon the case of Test 1, except searching for the trends within posts shared to a group, rather than from individual people.

- Test 3: Using the tags from the previous test cases, the system should be able to reccomend a link from the database that is NOT in the user's list.

- Test 4: The search function should accept one or more links, find relevant tags from them, and reccomend another link (that was not in the list er user is searching with) which is similar. 

##Project management
> How you will manage the development process: roles, Gantt charts, milestones, development methodology etc.

The application will be developed in PHP, alongside a MySQL database. The application will also use some Javascript to supplement it's design; for example hiding an individual entry's settings until the user wants to expand them, while keeping them present in the html source for accessability reasons.

We've started - and will continue to use - a gantt chart to keep track of what we need to do, how we are progressing and when we actually did things, on a week-to-week basis. 

We will also be considering a roadmap, or feature list, of practical things we will need to complete in the application before we can move further down the list. This should allow us to start abstracting our code before we write it, saving us time that we might otherwise spend refactoring our code.

Our key milestones will likely be: producing the minimal functional product (before implemenmting the reccomender system), a minimum viable product that is complete enough for a user to use without guidence, an administration interface and a functional reccomender system.

Kam - Handling most of the record keeping and some planning. Is also handling any surveys we use.
Kriss - Constructing roadmap and leading backend development.
Adonay - Building user flow diagrams.
Pou - 
Max - 
Dom - 

General planning, prototyping and development is being, and will be, contributed to by everyone.

PROBLEMS WE'LL FACE

##Conclusion
> Summarise your proposal, including the key points from the previous sections.

##Bibliography
> A list of published sources referenced in the proposal.

##Appendices
> The appendix or appendices should contain your group meeting minutes and any
additional raw material that is referred to in the text (e.g. data from requirements gathering, paper prototypes etc.)