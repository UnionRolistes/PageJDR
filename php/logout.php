<?php
session_start();
session_destroy(); //Ferme la session, detruit les vars associées
header('Location:../index.php');
?>