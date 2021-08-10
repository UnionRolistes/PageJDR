<?php
session_start();


//On ouvre le Xml :        
if (!file_exists("../data/events.xml")) {
    exit('Echec lors de la récupération des parties');
}
$xml = simplexml_load_file('../data/events.xml'); ?>


<!--Partie affichage : -->
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>L'agenda du rôliste - Admin</title>

    <link rel="stylesheet" href="../../css/master.css">
    <link rel="stylesheet" href="../../css/styleDark.css">
    <link rel="stylesheet" href="../css/styleEventsList.css">

    <link rel="icon" type="image/png" href="../../img/ur-bl2.png">
</head>
<body>
    
    <header>
        <h1 class="titleCenter">Liste des parties - ADMIN</h2>
    </header>
    <section id="URform">
                


<?php
$trouve=false;
$i=0;
foreach ($xml->partie as $partie) { 

    try{  
            $date=new DateTimeImmutable($partie->date);
            $titre=$partie->titre;
            $heure=$partie->heure;
            $type=$partie->type;       
            $systeme=$partie->systeme;
            $pjMineur=$partie->pjMineur; 
            ?>

        <fieldset>
            Le <?=$date->format('d/m/Y')?>, <strong><?=$titre?></strong><br><br>
        
            <strong>Type : </strong><?=$type?><br>
            <strong>Système : </strong><?=$systeme?><br>
            <strong>Mineurs : </strong><?=$pjMineur?><br><br>
            <strong>Heure : </strong><?=$heure?><br><br>
            Rajouter bouton supprimer ? Aux risques des modérateurs, car le supprimer du xml ne le supprimera pas de Discord

            <input type="button" onclick="window.location.href='modules/gameExportation.php?ID=<?=$partie->attributes()?>'" value="Voir la mise en forme"/>
            <input type="button" onclick="window.location.href='modules/gameFormSaving.php?ID=<?=$partie->attributes()?>'" value="Pré-remplir le formulaire"/>      
        </fieldset>

    <?php
    } catch (Exception $e) { //Si une partie a une date ou une autre info essentielle illisible, on zappe juste cette partie
    //echo 'Debug : erreur ',  $e->getMessage(), "\n";
    }    
} ?>
        
    </section>

</body>
<?php include('../../pages/footer.html'); ?>
</html>