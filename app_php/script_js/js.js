var usercount = 0;

function ajoutUser(){
	newuser = document.getElementById("usersearchinput").value;
	$.ajax({
		url: "http://localhost/biturodex/service/getusersbyname.php?name=" + newuser,
		success: function(data){
			user = data[0];
			
			newoption = document.createElement("li");
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
		},
		dataType: "json"
	});
}

function updateFormLatLng(){
	var key = "AIzaSyDU_a-nbiISFCPhqF-YluAD6f4e2CMafwE";

	var inputlat = document.getElementById("coordlat");
	var inputlng = document.getElementById("coordlng");
	
	var addr0 = document.getElementById("address0").value;
	var addr1 = document.getElementById("address1").value;
	var city = document.getElementById("city").value;
	var postcode = document.getElementById("postcode").value;
	var fulladdress = addr0 + " " + addr1 + " " + city + " " + postcode;
	
	var ajaxquery = $.ajax({
		url : "https://maps.googleapis.com/maps/api/geocode/json?address=" + fulladdress + "&sensor=true_or_false&key=" + key,
		success: function(data){
			if(data.status=="OK"){
				inputlat.setAttribute("value", data.results[0].geometry.location.lat);
				inputlng.setAttribute("value", data.results[0].geometry.location.lng);
			}
		},
		dataType: "json"
	});
}
