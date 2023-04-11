<?php



/***************************
 *
 * FONCTIONS INTERCO
 *
 **************************/   


function bloc($codeEpci, $type, $sstype, $titre){

	require("../variables.php"); 

  if($type=='A'){
    if($sstype=='a'){
      $req_bloc="SELECT A.*, I.LibEPCI, I.OrdreTypeSynd FROM intercoadhecommunes A, interco I WHERE A.CodeEPCI = I.CodeEPCI and I.OrdreTypeSynd like 'A%' and COMCARTO='".str_replace('COM', '', $codeEpci)."';";
    }elseif($sstype=='m'){
      $req_bloc="SELECT A.*, C.nom, I.LibEPCI, I.OrdreTypeSynd FROM intercoadhecommunes A, interco I, communes C WHERE A.CodeEPCI = I.CodeEPCI and A.COMCARTO=C.COMCARTO and I.OrdreTypeSynd like 'A%' and A.CodeEPCI='".$codeEpci."';";  
    }
  }
  if($type=='B'){
    if($sstype=='a'){
      $req_bloc="SELECT A.*, I.LibEPCI, I.OrdreTypeSynd FROM intercoadhecommunes A, interco I WHERE A.CodeEPCI = I.CodeEPCI and I.OrdreTypeSynd = 'B0' and COMCARTO='".str_replace('COM', '', $codeEpci)."';";
    }elseif($sstype=='m'){
      $req_bloc="SELECT A.*, C.nom, I.LibEPCI, I.OrdreTypeSynd FROM intercoadhecommunes A, interco I, communes C WHERE A.CodeEPCI = I.CodeEPCI and A.COMCARTO=C.COMCARTO and I.OrdreTypeSynd = 'B0' and A.CodeEPCI='".$codeEpci."';";  
    }
  }
  if($type=='C'){
    if($sstype=='a'){
      $req_bloc="SELECT A.*, I.LibEPCI, I.OrdreTypeSynd FROM intercoadhecommunes A, interco I WHERE A.CodeEPCI = I.CodeEPCI and I.OrdreTypeSynd like 'C%' and COMCARTO='".str_replace('COM', '', $codeEpci)."';";
    }elseif($sstype=='m'){
      $req_bloc="SELECT A.*, C.nom, I.LibEPCI, I.OrdreTypeSynd FROM intercoadhecommunes A, interco I, communes C WHERE A.CodeEPCI = I.CodeEPCI and A.COMCARTO=C.COMCARTO and I.OrdreTypeSynd like 'C%' and A.CodeEPCI='".$codeEpci."';";  
    }
  }
  if($type=='D'){
    if($sstype=='a'){
      $req_bloc="SELECT A.*, I.LibEPCI, I.OrdreTypeSynd FROM intercoadheepci A, interco I WHERE A.CodeEPCI = I.CodeEPCI and I.OrdreTypeSynd='B0' and A.CodeEPCIAdhe ='".str_replace('COM', '', $codeEpci)."';";
    }elseif($sstype=='m'){
      $req_bloc="SELECT A.*, I.LibEPCI, I.OrdreTypeSynd FROM intercoadheepci A, interco I WHERE A.CodeEPCIAdhe = I.CodeEPCI and I.OrdreTypeSynd like 'A%' and A.CodeEPCI ='".$codeEpci."';";  
    }
  }
  if($type=='E'){
    if($sstype=='a'){
      $req_bloc="SELECT A.*, I.LibEPCI, I.OrdreTypeSynd FROM intercoadheepci A, interco I WHERE A.CodeEPCI = I.CodeEPCI and I.OrdreTypeSynd like 'C%' and A.CodeEPCIAdhe ='".str_replace('COM', '', $codeEpci)."';";
    }elseif($sstype=='m'){
      $req_bloc="SELECT A.*, I.LibEPCI, I.OrdreTypeSynd FROM intercoadheepci A, interco I WHERE A.CodeEPCIAdhe = I.CodeEPCI and I.OrdreTypeSynd like 'A%' and A.CodeEPCI ='".$codeEpci."';";  
    }
  }
  if($type=='F'){
    if($sstype=='a'){
      $req_bloc="SELECT A.*, I.LibEPCI, I.OrdreTypeSynd FROM intercoadheepci A, interco I WHERE A.CodeEPCI = I.CodeEPCI and I.OrdreTypeSynd like 'C%' and A.CodeEPCIAdhe ='".str_replace('COM', '', $codeEpci)."';";
    }elseif($sstype=='m'){
      $req_bloc="SELECT A.*, I.LibEPCI, I.OrdreTypeSynd FROM intercoadheepci A, interco I WHERE A.CodeEPCIAdhe = I.CodeEPCI and I.OrdreTypeSynd like 'C%' and A.CodeEPCI ='".$codeEpci."';";  
    }
  }
  if($type=='G'){
    if($sstype=='m'){
      $req_bloc="SELECT * FROM intercoadheinstitution WHERE CodeEPCI ='".str_replace('COM', '', $codeEpci)."';";
    }
  }
	  
	$RequeteBloc = $connexion->prepare($req_bloc);
	$RequeteBloc->execute();
	$bloc = $RequeteBloc->fetchAll(\PDO::FETCH_ASSOC);


  	if(!empty($bloc)){
    
    if($titre!=''){
      echo $titre;
      $titre='';
    }
    
  
  
  if( ($type=='B' and $sstype=='m') or ($type=='C' and $sstype=='m')  ){
    echo "<tr><td colspan=\"4\" class=\"ligne_result_titre\">Communes</td></tr>\r";
  }
  if( ($type=='E' and $sstype=='a') or ($type=='F' and $sstype=='m') ){
    echo "<tr><td colspan=\"4\" class=\"ligne_result_titre\">Autres syndicats</td></tr>\r";
  }
  if( ($type=='E' and $sstype=='m') or ($type=='D' and $sstype=='m') ){
    echo "<tr><td colspan=\"4\" class=\"ligne_result_titre\">Communauté de communes ou d'agglomération</td></tr>\r";
  }  

  if( ($type=='G' and $sstype=='m') ){
    echo "<tr><td colspan=\"4\" class=\"ligne_result_titre\">Autres membres</td></tr>\r";
  }  
  

    $oldEPCI='';
	$color = "rgba(24,100,153,0.1)";
	$i = 0;
    while($i < sizeof($bloc)){
      	if($type=='G'){
			echo "<tr style=\"background-color:".$color.";\">\r";
        	echo "<td colspan=\"4\" class=\"ligne_result\">".$bloc[$i]['nomInstitution']."</td>\r";
	  	}
		else{
			if($type=='D' and $sstype=='m'){
				$lib=$bloc[$i]['LibEPCI'];
				$id=$bloc[$i]['CodeEPCIAdhe'];        
			}
			elseif($type=='E' and $sstype=='m'){
				$lib=$bloc[$i]['LibEPCI'];
				$id=$bloc[$i]['CodeEPCI'];        
			}
			elseif($bloc[$i]['nom']!=''){
				$lib=$bloc[$i]['nom'];
				$id="COM".$bloc[$i]['COMCARTO'];
			}
			else{
				$lib=$bloc[$i]['LibEPCI'];
				$id=$bloc[$i]['CodeEPCI'];        
			}
      
        if( $bloc[$i]['LibEPCI'] == $bloc[$i+1]['LibEPCI'] and $bloc[$i]['nom'] == $bloc[$i+1]['nom']){
			echo "<tr style=\"background-color:".$color.";\">\r";

			echo "<td class=\"ligne_result\" ><a href=\"annuaire.php?username=".$_GET['username']."&amp;IdComEpci=".$id."&amp;src=".$codeEpci."\" >".$lib."</a></td>\r";
			echo "<td class=\"ligne_result_droite_2\">&nbsp;";
				if($bloc[$i]['TypeAdhe']!='') echo $bloc[$i]['TypeAdhe']." ";
				if($bloc[$i]['DateAdh']!='0000-00-00 00:00:00' and $bloc[$i]['DateAdh']!='') echo "(".substr(date_trans_us_fr($bloc[$i]['DateAdh']), 3).")";
			echo "</td>\r";
			$i++;
			echo "<td class=\"ligne_result_droite_2\">&nbsp;</td>\r";
			echo "<td class=\"ligne_result_droite_2\">&nbsp;";
				if($bloc[$i]['TypeAdhe']!='') echo $bloc[$i]['TypeAdhe']." ";
				if($bloc[$i]['DateAdh']!='0000-00-00 00:00:00' and $bloc[$i]['DateAdh']!='') echo "(".substr(date_trans_us_fr($bloc[$i]['DateAdh']), 3).")";
			echo "</td>\r";
		}
		else{
			echo "<tr style=\"background-color:".$color.";\">\r";
			if($bloc[$i]['Dep']!='41'){
				echo "<td class=\"ligne_result\" >".$lib;
				if($bloc[$i]['Dep']!='') echo " (".$bloc[$i]['Dep'].")";
					echo "</td>\r";
			}
			else{
				echo "<td colspan=3 class=\"ligne_result\" ><a href=\"annuaire.php?username=".$_GET['username']."&amp;IdComEpci=".$id."&amp;src=".$codeEpci."\" >".$lib."</a></td>\r";
			}
			echo "<td class=\"ligne_result_droite_2\">&nbsp;";
				if($bloc[$i]['TypeAdhe']!='') echo $bloc[$i]['TypeAdhe']." ";
				if($bloc[$i]['DateAdh']!='0000-00-00 00:00:00' and $bloc[$i]['DateAdh']!='') echo "(".substr(date_trans_us_fr($bloc[$i]['DateAdh']), 3).")";
			echo "</td>\r";
			echo "</tr>\r";
                
		}
		if ($color=="rgba(24,100,153,0.1)"){ $color="#FFFFFF"; }else{ $color="rgba(24,100,153,0.1)"; }
      }  
	  $i++;
    }
  }
  return $titre;
}






/***************************
 *
 * FONCTIONS GENERIQUES
 *
 **************************/   

function mise_majuscules($texte){
  $texte = strtr($texte, "��������������������������������","�����������������������������Ɗ��");
  $texte = strtoupper($texte); 
  return $texte; 
}

function tel($num){
  $output='';
  for($i = 0, $len = strlen($num); $i < $len; $i++) {
		if($i % 2 == 0) $output .= " ";
		$output .= $num[$i];
	}
  return $output;
}


function date_trans_us_fr($date_us, $heure=0){

  $date=explode(" ", $date_us);
  $dates=explode("-", $date[0]);
  $date_fr=$dates[2]."/".$dates[1]."/".$dates[0];
  if($heure==1){
  $date_fr.=" ".$date[1];
  }

  return $date_fr;
}



function date_trans_fr_us($date_fr, $heure=0){

  $date=explode(" ", $date_fr);
  $dates=explode("/", $date[0]);
  $date_us=$dates[2]."-".$dates[1]."-".$dates[0];
  if($heure==1){
    $date_us.=" ".$date[1];
  }

  return $date_us;
}



?>
