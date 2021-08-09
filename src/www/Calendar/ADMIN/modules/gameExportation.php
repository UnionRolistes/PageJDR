<?php
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

    <link rel="icon" type="image/png" href="../../img/ur-bl2.png">
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
            :clapper: Titre Saignée Méditerranéenne<br>
            :timer: Durée moyenne du scénario 3h30<br>
            :person_standing_tone1: Nombre de joueurs 5<br>
            :crown: MJ <@194875837277929472> [Syn#3950]<br>
            :d10: Système Vampire<br>
            :baby::skin-tone-1: PJ Mineur non<br>
            :star2: Plateformes :discord:<br>
            :grey_question: Détails<br>
            Saison 3 - Chapitre 3 : Impasse Mexicaine<br>

            La tragédie ayant frappée la Cité a regonflé la détermination de la coterie à défendre Nice. 
            Ayant chacun obtenu des réponses et des questions à poser, ils présentent leurs résultats et leurs interrogations au Juge qui doit maintenant s'ouvrir sur son passé.
            Mais les conséquences de leurs actions passées sont également sur le point de tomber au pire moment...<br>


        </fieldset>
    </section>

</body>
<?php include('../../../php/footer.php'); ?>
</html>