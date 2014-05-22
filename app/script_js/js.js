function ajoutUser(){
	
	//récupère le contenu du select
	//var select = document.getElementById("bidonn").value;
	var select = document.getElementsByTagName("bidon").value;
	//var choice = select.selectedIndex  ;// Récupération de l'index du <option> choisi
 
	
	//document.write(select);
	//Création du nouveau Noeud
	var Nodenew = document.createElement("option");
	//var Nodenew2 = document.createElement("option");
	var texte = document.createTextNode(select);
	//var texte2 = document.createTextNode("option 3");
	Nodenew.appendChild(texte);
	//Nodenew2.appendChild(texte2);
	
	//Recupération du Noeud "position"
	var Node = document.getElementById("affiche");
	var NodeListe = Node.getElementsByTagName("option");
	var position = NodeListe.item(1);
	
	//Insertion
	Node.appendChild(Nodenew,position);
}
