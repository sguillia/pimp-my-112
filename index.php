<html>
<head>

<title>Urgences police/pompiers</title>

<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />


<style type="text/css">
body{
	background-color: rgb(245, 235, 220);
}

div{
	border: 1px black solid;
}

#num_errmsg{
	color: red;
}

#do_geoloc, #do_picture, input[type="submit"]{
	margin-left: 50px;
}

#map_wrapper {
    height: 700px;
}

#imap{
    width: 100%;
    height: 100%;
}

</style>

<script type="text/javascript">

var isready = true;

function set_num_errmsg(errmsg)
{
	document.getElementById("num_errmsg").innerHTML = errmsg;
}

function getXMLHttpRequest() {	
	var xhr = null;

	if (window.XMLHttpRequest || window.ActiveXObject)
	{
		if (window.ActiveXObject)
		{
			try
			{
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e)
			{
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		else
			xhr = new XMLHttpRequest(); 
	}
	else
	{
		set_num_errmsg("Cannot create XMLHTTPRequest");
		return (null);
	}
	return xhr;
}

function request(number, geoloc_txt, picture_txt){
	var xhr   = getXMLHttpRequest();
	

	if (!isready)
	{
		console.log("Busy");
		return ;
	}

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 || xhr.readyState == 0)
		{
			isready = true;
		}
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			document.getElementById("show").innerHTML = xhr.responseText;
			reload_map();
		} else if (xhr.readyState < 4) {
			document.getElementById("show").innerHTML = "Loading " + xhr.readyState + "/4";
		}
	};
	xhr.open("GET", "encode_number.php?number="+number+geoloc_txt+picture_txt, true);
	xhr.send(null);
	isready = false;
}

function submit_phonenumber()
{
	set_num_errmsg("");
	var elem;
	var xhr   = getXMLHttpRequest();
	var do_geoloc = document.getElementById('do_geoloc').checked;
	var do_picture = document.getElementById('do_picture').checked;

	elem = document.getElementById("phonenumber");
	if (!xhr)
		return ;
	elem.value = elem.value.replace(/ /g,'');
	if (isNaN(elem.value))
	{
		set_num_errmsg("Ceci n'est pas un numéro de téléphone valide !");
		return (false);
	}
	if (!do_geoloc && !do_picture)
	{
		set_num_errmsg("Aucune case n'est cochée !");
		return (false);
	}
	var geoloc_txt = do_geoloc ? "&do_geoloc" : "";
	var picture_txt = do_picture ? "&do_picture" : "";
	request(elem.value, geoloc_txt, picture_txt);
}

function reload_map()
{
	document.getElementById('imap').contentWindow.location.reload(true);
}




function init()
{
	setInterval(refresh_imap, 1500);
}


function refresh_imap()
{
	var iframe = document.getElementById('imap');
	var icontent = iframe.contentDocument || iframe.contentWindow.document;

	if (icontent)
	{
		if (icontent.getElementById('mybody') && icontent.getElementById('mybody').innerHTML == "<img src=\"france.png\">")
		{
			reload_map();
		}
		else
		{

		}
	}
	else
	{
		reload_map();
	}
}






</script>

</head>

<body onload="init(); return false;">

<fieldset>
<legend>Envoi de SMS</legend>

<p><a href="" onclick="document.getElementById('phonenumber').value='07 68 15 17 10'; return false;">Preset</a></p>

<form onsubmit="submit_phonenumber(); return false;">
<p>Phone number :
	<input type="text" name="phonenumber" id="phonenumber" autocomplete="off">
	<input type="checkbox" name="do_geoloc" id="do_geoloc" checked><label for="do_geoloc">Geolocalisation</label>
	<input type="checkbox" name="do_picture" id="do_picture"><label for="do_picture">Photo</label>
	&nbsp;<input type="submit" value="Send">
	<span id="num_errmsg"></span>
</p>
</form>

<p>Status: <span id="show"></span></p>

</fieldset>

<fieldset>
<legend>Carte - <a href="" onclick="location.reload(); return false;">Actualiser</a></legend>

<div id="map_wrapper">

<iframe id="imap" src="show_coord.php" style="width:100%;height:100%;"></iframe>

</div>




</fieldset>

</body>
</html>
