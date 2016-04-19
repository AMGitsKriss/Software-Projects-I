/*
	Function to replace tag ( var id )
	with an edit form. 
	Pre-populate the form. Can it be based on existing tags?
*/

//TODO needs "posted to..." option list
var form = "<form>\n<input name='title' type='text' /><input name='url' type='text' />\n<input type='submit' value='Update' name='update'/>\n<input type='submit' value='Delete' name='delete'/>\n</form>\n";

function editEntryForm(entryId){
	var entry = $( "#" + entryId ).html(); 
	//alert(entry);
	//same structure as CSS: "#/.container #/.subcontrainer"
	//Owner
	var owner = $("#" + entryId + " .owner").text();
	//Post id to update (dropping the word "post" as that's jsut for CSS distinction)
	var id = entryId.substring(4);
	//Post's title/name
	var title = $("#" + entryId + " .post-main a").text();
	//post's url
	var url = $("#" + entryId + " a").attr("href");

	var select = $( ".post .option-container" ).html(); 

	//TODO GRAB THE POSTING FORM AND FILL IN THE BLANKS

	//TODO needs "posted to..." option list
	var form = "<div class=entry-container id=post6 style='background-color:#ffcccc'>\n<form method='POST' action=''>\n<input name='title' type='text' value='" + title + "' /><input name='url' type='text' value='" + url + "' />\n<input type='submit' value='Update' name='update'/>\n<input type='submit' value='Delete' name='delete'/>\n" + select + "\n</form>\n</div>\n";

	//alert(select);

	//Replace the entry with a form
	$( "#" + entryId ).replaceWith(form);
	//alert(owner + "\n" + id + "\n" + title + "\n" + url);
}