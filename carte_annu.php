<?php
/*
// --------------- CARTE_ANNU.PHP sous http://www.pilote41.fr/ --> pour l'anuaire des mairies et EPCI
session_start();
include('variables.php');
$connexion=@mysql_connect("localhost",$user_pilote41,$pwd_pilote41);
mysql_select_db($bdd_pilote41);

*/


if($_GET['IdComEpci']!=''){
	//echo $_GET['EPLSid'];
    //$rep = "select id_cartes from cartes where id_entre = '".$_GET['IdComEpci']."';";
	$rep = "Select * from annuaire where  IdComEpci = '".$_GET['IdComEpci']."' and 'Xprecis' IS NOT NULL";
	
	
  //echo $rep;
  $num_carte = mysql_query($rep);
  if(mysql_num_rows($num_carte)>0){
  //echo $num_carte;
?>


  <script type="text/javascript">
  var divIdMarker=null;var fragment=null;var span=null;var texte=null;var old=null;var nomDCP = null;
  			function toolTips(color) {				
  				//Position du marker
  				posLeft = this.feature.marker.icon.imageDiv.style.left;
  					postop = this.feature.marker.icon.imageDiv.style.top;	
  						//Nom du marker						
  							name = this.feature.id;						
  								divIdMarker = document.getElementById(this.feature.marker.icon.imageDiv.id);	
  									divIdMarkerH = document.getElementById(this.feature.marker.icon.imageDiv.width);	
  										fragment = document.createDocumentFragment();
  											span = document.createElement("div");
  													//creation de l'id et de la class
  													span.setAttribute("Class", "toolTips");
  												span.setAttribute("id", "toolTips_");
  											// taille du div
  											widthDiv = name.length;
  										widthDiv = widthDiv*8;	
  									// Creation du node text			
  									texte = document.createTextNode(name);
  								//Insertion dans le DOM				
  								span.appendChild(texte);
  							fragment.appendChild(span);
  						divIdMarker.appendChild(fragment);
  						
  					divtoolTips = document.getElementById("toolTips_");
  						divtoolTips.style.width = widthDiv+"px";					
  							divtoolTips.style.display="block";	
  								divtoolTips.style.position="relative";	
  									divtoolTips.style.top="-35px";
  										divtoolTips.style.left="25px";
  										divtoolTips.style.backgroundColor= this.bgColor;
  									divtoolTips.style.filter="alpha(opacity="+this.opacity*100+")";												
  								divtoolTips.style.opacity=this.opacity;
  							divtoolTips.style.color= this.fontColor;
  						divtoolTips.style.paddingLeft="5px";
  					divtoolTips.style.paddingRight="5px";				
  			}					
  			function eraseToolTips() {						
  						old = document.getElementById("toolTips_");						
  						divIdMarker.removeChild(old);						
  			}
  </script>



<?
// Changement de la clé API de 8131055876007944676 à 
if(strstr($_SERVER["SERVER_NAME"],'www')){
  echo "<!--basodet.obs--><script src=\"http://api.ign.fr/geoportail/api?v=1.3-e&amp;key=6080680467560370759&amp;instance=VISU&amp;includeEngine=false&amp;\"></script>\r";
}else{
  echo "<!--basodet.obs--><script src=\"http://api.ign.fr/geoportail/api?v=1.3-e&amp;key=6080680467560370759&amp;instance=VISU&amp;includeEngine=false&amp;\"></script>\r";
}
    echo "<!--local<script src=\"http://api.ign.fr/geoportail/api?v=1.3-e&amp;key=791565661027328161&amp;instance=VISU&amp;includeEngine=false&amp;\">--></script>\r";

	echo "<script type=\"text/javascript\" src=\"http://api.ign.fr/geoportail/api/js/1.3/GeoportalExtended.js\" charset=\"utf-8\"></script>\r";
    echo "<script type=\"text/javascript\">\r";
	
    
    echo "function initGeoportalMap(){\r";
  	echo "var displayProjections = [\"IGNF:RGF93G\",\"IGNF:LAMB93\",'IGNF:LAMBE'];\r";
	
  	echo "geoportalLoadVISU(\"GeoportalVisuDiv\",\"normal\",\"FXX\",null, displayProjections, '/geoportail/proxy.php' + '?url=');\r";
  	echo "var tbx= VISU.getMap().getControlsByClass('Geoportal.Control.ToolBox')[0];\r";

  	echo "if (VISU) {\r";
	// -------------- TOUTES LES DONNEES DU GEOPORTAIL
  	//echo "VISU.addGeoportalLayers();\r";

	// -------------- PHOTOGRAPHIES AERIENNES (true=oui  false=non) (exemples d'opacité : 0.8 ou 1.0)
	echo "VISU.addGeoportalLayer('ORTHOIMAGERY.ORTHOPHOTOS', {name:'Photo aérienne', visibility:false, opacity: 0.8});\r";
	// -------------- CARTES IGN (true=oui  false=non) (exemples d'opacité : 0.8 ou 1.0)
  	echo "VISU.addGeoportalLayer('GEOGRAPHICALGRIDSYSTEMS', {visibility:true, opacity:0.6});\r";
	// -------------- ALTITUDE (true=oui  false=non) (exemples d'opacité : 0.8 ou 1.0)
	//echo "VISU.addGeoportalLayer('ELEVATION.SLOPS:WMSC', {visibility:false, opacity: 0.6});\r";
	// -------------- BD PARCELLAIRE (true=oui  false=non) (exemples d'opacité : 0.8 ou 1.0)
  	//echo "VISU.addGeoportalLayer('CADASTRALPARCELS.PARCELS:WMSC', {visibility:false, opacity:0.6});\r";
	// -------------- BATI (true=oui  false=non) (exemples d'opacité : 0.8 ou 1.0)
  	//echo "VISU.addGeoportalLayer('BUILDINGS.BUILDINGS:WMSC', {visibility:true, opacity:1});\r";	
	// -------------- HYDROGRAPHIE (true=oui  false=non) (exemples d'opacité : 0.8 ou 1.0)
	//echo "VISU.addGeoportalLayer('HYDROGRAPHY.HYDROGRAPHY:WMSC', {visibility:false, opacity: 0.6});\r";	
	// -------------- RESEAUX FERRES (true=oui  false=non) (exemples d'opacité : 0.8 ou 1.0)
  	//echo "VISU.addGeoportalLayer('TRANSPORTNETWORKS.RAILWAYS:WMSC', {visibility:true, opacity:1});\r";	
	// -------------- AERODROMES (true=oui  false=non) (exemples d'opacité : 0.8 ou 1.0)
  	//echo "VISU.addGeoportalLayer('TRANSPORTNETWORKS.RUNWAYS:WMSC', {visibility:true, opacity:1});\r";	
	// -------------- ROUTES (true=oui  false=non) (exemples d'opacité : 0.8 ou 1.0)
	//echo "VISU.addGeoportalLayer('TRANSPORTNETWORKS.ROADS:WMSC', {visibility:false, opacity: 0.6});\r";
	// -------------- LIMITES ADMINISTRATIVES (true=oui  false=non) (exemples d'opacité : 0.8 ou 1.0)	
	//echo "VISU.addGeoportalLayer('ADMINISTRATIVEUNITS.BOUNDARIES:WMSC', {visibility:true, opacity: 0.8});\r";
	
	//-----------------------------------------------------------------------
	// onglet "couches" affiché (true=oui  false=non)
				//VISU.setLayersPanelVisibility(true);
	// onglet "couches" développé (true=oui  false=non)
				//VISU.openLayersPanel(true);
	//-----------------------------------------------------------------------
	// onglet "outils" affiché (true=oui  false=non)        
				//VISU.setToolsPanelVisibility(true);
	// onglet "outils" développé (true=oui  false=non)        
				//VISU.openToolsPanel(true);
	//-----------------------------------------------------------------------
	// cache le bandeau inférieur 
				echo "VISU.setInformationPanelVisibility(false);\r";	
  	echo "}\r";

	// add "Print Map"   (08/11/10 - CL)
    echo "var nv= VISU.getMap().getControlsByClass('Geoportal.Control.NavToolbar')[0];\r";
    echo "nv.addControls([new Geoportal.Control.PrintMap()]);\r";

	
  while($donnees_cartes = mysql_fetch_array($num_carte)){

	
   	echo "var proj = new OpenLayers.Projection(\"IGNF:LAMB93\");\r";
      echo "var X=". $donnees_cartes['Xprecis'].";";
      echo "var Y=". $donnees_cartes['Yprecis'].";";
	echo "var ptcentre = new OpenLayers.LonLat(X,Y);\r"; 
    echo "ptcentre.transform(proj, VISU.getMap().getProjection());\r";
    //echo "VISU.getMap().setCenter(ptcentre,".$reponse_cartes['zoom'].");\r";	  

	
  // =>SAMUEL : ZOOM en fonction du Type 16=Commune - 12 pour CC - 10 autres
  if($donnees_cartes['TypeComEPCILib']=="Commune"){
    echo "VISU.getMap().setCenter(ptcentre,16);\r";
  }elseif($donnees_cartes['TypeComEPCILib']=="Communauté de communes ou d'agglomération"){
    echo "VISU.getMap().setCenter(ptcentre,12);\r";
  }else{
	 echo "VISU.getMap().setCenter(ptcentre,10);\r";  
  }
  
  
  
  
  
    echo "var olMap=VISU.getMap();\r"; 



  //--OK----------------  
  /* => SAMUEL : 
			- Commune (MAIRIE)= ANNUcom
			- Communauté (A1 ou A2) = ANNUcc
			- Pays (B0) = ANNUpays
  */
  
      if($donnees_cartes['TypeComEPCI']=="Mairie"){
        $idCarte='ANNUcom';
      }elseif($donnees_cartes['TypeComEPCI']=="A1" or $donnees_cartes['TypeComEPCI']=="A2"){
        $idCarte='ANNUcc';
      }elseif($donnees_cartes['TypeComEPCI']=="B0"){
        $idCarte='ANNUpays';
      }else{
    	 $idCarte='ANNU';  
      }
  
      $rep ="Select num_couche, ordre_couche, transp, visible from cartes_couche where id_cartes = '".$idCarte."' order by ordre_couche;";
      $reponse = mysql_query($rep);
      while($donnees = mysql_fetch_array($reponse)) {
     
        $rep ="Select * from couche_wms where num_id = '". $donnees['num_couche'] ."';";
        $transp=$donnees['transp'];
		    $visible=$donnees['visible'];
		    //echo $rep;
		    //echo $transp:
        $query = mysql_query($rep);
     
        while ($donnees_affichage = mysql_fetch_array($query)){
            echo "VISU.getMap().addLayer(\r";
            echo "\"WMS\",\"".$donnees_affichage['titre']."\",\r";
        		echo "\"".$donnees_affichage['lien']."\",\r";
        		echo "{layers:'".$donnees_affichage['layer']."',format:'image/png',transparent:true},\r";
        		if( $donnees_affichage['projection'] == ""){
          		echo "{projection: \"epsg:4326\",visibility:true,opacity: 0.7,singleTile: true}\r";
        		}
        		else {
        		  echo "{projection: \"".$donnees_affichage['projection']."\",\r";
				  echo "visibility: ".$visible.",opacity: ".$transp.",singleTile: true,\r";
				  echo "originators:[{logo:'pilote41',pictureUrl: 'http://doc.pilote41.fr/fournisseurs/observatoire/PILOTE41/vignettes_autres/pilote41_logoseul80.jpg',url: 'http://www.pilote41.fr'}]\r";
				  echo "}\r";
        		}
        	echo ");\r";
        }
      }
  //--OK----------------  

  
  /*
      $req = "Select * from annuaire where IdComEpci = '". $donnees_cartes['IdComEpci'] ."';";  
      $reponse_mark = mysql_query($req);
      $i=1;
      while($donnees= mysql_fetch_array($reponse_mark)){*/
        //if($donnees['picto']==''){
          echo "var size".$i." = new OpenLayers.Size(15,23);\r";
        //}else{
         // $size = getimagesize("http://www.basodet.pilote41.fr/api_icones/".$donnees['picto']);
         // echo "var size".$i." = new OpenLayers.Size(".$size[0].",".$size[1].");\r";
        //}
        echo "var offset".$i." = new OpenLayers.Pixel(-(size".$i.".w/1), -size".$i.".h);\r";
		  
      
        // => SAMUEL : si Commune alors $Libel = "Mairie" sinon "Siège de l'EPCI"
		    if($donnees_cartes['TypeComEPCI']=="Mairie"){
		      $libel="Mairie";
		    }elseif($donnees_cartes['IdComEpci']=="CG41"){
          $libel="Conseil général";
        }else{
          $libel="Siède de l'EPCI";
        }
		
        echo "var mLayer".$i." = new OpenLayers.Layer.Markers(\"".$libel."\");\r";
        echo "olMap.addLayer(mLayer".$i.");\r";
  
        echo "var lonLat".$i." = new OpenLayers.LonLat(".($donnees_cartes['Xprecis']+5).",".($donnees_cartes['Yprecis']-5).");\r";
        echo "lonLat".$i.".transform(proj, VISU.getMap().getProjection());\r";
        echo "var feature".$i." = new OpenLayers.Feature(olMap,lonLat".$i.",{icon:new OpenLayers.Icon('";
        if($donnees_cartes['picto']==''){echo "http://www.basodet.pilote41.fr/interface/orange.png";}else{echo "http://www.basodet.pilote41.fr/api_icones/".$donnees_cartes['picto'];}
        echo "',size".$i.",offset".$i.")});\r";
        echo "feature".$i.".id = \"".$libel."\";\r";
  
        echo "var marker".$i." = feature".$i.".createMarker();\r";
        echo "mLayer".$i.".addMarker(marker".$i.");\r";
        echo "marker".$i.".events.register(\"mouseover\", {'feature': feature".$i.", 'bgColor' : 'blue' , 'fontColor' : 'white', 'opacity' : '0.8'}, toolTips);\r";
        if($donnees_cartes['SiteWeb']!=''){
          echo "marker".$i.".events.register(\"click\", feature".$i.", function(e){window.open('http://".str_replace("http://", "", $donnees_cartes['SiteWeb'])."','lien','menubar=yes, status=yes, scrollbars=yes, resizable=yes, width=800, height=600');} )\r";
        }
        echo "marker".$i.".events.register(\"mouseout\", feature".$i.", eraseToolTips);\r";
        $i++;
        if($precision==''){
          $precision=$donnees_cartes['DegresPrecision'];
        }
      /*}  */
  
  
  
  
  
  
  }


    echo "}\r";
    
    echo "</script>\r";
  
    echo "<div id=\"GeoportalVisuDiv\" style=\"width:100%;height:450px;\"></div>\r";

 
 
  
  }


}
  
?>