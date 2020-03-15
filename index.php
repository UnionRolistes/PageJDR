<?php
if(isset($_GET['token'])){
	$token= $_GET['token'];
	//print_r($_POST);
	if(isset($_POST['submit'])){
		$seed = "";
		$date = date("d");
		$newtoken = $_POST['mj'] . $seed . $date;
		//echo "<br/>";
		$crypted =md5($newtoken);
		//echo $crypted;
		//echo "<br/>";
		//echo $token;
		//echo "<br/>";
		if($token === $crypted){
		
			$url = "https://discordapp.com/api/webhooks/XXXXXXXXXX";
			$content = '**Type** ' .$_POST['type']. '\n'. 
					':calendar:  **Date** Le ' . $_POST['date']. '\n' .
					':clock2:  **Heure** A partir de ' . $_POST['selectorHour'] . '\n' . 
					':timer:  **Durée moyen du scénario ** ' . $_POST['selectorTime'] . '\n' .
					':crown:  **MJ** @' . $_POST['mj'] . '\n' . 
					'<:custom_emoji_name:688535298325348407>  **Système** ' . $_POST['system'] . '\n' .
					':baby:  **PJ Mineur** ' . $_POST['pj'] . '\n';
			if ($_POST['diffusion1'] !== ""){
				$plateform .= ' <:custom_emoji_name:688725870948646921> ';
			}
			if ($_POST['diffusion2'] !== ""){
				$plateform .= ' <:custom_emoji_name:688725871716073474> ';
			}
			if ($_POST['diffusion3'] !== ""){
				$plateform .= ' <:custom_emoji_name:688725870998716447> ';
			}
			if ($_POST['diffusion4'] !== ""){
				$plateform .= ' :space_invader: ';
			}
			if ($plateform !== ""){
				$content .= ':star2: **Plateforme** ' .$plateform. '\n';

			}
			if ($_POST['desc'] !== ""){
				$desc=addcslashes($_POST['desc'],"\n\r");
				$desc=preg_replace("/@/","",$desc);
				$content .= ':grey_question:  **Détails**' . $desc . '\n';
			}
			$content .= '**Participe** :white_check_mark: / **Ne participe pas** :x:';
			$payload = '{
				"embeds":[
				{
					"thumbnail":
					{
						"url":"https://cdn.discordapp.com/attachments/688340383117082733/688732386820620351/UR-logo2.png"
					},
						"title":"Nouveau jeu de rôle !",
						"description":"'.$content.'",
						"color": "16711680"
				}
				]
			}';
			//$data = array('embeds' => $content );
			$curl = curl_init("$url");
			//echo "<br>".$content;
			//echo "<br>".$payload;
			//print_r($payload);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('content-type: application/json'));
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
			//préparation des data en json
			curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
			//désasctivation du ssl
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			//récupération du contenu pour debug
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($curl);
			if($result === FALSE) {
				echo "ERREUR : <br>";
				die(curl_error($curl));
			}
			//echo $result;
			echo "<BR> Votre partie a bien été envoyée sur le serveur discord";
		}else{
			echo "failed";
		}

	}

