<script src="jquery.js"></script>
<script>
	function popup(img){
		$('#imgpopup').attr('src',"");
		$('#imgpopup').attr('src',"Photos/"+img);
		$('#Affichepopup').show();
		
	}
	function popuphide(){
		$('#Affichepopup').hide();
	}
</script>

<?php

if($_GET['onglet']==''){
	if($_GET['IdComEpci']=="DepSen"){  
    	$_GET['onglet']=2;
	}
	else{
    	$_GET['onglet']=1;
  	}
}

echo "<div id=\"annuaire_epci_detail\">\r";


if($_GET['src']!=''){
	echo "<table cellpadding=\"3\" cellspacing=\"2\" align=\"center\" cellspacing=\"0\" width=\"100%\">\r";
	echo "<tr>\r";
	echo "<td style=\"text-align:left;\">\r";
	echo "<a href=\"annuaire.php?IdComEpci=".$_GET['src']."&amp;onglet=3&amp;username=".$_GET['username']."\" style=\"color:#000000; font-weight:bold; font-size:0.75em;\" > << Retour</a>\r";
	echo "</td>\r";
	echo "</tr>\r";
	echo "</table>";
}elseif($_SESSION['nbrEpci']>1){
	echo "<table cellpadding=\"3\" cellspacing=\"2\" align=\"center\" cellspacing=\"0\" width=\"100%\">\r";
	echo "<tr>\r";
	echo "<td style=\"text-align:left;\">\r";
	echo "<a href=\"annuaire.php?username=".$_GET['username']."&amp;retour=1\" style=\"color:#000000; font-weight:bold; font-size:0.75em;\" > << Retourner à la liste</a>\r";
	echo "</td>\r";
	echo "</tr>\r";
	echo "</table>";
}

$req_annuaire="select * from annuaire where IdComEpci='".$_GET['IdComEpci']."';";

$getDataAnnuaire = $connexion->prepare($req_annuaire);
$getDataAnnuaire->execute();
$DataAnnuaire = $getDataAnnuaire->fetchAll(\PDO::FETCH_ASSOC);
$annuaire = $DataAnnuaire[0];

