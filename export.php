<?php
session_start();
require("../variables.php");
include('fonctions.php');

$date = date("d-m-Y",time()); 
if($_GET['export']=='sub'){
  $nomfile ="OPENDATA41_CG41subventionsCommunes";
}elseif($_GET['export']=='sub2'){
  $nomfile ="OPENDATA41_CG41subventionsCC";
}elseif($_GET['export']=='ident'){
  $nomfile ="OPENDATA41_Annuaire";
}elseif($_GET['export']=='elus'){
  $nomfile ="OPENDATA41_AnnuairePersonnes";
}
$nomfile .= "_".$date;

$contenu='';
$champs_where='(';
$or='';
if(substr($_GET['IdComEpci'], 0, 3)=="COM"){
  $req="select comcarto from decoupagecommune where comcarto=\"".str_replace("COM", "", $_GET['IdComEpci'])."\";";  
}
else{
  $req="select comcarto from decoupagecommune where codedecoup=\"".$_GET['IdComEpci']."\" OR codedecoup=\"".$_GET['codedecoup']."\";";
}
$getcomcarto = $connexion->prepare($req);
$getcomcarto->execute();
$query = $getcomcarto->fetchAll(\PDO::FETCH_ASSOC);


if($_GET['export']=='sub'){
	
	foreach($query as $comcarto){
		$champs_where.=$or."c.CodeInsee=\"".$comcarto["comcarto"]."\"";
		$or=" or ";
	}
	$champs_where.=')';
	
	$req_data="select c.*, co.nom from CG41SubventionsCom c, communes co where ".$champs_where." and co.comcarto=c.CodeInsee order by c.Numero desc;";

	$getData = $connexion->prepare($req_data);
	$getData->execute();
	$Data = $getData->fetchAll(\PDO::FETCH_ASSOC);
	print_r($Data);

	$i=0;
 	while( $i < sizeof($Data) ){
  
		$contenu[$i]["Provenance"]="OPENDATA41 - www.pilote41.fr";
		$contenu[$i]["Numéro"]=$Data[$i]['Numero'];
		$contenu[$i]["CodeInsee"]=str_replace("COM", "", $Data[$i]['CodeInsee']);
		$contenu[$i]["Commune"]=$Data[$i]['nom'];
		$contenu[$i]["Objet"]=$Data[$i]['Objet'];
		$contenu[$i]["Description"]=$Data[$i]['Description'];
		$contenu[$i]["Montant Initial"]=$Data[$i]['MontantInitial'];
		$contenu[$i]["Montant Versé"]=$Data[$i]['MontantVerse'];
		$i++;
  }
  
  
}

elseif($_GET['export']=='sub2'){
    
	foreach($query as $comcarto){
    	$champs_where.=$or."c.CodeInsee=\"".$comcarto["comcarto"]."\"";
    	$or=" or ";
  	}
  	$champs_where.=')';
  
  
  	$req_data="select c.*, a.nomComEPCI from CG41SubventionsComCom c, annuaire a where c.CodeDecoup='".$_GET['IdComEpci']."' and a.IdComEpci=c.CodeDecoup order by c.Numero desc;";
  
 
  	$getData = $connexion->prepare($req_data);
	$getData->execute();
	$Data = $getData->fetchAll(\PDO::FETCH_ASSOC);

	$i=0;
 	while( $i < sizeof($Data) ){
  
		$contenu[$i]["Provenance"]="OPENDATA41 - www.pilote41.fr";
		$contenu[$i]["Numéro"]=$Data[$i]['Numero'];
		$contenu[$i]["Siren"]=$Data[$i]['SIREN'];
		$contenu[$i]["Nom"]=$Data[$i]['nomComEPCI'];
		$contenu[$i]["Objet"]=$Data[$i]['Objet'];
		//$contenu[$i]["Description"]=$Data[$i]['Description'];
		$contenu[$i]["Montant Initial"]=$Data[$i]['MI'];
		$contenu[$i]["Montant Versé"]=$Data[$i]['MV'];
		$i++;
  }
}

elseif($_GET['export']=='ident'){
  
	foreach($query as $comcarto){
    	$champs_where.=$or."IdComEpci='".$comcarto["comcarto"]."' or IdComEpci like 'COM%".$comcarto["comcarto"]."'";
    	$or=" or ";
  	}
  	$champs_where.=')';
  
  	$req_data="select * from annuaire where ".$champs_where." or IdComEpci='".$_GET['IdComEpci']."' or AliasCodeDecoup='".$_GET['IdComEpci']."'order by nomComEPCI asc;";
  	
  	$getData = $connexion->prepare($req_data);
	$getData->execute();
	$Data = $getData->fetchAll(\PDO::FETCH_ASSOC);

	$i=0;
 	while( $i < sizeof($Data) ){

		$contenu[$i]["Provenance"]="OPENDATA41 - www.pilote41.fr";
		$contenu[$i]["Type_de_collectivite"]=$Data[$i]['TypeComEPCILib'];
		$contenu[$i]["Collectivite"]=$Data[$i]['nomComEPCI'];
		$contenu[$i]["Collectivite_nomcourt"]=$Data[$i]['nomClassement'];
		$contenu[$i]["Adresse"]=$Data[$i]['Adresse'];
		$contenu[$i]["CodePostal"]=$Data[$i]['Codepostal'];
		$contenu[$i]["Commune"]=$Data[$i]['COMMUNE'];
		$contenu[$i]["Cedex"]=$Data[$i]['Cedex'];
		$contenu[$i]["Telephone"]=$Data[$i]['Tel'];
		$contenu[$i]["Telecopie"]=$Data[$i]['Fax'];
		$contenu[$i]["Email"]=$Data[$i]['Email'];
		$contenu[$i]["Siteweb"]=$Data[$i]['SiteWeb'];
		$contenu[$i]["NomDesHabitants"]=$Data[$i]['AutreInfo'];
		$contenu[$i]["Date_MAJ"]=$Data[$i]['DateMaj'];
		$contenu[$i]["SIREN"]=$Data[$i]['NoSiren'];
		$contenu[$i]["codeINSEE"]= str_replace("COM", "", $Data[$i]['IdComEpci']);
		$contenu[$i]["IdASPIC"]=$Data[$i]['IdASPIC'];
		$contenu[$i]["Horaires"]=$Data[$i]['Horaires'];
		$i++;
	}
  
}