?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Le formulaire</title>
    <link rel="stylesheet" href="css/uikit.css">
    <link rel="stylesheet" href="css/master.css">
    <script src="js/uikit.js" charset="utf-8"></script>
    <script src="js/uikit-icons.js" charset="utf-8"></script>
    <script src="js/uikit-icons.min.js" charset="utf-8"></script>
    <script src="js/jquery-3.4.1.min.js" charset="utf-8"></script>
    <script src="js/timeinc.js" charset="utf-8"></script>

  </head>
  <body onload="feed()"> <!--Quand la page se charge, appeler feed()-->

    <div class="container">
      <div class="box">
        <form method=post action=# id="URform">
        <table>
          <tr>
            <th>Type</th>
            <td>
              <select class="uk-select" name="type" id="type" required>
                <option value="" disabled hidden selected></option> <!--Cette "option" force l'utilisateur à sélectionner une option-->
                <option>Initiation</option>
                <option>One shoot</option>
                <option>Scénario</option>
                <option>Campagne</option>
              </select>
            </td>
          </tr>
          <tr>
            <th>Date </th>
             <td>
              <input class="uk-input" type="date" name="date" id="date" value=""  required> <!--L'attribut required force un champ à être rempli-->
            </td>
          </tr>

          <tr>
            <th>Heure ⌚</th>

            <td>
              <select class="uk-select" name="selectorHour" id="selectorHour" required>
                <option value="" disabled hidden selected></option>
              </select>
            </td>
          </tr>

          <tr>
            <th>Durée ⏱</th><td>

            <select class="uk-select" name="selectorTime" id="selectorTime" required>
              <option value="" disabled hidden selected></option>
              
            </select>

          </td>
          </tr>


          <tr>
            <th>Maître du jeu 👑</th>
            <td>
              <input type="text" class="uk-input" placeholder="ABCD#1234" onchange="Onchange()" name="mj" id="mj" maxlength="37" required> <!--Ici, en plus de se servir de required, on utlise une fonction pour savoir si le pseudo entré peut correspondre à un pseudo discord-->
            </td>
          </tr>

          <tr>
            <th>Système 🎲</th><td>
            <select class="uk-select" name ="system" id="system" required>
              <option hidden diasabled selected value="">Liste des JdR proposés</option>
                <optgroup label="JdR Générique">
                    <option>Brigandyne</option>
                    <option>HomeBrew</option>
                    <option>D-Critique</option>
                    <option>GURPS</option>
                    <option>PbtA</option>
                    <option>SavageWolrd</option>
                    <option>Tiny</option>
					<option>Trash</option>
                </optgroup>
                <optgroup label="JdR Médiéval Fantastique / épic">
                    <option>Agone</option>
                    <option>Anima</option>
                    <option>Ciels_Cuivre</option>
                    <option>D&D (d&d, Ad&d, chronique, pathfinder)</option>
                    <option>Ad&d</option>
                    <option>Chronique oublier</option>
                    <option>Pathfinder</option>
                    <option>Défis Fantastiques</option>
                    <option>DiscWorld</option>
                    <option>DragonAge</option>
                    <option>GoT</option>
                    <option>L5R</option>
                    <option>MyLittlePony</option>
                    <option>Naheulbeuk</option>
                    <option>Rêve de Dragon</option>
                    <option>Ryuutama</option>
                    <option>Tolkien</option>
                    <option>Shaan</option>
                    <option>Yggdrasil</option>
                    <option>WarHammer</option>
                </optgroup>
                <optgroup label="JdR Pirate / renaissance">
                    <option>7e-mer</option>
                    <option>Pavillion Noir</option>
                    <option>Cardinal (Les lames Du)</option>
                </optgroup>
                <optgroup label="JdR Western">
                    <option>DeadLands</option>
                </optgroup>
                <optgroup label="JdR Contemporain">
                    <option>Cats</option>
                    <option>Heroes (super et mutant Xmen)</option>
                    <option>HP</option>
                    <option>Tiny</option>
                    <option>Nephilim</option>
                </optgroup>
                <optgroup label="JdR Futuriste / post apo">
                    <option>COPS</option>
                    <option>Cyberpunk</option>
                    <option>Dégénésis</option>
                    <option>Eclipse phase</option>
                    <option>FallOut</option>
                    <option>Knight</option>
                    <option>Metal Adv</option>
                    <option>Numenéra</option>
                    <option>Polaris</option>
                    <option>Starwars</option>
                    <option>Terra X</option>
                    <option>Zombie</option>
                </optgroup>
                <optgroup label="JdR Dark / sexe / drogue / rock'n roll">
                    <option>BloodLust</option>
                    <option>Cthulhu</option>
                    <option>w40k-DarkHeresy</option>
                    <option>INSMV</option>
                    <option>Féals (Chronique des</option>
                    <option>Ombres d'Esteren</option>
                    <option>Patient 13</option>
                    <option>Paranoïa</option>
                    <option>Vampire</option>
                    <option>Scion</option>
                    <option>Sombre</option>
                    <option>Tales from the loop</option>
                </optgroup>
            </select>
          </td>
          </tr>

          <tr>
            <th>Outils 🛠</th>
            <td>
              <select class="uk-select" name="outils" id="outils" required>
                <option hidden disabled selected value=""></option>
                <option value="Discord">Discord</option>
                <option >Discord + Roll20 </option>
                <option>Discord + Rolistream</option>
                <label><input class="uk-checkbox" name="diffusion1" type="checkbox"> Partie diffusée sur Twitch <img src="img/iconTwitch.png"> &nbsp&nbsp&nbsp</label><br>
                <label><input class="uk-checkbox" name="diffusion2" type="checkbox"> Partie diffusée sur Roll20 <img src="img/iconRoll20.png"></label><br>
                <label><input class="uk-checkbox" name="diffusion3" type="checkbox"> Partie diffusée sur Discord <img src="img/iconDiscord.png"></label><br>
                <label><input class="uk-checkbox" name="diffusion4" type="checkbox"> Partie diffusée sur Autre <img src="img/iconAutre.png"></label><br>
              </select>
            </td>
          </tr>
          <tr>
            <th>PJ mineur 👶</th>
            <td>
              <label><input class="uk-radio" type="radio" name="pj" id="pj" value="Oui">&nbspOui</label>
              <label><input class="uk-radio" type="radio" name="pj" id="pj" value="Non préférable">&nbspNon préférable</label>
              <label><input class="uk-radio" type="radio" name="pj" id="pj" value="Non recommandé">&nbspNon recommandé</label>
            </td>
          </tr>

        
          <tr>
            <th>Description (optionnelle) 📄</th>
            <td>
              <textarea class="uk-textarea"  maxlength="500" rows="5" name ="desc" id="desc"></textarea>
            </td>
          </tr>

          <tr>
            <th></th>
            <td><button type="submit" class="uk-button uk-button-default" name="submit" id="submit">Valider ✔</button></td>
          </tr>
          </table>
        </form>

      </div>


    </div>
  </body>
</html>
<?php
}else{
	echo 'ERREUR : veuillez venir accompagné d\'un token s\'il vous plaît!';
}
?>

