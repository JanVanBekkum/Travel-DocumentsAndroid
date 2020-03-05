<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<meta name="description" content="Repository of documents and procedures needed to enter countries or drive ones own vehicle.">
<meta name="keywords" content="Travel,Documents,Overlanding,RHD,Carnet,CPD,CdP,Visa,Passport,Overland,Borders,International Driving Permit,Carnet de Passages">
<meta name="author" content="Jan van Bekkum">
<link rel="stylesheet" type="text/css" href="travel_documents.css">
<link rel="shortcut icon" type="image/x-icon" href="images\favicon.ico" />
<title>Travel Documents Repository for Overlanders</title>

<!-- Style for footer table -->
<style>
	div.container {
		width:98%; 
		margin:1%;
	}
	table#table1 {
		text-align:center; 
		margin-left:auto; 
		margin-right:auto; 
		width:100px;
	 }
	tr,td {text-align:left;}
</style>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-42892868-3"></script>

<!-- Needed for login -->
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-42892868-3');
</script>

<!-- Get the Google jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
var current_destination = "";
</script>

<!-- Google advertisements
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-5044809938254779",
          enable_page_level_ads: true
     });
</script>-->

</head>
<body>

	<div style="text-align:center">
		<img src="images\Route B1804_v7.jpg" alt="Logo" style="max-width: 128px; max-height: auto">
		<h1>4ever2wherever Travel Documents Repository</h1>
		
		<p>The 4ever2wherever travel documents repository is a simple tool for overlanders to share knowledge about paperwork and procedures needed to enter and stay in countries as well as to drive and store their own vehicle there.</p>
	</div>
		<p>
		<u>Topics covered:</u>
			<ul>
				<li><i>Entry in country</i> - What formalities are needed to enter a country;</li>
				<li><i>Extend stay in country</i> - What formalities are needed to extend the stay of persons in a country;</li>
				<li><i>Permit</i> - what permits are needed to visit a specific area;</li>
				<li><i>Drive own vehicle</i> - Temporary import of your vehicle, but also insurance, driver's license, etc.;</li>
				<li><i>Extend vehicle import</i> - Keep your vehicle in the country for a longer period;</li>
				<li><i>Store vehicle while leaving</i> - Store your vehicle in the country while you leave.</li>
			</ul>
		</p>

		<p>Per topic non-commercial information, commercial information and traveler feedback are provided in separate sections; this helps to assess the information. Countries as well as important multi-country documents such as drivers licenses and insurance are covered.</p>
		
		<p>Please extend and update the information in the repository when applicable; this can be done <i>very easily</i>.</p>
		<p>Select the desired <i>document</i> or <i>country</i> in the box below, then click view.</p>

	<div style="text-align:center">		
<?php

// Make MySQL server connection.
$link = mysqli_connect("localhost", "jvbekkum_0001", "VKhqGnwtSWE2", "jvbekkum_traveldocuments");

// Check connection
if($link === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Get country list for country selection
$sql = 'SELECT * FROM countries WHERE 1 ORDER BY country_name';
$result = mysqli_query($link, $sql);

echo "<form id='document_retrieval' action='retrieve.php' method='get'><p>
	<select name='active_destination' id='active_destination' size='10' required>";
		if (mysqli_num_rows($result) > 0) {

			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
//				| Align here			
echo <<<EOL
<option value= "
EOL;
echo $row['country'];
echo <<<EOL
">
EOL;
echo $row['country_name'] . "</option>";
//				| Align here
			}
		} else {
			echo " 0 results";
		}
	echo " </select></p>
	<p><input type='submit' value='View country/topic'></p>
</form>";
?>

		<div style = "line-height: 1.8";>
			<p>More information:<br>
			<a href = "instructions.php">Detailed instructions</a><br>
			<a href = "instructions.php#available">Number of documents available per country.</a><br>
			</p>
		</div>
	</div>
	
	<div class="container">
		<table id="table1">
			<tr>
				<td style = "padding: 15px ;">Contact:<br><a href="mailto:info@4ever2wherever.com" target='_blank'>info@4ever2wherever.com</a></td>
				<td style = "padding: 15px ;">About:<br><a href="about.html">About</a></td>
			</tr>
		</table>
	</div>
	<div style="text-align:center">
		<a href="https://www.facebook.com/4ever2wherever/" target="_blank">
			<br><img src="images\facebook-button-300x82_v2.jpg" alt="Facebook">
		</a>
	</div>

</body>
</html>