if(!empty($annuaire)){

  	if($annuaire['AliasCodeDecoup']!=''){
    	$codedecoup=$annuaire['AliasCodeDecoup'];
	}
	  else{
    	$codedecoup=$_GET['IdComEpci'];  
  	}


  	echo "<h2 class=\"titreDetail\"><a href=\"print_annuaire.php?IdComEpci=".$_GET['IdComEpci']."\" target=\"_blank\" >
  	</a>".str_replace(" (élus du Loir-et-Cher)", "", $annuaire['nomComEPCI'])."</h2>";
	  
  	echo "<div id=\"onglets\">\r";
  	echo "<ul class=\"sidenav\">\r";
  	if($_GET['IdComEpci']!="DepSen"){  
  	  echo "<li><a ";if($_GET['onglet']==1){echo "class=\"active\"";}echo " href=\"annuaire.php?username=".$_GET['username']."&amp;IdComEpci=".$_GET['IdComEpci']."&amp;onglet=1\">Fiche d'identité</a></li>\r";
  	}

    
  	$req_fonc="select distinct af.FonctionGpe, af.OrdreFonction from  annuairepers ap, annuairefonctions af 
  	where ap.FinFonction is null and ap.Fonction=af.Fonction and ap.NoComEPCI='".$_GET['IdComEpci']."' and af.FonctionType!='Admin' 
  	order by af.OrdreFonction;";  //--Lister les fonctions hors Admin	

  	$getDataFonction = $connexion->prepare($req_fonc);
	$getDataFonction->execute();
	$DataFonction = $getDataFonction->fetchAll(\PDO::FETCH_ASSOC);
	$fonction = $DataFonction[0];

  	if(!empty($fonction)){
  	  echo "<li><a ";if($_GET['onglet']==2){echo "class=\"active\"";}echo " href=\"annuaire.php?username=".$_GET['username']."&amp;IdComEpci=".$_GET['IdComEpci']."&amp;onglet=2\">Elus</a></li>\r";
  	}  
  	if($_GET['IdComEpci']!="DepSen"){
  	  	if($_GET['IdComEpci']!="CR"){
  	    	echo "<li><a ";if($_GET['onglet']==3){echo "class=\"active\"";}echo " href=\"annuaire.php?username=".$_GET['username']."&amp;IdComEpci=".$_GET['IdComEpci']."&amp;onglet=3\">Intercommunalité</a></li>\r";
			//---PL--Modifier le critère => 
			/*       if($annuaire['Xprecis']!='' and $annuaire['Yprecis']!=''){
    		    echo "<li><a ";if($_GET['onglet']==4){echo "class=\"active\"";}echo " href=\"annuaire.php?username=".$_GET['username']."&amp;IdComEpci=".$_GET['IdComEpci']."&amp;onglet=4\">Localisation</a></li>\r";
			  } 
			*/
      		echo "<li><a ";if($_GET['onglet']==5){echo "class=\"active\"";}echo " href=\"annuaire.php?username=".$_GET['username']."&amp;IdComEpci=".$_GET['IdComEpci']."&amp;onglet=5\">Autres découpages</a></li>\r";
      		echo "<li id='lienOnglet6' ><a ";if($_GET['onglet']==6){echo "class=\"active\"";}echo " href=\"annuaire.php?username=".$_GET['username']."&amp;IdComEpci=".$_GET['IdComEpci']."&amp;onglet=6\">Téléchargement</a></li>\r";
    	}
 	}
  	echo "</ul>\r";
  
  	//echo "<a id=\"lien_erreur\" target=\"_blank\" href=\"http://www.pilote41.fr/index.php?option=com_artforms&&formid=2&IdComEpci=".$_GET['IdComEpci']."\">Nous signaler une modification</a>\r";
  	echo "<a id=\"lien_erreur\" target=\"_blank\" href=\"mailto:infos@observatoire41.com?subject=Pilote41 - Signaler une modification&body=>>> Fiche &agrave; modifier : ".($annuaire['nomComEPCI'])." (code : " .$_GET['IdComEpci'].") <<<\">Nous signaler une modification</a>\r";
	echo "</div>\r";
	

	
	if($_GET['onglet']==1){    
		echo "<div class=\"epci_onglet\" >\r"; 

		echo "<div id=\"fiche_coord\">\r";
		echo "<table class=\"fiche coordonnees\">\r";

		echo "<tr>\r";
		echo "<td class=\"top\">";
		echo $annuaire['Adresse']."<br />";
		echo $annuaire['Codepostal']." ";
		echo $annuaire['COMMUNE']." ";
		echo $annuaire['Cedex']."<br />";
		echo "</td>\r";
		echo "<td class=\"top\">";
		if($annuaire['Tel']!='') echo "Tél. ".tel($annuaire['Tel'])."<br />";
		if($annuaire['Fax']!='') echo "Fax. ".tel($annuaire['Fax'])."<br />";
		if($annuaire['Email']!='') echo "E-mail : <a href=\"mailto:".$annuaire['Email']."\" >".$annuaire['Email']."</a><br />";
		if($annuaire['SiteWeb']!='') echo "Site web : <a target=\"_blank\" href=\"https://".str_replace("https://", "",$annuaire['SiteWeb'])."\" >".$annuaire['SiteWeb']."</a>";
		echo "</td>\r";
		echo "</tr>\r";
		
		echo "</table>";
		echo "</div>";

		
		$req_maire="select ap.* from  annuairepers ap, annuairefonctions af 
		where ap.FinFonction is null and ap.Fonction=af.Fonction and ap.NoComEPCI='".$_GET['IdComEpci']."' and af.FonctionType='EluAdmin' order by NomPersonne;";
		
		$getDataMaire = $connexion->prepare($req_maire);
		$getDataMaire->execute();
		$ResultMaire = $getDataMaire->fetchAll(\PDO::FETCH_ASSOC);
		$Maire = $ResultMaire[0];

		if(!empty($Maire)){

			echo "<div id=\"fiche_maire\">";
			echo "<table class=\"fiche maire\">\r";
			echo "<tr><td colspan=\"2\" class=\"fiche_titre\">".$Maire['Fonction']."</td></tr>\r";

			$nb=1;
			if($groupeelu=='0'){
				if($Maire['TelPerso']!='') $nb++;
				if($Maire['MailPerso']!='') $nb++;
				if($Maire['Profession']!='') $nb++;
			}
			
			echo "<tr>\r";
			echo "<td style=\"width:60%;\" class=\"fiche_texte\">";
			echo "<a href=\"annuaire.php?username=".$_GET['username']."&amp;nompers=".$Maire['Civilite']." ".$Maire['NomPersonne']." ".$Maire['PrenomPersonne']."\" >".$Maire['Civilite']." ".$Maire['PrenomPersonne']." ".$Maire['NomPersonne']."</a>";
			echo "</td>\r";
			echo "<td class=\"fiche_texte onglet1_photo\" style=\"width:5%;\" rowspan=\"".$nb."\" >";
			if($Maire['Photo']!='' and file_exists("Photos/".$Maire['Photo'])) echo "<a href=\"javascript:popup('".$Maire['Photo']."');\" ><img src=\"Photos/".$Maire['Photo']."\" alt=\"\" width=\"40px\" /></a>\r";
			echo "</td>\r";
			echo "</tr>\r";

			if($groupeelu=='0'){
				if($Maire['TelPerso']!=''){
					echo "<tr>\r";
					echo "<td colspan=\"2\" class=\"fiche_libelle\">Téléphone personnel : ".tel($Maire['TelPerso']);
					echo "</td>\r";
					echo "</tr>\r";
				}

				if($Maire['MailPerso']!=''){
					echo "<tr>\r";
					echo "<td colspan=\"2\"  class=\"fiche_libelle\">E-mail personnel : <a href=\"mailto:".$Maire['MailPerso']."\" >".$Maire['MailPerso']."</a></td>\r";
					echo "</tr>\r";
				}

				if($Maire['Profession']!=''){
					echo "<tr>\r";
					echo "<td class=\"fiche_libelle\" colspan=\"2\" >Profession : ".$Maire['Profession']."</td>\r";
					echo "</tr>\r";
				}
			}

		echo "</table></div>";
		}
		
		echo "<div id=\"fiche_administration\">";
		echo "<table class=\"fiche administration\">\r";
		$req_adjoint="select ap.* from annuairepers ap, annuairefonctions af where ap.FinFonction is null and ap.NoComEPCI='".$_GET['IdComEpci']."' and ap.Fonction=af.Fonction and af.FonctionType='Admin' order by ap.OrdreFonction asc, ap.CommunePersonne asc, ap.NomPersonne asc, ap.PrenomPersonne asc;";
		//echo $req_adjoint; //--DEBUG
		
		$getDataAdjoint = $connexion->prepare($req_adjoint);
		$getDataAdjoint->execute();
		$ResultAdjoint = $getDataAdjoint->fetchAll(\PDO::FETCH_ASSOC);

		if(!empty($ResultAdjoint)){

			echo "<tr><td colspan=\"3\" class=\"fiche_titre\">Administration</td></tr>\r";      
			
			foreach($ResultAdjoint as $adjoint){
				echo "<tr>\r";
				echo "<td  class=\"fiche_texte\">";
				echo "<a href=\"annuaire.php?username=".$_GET['username']."&amp;nompers=".$adjoint['Civilite']." ".$adjoint['NomPersonne']." ".$adjoint['PrenomPersonne']."\" >".$adjoint['Civilite']." ".$adjoint['PrenomPersonne']." ".$adjoint['NomPersonne']."</a>";
				echo "</td>\r";
				echo "<td class=\"fiche_texte\">".$adjoint['Fonction']."</td>";
				echo "<td class=\"fiche_texte  onglet1_photo\" style=\"width:5%;\" >"; 
				if($adjoint['Photo']!='' and file_exists("Photos/".$adjoint['Photo'])) echo "<a href=\"javascript:popup('".$adjoint['Photo']."');\" ><img src=\"Photos/".$adjoint['Photo']."\" alt=\"\" width=\"40px\" /></a>\r";
				echo "&nbsp;</td>\r";
				echo "</tr>\r";
			}
		}
		
		echo "</table></div>";
		echo "</td>";
		
		echo "<td style=\"vertical-align:top;\" >";
		echo "<div id=\"div_hor_stat\">";

		if($annuaire['Horaires']!=''){
			echo "<div id=\"fiche_horaires\">";
			echo "<table class=\"fiche horaires\">\r";
			echo "<tr><td class=\"fiche_titre\">Horaires d'ouverture au public</td></tr>\r";
			echo "<tr><td class=\"fiche_texte\">".nl2br($annuaire['Horaires'])."</td></tr>\r";
			echo "</table></div><br />";
		
		}
		
		
		$requete="select * from decoupagecommune where codedecoup like '".$codedecoup."'";
		//echo $requete;
		$getDatacodecommunes = $connexion->prepare($requete);
		$getDatacodecommunes->execute();
		$Resultcodecommune = $getDatacodecommunes->fetchAll(\PDO::FETCH_ASSOC);

		$champs_where="";
		foreach ($Resultcodecommune as $codecommune){
			$comcarto=$codecommune["comcarto"];
			$champs_where.=$or." comcarto='$comcarto' ";
			$or="or";
		}
		

		
		$requete="select annee,sum(ptot) as ptot,sum(psdc) as psdc from population where (".$champs_where.") group by annee ORDER BY annee DESC limit 0,1";
		
		$getDataPop = $connexion->prepare($requete);
		$getDataPop->execute();
		$ResultPop = $getDataPop->fetchAll(\PDO::FETCH_ASSOC);
		$pop = $ResultPop[0];

		echo "<div id=\"fiche_stats\">";
		echo "<table class=\"fiche stats\">\r";

		echo "<tr><td class=\"fiche_titre\">Population / Statistiques</td></tr>\r";
		echo "<tr><td class=\"fiche_texte\">";
		if(!empty($pop)){
			//echo number_format($pop['ptot'], 0, '.', ' ')." habitants (".$pop['annee'].") <br />";
			echo number_format($pop['psdc'], 0, '.', ' ')." habitants (".$pop['annee'].") <br />";
		}
		if (stristr($annuaire['TypeComEPCI'],'Mairie')) echo "Code INSEE : ".substr($_GET['IdComEpci'],3)."<br />";
		if($annuaire['NoSiren']!='') echo "Siren : ".$annuaire['NoSiren']."<br />";
		
		if($annuaire['AutreInfo']!='') echo "Nom des habitants : ".ucfirst($annuaire['AutreInfo'])."<br />";
		
		$requete="select distinct sous_type, codedecoup, codedecoupgene from decoupage where codedecoup='".$_GET['IdComEpci']."' order by sous_type";
		
		$getDataCategories = $connexion->prepare($requete);
		$getDataCategories->execute();
		$DataCategories = $getDataCategories->fetchAll(\PDO::FETCH_ASSOC);
		$cat = $DataCategories[0];
		
		$pageInsee="https://www.insee.fr/fr/statistiques/1405599?geo=";
		$statsInsee="https://www.insee.fr/fr/statistiques?taille=50&debut=0&categorie=5+4&geo=";
		//$rapportatlas ="https://atlas.pilote41.fr/socioeco/index.php#c=report&chapter=dep41_p04&report=r03&selgeo2=dep.41&selgeo1=";	//com2019.41018
		$rapportatlas ="https://atlas.pilote41.fr/socioeco/Hub.php?cle=41#c=report&chapter=dep41_p04&report=r03";	//com2019.41018
		
		if(stristr($annuaire['TypeComEPCI'],'Mairie')) {
			$lien = $pageInsee."COM-".substr($_GET['IdComEpci'],3)."+DEP-41" ;
			$lienstats =  $statsInsee."COM-".substr($_GET['IdComEpci'],3) ;
			$lienatlas = $rapportatlas."&selgeo2=dep.41&selgeo1="."com2019.".substr($_GET['IdComEpci'],3)  ;
			echo "<a target=\"_blank\" href=\"$lienatlas\" >Portrait de territoire de l'atlas socio-économique <img src=\"images/picto_cu2_41_40px.png\" align=\"absmiddle\" alt=\"Portrait de territoire de l'atlas socio-économique\" style=\"border:none;\"/></a><br />";
			echo "<a target=\"_blank\" href=\"$lien\" >Chiffres clés</a> - <a target=\"_blank\" href=\"$lienstats\" >Statistiques</a>&nbsp;<a target=\"_blank\" href=\"$lien\" ><img src=\"images/logo_insee_site40.png\" align=\"absmiddle\" alt=\"Dossier statistique complet - INSEE\" style=\"border:none;\"/></a>";
		}
		
		if(substr($annuaire['TypeComEPCI'],0,1)=='A' and $annuaire['NoSiren']!='') {	// ComDeCom avec SIREN connu dans la base
			$lien = $pageInsee."EPCI-".$annuaire['NoSiren']."+DEP-41"  ;
			$lienstats =  $statsInsee."EPCI-".$annuaire['NoSiren'] ;
			$lienatlas = $rapportatlas."&selgeo2=dep.41&selgeo1="."comcom.".$annuaire['NoSiren']  ;
			echo "<a target=\"_blank\" href=\"$lienatlas\" >Portrait de territoire de l'atlas socio-économique <img src=\"images/picto_cu2_41_40px.png\" align=\"absmiddle\" alt=\"Portrait de territoire de l'atlas socio-économique\" style=\"border:none;\"/></a><br />";
			echo "<a target=\"_blank\" href=\"$lien\" >Chiffres clés</a> - <a target=\"_blank\" href=\"$lienstats\" >Statistiques</a>&nbsp;<a target=\"_blank\" href=\"$lien\" ><img src=\"images/logo_insee_site40.png\" align=\"absmiddle\" alt=\"Dossier statistique complet - INSEE\" style=\"border:none;\"/></a>";
		}
		if($annuaire['TypeComEPCI']=='001' or $annuaire['TypeComEPCI']=='003') { 	//CD41 ou Parlementaires
			$lien = $pageInsee."DEP-41+REG-24+FRANCE-1" ;
			$lienstats =  $statsInsee."DEP-41" ;
			$lienatlas = $rapportatlas."&selgeo2=reg.24&selgeo1=dep.41"  ;
			echo "<a target=\"_blank\" href=\"$lienatlas\" >Portrait de territoire de l'atlas socio-économique <img src=\"images/picto_cu2_41_40px.png\" align=\"absmiddle\" alt=\"Portrait de territoire de l'atlas socio-économique\" style=\"border:none;\"/></a><br />";
			echo "<a target=\"_blank\" href=\"$lien\" >Chiffres clés</a> - <a target=\"_blank\" href=\"$lienstats\" >Statistiques</a>&nbsp;<a target=\"_blank\" href=\"$lien\" ><img src=\"images/logo_insee_site40.png\" align=\"absmiddle\" alt=\"Dossier statistique complet - INSEE\" style=\"border:none;\"/></a>";
		}
		if($annuaire['TypeComEPCI']=='002') { 	//Région Centre
			$lien = $pageInsee."REG-24+FRANCE-1";
			$lienstats =  $statsInsee."REG-24" ;
			echo "<a target=\"_blank\" href=\"$lien\" >Chiffres clés</a> - <a target=\"_blank\" href=\"$lienstats\" >Statistiques</a>&nbsp;<a target=\"_blank\" href=\"$lien\" ><img src=\"images/logo_insee_site40.png\" align=\"absmiddle\" alt=\"Dossier statistique complet - INSEE\" style=\"border:none;\"/></a>";
		}	

		echo "</td></tr>\r"; // target=\"_blank\"
		echo "</table></div>";
		
		echo "</div>";

		echo "<div id=\"fiche_carte\">";
	
		//---Fiche d'identité - Affichage des cartes
		if( substr($annuaire['TypeComEPCI'],0,2)=='B0' ){  //-- B0 => Pays

		$reqCarte="select * from DecoupageCartes where CodeDecoup='".str_replace("COM", "", $_GET['IdComEpci'])."';";
		
		$getDataCarte = $connexion->prepare($reqCarte);
		$getDataCarte->execute();
		$ResultCarte = $getDataCarte->fetchAll(\PDO::FETCH_ASSOC);
		$carte = $ResultCarte[0];

		if(!empty($carte)){
			echo "<a href=\"".$carte['LienRep'].$carte['Fichier']."\" target=\"_blank\" ><img class=\"vignette_carte\" src=\"images/annupays_1.jpg\" alt=\"\" /></a>\r";  
		}
		//echo "<a href=\"http://doc.pilote41.fr/fournisseurs/observatoire/cartotheque/cartes_administratives/intercommunalite/cg41_pays.pdf\" target=\"_blank\" ><img class=\"vignette_carte\" src=\"images/annupays_2.jpg\" alt=\"\" /></a>\r";
		echo "<a href=\"https://doc.pilote41.fr/fournisseurs/observatoire/cartotheque/cartes_administratives/intercommunalite/carte_pays.pdf\" target=\"_blank\" ><img class=\"vignette_carte\" src=\"images/annupays_3.jpg\" alt=\"\" /></a>\r";
		}
		elseif( substr($annuaire['TypeComEPCI'],0,1)=='A' ){  //-- A => ComDeCom
			$reqCarte="select * from DecoupageCartes where CodeDecoup='".str_replace("COM", "", $_GET['IdComEpci'])."';";
			
			$getDataCarte = $connexion->prepare($reqCarte);
			$getDataCarte->execute();
			$ResultCarte = $getDataCarte->fetchAll(\PDO::FETCH_ASSOC);
			$carte = $ResultCarte[0];

			if(!empty($carte)){
				echo "<a href=\"".$carte['LienRep'].$carte['Fichier']."\" target=\"_blank\" ><img class=\"vignette_carte\" src=\"images/annucc_1.jpg\" alt=\"\" /></a>\r";  
			}
			//echo "<a href=\"http://doc.pilote41.fr/fournisseurs/observatoire/cartotheque/cartes_administratives/intercommunalite/cg41_cc.pdf\" target=\"_blank\" ><img class=\"vignette_carte\" src=\"images/annucc_2.jpg\" alt=\"\" /></a>\r";
			echo "<a href=\"https://doc.pilote41.fr/fournisseurs/observatoire/cartotheque/cartes_administratives/intercommunalite/carte_comdecomm.pdf\" target=\"_blank\" ><img class=\"vignette_carte\" src=\"images/annucc_3.jpg\" alt=\"\" /></a>\r";
		}
		elseif( stristr($annuaire['TypeComEPCI'],'Mairie') ){ //-- Communes
		//echo "<a href=\"http://doc.pilote41.fr/fournisseurs/observatoire/cartotheque/cartes_administratives/intercommunalite/cg41_maires_3circo.pdf\" target=\"_blank\" ><img class=\"vignette_carte\" src=\"images/annucom_2.jpg\" alt=\"\" /></a>\r";
		echo "<a href=\"https://doc.pilote41.fr/fournisseurs/observatoire/cartotheque/cartes_administratives/lc_decoup/cart_02.pdf\" target=\"_blank\" ><img class=\"vignette_carte\" src=\"images/annucom_3.jpg\" alt=\"\" /></a>\r";
		}
		elseif($_GET['IdComEpci']=="DepSen"){
		//echo "<a href=\"http://doc.pilote41.fr/fournisseurs/observatoire/cartotheque/cartes_administratives/lc_decoup/cg41_circonscriptions_electorales.pdf\" target=\"_blank\" ><img class=\"vignette_carte\" src=\"images/annucirco_2.jpg\" alt=\"\" /></a>\r";
		}
		elseif($_GET['IdComEpci']=="CG41"){
		//echo "<a href=\"http://doc.pilote41.fr/fournisseurs/observatoire/cartotheque/cartes_administratives/intercommunalite/cg41_conseillers_generaux.pdf\" target=\"_blank\" ><img class=\"vignette_carte\" src=\"images/annucan_2.jpg\" alt=\"\" /></a>\r";
		echo "<a href=\"https://doc.pilote41.fr/fournisseurs/observatoire/cartotheque/cartes_administratives/lc_decoup/cart_02.pdf\" target=\"_blank\" ><img class=\"vignette_carte\" src=\"images/annucan_3.jpg\" alt=\"\" /></a>\r";
		}
		

		
		
		
		if($annuaire['Photo1']!='' and file_exists("Photos/".$annuaire['Photo1'])) echo "<a href=\"javascript:popup('".$annuaire['Photo1']."');\" ><img src=\"Photos/".$annuaire['Photo1']."\" alt=\"\" hspace=\"20\" height=\"100px\" /></a>\r";
		if($annuaire['Photo2']!='' and file_exists("Photos/".$annuaire['Photo2'])) echo "<a href=\"javascript:popup('".$annuaire['Photo2']."');\" ><img src=\"Photos/".$annuaire['Photo2']."\" alt=\"\" height=\"100px\" /></a>\r"; 
	
		echo "</div>\r";
	}
	
	elseif($_GET['onglet']==2){
		
		echo "<div class=\"epci_onglet onglet2\" >\r";
	
	
	
		echo "<table id=\"tableelus\">\r";
		
		$req_fonc="select distinct af.FonctionGpe, af.OrdreFonction from  annuairepers ap, annuairefonctions af 
		where ap.FinFonction is null and ap.Fonction=af.Fonction and ap.NoComEPCI='".$_GET['IdComEpci']."' and af.FonctionType!='Admin' 
		order by af.OrdreFonction;";
		
		$getDataFonc = $connexion->prepare($req_fonc);
		$getDataFonc->execute();
		$ResultFonc = $getDataFonc->fetchAll(\PDO::FETCH_ASSOC);

		if(!empty($ResultFonc)){
			foreach($ResultFonc as $fonc){

				if(substr($_GET['IdComEpci'], 0, 3)!='COM'){ $colspan="4"; }else{ $colspan="3"; }

				if($_GET['IdComEpci']=='CR' or $_GET['IdComEpci']=='DepSen'){
					echo "<tr><td colspan=\"".$colspan."\" class=\"fiche_titre\">".$fonc['FonctionGpe']." élus du Loir-et-Cher</td></tr>\r";      
				}
				else{
					echo "<tr><td colspan=\"".$colspan."\" class=\"fiche_titre\">".$fonc['FonctionGpe']."</td></tr>\r";
				}
				
				$req_adjoint="select ap.* from annuairepers ap, annuairefonctions af 
				where ap.FinFonction is null and ap.NoComEPCI='".$_GET['IdComEpci']."' and af.FonctionGpe='".$fonc['FonctionGpe']."' and ap.Fonction=af.Fonction and af.FonctionType!='Admin' ";
				if(trim($fonc['FonctionGpe'])=="Délégués communautaires" ){
					//$req_adjoint.="order by ap.CommunePersonne asc, ap.OrdreFonction asc, ap.NomPersonne asc, ap.PrenomPersonne asc;";
					$req_adjoint.="order by ap.CommunePersonne COLLATE latin1_swedish_ci asc, ap.OrdreFonction asc, ap.NomPersonne asc, ap.PrenomPersonne asc;";
				}
				else{
					//$req_adjoint.="order by ap.OrdreFonction asc, ap.CommunePersonne asc, ap.NomPersonne asc, ap.PrenomPersonne asc;";
					//$req_adjoint.="order by ap.OrdreFonction asc, (CON T(ap.CommunePersonne USING utf8 ) COLLATE utf8_general_ci) asc, ap.NomPersonne asc, ap.PrenomPersonne asc;";
					$req_adjoint.="order by ap.OrdreFonction asc, ap.CommunePersonne COLLATE latin1_swedish_ci asc, ap.NomPersonne asc, ap.PrenomPersonne asc;";
				}
				
				$getDataAdjoint = $connexion->prepare($req_adjoint);
				$getDataAdjoint->execute();
				$ResultAdjoint = $getDataAdjoint->fetchAll(\PDO::FETCH_ASSOC);

				foreach($ResultAdjoint as $adjoint){
					echo "<tr>\r";
					echo "<td class=\"ligne_result\">";
					echo "<a href=\"annuaire.php?username=".$_GET['username']."&amp;nompers=".$adjoint['Civilite']." ".$adjoint['NomPersonne']." ".$adjoint['PrenomPersonne']."\" >".$adjoint['Civilite']." ".$adjoint['PrenomPersonne']." ".$adjoint['NomPersonne']."</a>";
					echo "</td>\r";
					echo "<td class=\"ligne_result\">&nbsp;";
					echo $adjoint['LibOrdreFonction'];
					echo "</td>\r";
					if(substr($_GET['IdComEpci'], 0, 3)!='COM'){
						echo "<td class=\"ligne_result\">&nbsp;";
						echo $adjoint['CommunePersonne'];
						echo "</td>\r";
					}
					echo "<td class=\"ligne_result_photo\">";
					if($adjoint['Photo']!='' and file_exists("Photos/".$adjoint['Photo'])) echo "<a href=\"javascript:popup('".$adjoint['Photo']."');\" ><img src=\"Photos/".$adjoint['Photo']."\" alt=\"\" width=\"40px\" /></a>\r";
					echo "&nbsp;</td>\r";
					echo "</tr>\r";
				}
			}
		}
		
		echo "</table>\r";  
		//---------Message Actualisation election ------
/* 		if(substr($annuaire['TypeComEPCI'],0,1)!='0'){ 
		echo "<div class='encartInfo'><p>Le nom des élus sera prochainement mis à jour dans le cadre d’un partenariat avec l’association des Maires de Loir-et-Cher</p></div>";
		} */
		//----------------------------------------------
		echo "</div>\r";

	}
	
	elseif($_GET['onglet']==3){
		
		echo "<div class=\"epci_onglet onglet3\" style=\"padding-top:10px;\">\r";
	
		if(stristr($annuaire['TypeComEPCI'],'Mairie')){

			echo "<table class=\"tableintercomm\">\r";
			$titre="<tr><td class=\"fiche_titre\" style=\"width:50%;\" >Communauté de communes / Syndicat de pays</td><td colspan=3 class=\"fiche_sstitre\" >Type et date d'adhésion</td></tr>\r";
			$titre=bloc($_GET['IdComEpci'], 'A', 'a', $titre);
			$titre=bloc($_GET['IdComEpci'], 'B', 'a', $titre);
			$titre="<tr><td class=\"fiche_titre\" style=\"width:50%;\">Autres syndicats</td><td colspan=3 class=\"fiche_sstitre\" >Type et date d'adhésion</td></tr>\r";
			bloc($_GET['IdComEpci'], 'C', 'a', $titre);
			echo "</table>\r";
		}
		
		elseif(substr($annuaire['TypeComEPCI'], 0, 1)=='A'){

			echo "<table class=\"tableintercomm\" >\r";
			$titre="<tr><td class=\"fiche_titre\" style=\"width:50%;\">Communes membres</td><td colspan=3 class=\"fiche_sstitre\" >Type et date d'adhésion</td></tr>\r";
			$titre=bloc($_GET['IdComEpci'], 'A', 'm', $titre);
			echo "</table>\r";    

			echo "<table class=\"tableintercomm\" >\r";
			$titre="<tr><td class=\"fiche_titre\" style=\"width:50%;\">Adhésion à un EPCI</td><td colspan=3 class=\"fiche_sstitre\" ></td></tr>\r";
			$titre=bloc($_GET['IdComEpci'], 'D', 'a', $titre);
			$titre=bloc($_GET['IdComEpci'], 'E', 'a', $titre);
			echo "</table>\r";

		}
		
		elseif(substr($annuaire['TypeComEPCI'], 0, 1)=='B'){

			echo "<table class=\"tableintercomm\">\r";
			$titre="<tr><td class=\"fiche_titre\" style=\"width:50%;\">Les membres</td><td colspan=3 class=\"fiche_sstitre\" >Type et date d'adhésion</td></tr>\r";
			$titre=bloc($_GET['IdComEpci'], 'B', 'm', $titre);
			$titre=bloc($_GET['IdComEpci'], 'D', 'm', $titre);
			$titre=bloc($_GET['IdComEpci'], 'G', 'm', $titre);
			echo "</table>\r";
		}
		
		elseif(substr($annuaire['TypeComEPCI'], 0, 1)=='C'){

			echo "<table class=\"tableintercomm\">\r";
			$titre="<tr><td class=\"fiche_titre\" style=\"width:50%;\">Les membres</td><td colspan=3 class=\"fiche_sstitre\" >Type et date d'adhésion</td></tr>\r";
			$titre=bloc($_GET['IdComEpci'], 'C', 'm', $titre);
			$titre=bloc($_GET['IdComEpci'], 'E', 'm', $titre);
			$titre=bloc($_GET['IdComEpci'], 'F', 'm', $titre);
			$titre=bloc($_GET['IdComEpci'], 'G', 'm', $titre);
			echo "</table>\r";
			echo "<table class=\"tableintercomm\">\r";
			$titre="<tr><td class=\"fiche_titre\" style=\"width:50%;\">Adhésion à un EPCI</td><td colspan=3 class=\"fiche_sstitre\" ></td></tr>\r";
			$titre=bloc($_GET['IdComEpci'], 'F', 'a');
			echo "</table>\r";
		}


		echo "<table class=\"tableintercomm\">\r";
		echo "<tr><td class=\"spacer\" ></td></tr>\r";
		echo "</table>\r";  


		echo "</table>\r";  
		echo "</div>\r";
	
	}

	elseif($_GET['onglet']==4){
		echo "<div class=\"epci_onglet onglet4\" >\r";
		include('carte_annu.php');
		echo "</div>\r";
	}	

	elseif($_GET['onglet']==5){
		echo "<div class=\"epci_onglet onglet5\" >\r";
		include('liste_autres_tout.php');
		echo "</div>\r";
	}

	elseif($_GET['onglet']==6){
		echo "<div class=\"epci_onglet onglet6\">";
		include('opendata.php');
		echo "</div>";
	}

}
echo "</div>\r";

?>

<div id="Affichepopup">
	<span class="helper"></span>
	<div>
		<a onclick="popuphide()" class="popupCloseButton">X</a>
		<img id="imgpopup" src="" style="max-height:300;max-width:300;min-height:200;min-width:200;"/>
	</div>
</div>
