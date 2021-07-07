<?php
if (session_status() != PHP_SESSION_ACTIVE)
    session_start();

# this is not to leak authotification information
# stored in config.php when pushing to github
if(!file_exists("php/config.php")){
    copy("php/config.php.default", "php/config.php");
}

require("php/config.php");

if (isset($_GET['webhook']))
    $_SESSION['webhook'] = $_GET['webhook'];

$emot_twitch = ' <:custom_emoji_name:434370263518412820> ';
$emot_roll20 = ' <:custom_emoji_name:493783713243725844> ';
$emot_discord = ' <:custom_emoji_name:434370093627998208> ';
$emot_autre = ' :space_invader: ';

?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title> Le formulaire de partie </title>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/styleDark.css">
    
    <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/457233258661281793/458727800048713728/dae-cmd.png">


    <script src="js/updateSliderText.js"></script>
    <script src="js/durationSelect.js"></script>
    <script src="js/colorModeSwitch.js"></script>

    <!--On utilise un script externe pour le slider et le calendrier de choix de date et durée-->
    <script src="js/nouislider.js"></script> <!--Pour le slider du nombre de joueurs-->
    <link rel="stylesheet" href="css/nouislider.css">

    <script src="js/tail.datetime.js"></script><!-- Pour le calendrier du choix de la date-->
    <script src="js/tail.datetime-fr.js"></script>
    <link type="text/css" rel="stylesheet" href="css/tail.datetime-default.css">


</head>
<body onload="updateSliderText();durationSelect();"> 
<!--updateSliderText met à jour le texte situé sous le slider du nombre de joueur. durationSelect remplit le select des durées de parties (30m, 1h, ...) -->
    
