<?php
  session_start();
  require("../variables.php");  
  include('fonctions.php');
  include("redirection.php");


?>
<script>

</script>

<html>
	<head>
		<meta name="viewport" content="width=device-width initial-scale=1.0 minimum-scale=1.0 user-scalable=no" />
		<title>Extranet Observatoire Loir-et-cher - Entreprises</title>
			<!--<meta content="text/html" charset="iso-8859-1" http-equiv="Content-Type">-->
		<link rel="stylesheet" href="stylebis.css" type="text/css">

		<link rel="stylesheet" href="/components/com_flexicontent/assets/css/flexicontent.css" type="text/css" />


		<script language="javascript" src="completion.js"></script>

		<script language="javascript">
			var minimum_caractere=2;
		</script>

	</head>

<body style="text-align:left;">



<div id="annuaire_epci">

	<div id="header">
		<h1 id="headerTitre">Annuaire des élus et des territoires</h1>

		<div id="logo" >
			<img src="images/am41_logo-png.png"  height="60px;" hspace="6" alt="" />
			<img src="images/loir-et-cher_41_logo_2015.png"  height="50px;" hspace="6" alt="" />
			<img src="images/LogoOET.png" height="45px;" hspace="6" alt="" />
		</div>
	</div>

	<div id="annuaire_epci_rech">

	<form method="post" name="formulaire" action="annuaire.php?PHPSESSID=<?=session_id()?>">
	<input type="hidden" name="type_rech" value="liste">

	<select name="commune" id="commune"  onchange="<?="document.location.href='annuaire.php?username=".$_GET['username']."&IdComEpci='+this.value;"?>" >
	<?php $req_communes="select nomClassement, IdComEpci from annuaire where TypeComEPCI like 'Mairie%' order by nomClassement asc";?>
		<option value="">Sélectionnez une commune...</option>
		<?php
		$getDataCommunes = $connexion->prepare($req_communes);
		$getDataCommunes->execute();
		$communes = $getDataCommunes->fetchAll(\PDO::FETCH_ASSOC);
		foreach( $communes as $commune){
			echo "<option value=\"".$commune['IdComEpci']."\">".$commune['nomClassement']."</option>\r";
		}
		?>
	</select>

	<select name="communaute" id="communaute" onchange="<?= "document.location.href='annuaire.php?username=".$_GET['username']."&IdComEpci='+this.value;"?>" >
	<?php $req_communautes="select nomClassement, IdComEpci from annuaire where TypeComEPCI like 'A%' order by nomClassement asc"; ?>
	<option value="">Sélectionnez une communauté...</option>
		<?php
		$getDataCommunaute = $connexion->prepare($req_communautes);
		$getDataCommunaute->execute();
		$Communautes = $getDataCommunaute->fetchAll(\PDO::FETCH_ASSOC);
		foreach( $Communautes as $Communaute){
			echo "<option value=\"".$Communaute['IdComEpci']."\">".$Communaute['nomClassement']."</option>\r";
		}
		?>
	</select>

	<select name="syndicat" id="syndicat" onchange="<?= "document.location.href='annuaire.php?username=".$_GET['username']."&IdComEpci='+this.value;"?>" >
	<?php $req_syndicats="select nomClassement, IdComEpci from annuaire where TypeComEPCI like 'C%' order by nomClassement asc"; ?>
		<option value="">Sélectionnez un autre EPCI...</option>
		<?php 
		$getDataSyndicats = $connexion->prepare($req_syndicats);
		$getDataSyndicats->execute();
		$Syndicats = $getDataSyndicats->fetchAll(\PDO::FETCH_ASSOC);
		foreach( $Syndicats as $Syndicat){
			echo "<option value=\"".$Syndicat['IdComEpci']."\">".$Syndicat['nomClassement']."</option>\r";
		}
		?>
	</select>

	<select name="pays" id="pays" onchange="<?="document.location.href='annuaire.php?username=".$_GET['username']."&IdComEpci='+this.value;"?>" >
	<?php $req_pays="select nomClassement, IdComEpci from annuaire where TypeComEPCI='B0' order by nomClassement asc"; ?>
		<option value="">Sélectionnez un pays...</option>
		<?php 
		$getDataPays = $connexion->prepare($req_pays);
		$getDataPays->execute();
		$Pays = $getDataPays->fetchAll(\PDO::FETCH_ASSOC);
		foreach( $Pays as $pays){
			echo "<option value=\"".$pays['IdComEpci']."\">".$pays['nomClassement']."</option>\r";
		}
		?>
	</select>

	</form>
	<!--<h2>Recherche :</h2>-->
	<div id="divSearch">
	<form method="post" name="completion_form" action="annuaire.php?PHPSESSID=<?=session_id()?>">
	<input type="hidden" name="type_rech" value="liste">

		Recherche sur le nom :
		<div id="radioPers">
			<input type="radio" name="type_nom" value="personne" id="radioP" checked />
			<label for="radioP">d'une personne</label>
		</div>
		<div id="radioColl">
			<input type="radio" name="type_nom" value="collectivite" id="radioC" />
			<label for="radioC">d'une collectivité</label>
		</div>

		<div id="bloc_autocomp" >
			<input type="text" name="nom" id="search" class="searchAnnu" value="" onkeypress="if(event.keyCode == 13){ recup_email(event, 'submit'); return false;}" onkeyup="recup_email(event, '');" autocomplete="off" />
			<input type="image" id="completion_select" value="submit" onclick="recup_mail_click();" />
		</div>
	</form>
	</div>
	
	<div id="accesRapideAnnu">
		<a href="annuaire.php?username=<?=$_GET['username']?>&IdComEpci=CG41">Conseil départemental 41</a>
		<a href="annuaire.php?username=<?=$_GET['username']?>&IdComEpci=CR">Conseil régional</a>
		<a href="annuaire.php?username=<?=$_GET['username']?>&IdComEpci=DepSen">Députés et Sénateurs</a>
	</div>

	</div>


<?php 
	include("alertinfo_annuairedeselus.php");  

	if($_POST['type_rech']!='' or $_GET['nompers']!='' or $_GET['retour']!=''){
		$_SESSION['IdComEpci']='';
	}

	if($_GET['IdComEpci']!=''){
		$_SESSION['IdComEpci']=$_GET['IdComEpci'];
	}  
	$_GET['IdComEpci']=$_SESSION['IdComEpci'];



	if($_SESSION['IdComEpci']==''){

		if($_GET['nompers']!=''){
			$_SESSION['nom']=$_GET['nompers'];
			$_SESSION['type_nom']='personne';
		} 

		if($_POST['type_nom']!='' and $_POST['nom']!=''){
			$_SESSION['type_nom']=$_POST['type_nom'];
			$_SESSION['nom']=$_POST['nom'];
		}

		if($_SESSION['type_nom']!='' and $_SESSION['nom']!='')
			include("resultat.php");

	}


	if($_GET['IdComEpci']!=''){
		include("detail.php");
	}
?>
</div>



</body>
</html>




