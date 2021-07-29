        <form method=post action="cgi/create_post.py" id="URform" onsubmit="alert('Partie validée ! Envoi en cours ..');">

            <?php
            if (isset($_GET['error'])){ 
            //Affichage des erreurs. Rajouter des lignes si on rajoute d'autres codes d'erreurs (optimisable en les mettant dans un fichier si on commence à en avoir beaucoup)
                $error=$_GET['error'];
                if($error=='invalidData') echo '<span class="rouge">Données invalides. Veuillez vérifier le formulaire</span>'; //--> Pas encore fonctionnel côté Python
                if($error=='isPosted') echo '<span class="vert">Votre partie a bien été postée</span>'; //--> Pas encore fonctionnel côté Python
            } 
            ?>

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
                echo '<input type="button" value="Deconnexion" id="deconnexion" onclick="window.location.href=\'php/logout.php\'"/>';
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
                
            <label>Nombre de joueurs</label>
                <div id="range" style="color:black !important" aria-describedby="nbTxt">
                    <script>
                        var range = document.getElementById('range');

                        noUiSlider.create(range, {
                            start: [1, 5],
                            step:1,
                            range: {
                                'min': 0,
                                'max': 16
                            },
                            padding:[1,1],
                            connect:true

                        });
                    </script>
                </div>
            <small id="nbTxt" name="nbJoueurs" class="annotation">Moins de 5 joueurs</small>

            
            <input type="text" value="1" name="minJoueurs" id="minJoueurs"/>
            <input type="text" value="5" name="maxJoueurs" id="maxJoueurs"/>

                
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
            <input type="text" placeholder="nom de la campagne ou du scenario" name="jdr_title" id="titre" max="70" required> 									
                    

            <!-- Durée -->       
            <label> Durée ⏱ <span class="rouge">*</span></label>      
            <select name="jdr_length" id="selectorTime" required>
                <option value="" disabled hidden selected></option>
            </select>									
                        
            <div></div> <!--Pour faire de la place entre Durée et Jdr-->
            
            <!-- Sélection du système jdr -->       
            <label>JDR 🎲 <span class="rouge">*</span> (Hors liste <input type="checkbox" id="checkJDR" onclick="chgJdrList()">)</label>
                
            <select name ="jdr_system" id="system" required>
                <option hidden disabled selected value="">Liste des JdR proposés</option>
                <?php

                    if (!file_exists('data/jdr_systems.xml')) {
                        exit('Echec lors de la récupération des parties');
                    }
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
        
            <!-- N'apparait qu'en cochant la case hors liste -->
            <input type="text" style="display: none" placeholder="nom du jeu si hors liste" name="jdr_system_other" id="system2" max="37"> 									         
                
            <!-- Outils -->   
            <label> Outils 🛠 </label>
            <div class="right">
                <input name="platform" type="checkbox" value="<?=$emot_twitch?>"> Partie diffusée sur Twitch <img src="img/iconTwitch.png"><br>
                <input name="platform" type="checkbox" value="<?=$emot_roll20?>"> Partie jouée sur Roll20 <img src="img/iconRoll20.png"><br>
                <input name="platform" type="checkbox" value="<?=$emot_discord?>"> Partie jouée sur Discord <img src="img/iconDiscord.png"><br>
                <input name="platform" type="checkbox" value=":space_invader:"> Partie jouée sur Autre <img src="img/iconAutre.png"><br>	
            </div>

            <!-- PJ mineurs -->       
            <label>PJ mineur 👶 <span class="rouge">*</span></label>
            <div class="right">
                <input type="radio" name="jdr_pj" required value="0" > &nbspOui
                <input type="radio" name="jdr_pj" value="1"> &nbspNon préférable 
                <input type="radio" name="jdr_pj" value="2"> &nbspNon <!-- Attention : Changer les value ici implique de devoir les changer aussi dans cgi/const.py -->
            </div>
                
            <!-- Description -->          
            <label>Description (optionnelle) 📄<br><br>
                <small class="annotation">Entrée pour revenir à la ligne</small>
            </label>
            <textarea rows="5" name ="jdr_details" id="desc" style="resize: vertical;" autocomplete="on"></textarea>	

            <div class="right">	
                <button type="reset" onclick="document.getElementById('range').noUiSlider.set([1,5]);">Réinitialiser 🔄</button>	
                <br><br>			
                <button type="submit" name="submit" id="submit" <?php if (!isset($_SESSION['avatar_url']) or !isset($_SESSION['username'])){echo 'disabled ><b>Veuillez vous connecter';}else{ echo 'style="background-color:#169719;"'?>><b>Valider ✔<?php }?></b></button>					
            <!--Bloque le bouton si on s'est pas connecté-->
            </div>

            
            <span class="beta"><b>Attention cet outil est en beta-test</b><br>
            <a href="https://github.com/UnionRolistes/Web_Planning" uk-icon="icon: github; ratio:1.5">GitHub</a></span>

        </form>
