<?php
if (!isset($_POST['summary'])){ //A completer
  header('Location:../index.php');
}

$summary = explode(",", $_POST['summary']);//Enleve les , du nom du fichier, car elles ne sont pas acceptées (fait planter le script)
$summary=implode(" ",$summary);

include 'ICS.php';

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename='.$summary.'.ics');

$ics = new ICS(array(
  'location' => $_POST['location'],
  'description' => $_POST['description'],
  'dtstart' => $_POST['date_start'],
  'dtend' => $_POST['date_end'],
  'summary' => $_POST['summary']
));

echo $ics->to_string();
?>