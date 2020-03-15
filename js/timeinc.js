function Onchange()
{
	reg = new RegExp("^[^@#]{2,32}#[0-9]{4}"); //On cherche une chaîne de caractère comprenant d'abord entre deux et 32 caractères quelconques sauf un # et @, suivis d'un # et d'une suite de 4 chiffres
	if (!(reg.test(document.getElementById("mj").value)))
	{
		document.getElementById("mj").setCustomValidity("Le pseudo ne respecte pas le format");
	}
	else
	{
		document.getElementById("mj").setCustomValidity("");
	}
}
function feed()//Cette fonction permet de remplir les deux select, allégeant le code HTML
{
	time = document.getElementById("selectorTime");
	hour = document.getElementById("selectorHour"); 
	t = 0;
	while (t <= 300)
	{
		t = t + 30;
		m = (t % 60).toString();
		h = Math.floor(t / 60).toString() + "h";
		if (h == "0h")
		{
			h = "";
			m = m + "m";
		}
		if (m == "0")
		{
			m = "";
		}
		var opt = document.createElement("option");
		opt.innerHTML = h + m;
		time.appendChild(opt);
	}
	t = 0;
	while (t <= 1410)
	{
		m = (t % 60).toString();
		h = Math.floor(t / 60).toString() + "h";
		if (m.length == 1)
		{
			m ="0" + m;
		}
		if (h.length == 2)
		{
			h = "0" + h;
		}
		var opt = document.createElement("option");
		opt.innerHTML = h + m;
		hour.appendChild(opt);
		t = t + 30
	}
	
}
function chgMode()
{
	if (document.getElementById("mode").innerHTML == "Clair ☀")
	{
		document.getElementById("mode").innerHTML = "Sombre 🌙";
		var oldlink = document.getElementsByTagName("link").item(1);
    	var newlink = document.createElement("link");
    	newlink.setAttribute("rel", "stylesheet");
    	newlink.setAttribute("href", "css/dark.css");
    	document.getElementsByTagName("head").item(0).replaceChild(newlink, oldlink);

	}
	else
	{
		document.getElementById("mode").innerHTML = "Clair ☀";
		var oldlink = document.getElementsByTagName("link").item(1);
    	var newlink = document.createElement("link");
    	newlink.setAttribute("rel", "stylesheet");
    	newlink.setAttribute("href", "css/uikit.css");
    	document.getElementsByTagName("head").item(0).replaceChild(newlink, oldlink);

		
	}
}
function post33()
{
	try
	{
		pj = document.querySelector('input[name = pj]:checked').value; //Permet de récupérer la valeur cochée dans le bouton radio
	}
	catch(TypeError)
	{
		pj = ""; //Dans le cas où il n'a rien coché
	}
	try
	{
		desc = document.getElementById("desc").value; //On remplace les @ par des \@ afin d'éviter des ping discord 
	}
	catch(TypeError)
	{
		desc = ""; //La description étant optionelle, il se peut qu'elle soit vide
	}
	console.log(desc);
	date = document.getElementById("date").value.split("-").reverse().join("/"); //Le <input type = date> renvoie par défaut Année-Mois-Jour donc on transforme en Jour/Mois/Année
	hour =  document.getElementById("selectorHour").value;
	time = document.getElementById("selectorTime").value;
	mj = document.getElementById("mj").value;
	type = document.getElementById("type").value;
	outils = document.getElementById("outils").value;
	systeme = document.getElementById("system").value;
	if (outils == "" || hour  == "" || system == "" || date == "" || time == "" || !(reg.test(document.getElementById("mj").value)) || pj == "") //Si l'un des champs est vide,  on clique sur submit afin de forcer l'utlisateur à les remplir
	{
		document.getElementById("submit").click();
	}
	else
	{
		url = "https://discordapp.com/api/webhooks/688376945062314051/pCEkv1Pxsz7erhtUK2AAgV0HbMLX_e1R8BKSSb45ZukkzWxIUIYDf9DF8dBZc9NdTYUc"; //Url du webhook discord, à adapter
		content = "**Type** " + type + "\n" +                  //On crée le contenu du message
					":calendar:  **Date** Le " + date + "\n" + 
					":clock2:  **Heure** A partir de " + hour + "\n" + 
					":crown:  **MJ** @" + mj + "\n" + 
					":d10:  **Système** " + systeme + "\n" +
					":timer:  **Durée moyen du scénario ** " + time + "\n" +
					":baby:  **PJ Mineur** " + pj + "\n";
		if (desc != "")
		{
			content = content + ":grey_question:  **Détails** " + desc  + "\n"; //S'il y a une description, on l'ajoute
		}
		content = content + "**Participe** :white_check_mark: / **Ne participe pas** :x:";
		payload = {
			"embeds":[
			{
				"thumbnail":
				{
					"url":"https://cdn.discordapp.com/attachments/457233258661281793/458727800048713728/dae-cmd.png" //url de l'icône
				},
					"title":"Nouveau jeu de rôle !",
					"description":content,
					"color": "16711680"
			}
			]
		};
		
		
		xhr = new XMLHttpRequest(); //On crée une requête
		xhr.open("POST", url, true);//Avec la méthode post
		xhr.setRequestHeader("Content-Type", "application/json")//On spécifie qu'on envoie du json
		xhr.send(JSON.stringify(payload))//Et on l'envoie

	}
	
}
