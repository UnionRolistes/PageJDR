function Onchange()
{
	reg = new RegExp("^[^@#]{2,32}#[0-9]{4}");
	if (!(reg.test(document.getElementById("mj").value)))
	{
		document.getElementById("mj").setCustomValidity("Le pseudo ne respecte pas le format");
	}
	else
	{
		document.getElementById("mj").setCustomValidity("");
	}
}
function post()
{
	try
	{
		pj = document.querySelector('input[name = pj]:checked').value;
	}
	catch(TypeError)
	{
		pj = "";
	}
	try
	{
		desc = document.getElementById("desc").value.replace("@", "\@");
	}
	catch(TypeError)
	{
		desc = "";
	}
	date = document.getElementById("date").value.split("-").reverse().join("/");
	hour =  document.getElementById("selectorHour").value;
	time = document.getElementById("selectorTime").value;
	mj = document.getElementById("mj").value;
	type = document.getElementById("type").value;
	outils = document.getElementById("outils").value;
	systeme = document.getElementById("system").value;
	if (outils == "" || hour  == "" || system == "" || date == "" || time == "" || !(reg.test(document.getElementById("mj").value)) || pj == "")
	{
		document.getElementById("submit").click();
	}
	else
	{
		url = "https://discordapp.com/api/webhooks/680160222756733229/qKcvu9z3RTFoY98nJgUfQjIRcUelKzTbinnhG9QT1BHYWJuL3XPt-79-eHTh5OKKjMeW";
		content = "**Type** " + type + "\n" + 
					":calendar:  **Date** Le " + date + "\n" + 
					":clock2:  **Heure** A partir de " + hour + "\n" + 
					":crown:  **MJ** @" + mj + "\n" + 
					":d10:  **Système** " + systeme + "\n" +
					":timer:  **Durée moyen du scénario ** " + time + "\n" +
					":baby:  **PJ Mineur** " + pj + "\n" + 
					":tools:  **Outils** " + outils + "\n" +
					":grey_question:  **Détails** " + desc  + "\n" +
					"**Participe** :white_check_mark: / **Ne participe pas** :x:";
		payload = {
			"embeds":[
			{
				"thumbnail":
				{
					"url":"https://cdn.discordapp.com/attachments/457233258661281793/458727800048713728/dae-cmd.png"
				},
					"title":"Nouveau jeu de rôle !",
					"description":content,
					"color": "16711680"
			}
			]
		};
		
		
		xhr = new XMLHttpRequest();
		xhr.open("POST", url, true);
		xhr.setRequestHeader("Content-Type", "application/json")
		//xhr.setRequestHeader("User-agent", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36")
		xhr.send(JSON.stringify(payload))

	}
	
}
