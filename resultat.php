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

<?php if($_GET['nompers']!=''){ ?>
	<table cellpadding="3" cellspacing="2" cellspacing="0" width="95%">
	<tr>
	<td style="text-align:left;">
	<a onclick="window.history.go(-1);" style="color:#000000; font-weight:bold; font-size:0.75em;cursor: pointer;" > << Retourner à la fiche </a>
	</td>
	</tr>
	</table>
<?}?>
<?php
  //---MOTEUR SIMPLE ----
    if($_SESSION['type_nom']=='personne'){
    	$requete_liste_epci="
      select 
      a.nomComEPCI, a.IdComEpci, ap.Civilite, ap.NomPersonne, ap.PrenomPersonne, ap.Fonction, ap.LibOrdreFonction, ap.Photo 
      from 
      annuairepers ap, annuaire a 
      where 
      a.IdComEpci=ap.NoComEPCI and UPPER(CONCAT(ap.Civilite, ' ',ap.NomPersonne, ' ',ap.PrenomPersonne)) COLLATE latin1_swedish_ci  like '%".addslashes(mise_majuscules($_SESSION['nom']))."%' 
      order by 
      NomPersonne asc, PrenomPersonne asc;";
    }else{
    
    	$requete_liste_epci="select 
      nomComEPCI, IdComEpci
      from 
      annuaire 
      where 
      (UPPER(nomComEPCI) COLLATE latin1_swedish_ci  like '%".addslashes(mise_majuscules($_SESSION['nom']))."%' 
      or 
      UPPER(nomClassement) COLLATE latin1_swedish_ci  like '%".addslashes(mise_majuscules($_SESSION['nom']))."%')
      order by 
      nomComEPCI asc;";
    }
    $requeteGetData = $connexion->prepare($requete_liste_epci);
    $requeteGetData->execute();
	$personnes = $requeteGetData->fetchAll(\PDO::FETCH_ASSOC);
	
	$nbr = sizeof($personnes);

	$_SESSION['nbrEpci']= $nbr;

    if( $nbr==1 and $_SESSION['type_nom']!='personne' ){
      $_GET['IdComEpci']=$personnes[0]['IdComEpci'];
	}
	else{ ?>
 
      <div id="annuaire_epci_result">
      <table width="95%">
      <tr>
      <td style="text-align:right;">
	
	  <?php
      if ($nbr==0){
          echo "Il n'y a aucune réponse à votre recherche.";
	  }
	  else{ ?>
        Il y a <?=$nbr?> réponse(s) à votre recherche.
      
        </td>
        </tr>
        </table>
      
        <table id="tableResultats" width="95%">
		
		<?php
        $color="#FFFFFF";
        if($_SESSION['type_nom']=='personne'){
    
			echo "<thead>\n";
			echo "<th>Commune/Collectivité</th>\r";
			echo "<th style=\"padding: 10px 0px;\">Mandat/Fonction</th>\r";
        	echo "</thead>\n";
	
			$j=0;
			while($j < sizeof($personnes)){            
				if ($color=="rgba(24,100,153,0.2)"){ $color="#FFFFFF"; }else{ $color="rgba(24,100,153,0.2)"; }

				echo "<tr>\r";
				echo "<th COLSPAN=2 class=\"epci_result titreresult\" style=\"background-color:".$color.";\">\r";
				if($personnes[$j]['Photo']!='' and file_exists("Photos/".$personnes[$j]['Photo']) ){
				?>
					<a href="javascript:popup('<?=$personnes[$j]['Photo']?>');" ><img class="imgPers" height="50px" src="Photos/<?=$personnes[$j]['Photo']?>" alt="<?=$personnes[$j]['NomPersonne']?>  <?=$personnes[$j]['PrenomPersonne']?>" /> </a>
					
					<div id="Affichepopup">
						<span class="helper"></span>
						<div>
							<a onclick="popuphide()" class="popupCloseButton">X</a>
							<img id="imgpopup" src="" style="max-height:300;max-width:300;min-height:200;min-width:200;"/>
						</div>
					</div>

					<?php
				} 
				echo "<div>\r";
				echo $personnes[$j]['Civilite']." ".$personnes[$j]['PrenomPersonne']." ".$personnes[$j]['NomPersonne'];
				echo "</div>\r";
				echo "</th>\r";
				echo "</tr>\r";

				do{
					echo"<tr>\r";
					echo "<td width=\"50%\" class=\"epci_result\" style=\"border:0px;background-color:".$color.";\"><a href=\"annuaire.php?username=".$_GET['username']."&amp;IdComEpci=".$personnes[$j]['IdComEpci']."\">".$personnes[$j]['nomComEPCI']."</a></td>\r";
					echo "<td width=\"50%\" class=\"epci_result\" style=\"border:0px;background-color:".$color.";\">";
					echo $personnes[$j]['Fonction'];
					if($personnes[$j]['LibOrdreFonction']!='') echo " (".$personnes[$j]['LibOrdreFonction'].")";
					echo "</td>\r";
					echo "</tr>\r";
					$j++;
				}
				while($personnes[$j-1]["PrenomPersonne"] == $personnes[$j]["PrenomPersonne"] and $personnes[$j-1]["NomPersonne"] == $personnes[$j]["NomPersonne"]);
					
			}
  
		}
		else{
  
			echo "<tr>\n";
			echo "<td class=\"epci_titre\">Commune/Collectivité</td>\r";
			echo "</tr>\n";
	
			foreach($personnes as $epci){
	
				if ($color=="rgba(24,100,153,0.2)"){ $color="#FFFFFF"; }else{ $color="rgba(24,100,153,0.2)"; }
	
				echo "<tr>\r";
				echo "<td class=\"epci_result\" style=\"text-align:left;border:0px;background-color:".$color.";\">\r";
				echo "<a href=\"annuaire.php?username=".$_GET['username']."&amp;IdComEpci=".$epci['IdComEpci']."\">".$epci['nomComEPCI']." </a>";
				echo "</td>\r";
	
	
				echo "</tr>\r";
			}
  
        }
  
	}
	echo "</table>\r";

	echo "</div>\r";

}
?>
