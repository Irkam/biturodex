var usercount = 0;

function ajoutUser(){
	newuser = document.getElementById("usersearchinput").value;
	user = getUserByName(newuser);
	
	newoption = document.createElement("li");
	//newoption.setAttribute("name", "user0");
	//newoption.setAttribute("value", newuser);
	newoption.innerHTML = user.username;
	document.getElementById("useraddlist").appendChild(newoption);
	
	//Ajout champ hidden
	newinputhidden = document.createElement("input");
	newinputhidden.setAttribute("type", "hidden");
	newinputhidden.setAttribute("name", "user" + usercount);
	newinputhidden.setAttribute("value", user.uid);
	document.getElementById("newconversationform").appendChild(newinputhidden);
	usercount += 1;
	
	document.getElementById("conversationuserscount").setAttribute("value", usercount);
}

function getUserByName(username){
	url = "http://localhost/biturodex/service/getusersbyname.php?name=" + username;
	ajaxquery = $.ajax(url);
	users = $.parseJSON(ajaxquery.responseText);
	return users[0];
}
