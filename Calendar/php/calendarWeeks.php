<!-- Génére le calendrier d'une semaine -->

<?php
    if (session_status() != PHP_SESSION_ACTIVE)
        session_start();
        
    $daysOfTheWeek = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

    if (!isset($_SESSION['monday']))
        $_SESSION['monday'] = new DateTimeImmutable('monday this week');

    if (isset($_POST['timeInterval']))
        if($_POST['timeInterval']=="reset")
            $_SESSION['monday'] = new DateTimeImmutable('monday this week');
        else
            $_SESSION['monday'] = $_SESSION['monday']->add(date_interval_create_from_date_string($_POST['timeInterval']));
    

    $monday = $_SESSION['monday']    
?>

<section class="calendar">
    <h2 class="titleCenter">Semaine du <?= $monday->format("d/m") ?></h2> 

    <div class="header">
        <ul class="weekDays">
            <?php
                # Jours de la semaine
                foreach ($daysOfTheWeek as $day)
                    echo '<li>' . $day . '</li>'
            ?>
        </ul>

        <ul id="dayNumbers-container" class="dayNumbers-container">     
            <?php 
                # Dates de la semaine
                for ($i = 0; $i < 7; $i++)
                    echo '<li>' . $monday->add(date_interval_create_from_date_string($i . ' days'))->format("d/m") . '</li>'
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
</section>
