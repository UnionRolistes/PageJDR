<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Le calendrier</title>

    <link rel="stylesheet" href="css/styleCalendar.css">
    <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/457233258661281793/458727800048713728/dae-cmd.png">
    <script type="text/javascript" src="js/scriptDates.js"></script>
</head>
<body>
    <header class="flex-horizontal">
        <nav class="flex-horizontal">
            <button id="btn_Weeks" class="btn_Switch" disabled>Semaine</button>
            <button id="btn_Months" class="btn_Switch">Mois</button>
        </nav>

        <h1> Calendrier JDR <h1>

        <nav>
            <button class="btn-change btn_previous" value="-1 week"><--</button>
            <button class="btn-change btn_current" value="reset">Aujourd'hui</button>
            <button class="btn-change btn_next" value="+1 week">--></button>
        </nav>
    </header>
    <div id="calendarFrame">
        <?php 
            include('php/calendarWeeks.php')
        ?>
    </div>

    <script src="js/requestCalendar.js"></script>
</body>
<?php
    include('php/footer.php')
?>
</html>