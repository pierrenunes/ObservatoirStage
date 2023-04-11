

<script type="text/javascript">
	function changeresult(num){
		if(document.getElementById('result'+num).style.display=='block'){
			document.getElementById('result'+num).style.display='none';
			document.getElementById('plusmoins'+num).src='images/plus.svg';
		}
		else{
			document.getElementById('result'+num).style.display='block';
			document.getElementById('plusmoins'+num).src='images/moins.svg';
		}
	}
</script>

<?php

$sous_type=stripslashes($sous_type);

$req="select comcarto from decoupagecommune where codedecoup=\"".$codedecoup."\"";
//echo $req;
$getDatacomcartos = $connexion->prepare($req);
$getDatacomcartos->execute();
$Comcartos = $getDatacomcartos->fetchAll(\PDO::FETCH_ASSOC);

foreach( $Comcartos as $Comcarto){
	$champs_where.=$or."comcarto=\"".$Comcarto["comcarto"]."\"";
	$or=" or ";
}


/*-- Archive 19/03/2015 pour affichage nouveaux cantons ---
$req="select codedecoupgene,intituledecoupage from decoupagegeneral where codedecoupgene='CANTONS' OR  codedecoupgene='Arr' OR  codedecoupgene='LEGISLAT' OR  codedecoupgene like 'Bas_%' ";
*/
$req="select codedecoupgene,intituledecoupage from decoupagegeneral where codedecoupgene='CAN2014' OR  codedecoupgene='Arr' OR  codedecoupgene='LEGISLAT' OR  codedecoupgene like 'Bas_%' ";
$getDataresult = $connexion->prepare($req);
$getDataresult->execute();
$results = $getDataresult->fetchAll(\PDO::FETCH_ASSOC);

$i=0;
$h=0;
foreach( $results as $result){
	
  	$tabint[$h]=$result['intituledecoupage'];
  	$req2="select codedecoup from decoupage where codedecoupgeneobs!='INTERCO' AND codedecoupgene=\"".$result["codedecoupgene"]."\" and codedecoup!=\"".$codedecoup."\"  order by sous_type";
  	$getDataresult2 = $connexion->prepare($req2);
	$getDataresult2->execute();
	$results2 = $getDataresult2->fetchAll(\PDO::FETCH_ASSOC);

	foreach( $results2 as $result2){
		$req3="select codedecoup from decoupagecommune where ($champs_where) and codedecoup like '".$result2["codedecoup"]."'";
		$getDataresult3 = $connexion->prepare($req3);
		$getDataresult3->execute();
		$results3 = $getDataresult3->fetchAll(\PDO::FETCH_ASSOC);
		$result3 = $results3[0];

		if ($result3["codedecoup"]!="") $tab[$h][$i]=$result3["codedecoup"];
		$i++;
	}
  $h++;
}

echo "<TABLE>\r";

if($tab!=''){


  $h=0;
  foreach ($tabint as $elem2){
    if($tab[$h]!=''){
      echo "<TR>\r";
      echo "<TD colspan=\"2\" class=\"fiche_titre_onglet4\" style=\"text-align:left; cursor:pointer;\" onclick=\"changeresult(".$h.");\" >\r";
      echo "<b><img style=\"cursor:pointer;\" src=\"images/plus.svg\" id=\"plusmoins".$h."\" alt=\"\" /> ".$elem2."</b>\r";
	
      $codeGene=$result["codedecoupgeneobs"];
      echo "</TD>\r";
	  echo "</TR>\r";
	  
      echo "<TR>\r";
      //echo "<TD colspan=\"2\" id=\"result".$h."\" style=\"display:none;\" >\r";
      echo "<TD colspan=\"2\" id=\"result".$h."\" style=\"display:none;\" >\r";
	  echo "<TABLE class=\"fiche onglet4\" >\r";
      $flag=0;
      foreach ($tab[$h] as $elem){
        $req="select * from decoupage where codedecoup=\"".$elem."\" order by sous_type";
		
		$getDataresult = $connexion->prepare($req);
		$getDataresult->execute();
		$results = $getDataresult->fetchAll(\PDO::FETCH_ASSOC);
		$result = $results[0];
        
        echo "<TR>\r";
        if ($syndic_old!=$result["sous_type"] or $flag==0){
			
			$reqCarte="select * from DecoupageCartes where CodeDecoupGene='".$result["codedecoupgeneobs"]."';";

			$getDataCarte = $connexion->prepare($reqCarte);
			$getDataCarte->execute();
			$ResultCarte = $getDataCarte->fetchAll(\PDO::FETCH_ASSOC);
			$carte = $ResultCarte[0];

			echo "<TD class=\"ligne_result_gauche\" >";
			if(!empty($carte)){
				echo "<a href=\"".$carte['LienRep'].$carte['Fichier']."\" target=\"_blank\" title=\"Voir la carte\" ><img class=\"imgPDFautreDecoupe\" border=\"0\" height=\"20\" align=\"absmiddle\" src=\"images/pdf.png\" alt=\"\" />".$result["sous_type"]."</a>\r";  
			}
			else if($result["sous_type"]){
				echo "<b>".$result["sous_type"]." ";
			}
			echo "</b>\r";
			}
			else{
				echo "<TD style=\"width:60%\" class=\"ligne_result\" style=\"border:none; \">";
			}
			echo "</td>\r";
		
        //SAMUEL LIGNE AVEC LIEN BASODET
        //echo "<TD style=\"width:40%\" class=\"ligne_result\"><a target=\"_blank\"href=\"http://www.pilote41.fr/index.php?option=com_iframe&view=iframe&Itemid=267&basodet=1&num_theme=".$_GET['num_theme']."&IdComEpci=".$_GET['IdComEpci']."&type_info=territoire&depuis=v3&decoup=".$result["decoup"]."&codedecoup=".$result["codedecoup"]."&territoire=".$result["codedecoupgene"]."&sous_type=".addslashes($result["sous_type"])."\" >".$result["intituledecoupage"]."</a></TD>\r";
        echo "<TD class=\"ligne_result_droite\" >".$result["intituledecoupage"]."</TD>\r";
        
        echo "</TR>\r";
        $syndic_old=$result["sous_type"];        
        $flag=1;
      }
      echo "</TABLE>\r";
      echo "</TD>\r";
      echo "</TR>\r";
    }
    $h++;
  }


}
else{
	echo "<TR>\r";
	echo "<TD colspan=\"\" class=\"niv_4_partie_corps\">Aucun résultat.</TD>\r";
 	echo "</TR>\r";
}
echo "</table>\r";



?>
