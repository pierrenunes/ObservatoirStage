<script src="jquery.js"></script>
<script>
	function popup(nb){

		if(nb==1){
			$('#liensIdent').show();
			$('#liensElus').hide();
		} 
		else if(nb==2){
			$('#liensIdent').hide();
			$('#liensElus').show();
		}
		$('#Affichepopup').show();
			
		}
	function popuphide(){
		$('#Affichepopup').hide();
	}
</script>

<div id="Affichepopup" >
	<span class="helper"></span>
	<div>
		<a onclick="popuphide()" class="popupCloseButton lien">X</a>
		<h2>Choisissez un type de fichier</h2>
		<div id="liensIdent">
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=csv&export=ident"?>"  id="lienCSV" ><img   src="images/csv.png"    width=80 /></a>
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=json&export=ident"?>" id="lienJSON" ><img  src="images/json.png"   width=80 /></a>
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=xml&export=ident"?>"  id="lienXML" ><img   src="images/xml.png"    width=80 /></a>
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=xls&export=ident"?>"  id="lienXLS" ><img   src="images/xls.png"    width=80 /></a>
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=html&export=ident"?>"  id="lienHTML" ><img   src="images/html.png" width=80 /></a>
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=txt&export=ident"?>"  id="lienTXT" ><img   src="images/txt.png"    width=80 /></a>
		</div>
		<div id="liensElus">
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=csv&export=elus"?>"  id="lienCSV" ><img   src="images/csv.png"     width=80 /></a>
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=json&export=elus"?>" id="lienJSON" ><img  src="images/json.png"    width=80 /></a>
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=xml&export=elus"?>"  id="lienXML" ><img   src="images/xml.png"     width=80 /></a>
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=xls&export=elus"?>"  id="lienXLS" ><img   src="images/xls.png"     width=80 /></a>
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=html&export=elus"?>"  id="lienHTML" ><img   src="images/html.png"  width=80 /></a>
			<a target="_blank" class="lien" href="<?="export.php?IdComEpci=".$_GET['IdComEpci']."&amp;codedecoup=".$codedecoup."&amp;type=txt&export=elus"?>"  id="lienTXT" ><img   src="images/txt.png"     width=80 /></a>
		</div>
		<a href="https://icones8.fr/" target="_blank" style="color:#ececec;float: left;font-size: xx-small;padding-top: 20px;">Icons</a>
    </div>
</div>



<table>
	<tr><td class="fiche_titre">Données source</td></tr>

	<tr><td class="ligne_result">
		<a onclick='popup(1);'>Fiche d'identité de la commune / Fiche d'identité du territoire et de ses communes</a>
	</td></tr>

	<tr><td class="ligne_result">
		<a onclick='popup(2);'>Elus et personnel de la commune / Elus et personnel du territoire et de ses communes</a>
	</td></tr>
	
	<?php
	/*Ne Fonctionne pas BDD CG41SubventionsCom n'existe plus
	/*

	echo "<tr><td class=\"ligne_result\">\r";
	if(substr($_GET['IdComEpci'], 0, 3)=='COM'){
	  	echo "<a href=\"javascript:popup(3);\" >Les subventions du Conseil Général de Loir-et-Cher à la commune</a>";  
	}
	else{
	 	echo "<a href=\"javascript:popup(3);\" >Les subventions du Conseil Général de Loir-et-Cher aux communes du territoire</a>";  
	}
	*/

	/* Ne Fonctionne pas BDD CG41SubventionsComCom n'existe plus*/

	/*

	if(trim($annuaire['TypeComEPCI'])=="A1" or trim($annuaire['TypeComEPCI'])=="A2"){
	  	echo "<tr><td class=\"ligne_result\">\r";
	  	echo "<a href=\"javascript:popup(4);\" >Les subventions du Conseil Général de Loir-et-Cher à la communauté</a>";
	  	echo "</td></tr>";
	}

	*/
	?>

	
</table>
