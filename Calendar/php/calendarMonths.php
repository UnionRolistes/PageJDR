<!-- Génère le calendrier d'un mois -->

<?php
    if (session_status() != PHP_SESSION_ACTIVE)
        session_start();
        
    $daysOfTheWeek = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    $months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');//Tableau pour les mois francais

    if (!isset($_SESSION['monday']))
        $_SESSION['monday'] = new DateTimeImmutable('monday this week');

    if (isset($_POST['timeInterval']))
        if($_POST['timeInterval']=="reset")
            $_SESSION['monday'] = new DateTimeImmutable('monday this week');
        else
            $_SESSION['monday'] = $_SESSION['monday']->add(date_interval_create_from_date_string($_POST['timeInterval']));
    

    $monday = $_SESSION['monday']; 
?>

<h2 class="titleCenter"><?=$months[$monday->format("m")-1].' '.$monday->format("Y")?></h2>
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
                $lundiDebutMois=new DateTimeImmutable(date("Y-m-d", strtotime('monday this week', strtotime($monday->format('Y').'-'.$monday->format('m').'-01')))); 
                $debutMois=new DateTimeImmutable(date("Y-m-d", strtotime($monday->format('Y').'-'.$monday->format('m').'-01')));               

                for ($i = 0; $i <= 6; $i++){
                    $style="";
                    if($lundiDebutMois->add(date_interval_create_from_date_string($i . ' days'))->format("m") !=$debutMois->format("m")){$style="color: gray;";}

                    echo '<li style="'.$style.'">' . $lundiDebutMois->add(date_interval_create_from_date_string($i . ' days'))->format("d/m") . '</li>';
                }                 
            ?>
        </ul>
    </div>
   

    <div class="timeslots-containers">
        <ul class="timeslots">
            <?php
                # Créneaux horaires
                for ($i = 1; $i < 6; $i++)
                    echo '<li>S'.$i.'</li>'
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
                
            $date=new DateTimeImmutable($partie->date);

            if ($date>=$debutMois && $date< $debutMois->add(date_interval_create_from_date_string('1 month')) ){ //Si la date est dans le mois actuellement simulé

                //Jour :
                $column=date('N', strtotime($partie->date)); //Sort l'index du jour dans sa semaine. 7 pour dimanche, 1 pour lundi, etc.

                //S1 :
                if($date>=$debutMois && $date<$debutMois->add(date_interval_create_from_date_string('next monday'))){
                    $row=1;
                } //S2 :
                else if ($date>=$lundiDebutMois->add(date_interval_create_from_date_string('next monday')) && $date<$lundiDebutMois->add(date_interval_create_from_date_string('2 weeks'))){
                    $row=11;
                } //S3 :
                else if ($date>=$lundiDebutMois->add(date_interval_create_from_date_string('2 weeks')) && $date<$lundiDebutMois->add(date_interval_create_from_date_string('3 weeks'))){
                    $row=21;
                } //S4 :
                else if ($date>=$lundiDebutMois->add(date_interval_create_from_date_string('3 weeks')) && $date<$lundiDebutMois->add(date_interval_create_from_date_string('4 weeks'))){
                    $row=30;
                } //S5 :
                else if ($date>=$lundiDebutMois->add(date_interval_create_from_date_string('4 weeks')) && $date<$lundiDebutMois->add(date_interval_create_from_date_string('5 weeks'))){
                    $row=40;
                }

                //row +4 si on veut en caser un 2eme. +10 si on veut changer de semaine

                $heure=explode("h", "$partie->heure");
                //Code couleur :
                $color="green";//Par défaut, places disponibles

                if (intval($partie->inscrits) >= intval($partie->minimum)){$color="rgb(194, 194, 21)";}//Si on a le nombre de joueurs minimum    
                if (intval($partie->inscrits) >= intval($partie->capacite)){$color="rgb(255, 17, 17)";} //Si c'est complet
                if (new DateTime($partie->date.' '.$heure[0].':'.$heure[1].":00") < new DateTime()){$color="gray";} //Si la date est passée                   
                ?>
               
                <a href="php/monthsToWeeks.php?date=<?=$partie->date?>" class="slot slotMonth" style="height: 60px; grid-row: <?=$row?>; grid-column: <?=$column?>; background: <?=$color?>">
                    <strong><?=$partie->titre?></strong><br>
                    <strong>Systeme : </strong><?=$partie->systeme?><br>
                    <strong>Capacité : </strong><?=$partie->inscrits?>/<?=$partie->capacite?><br>
                    <strong>Durée : </strong><?=$partie->duree?>
                </a>
            <?php
            }         
        } ?>         
            
    </div>

</section>