elseif($_GET['export']=='elus'){
	
	foreach($query as $comcarto){
    	$champs_where.=$or."a.IdComEpci='".$comcarto["comcarto"]."' or a.IdComEpci like 'COM%".$comcarto["comcarto"]."'";
    	$or=" or ";
  	}
	$champs_where.=')';
  
  
  	$req_data="
    select a.*, ap.* from annuaire a, annuairepers ap, annuairefonctions af 
    where af.Fonction=ap.Fonction and ".$champs_where." and ap.NoComEPCI=a.IdComEpci order by a.nomComEPCI asc, af.OrdreFonction asc;";

	$getData = $connexion->prepare($req_data);
	$getData->execute();
	$Data = $getData->fetchAll(\PDO::FETCH_ASSOC);

	$i=0;
 	while( $i < sizeof($Data) ){
		$contenu[$i]["Provenance"]="OPENDATA41 - www.pilote41.fr";
		$contenu[$i]["CodeINSEE"]=str_replace("COM", "", $Data[$i]['NoComEPCI']);
		$contenu[$i]["Collectivite"]=$Data[$i]['nomComEPCI'];
		$contenu[$i]["Fonction"]=$Data[$i]['Fonction'];
		$contenu[$i]["Fonction_complément"]=$Data[$i]['LibOrdreFonction'];
		$contenu[$i]["Civilité"]=$Data[$i]['Civilite'];
		$contenu[$i]["NomPersonne"]=$Data[$i]['NomPersonne'];
		$contenu[$i]["PrenomPersonne"]=$Data[$i]['PrenomPersonne'];
		$contenu[$i]["CommunePersonne"]=$Data[$i]['CommunePersonne'];
		$i++;
	}
  
  
}



if($_GET["type"] == "json"){
	header('Content-type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	//header("Content-Disposition: attachment; filename=".$nomfile.".json");
	echo json_encode($contenu);
}
if($_GET['type']== "xml"){
	header("Content-type: text/xml;charset=utf-8");
	//header("Content-Disposition: attachment; filename=".$nomfile.".xml");
	$xml = new SimpleXMLElement('<xml/>');
	$OPD = $xml->addChild('OPENDATA41-www.pilote41.fr');
	foreach($contenu as $deps){
		$data = $OPD->addChild($_GET['export']);
		foreach($deps as $key=>$val){
			str_replace(" ","_",$key);
			$element= $data->addChild($key,$val);
		}
	}
	echo $xml->asXML();
	
}
if($_GET['type']=="xls" or $_GET['type']=="csv"){
	$delimiter = ';';
	if($_GET['type']=="xls"){
		header("Content-disposition: attachment; filename=".$nomfile.".xls");
	}
    else{
		header("Content-disposition: attachment; filename=".$nomfile.".csv");
	}
    header("Content-Type: text/csv");
    // I open PHP memory as a file
    $fp = fopen("php://output", 'w');
    // Insert the UTF-8 BOM in the file
	fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
	
    // I add the array keys as CSV headers
    fputcsv($fp,array_keys($contenu[0]),$delimiter);

    // Add all the data in the file
    foreach ($contenu as $data) {
        fputcsv($fp, $data,$delimiter);
	}
	
    // Close the file
    fclose($fp);
	echo $fp;
}
if($_GET['type']=="html"){
	$premier = true;
	
	header("Content-Type: text/html; charset=utf-8");
	//header("Content-disposition: attachment; filename=".$nomfile.".html");
	echo "<html><head><title>OPENDATA - Pilote41</title>";
	echo "<style>
	#tableauOpenData{
		border-collapse:collapse;
	}
	#tableauOpenData tr{
		height:50px;
	}
	#tableauOpenData td{
		border : 1px solid black;
		padding:5px;
	}
	#tableauOpenData th{
		border : 2px solid black;
		padding:5px;
	}
	</style></head>";
	echo "<body><table id=\"tableauOpenData\" >";

	$keys = array_keys($contenu[0]);
	echo "<tr>";
	foreach($keys as $key){
		echo "<th>".$key."</th>";
	}
	echo "</tr>";
	foreach($contenu as $key => $value){
		echo "<tr>"	;
		foreach($value as $cle => $valeur){
			echo "<td>".$valeur."</td>";
		}
		echo "</tr>";
	}
	echo "</table></body></html>";
}
if($_GET['type']=="txt"){

	header('Content-type: text/plain; charset=utf-8');
	header("Content-disposition: attachment; filename=".$nomfile.".txt");
	$txtfile = '';
	$keys = array_keys($contenu[0]);
	foreach($keys as $key){
		$txtfile .= $key." | ";
	}
	foreach($contenu as $key => $value){
		foreach($value as $cle => $valeur){
			$txtfile .= $valeur." | ";
		}
		$txtfile .= "\r";
	}
	echo $txtfile;
}

?>