<h1 class="titleCenter">Création de partie</h2>

    <form method=post action="cgi/create_post.py" id="URform">

        <!-- Connexion discord -->   
        <input type=hidden name="webhook_url" value="<?= isset($_SESSION['webhook']) ? $_SESSION['webhook'] : "" ?>">
        <input type=hidden name="user_id" value="<?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ""?>">
        <input type=hidden name="pseudo" value="<?= isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : ""?>">           
        <label>Maître du jeu 👑</label>
        <?php
        if (isset($_SESSION['avatar_url']) and isset($_SESSION['username'])) {
            echo '<div>';
            echo "<img src=\"" . $_SESSION['avatar_url'] . "\"/>";      
            echo $_SESSION['username'];
            echo '</div>';
        } else
            echo '<div><input type="button" value="Me connecter" id="connexion" onclick="window.location.href=\'php/get_authorization_code.php\'"/></div>'
        ?>

        <!-- Button for changing color mode -->
        <label id="mode">Sombre 🌙</label>					
        <div>
            <label class="switch">
                <input type="checkbox" onclick="chgMode()">
                <span class="slider round"></span>
            </label>
        </div>
            
        <!--label>Nombre de joueurs</label>
            <div id="range" style="color:black !important" aria-describedby="nbTxt">
                <script>
                    var range = document.getElementById('range');

                     noUiSlider.create(range, {
                        start: [1, 5],
                        step:1,
                        range: {
                            'min': 0,
                            'max': 8
                        },
                        padding:[1,1],
                        connect:true

                    });
                </script>
            </div>
        <small id="nbTxt">Moins de 5 joueurs</small-->


            
        <label>Type <span class="rouge">*</span></label>             
        <select name="jdr_type" id="type" required>
            <option value="" disabled hidden selected></option> <!--Cette "option" force l'utilisateur à sélectionner une option-->
            <option> Initiation </option>
            <option> One shoot </option>
            <option> Scénario </option>
            <option> Campagne </option>
        </select>   
                 

            
        <label>Date 📅 et heure ⌚ <span class="rouge">*</span></label>
                
        <input autocomplete="off" id="date" name="jdr_date" type="text" class="tail-datetime-field" style="border-radius: 0px !important; height:40px; width:100%" required/>

        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function(){
            tail.DateTime(".tail-datetime-field", { 
                dateFormat:"dd/mm/YYYY",
                timeFormat:"HH:ii",
                locale:"fr",
                timeSeconds:false,
                viewDecades:false,
                dateStart:new Date().toISOString().slice(0, 10)});
            });
        </script> <!--L'attribut required force un champ à être rempli pour envoyer le formulaire-->
                    
           
            
        <!-- Nom campagne -->         
        <label> Titre : <span class="rouge">*</span></label>
        <input type="text" placeholder="nom de la campagne ou du scenario" autocomplete="off" name="jdr_title" id="titre" max="50" required> 									
                

        <!-- Durée -->       
        <label> Durée ⏱ <span class="rouge">*</span></label>      
        <select name="jdr_length" id="selectorTime" required>
            <option value="" disabled hidden selected></option>
        </select>									
                    
        <div></div> <!--Pour faire de la place entre Durée et Jdr-->
            
           
        <!-- Sélection du système jdr -->       
        <label>JDR 🎲</label>
               
        <select name ="jdr_system" id="system">
            <option hidden disabled selected value="">Liste des JdR proposés</option>
            <?php
                # Generates all the options from an xml file
                $systems = simplexml_load_file("data/jdr_systems.xml");
                foreach ($systems as $optgroup) {
                    echo '<optgroup label ="' . $optgroup['label'] .'">';
                    foreach ($optgroup as $option) {
                        echo '<option>' . $option . '</option>'; 
                    }
                    echo '</optgroup>';
                }
            ?>         
        </select>				
            
        <!-- JDR Hors liste -->    
        <label> JDR Hors liste 🎲</label>
        <input type="text" placeholder="nom du jeu si hors liste" name="jdr_system_other" id="system2" max="37"> 									
            
            
        <!-- Outils -->   
        <label> Outils 🛠 </label>
        <div class="right">
            <input name="platform" type="checkbox" value="<?=$emot_twitch?>"> Partie diffusée sur Twitch <img src="img/iconTwitch.png"><br>
            <input name="platform" type="checkbox" value="<?=$emot_roll20?>"> Partie jouée sur Roll20 <img src="img/iconRoll20.png"><br>
            <input name="platform" type="checkbox" value="<?=$emot_discord?>"> Partie jouée sur Discord <img src="img/iconDiscord.png"><br> <!--checked-->
            <input name="platform" type="checkbox" value=":space_invader:"> Partie jouée sur Autre <img src="img/iconAutre.png"><br>	
        </div>

        <!-- PJ mineurs -->       
        <label>PJ mineur 👶</label>
        <div class="right">
            <input type="radio" name="jdr_pj" required value="0" > &nbspOui <!--checked-->
            <input type="radio" name="jdr_pj" value="1"> &nbspNon préférable 
          <!--  <input type="radio" name="jdr_pj" value="2"> &nbspPréférable  -->
          <!-- Demander à Dae si il veut les choix "non" et "préférable" séparément-->
            <input type="radio" name="jdr_pj" value="3"> &nbspNon recommandé
        </div>
            
        <!-- Description -->
            
        <label>Description (optionnelle) 📄</label>        
        <textarea maxlength="500" rows="5" name ="jdr_details" id="desc" style="resize: vertical;"></textarea>	
             

        <div class="right">	
            <button type="reset" onclick="document.getElementById('range').noUiSlider.set([1,5]);">Réinitialiser 🔄</button>	
            <br><br>			
            <button type="submit" name="submit" id="submit" <?php if (!isset($_SESSION['avatar_url']) and !isset($_SESSION['username'])){echo 'disabled ><b>Veuillez vous connecter';}else{ echo 'style="background-color:#169719;"'?>><b>Valider ✔<?php }?></b></button>					
        <!--Bloque le bouton si on s'est pas connecté-->
        </div>

        
        <span class="beta"><b>Attention cet outil est en beta-test</b><br>
        <a href="https://github.com/UnionRolistes/Web_Presentation" uk-icon="icon: github; ratio:1.5">GitHub</a></span>

    </form>
    
    <script src="js/record_form.js"></script>
</body>

<?php 
    include('php/footer.php');
?>
</html>