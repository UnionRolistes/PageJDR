
function durationSelect(){ //Cette fonction permet de remplir le select de la durée de partie, allégeant le code HTML

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
}