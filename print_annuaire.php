<?php
session_start();

require("../v2/variables.php");

include('fonctions.php');

$db = mysql_connect("localhost", "pilote41v3", "K5bvLXRdH5WB26jw") or die("erreur de connexion au serveur $host");
$dbjoomla = mysql_select_db("pilote41v3",$db) or die ("Base de données introuvable");
$sql = "SELECT nom_groupe from jos_gm_groupe a,jos_gm_membre b , jos_users c  where c.username='".$_GET['username']."' and c.id=b.id_membre and b.id_groupe=a.id_groupe and a.nom_groupe like 'Elu%'";
$res = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($res)){
  $num=substr($data['nom_groupe'],1,2)*1;
  $groupeelu = $groupeelu.$num.",";
}
$groupeelu=rtrim($groupeelu,',');



$connexion=mysql_connect("localhost",$user_mysql,$password_mysql) or die("erreur de connexion au serveur $host") ;
$bdd=mysql_select_db($bdd_basodet,$connexion) or die ("Base de données introuvable");

ob_start();

echo "<style type=\"text/css\" >";



echo "h1{position:relative; float:left; width:95%; height:auto; color:#436B18; font-size:30px; font-weight:400; font-style:oblique; padding:7px 0px 0px 0px; margin:0px 0px 10px 0px;}";
echo "#logo{position:relative; float:left; width:300px; height:auto; text-align:right;}";
echo ".h2{position:relative; float:left; width:70%; height:auto; color:#FFFFFF; background:#436b18; font-size:25px; padding:6px 0px 6px 10px; margin:0px 0px 10px 0px; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px;}";




 

echo "#annuaire_epci_coord{border:solid 1px #5d7f37; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; padding:6px 0px;}";
//echo "#annuaire_epci_coord td{color:#436B13; font-weight:bold; font-size:0.8em;}";



echo ".fiche{border:solid 1px #f1af01;}";
echo ".fiche_titre{text-align:left; background-color:#f1af01; font-weight:bold; font-size:0.8em;  padding:5px 4px;color:#000000;}";
echo ".fiche_sstitre{text-align:left; background-color:#f1af01; font-weight:normal; font-size:0.75em;  padding:5px 4px;color:#000000;}";
echo ".fiche_libelle{font-weight:bold; font-size:0.75em; color:#000000; text-align:left; vertical-align:middle;}";

echo ".fiche_texte{font-size:0.75em; color:#000000; text-align:left;padding:5px;vertical-align:middle;}";

echo ".ligne_result{font-size:0.75em; color:#000000; text-align:left;padding:5px; border-bottom:solid 1px #f1af01;}";

echo ".ligne_result_titre{font-size:0.8em; color:#000000; font-weight:bold; text-align:left;padding:5px; border-bottom:solid 1px #f1af01;}";



