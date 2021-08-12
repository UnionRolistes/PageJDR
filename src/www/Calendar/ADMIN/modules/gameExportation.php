<?php
/*UR_Bot © 2020 by "Association Union des Rôlistes & co" is licensed under Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA)
To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/4.0/
Ask a derogation at Contact.unionrolistes@gmail.com*/


//TODO : demander les détails à Dae et terminer la page

if (!isset($_GET['ID']) || !is_numeric($_GET['ID'])){header('Location:../index.php');}

$ID=$_GET['ID'];


//On ouvre le Xml :        
if (!file_exists("../../data/events.xml")) {
    exit('Echec lors de la récupération des parties');
}
$xml = simplexml_load_file('../../data/events.xml');

//(Pas trouvé de fonction "find by id" qui fonctionne bien. Et dans les 2 cas ca revient à un parcours de xml, donc on ne perd pas en optimisation)
$trouve=false;
foreach ($xml->partie as $partie) {

    try{  
        if ($partie->attributes()==$ID){         

            $titre=$partie->titre;
            $capacite=$partie->capacite;
            $minimum=$partie->minimum;
            $date=new DateTime($partie->date); //On choisit DateTime face à DateTimeImmutable pour un ajout des heures plus simples
            $heure=$partie->heure;
            $duree=$partie->duree;
            $type=$partie->type;
            $MJ=$partie->mj;
            $systeme=$partie->systeme;
            $pjMineur=$partie->pjMineur;
            $plateformes=$partie->plateformes; 
            $details=$partie->details;
            $lien=$partie->lien;
        
            $trouve=true;
            break;
        }
    } catch (Exception $e) { //Si une partie a une date ou une autre info essentielle illisible, on zappe juste cette partie
    echo 'Debug : erreur ',  $e->getMessage(), "\n";
    } 
}
if(!$trouve){
    echo 'Erreur, partie introuvable';
    exit;
} ?>


<!--Partie affichage : -->
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$titre?></title>

    <link rel="stylesheet" href="../../../css/master.css">
    <link rel="stylesheet" href="../../../css/styleDark.css">
    <link rel="stylesheet" href="../../css/stylePopup.css">

    <link rel="icon" type="image/png" href="../../../img/ur-bl2.png">
</head>
<body>
    
    <header>
        <h1 class="titleCenter"><?=$titre?></h2>
    </header>
    <section id="URform">

        <fieldset>
            <legend>Mise en forme</legend>

            <strong>Titre : </strong><?=$titre?><br>
            <strong>Type : </strong><?=$type?><br>
            <strong>Date : </strong>Le <?=$date->format('d/m')?> à <?=$heure?><br>
            <strong>Durée moyenne : </strong><?=$duree?><br>
            <strong>Nombre de joueurs : </strong><?php if (intval($capacite)==intval($minimum)){echo $capacite;}else{echo $minimum.'~'.$capacite;}?> <br>
            <strong>MJ : </strong> <?=$MJ?><br>
            <strong>Système : </strong><?=$systeme?><br>
            <strong>PJ mineur : </strong><?=$pjMineur?><br>
            <strong>Plateformes : </strong><?=$plateformes?><br><br>
            <strong>Détails : </strong><?=$details?><br>


        </fieldset>
    </section>

</body>
<?php include('../../../pages/footer.html'); ?>
</html>