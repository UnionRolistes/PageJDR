<!-- Génère le calendrier d'une semaine -->

<?php
    if (session_status() != PHP_SESSION_ACTIVE){session_start();}
    
    $daysOfTheWeek = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

    if (!isset($_SESSION['monday'])){
        $_SESSION['monday'] = new DateTimeImmutable('monday this week');}

    if (isset($_POST['timeInterval'])){
        if($_POST['timeInterval']=="reset"){$_SESSION['monday'] = new DateTimeImmutable('monday this week');}
        else{
            $_SESSION['monday'] = $_SESSION['monday']->add(date_interval_create_from_date_string($_POST['timeInterval']));
        }
    }

    $monday = $_SESSION['monday'];    
?>

<h2 class="titleCenter">Semaine du <?=$monday->format("d/m") ?></h2>
<section class="calendar">
    
    <div></div> <!--Pour la case vide en haut à gauche du calendrier -->
    <div class="header">
        <ul class="weekDays">
            <?php
                # Jours de la semaine
                foreach ($daysOfTheWeek as $day)
                    echo '<li>' . $day . '</li>'
            ?>
        </ul>

        <ul class="dayNumbers-container">     
            <?php 
                # Dates de la semaine
                for ($i = 0; $i < 7; $i++)
                    echo '<li>' . $monday->add(date_interval_create_from_date_string($i . ' days'))->format("d/m") . '</li>';
            ?>
        </ul>
    </div>
   

    <div class="timeslots-containers">
        <ul class="timeslots">
            <?php
                # Créneaux horaires
                for ($i = 0; $i < 24; $i++)
                    echo '<li>' . (6 + $i) % 24 . 'h </li>'
            ?>
        </ul>
    </div>


    <!-- Affichage des parties -->
    <div class="event-container">       
        <?php 
        $path="data/events.xml";
        if (isset($_POST['ajax'])){$path="../data/events.xml";} //Car les liens absolus ne marchent pas, et apres un appel Ajax c'est le fichier php/calendarWeeks qui est appelé, et plus index.php

        # Get the events from an xml file / From Discord
        if (!file_exists($path)) {
            exit('Echec lors de la récupération des parties');
        }
        $xml = simplexml_load_file($path);

        foreach ($xml->partie as $partie) {
           
            try{ 
                $date=new DateTimeImmutable($partie->date);
                if ($date>=$monday && $date<=$monday->add(date_interval_create_from_date_string('6 days')) ){ //Si la date est dans la semaine actuellement simulée 

                    //Durée :
                    $duree=explode("h", "$partie->duree"); //Sépare X h Y en X et Y
                    if ($duree[1]=="00" || $duree[1]==""){ $demieDuree=0;} 
                    else{$demieDuree=1;}

                    $height=60*$duree[0]+30*$demieDuree;

                    //Heure de début :
                    $heure=explode("h", "$partie->heure");
                    if ($heure[1]=="00" || $heure[1]==""){ $demieHeure=0;} 
                    else{$demieHeure=1;}
                    if ($heure[1]==""){$heure[1]="00";}//Utilisé plus tard pour détecter si l'heure est passée

                    $row=($heure[0]-5)*2-1+1*$demieHeure;
                    //Permet de detecter les demies heures. 
                    //NOTE : Ici je fais une précision à la demie heure près. Une partie comprise entre Xh00 et Xh30, ou entre Xh30 et X+1h00 sera affichée à Xh30. 
                    //Comme toutes les parties que j'ai vu sont à heure pile ou demies. A demander à Dae si il veut une precision au 1/4 heure près

                    //Jour :
                    $column=date('N', strtotime($partie->date)); //Sort l'index du jour dans sa semaine. 7 pour dimanche, 1 pour lundi, etc.


                    //Code couleur :
                    $color="green";//Par défaut, places disponibles
                    //$inscription='<a href="pages/popupEvent.php?ID=5" target="popup" onclick=\'window.open("\'pages/popupEvent.php?ID=5\',\'name\',\'width=600,height=400")\'>Details et inscription</a><br>';
                    
                    $inscription='<a href="pages/popupEvent.php?ID='.$partie->attributes().'" target="_blank">Details et inscription</a><br>';

                    //Par défaut. (Liaison avec Discord à faire)

                    if (intval($partie->inscrits) >= intval($partie->minimum)){$color="rgb(194, 194, 21)";}//Si on a le nombre de joueurs minimum    
                    if (intval($partie->inscrits) >= intval($partie->capacite)){ $inscription="COMPLET";$color="rgb(255, 17, 17)";} //Si c'est complet
                    if (new DateTime($partie->date.' '.$heure[0].':'.$heure[1].":00") < new DateTime()){$color="gray"; $inscription="TERMINÉ";} //Si la date est passée                     
                    ?>


                    <div class="slot" style="height: <?=$height?>px; grid-row: <?=$row?>; grid-column: <?=$column?>; background: <?=$color?>"><strong><?=$partie->titre?></strong><br><br>
                        <strong>Type : </strong><?=$partie->type?><br>
                        <strong>Systeme : </strong><?=$partie->systeme?><br>
                        <strong>Mineurs : </strong><?=$partie->pjMineur?><br>
                        <strong>Capacité : </strong><?=$partie->inscrits?>/<?=$partie->capacite?><br>
                        <?=$partie->minimum?> joueurs minimum
                        <br><br>À <strong><?=$partie->heure?></strong><br>
                        <?=$inscription?><br>
                    </div>
                <?php
                }
            } catch (Exception $e) { //Si une partie a une date ou une autre info essentielle illisible, on zappe juste cette partie
                //echo 'Debug : erreur ',  $e->getMessage(), "\n"; 
            }           
        } ?>         
            
    </div>
</section>