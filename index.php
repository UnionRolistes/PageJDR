<?php
if(isset($_GET['token'])){
//Config
$url = "https://discordapp.com/api/webhooks/";
$seed = "";
$token= $_GET['token'];
//print_r($_POST);
if(isset($_POST['submit'])){

    $date = date("d");
    $newtoken = $_POST['mj'] . $seed . $date;
    //echo "<br/>";
    $crypted =md5($newtoken);
    //echo $crypted;
    //echo "<br/>";
    //echo $token;
    //echo "<br/>";
    if($token === $crypted){


        $content = '**Type** ' .$_POST['type']. '\n'.
            ':calendar:  **Date** Le ' . $_POST['date']. '\n' .
            ':clock2:  **Heure** A partir de ' . $_POST['selectorHour'] . '\n' .
            ':timer:  **Durée moyen du scénario ** ' . $_POST['selectorTime'] . '\n' .
            ':crown:  **MJ** @' . $_POST['mj'] . '\n' .
            '<:custom_emoji_name:434358038342664194>  **Système** ' . $_POST['system'] . '\n' .
            ':baby:  **PJ Mineur** ' . $_POST['pj'] . '\n';
        if ($_POST['diffusion1'] == "twitch"){
            $plateform .= ' <:custom_emoji_name:434370263518412820> ';
        }
        if ($_POST['diffusion2'] == "roll20"){
            $plateform .= ' <:custom_emoji_name:493783713243725844> ';
        }
        if ($_POST['diffusion3'] == "discord"){
            $plateform .= ' <:custom_emoji_name:434370093627998208> ';
        }
        if ($_POST['diffusion4'] == "autre"){
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
						"color": "11053224"
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
        <link rel="stylesheet" href="css/dark.css">
        <link rel="stylesheet" href="css/nouislider.css">
        <link type="text/css" rel="stylesheet" href="css/tail.datetime-default.css">
        <link rel="stylesheet" href="css/tail.datetime-harx-dark.min.css">
        <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/457233258661281793/458727800048713728/dae-cmd.png">
        <script src="js/uikit.min.js" ></script>
        <script src="js/uikit-icons.min.js"></script>
        <script src="js/script.js"></script>
        <script src="js/nouislider.js"></script>
        <script src="js/tail.datetime.js"></script>
        <script src="js/tail.datetime-fr.js"></script>

    </head>
    <body onload="feed();" id="body"> <!--Quand la page se charge, appeler feed()-->

    <div class="container">
        <div class="box">
            <table>
                <form method=post action=# id="URform">

                    <tr>
                        <th>
                            <label class="switch">
                                <input type="checkbox" onclick="chgMode()">
                                <span class="slider round"></span>
                            </label><span id="mode">Sombre 🌙</span></th><td></td><!--<button class="uk-button uk-button-default" id="mode" onclick="chgMode()">Sombre 🌙</button></td>-->
                    </tr>
                    <tr>
                        <th>Nombre de joueur</th>
                        <td><div id="range" style="color:black !important">
                                <script>
                                    var range = document.getElementById('range');

                                    noUiSlider.create(range, {
                                        start: [4, 15],
                                        step:1,
                                        range: {
                                            'min': 1,
                                            'max': 41
                                        },
                                        padding:[1,1],
                                        connect:true

                                    });
                                </script>

                            </div>
                            <p id="nbTxt">Moins de 25 joueurs</p>
                        </td>
                    </tr>
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
                        <th>Date 📅 et heure ⌚</th>
                        <td id="date">
                            <input type="text" class="tail-datetime-field" required style="border-radius: 0px !important; height:40px; width:100%"/>

                            <script type="text/javascript">
                                document.addEventListener("DOMContentLoaded", function(){
                                    tail.DateTime(".tail-datetime-field", { dateFormat:"dd/mm/YYYY",
                                        timeFormat:"HH:ii",
                                        locale:"fr",
                                        timeSeconds:false,
                                        viewDecades:false,
                                        dateStart:new Date().toISOString().slice(0, 10)});
                                });
                            </script> <!--L'attribut required force un champ à être rempli-->
                        </td>
                    </tr>

                    <tr>
                        <th>Durée ⏱</th><td>

                            <select class="uk-select" name="selectorTime" id="selectorTime" required>
                                <option value="" disabled hidden selected></option>

                            </select>

                        </td>
                    </tr>
                    <div id="alert"></div>

                    <!--<div class="uk-alert-success" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p>Votre formulaire a bien été pris en compte.</p>
                    </div>-->

                    <tr>
                        <th>Maître du jeu 👑</th>
                        <td>
                            <input type="text" class="uk-input" placeholder="ABCD#1234" name="mj" id="mj" max="37" pattern="^[^@#]{2,32}#[0-9]{4}" required> <!--Ici, en plus de se servir de required, on utlise une fonction pour savoir si le pseudo entré peut correspondre à un pseudo discord-->
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
									<option>gobelin qui s'en dédit</option>
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
                            <label><input class="uk-checkbox" name="diffusion1" type="checkbox" value="twitch"> Partie diffusée sur Twitch <img src="img/iconTwitch.png"> &nbsp&nbsp&nbsp</label><br>
                            <label><input class="uk-checkbox" name="diffusion2" type="checkbox" value="roll20"> Partie diffusée sur Roll20 <img src="img/iconRoll20.png"></label><br>
                            <label><input class="uk-checkbox" name="diffusion3" type="checkbox" value="discord"> Partie diffusée sur Discord <img src="img/iconDiscord.png"></label><br>
                            <label><input class="uk-checkbox" name="diffusion4" type="checkbox" value="autre"> Partie diffusée sur Autre <img src="img/iconAutre.png"></label><br>
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
                            <textarea class="uk-textarea"  maxlength="500" rows="5" name ="desc" id="desc" oninput="save()"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><button type="reset" class="uk-button uk-button-default" onclick="document.getElementById('range').noUiSlider.set([4,15]);">Réinitialiser 🔄</button></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><button type="submit" class="uk-button uk-button-default" name="submit" id="submit" onclick="Alert()/*UIkit.notification({ message: 'Votre formulaire a été pris en compte',status: 'success',timeout: 5000});*/">Valider ✔</button></td>
                    </tr>
            </table>
            <span style="text-align:center;margin-top:5vh;font-size:12px">Attention cet outil est en beta-test<br><a href="https://github.com/Bot-a-JDR/PageJDR" uk-icon="icon: github; ratio:1.5"></a></span>
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