echo "</style>";


  $req_annuaire="select * from annuaire where IdComEpci='".$_GET['IdComEpci']."';";
  $query_annuaire=mysql_query($req_annuaire);
  $annuaire=mysql_fetch_array($query_annuaire);

  if($annuaire['AliasCodeDecoup']!=''){
    $codedecoup=$annuaire['AliasCodeDecoup'];
  }else{
    $codedecoup=$_GET['IdComEpci'];  
  }

  echo "<page backtop=\"3%\" backbottom=\"3%\" backleft=\"3%\" backright=\"3%\" style=\"height:auto;\">";

  echo "<h1>Annuaire des élus et des territoires";
  
  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <img src=\"https://www.pilote41.fr/images/stories/Pilote41/Partenaires/asso_maire.jpg\" height=\"45px;\" hspace=\"6\" alt=\"\" />";
  echo "<img src=\"https://www.pilote41.fr/images/stories/Pilote41/Partenaires/loir-et-cher_41_logo_2015.png\" height=\"45px;\" hspace=\"6\" alt=\"\" />";
  echo "<img src=\"https://www.pilote41.fr/images/template/footer/LogoOET.png\" height=\"45px;\" hspace=\"6\" alt=\"\" />";
  echo "</h1>";

  echo "<table width=\"450px\" cellpadding=\"20\">";
  echo "<tr><td class=\"h2\" style=\"width:450px;\">".utf8_encode($annuaire['nomComEPCI'])."</td></tr>";
  echo "</table>";


  if($_GET['IdComEpci']!="DepSen"){
    echo "<br /><br /><table align=\"center\" style=\"width:100%;\">";
    echo "<tr>";
    echo "<td style=\"vertical-align:top; width:70%;\" >";   
  
  
    echo "<table id=\"annuaire_epci_coord\" style=\"width:100%\" align=\"center\" >";
  
    echo "<tr>";
    echo "<td class=\"top\" style=\"width:1%\">&nbsp;</td>";
    echo "<td class=\"top\" style=\"width:49%\">";
    echo utf8_encode($annuaire['Adresse'])."<br />";
    echo utf8_encode($annuaire['Codepostal'])." ";
    echo utf8_encode($annuaire['COMMUNE'])." ";
    echo utf8_encode($annuaire['Cedex']);
    echo "</td>";
    echo "<td class=\"top\" style=\"width:1%\">&nbsp;</td>";
    echo "<td class=\"top\" style=\"width:49%\">";
    if($annuaire['Tel']!='') echo "Tél. ".tel($annuaire['Tel'])."<br />";
    if($annuaire['Fax']!='') echo "Fax. ".tel($annuaire['Fax'])."<br />";
    if($annuaire['Email']!='') echo "E-mail : ".$annuaire['Email']."<br />";
    if($annuaire['SiteWeb']!='') echo "Site web : ".$annuaire['SiteWeb'];
    echo "</td>";
    echo "<td class=\"top\" style=\"width:1%\">&nbsp;</td>";
    echo "</tr>";
    
    echo "</table>";
  
  
    echo "</td>";
  
  
    echo "<td style=\"vertical-align:top; width:30%;\" >&nbsp;";
  
    if($annuaire['Photo1']!='' and file_exists("Photos/".$annuaire['Photo1'])) echo "<img src=\"Photos/".$annuaire['Photo1']."\" alt=\"\" hspace=\"20\" height=\"100px\" />";
    if($annuaire['Photo2']!='' and file_exists("Photos/".$annuaire['Photo2'])) echo "<img src=\"Photos/".$annuaire['Photo2']."\" alt=\"\" height=\"100px\" />";
   
    echo "</td>";
  
    echo "</tr>";
    echo "</table>";
  }

  echo "<table align=\"center\" style=\"width:100%;\">";

  echo "<tr>";
  echo "<td style=\"width:60%;\"></td>";
  echo "<td style=\"width:40%;\"></td>";  
  echo "</tr>";

 
  echo "<tr>";
  echo "<td style=\"vertical-align:top; width:60%;\" >";    

  $req_maire="select ap.* from  annuairepers ap, annuairefonctions af 
  where ap.FinFonction is null and ap.Fonction=af.Fonction and ap.NoComEPCI='".$_GET['IdComEpci']."' and af.FonctionType='EluAdmin' order by NomPersonne;";
  $query_maire=mysql_query($req_maire) or die(mysql_error());
  if(mysql_num_rows($query_maire)>0){
    echo "<br /><br /><table style=\"width:95%;\" class=\"fiche\">";
    $maire=mysql_fetch_array($query_maire);
    echo "<tr><td colspan=\"2\" class=\"fiche_titre\">".utf8_encode($maire['Fonction'])."</td></tr>";

    $nb=1;
    if($groupeelu=='0'){
      if($maire['TelPerso']!='') $nb++;
      if($maire['MailPerso']!='') $nb++;
      if($maire['Profession']!='') $nb++;
    }
    
    echo "<tr>";
    echo "<td style=\"width:80%;\" class=\"fiche_texte\">";
    echo utf8_encode($maire['Civilite']." ".$maire['PrenomPersonne']." ".$maire['NomPersonne']);
    echo "</td>";
    echo "<td class=\"fiche_texte\" style=\"width:20%;\" rowspan=\"".$nb."\" >";
    if($maire['Photo']!='' and file_exists("Photos/".$maire['Photo'])) echo "<img src=\"Photos/".$maire['Photo']."\" alt=\"\" style=\"width:40px;\" />";
    echo "</td>";
    echo "</tr>";

    if($groupeelu=='0'){
      if($maire['TelPerso']!=''){
        echo "<tr>";
        echo "<td colspan=\"2\" class=\"fiche_libelle\">Téléphone personnel : ".tel($maire['TelPerso']);
        echo "</td>";
        echo "</tr>";
      }

      if($maire['MailPerso']!=''){
        echo "<tr>";
        echo "<td colspan=\"2\"  class=\"fiche_libelle\">E-mail personnel : ".$maire['MailPerso']."</td>";
        echo "</tr>";
      }

      if($maire['Profession']!=''){
        echo "<tr>";
        echo "<td class=\"fiche_libelle\" colspan=\"2\" >Profession : ".utf8_encode($maire['Profession'])."</td>";
        echo "</tr>";
      }
    }

    echo "</table><br />";
  }



  $req_secr="select ap.*, af.FonctionGpe from  annuairepers ap, annuairefonctions af 
  where ap.FinFonction is null and ap.Fonction=af.Fonction and ap.NoComEPCI='".$_GET['IdComEpci']."' and af.FonctionType='Admin'   
  order by af.OrdreFonction, NomPersonne;";
  $query_secr=mysql_query($req_secr) or die(mysql_error());
  if(mysql_num_rows($query_secr)>0){
    echo "<table style=\"width:95%;\" class=\"fiche\">";
    $secr=mysql_fetch_array($query_secr);
  
    echo "<tr><td colspan=\"2\" class=\"fiche_titre\">".utf8_encode($secr['FonctionGpe'])."</td></tr>";
    
    echo "<tr>";
    //echo "<td style=\"width:30%;\" class=\"fiche_libelle\">".$secr['Fonction']." : </td>";
    echo "<td style=\"width:80%;\" class=\"fiche_texte\">";
    echo utf8_encode($secr['Civilite']." ".$secr['PrenomPersonne']." ".$secr['NomPersonne']);
    echo "</td>";
    echo "<td style=\"width:20%;\" class=\"fiche_texte\">";
    if($secr['Photo']!='' and file_exists("Photos/".$secr['Photo'])) echo "<img src=\"Photos/".$secr['Photo']."\" alt=\"\" style=\"width:40px;\" />";
    echo "</td>";
    echo "</tr>";

    echo "</table>";
  }



  echo "</td>";
  
  echo "<td style=\"vertical-align:top; width:40%;\" >";
  
  if($annuaire['Horaires']!=''){
    echo "<br /><br /><table style=\"width:100%;\" class=\"fiche\">";
  
    echo "<tr><td class=\"fiche_titre\" style=\"width:100%;\">Horaires d'ouverture au public</td></tr>";
    
    echo "<tr><td class=\"fiche_texte\">".utf8_encode(nl2br($annuaire['Horaires']))."</td></tr>";


    echo "</table><br />";
  }
  
  $requete="select * from decoupagecommune where codedecoup like '".$codedecoup."'";
  //echo $requete;
  $query=mysql_query($requete) or die ("Requete invalide Decoupage Commune");
  $champs_where="";
  $or='';
  while ($codecommune=mysql_fetch_array($query)){
    $comcarto=$codecommune["comcarto"];
    $champs_where.=$or." comcarto='$comcarto' ";
    $or="or";
  }
  
  
  if($_GET['IdComEpci']!="DepSen" and $_GET['IdComEpci']!="CR"){
    $requete="select annee,sum(ptot) as ptot from population where (".$champs_where.") group by annee ORDER BY annee DESC limit 0,1";
    $query_pop=mysql_query($requete) ;//or die ("Requete invalide Comcarto");
  
    echo "<br /><table style=\"width:100%;\" class=\"fiche\">";
  
    echo "<tr><td class=\"fiche_titre\" style=\"width:100%;\">Population / Statistiques</td></tr>";
    echo "<tr><td class=\"fiche_texte\">";
  
    if(mysql_num_rows($query_pop)>0){
      $pop=mysql_fetch_array($query_pop);      
      echo number_format($pop['ptot'], 0, '.', ' ')." habitants (".$pop['annee'].") <br />";
    }
    if(substr($_GET['IdComEpci'], 0,3)=='COM') echo "Code INSEE : ".substr($_GET['IdComEpci'],3)."<br />";
    if($annuaire['NoSiren']!='') echo "Siren : ".$annuaire['NoSiren']."<br />";
    
    if($annuaire['AutreInfo']!='') echo "Nom des habitants : ".utf8_encode(ucfirst($annuaire['AutreInfo']));
  
    echo "</td></tr>\r";
  
    echo "</table>";
  }  

  echo "</td>";
  echo "</tr>";

  echo "</table>";




 
  $req_fonc="select distinct af.FonctionGpe from  annuairepers ap, annuairefonctions af 
  where ap.FinFonction is null and ap.Fonction=af.Fonction and ap.NoComEPCI='".$_GET['IdComEpci']."' and af.FonctionType!='Admin' 
  order by af.OrdreFonction;";
  $query_fonc=mysql_query($req_fonc) or die(mysql_error());
  if(mysql_num_rows($query_fonc)>0){
    echo "<br /><br /><table align=\"center\" cellspacing=\"0\" style=\"width:100%;\">";
    while($fonc=mysql_fetch_array($query_fonc)){

      if(substr($_GET['IdComEpci'], 0, 3)!='COM'){ $colspan="4"; }else{ $colspan="3"; }


      echo "<tr><td colspan=\"".$colspan."\" class=\"fiche_titre\" style=\"width:100%;\" >&nbsp;".utf8_encode($fonc['FonctionGpe'])."</td></tr>";
      //echo "<tr><td class=\"fiche_titre\" style=\"width:100%;\" >&nbsp;".$fonc['FonctionGpe']."</td></tr>";
    
      $req_adjoint="select ap.* from annuairepers ap, annuairefonctions af 
      where ap.FinFonction is null and ap.NoComEPCI='".$_GET['IdComEpci']."' and af.FonctionGpe='".$fonc['FonctionGpe']."' and ap.Fonction=af.Fonction and af.FonctionType!='Admin' ";
      if(trim($fonc['FonctionGpe'])=="Délégués communautaires" ){
        $req_adjoint.="order by ap.CommunePersonne asc, ap.OrdreFonction asc, ap.NomPersonne asc, ap.PrenomPersonne asc;";
      }else{
        $req_adjoint.="order by ap.OrdreFonction asc, ap.CommunePersonne asc, ap.NomPersonne asc, ap.PrenomPersonne asc;";
      }
      
      $query_adjoint=mysql_query($req_adjoint) or die(mysql_error());
      while($adjoint=mysql_fetch_array($query_adjoint)){

        echo "<tr>";
        echo "<td class=\"ligne_result\" style=\"width:30%\" >&nbsp;".utf8_encode($adjoint['Civilite']." ".$adjoint['PrenomPersonne']." ".$adjoint['NomPersonne'])."</td>";

        echo "<td class=\"ligne_result\" style=\"width:30%\" >&nbsp;".utf8_encode($adjoint['LibOrdreFonction'])."</td>";
        if(substr($_GET['IdComEpci'], 0, 3)!='COM'){
          echo "<td nowrap class=\"ligne_result\">&nbsp;".utf8_encode($adjoint['CommunePersonne'])."</td>";
        }
        echo "<td class=\"ligne_result\" style=\"width:10%\" >&nbsp;";
        if($adjoint['Photo']!='' and file_exists("Photos/".$adjoint['Photo'])) echo "<img src=\"Photos/".$adjoint['Photo']."\" alt=\"\" style=\"height:40px;\" />";
        echo "</td>";

        echo "</tr>";


      }


    }
    echo "</table>";
  }







echo "</page>";

$content = ob_get_clean();

require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');

try
{
  $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 3);
  $html2pdf->pdf->SetDisplayMode('fullpage');
  $html2pdf->setDefaultFont('helvetica');
  $html2pdf->WriteHTML($content, false);
  $html2pdf->Output('extraction.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}




?>