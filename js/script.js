function save()
{
	localStorage.setItem("text", document.getElementById("desc").value); //Permet de stocker le contenu de la description
}

function Alert()
{
	document.getElementById("alert").innerHTML="<div class='uk-alert-success' uk-alert > <a class='uk-alert-close' uk-close ></a> <p>Votre formulaire a bien été pris en compte.</p></div>"
}
function feed()//Cette fonction permet de remplir les deux select, allégeant le code HTML
{
	range.noUiSlider.on("update", function(values, handle){
		txt=document.getElementById("nbTxt");
		console.log(values);
		values[0] = parseInt(values[0], 10);

		values[1] = parseInt(values[1], 10);
		console.log(values);
		if (values[0]==values[1])
		{
			txt.innerHTML=values[0] + " joueurs";
		}
		else if (values[0]==2)
		{
			txt.innerHTML="Moins de " +values[1]+" joueurs"
		}
		else{
			txt.innerHTML="Entre "+values[0]+" et "+values[1]+" joueurs"
		}
	})
	try
	{
		document.getElementById("desc").value = localStorage.getItem("text");
	}
	catch(e)
	{
	}
	console.log("Valeur : ", document.cookie);
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
	//return chgColor("white")

}

function chgMode()
{
	if (document.getElementById("mode").innerHTML == "Clair ☀")
	{
		document.getElementById("mode").innerHTML = "Sombre 🌙";
		/*var oldlink1 = document.getElementsByTagName("link").item(1);
    	var newlink = document.createElement("link");
    	newlink.setAttribute("rel", "stylesheet");
    	newlink.setAttribute("href", "css/dark.css");
    	document.getElementsByTagName("head").item(0).replaceChild(newlink, oldlink1);*/
		var oldlink1 = document.getElementsByTagName("link").item(1);
		var oldlink2 = document.getElementsByTagName("link").item(4);
		var newlink1 =  document.createElement("link");
		var newlink2 =  document.createElement("link");
		newlink1.setAttribute("rel", "stylesheet");
		newlink1.setAttribute("href", "css/dark.css");
		newlink2.setAttribute("rel", "stylesheet");
		newlink2.setAttribute("href", "css/tail.datetime-harx-dark.min.css");
		document.getElementsByTagName("head").item(0).replaceChild(newlink1, oldlink1);
		document.getElementsByTagName("head").item(0).replaceChild(newlink2, oldlink2);



	}
	else
	{
		document.getElementById("mode").innerHTML = "Clair ☀";
		var oldlink1 = document.getElementsByTagName("link").item(1);
		var oldlink2 = document.getElementsByTagName("link").item(4);
		var newlink1 =  document.createElement("link");
		var newlink2 =  document.createElement("link");
		newlink1.setAttribute("rel", "stylesheet");
		newlink1.setAttribute("href", "css/uikit.css");
		newlink2.setAttribute("rel", "stylesheet");
		newlink2.setAttribute("href", "css/tail.datetime-harx-light.min.css");
		document.getElementsByTagName("head").item(0).replaceChild(newlink1, oldlink1);
		document.getElementsByTagName("head").item(0).replaceChild(newlink2, oldlink2);

		
	}
}
