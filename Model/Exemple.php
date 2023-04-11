<?php

session_start();
require_once('Login.php');
$listutil->setNom($_POST["prenom_nom_util"]);
$listutil->setMdp($_POST["mdp_util"]);
$verif = $listutil->verifListe();
if( $verif != FALSE ){
    $_SESSION['user_log']= TRUE;
    $_SESSION['user']=$listutil->getNom();
    $_SESSION['idUser']=$verif;
}
else{
    $_SESSION['user_log']= FALSE;
}

header('Location: ../../index.php');
exit;