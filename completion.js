// pas touche
// cr�ation de l'objet Ajax
var http = null;
if		(window.XMLHttpRequest) // Firefox 
	http = new XMLHttpRequest(); 
else if	(window.ActiveXObject) // Internet Explorer 
	http = new ActiveXObject("Microsoft.XMLHTTP");
else	// XMLHttpRequest non support� par le navigateur 
   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");


function recup_email(e, sub) {

	var sel = document.completion_form.completion_select ;
	var nb_el = sel.options.length ;
	var selIndex = sel.selectedIndex ;

  for( i = 0; i < document.completion_form.type_nom.length; i++ ) {
    if( document.completion_form.type_nom[i].checked == true ) var type = document.completion_form.type_nom[i].value;
  }

	
	if (!document.completion_form.nom.value)
	{	sel.style.display = 'none';
	}
	else if (e.keyCode == 40 && nb_el) { // fleche bas
		if (selIndex < sel.options.length - 1)
			sel.selectedIndex = selIndex + 1 ;
	}
	else if (e.keyCode == 38 && nb_el) { // fleche haut
		if (selIndex > 0)
			sel.selectedIndex = selIndex - 1 ;
	}
	else if (e.keyCode == 13 && nb_el) { // entrée
		document.completion_form.nom.value = sel.options[selIndex].value ;
		sel.style.display = 'none';
	}
	else { // autre touche --> on recherche les emails
		val = document.completion_form.nom.value ;
		if (val.length >= minimum_caractere) {
		  //alert("ajax.php?what=completion1&type="+type+"&val="+val);
			http.open("GET", "ajax.php?what=completion1&type="+type+"&val="+val, true);
			http.onreadystatechange = handleHttpResponse_recup_email;
			http.send(null);
		}
	}
	if(sub!=''){
    	recup_mail_click();
  }
}

function handleHttpResponse_recup_email()
{
	if (http.readyState == 4) {
	document.getElementById('annuaire_epci_rech').InnerHTML=http.responseText;
  emails = eval('(' + http.responseText + ')'); // [id1,id2, ...]

		var sel = document.completion_form.completion_select ;
		sel.attributes['size'].value = emails.length;

		// on vide le select
		while(sel.options.length > 0)
			sel.options[0] = null

		// on rempli avec les nouveaux emails
		for(i=0 ; i<emails.length ; i++)
			sel.options[sel.options.length] = new Option(emails[i],emails[i]);

		if (sel.options.length) {
			sel.selectedIndex = 0 ; // on selection le premier element de la liste
			sel.style.display = 'block';
		}
		else
			sel.style.display = 'none';
	}	
}

function recup_mail_click() {
	var sel = document.completion_form.completion_select ;
	document.completion_form.nom.value = sel.options[sel.selectedIndex].value;
	sel.style.display = 'none';
	document.completion_form.submit();
}
