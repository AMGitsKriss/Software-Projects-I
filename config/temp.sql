    CREATE TABLE Users (
		name VARCHAR(100) NOT NULL PRIMARY KEY, 
		email VARCHAR(100), 
		password VARCHAR(100), 
		reg_date TIMESTAMP
	); 
	CREATE TABLE Posts (
		postid INT AUTO_INCREMENT, 
		added TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
		name VARCHAR(100), 
		url VARCHAR(255), 
		owner VARCHAR(100), 
		ip VARCHAR(15), 
		PRIMARY KEY(postid), 
		FOREIGN KEY(owner) REFERENCES Users(name)
	); 
	CREATE TABLE Groups (
		name VARCHAR(100) NOT NULL PRIMARY KEY
	); 
	CREATE TABLE GroupMembers (
		groupid VARCHAR(100), 
		userid VARCHAR(100), 
		FOREIGN KEY (groupid) REFERENCES Groups(name), 
		FOREIGN KEY (userid) REFERENCES Users(name)
	); 
	CREATE TABLE Tags (
		name VARCHAR(100) NOT NULL PRIMARY KEY
	); 
	CREATE TABLE TagMambers (
		tagid VARCHAR(100), 
		postid INT(6), 
		FOREIGN KEY (tagid) REFERENCES Tags(name), 
		FOREIGN KEY (postid) REFERENCES Posts(postid)
	); 
	CREATE TABLE GroupPosts (
		postid INT, 
		groupid VARCHAR(100), 
		FOREIGN KEY (groupid) REFERENCES Groups(name), 
		FOREIGN KEY (postid) REFERENCES Posts(postid)
	);