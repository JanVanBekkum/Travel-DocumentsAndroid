<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="google-signin-client_id" content="2179150614-f6kt7p3m7t7uqu2ii54iv621v2952mbe.apps.googleusercontent.com"> <!-- Google sign-in -->
	<link rel="stylesheet" type="text/css" href="travel_documents.css">
	
	<link rel="shortcut icon" type="image/x-icon" href="images\favicon.ico" />
	<title>Travel documents - add change view records</title>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-42892868-3"></script>

	<!-- Google Platform Library needed for sign-in -->
	<script src="https://apis.google.com/js/platform.js" async defer></script>

	<!-- Google advertisements
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
		 (adsbygoogle = window.adsbygoogle || []).push({
			  google_ad_client: "ca-pub-5044809938254779",
			  enable_page_level_ads: true
		 });
	</script>-->

	<script>
		// Needed for login
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-42892868-3');
	</script>

	<!-- Get the Google jQuery CDN -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

	<script>

	var current_destination
	var person_info=false;
	var vehicle_info=false;
	var description_info=false;
	var document_info=false;
	var drive_entry_info=false;
	var display_mode; // Display mode: show record, modify record or add record
	var user_email = null; // email address of signed in user

	$(document).ready(function(){
		
			$(".nationality").hide();
			$(".registration").hide();
		
		// Show entry date details fields for a person related document only. Show vehicle entry conditions for a Drive own Vehicle document only.
		
		// Topic click
		$("#enter_country_entry").click(function(){
			person_info=true;
			vehicle_info=false;
			drive_entry_info=false;
			if(document_info) {$(".person_time").show()};
			$(".vehicle_time").hide();
			$(".vehicle_papers").hide();
			$(".nationality").show();
			$(".registration").hide();
		});		
		$("#extend_person_entry").click(function(){
			person_info=true;
			vehicle_info=false;
			drive_entry_info=false;
			if(document_info) {$(".person_time").show()};
			$(".vehicle_time").hide();
			$(".vehicle_papers").hide();
			$(".nationality").show();
			$(".registration").hide();			
			
		});		
		$("#permit_entry").click(function(){
			person_info=true;
			vehicle_info=false;
			drive_entry_info=false;
			if(document_info) {$(".person_time").show()};
			$(".vehicle_time").hide();
			$(".vehicle_papers").hide();
			$(".nationality").show();
			$(".registration").hide();			
			
		});		
		$("#drive_entry").click(function(){
			person_info=false;
			vehicle_info=true;
			drive_entry_info=true;
			if(document_info) {$(".vehicle_time").show()};
			if(description_info) {$(".vehicle_papers").show()};
			$(".person_time").hide();
			$(".nationality").hide();
			$(".registration").show();			
			
		});		
		$("#extend_car_entry").click(function(){
			person_info=false;
			vehicle_info=true;
			drive_entry_info=false;
			if(document_info) {$(".vehicle_time").show()};
			$(".person_time").hide();
			$(".vehicle_papers").hide();
			$(".nationality").hide();
			$(".registration").show();				
			
		});		
		$("#store_entry").click(function(){
			person_info=false;
			vehicle_info=true;
			drive_entry_info=false;
			if(document_info) {$(".vehicle_time").show()};
			$(".person_time").hide();
			$(".vehicle_papers").hide();
			$(".nationality").hide();
			$(".registration").show();				
			
		});
		
		// Entry type click
		$("#description_entry").click(function(){
			description_info=true;
			document_info=false;
			$(".person_time").hide();
			$(".vehicle_time").hide();
			if(drive_entry_info) { $(".vehicle_papers").show()};
		});		
		$("#document_entry").click(function(){
			document_info=true;
			description_info=false;			
			if (person_info) {$(".person_time").show()};
			if (vehicle_info) {$(".vehicle_time").show()};
			$(".vehicle_papers").hide();
		});
		$("#note_link_entry").click(function(){
			document_info=false;
			description_info=false;					
			$(".person_time").hide();
			$(".vehicle_time").hide();
			$(".vehicle_papers").hide();
		});
		$("#business_link_entry").click(function(){
			document_info=false;
			description_info=false;					
			$(".person_time").hide();
			$(".vehicle_time").hide();
			$(".vehicle_papers").hide();
		});		
		$("#comment_link_entry").click(function(){
			document_info=false;
			description_info=false;					
			$(".person_time").hide();
			$(".vehicle_time").hide();
			$(".vehicle_papers").hide();
		});
	});
	</script>
	
	</head>
<body onload="fillTable()">

	<?php
	// make MySQL server connection.
	$link = mysqli_connect("localhost", "jvbekkum_0001", "VKhqGnwtSWE2", "jvbekkum_traveldocuments");
	 
	// Check connection
	if($link === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}

	// Escape user inputs for security
	$destination = mysqli_real_escape_string($link, $_GET["active_destination"]);
	
	// Check if entered country is in country list
	$sqlcountry = 'SELECT *  FROM countries WHERE country = "' . $destination . '"';
	$resultcountry = mysqli_query($link, $sqlcountry);
	if (mysqli_num_rows($resultcountry) == 0) {
		$temp = '"index.php"';
		echo "Invalid country or document<br><br>
		<button onclick='window.location.href = " . $temp . ";' style='font-size: 100%'>Home</button>";
		exit;
	}


	if(isset($_GET["active_record"])) {
		// show active record
		$actrec = mysqli_real_escape_string($link, $_GET["active_record"]);
		$sql = 'SELECT * FROM orddocinfo WHERE id =  "' . $actrec . '" LIMIT 1';
		$result = mysqli_query($link, $sql);
		if (false === $result) { echo mysqli_error($link); }
		$i = mysqli_fetch_array ($result);
		
		$str_id=$i['id'];
		$str_destination=$i['destination'];
		$str_topic=$i['topic'];
		$str_entry_type=$i['entry_type'];
		$str_legend=$i['legend'];	
		$str_title = mysqli_real_escape_string($link, $i['title']);
		$str_description = mysqli_real_escape_string($link, $i['description']);		
		$str_link_address = mysqli_real_escape_string($link, $i['link_address']);	
		$str_stay_length = mysqli_real_escape_string($link, $i['stay_length']);	
		$str_permit_validity_start = mysqli_real_escape_string($link, $i['permit_validity_start']);
		$str_permit_validity_duration = mysqli_real_escape_string($link, $i['permit_validity_duration']);
		$str_allowance = mysqli_real_escape_string($link, $i['allowance']);
		$str_uses = mysqli_real_escape_string($link, $i['uses']); //Escape not really necessary: no use text input
		$str_extendable = mysqli_real_escape_string($link, $i['extendable']);
		$str_arrival_departure_count = mysqli_real_escape_string($link, $i['arrival_departure_count']);	//Escape not really necessary: no use text input
		$str_where_to_get = mysqli_real_escape_string($link, $i['where_to_get']);
		$str_delivery_time = mysqli_real_escape_string($link, $i['delivery_time']);
		$str_costs = mysqli_real_escape_string($link, $i['costs']);
		$str_import_permit = mysqli_real_escape_string($link, $i['import_permit']);
		$str_drivers_license = mysqli_real_escape_string($link, $i['drivers_license']);
		$str_insurance = mysqli_real_escape_string($link, $i['insurance']);
		$str_rhd = mysqli_real_escape_string($link, $i['rhd']);
		$str_coming_from = mysqli_real_escape_string($link, $i['coming_from']);
		$str_nationality = mysqli_real_escape_string($link, $i['nationality']);
		$str_resident_of = mysqli_real_escape_string($link, $i['resident_of']);
		$str_vehicle_registration = mysqli_real_escape_string($link, $i['vehicle_registration']);
		$str_update_time = mysqli_real_escape_string($link, $i['update_time']);	//Escape not really necessary: no use text input
		$str_current = mysqli_real_escape_string($link, $i['current']);	//Escape not really necessary: no use text input
		
		if ($actrec > 0) {$table_mode="show_record";} else {$table_mode="add_record";}
	}

	// Close connection
	mysqli_close($link);
	?>
	
	<!-- Show destination in header -->
	<h1 id='destination_string' style='text-align:center'></h1>
	
	<!-- Get user credentials for database writing: show sign in button if user wants to write and didn't sign in yet -->
	<div id="login_button">	
		<h2> Sign-in Needed</h2>	
		Sign-in is needed once to add or modify topics. Don't worry, sign-in is <u>only</u> used to get in touch with the author in case of data entry problems.<br><br>		
		<div class="g-signin2" data-onsuccess="onSignIn"></div><br>
		<h2>Data Entry or Modification</h2>
	</div>

	<!-- Display details form -->
	<form id="document_info_entry" action='insert.php' method="post">
		<div id="fill_id"></div> <!-- Fill ID for modified record -->
		<div id="fill_destination"></div> <!-- Fill destination for modified record -->
		<input type="hidden" id="uses" name="uses" value="">
		<input type="hidden" id="arrival_departure_count" name="arrival_departure_count" value="">
		<input type="hidden" id="updated_by">
		<table cellpadding="10" table-layout: fixed;>
			<tr><th>Item</th><th>Details</th></tr>
					
			<!--Topic-->
			<!--<tr><td width = "25%">Topic<sup>*</sup></td><td width = 50%><div class="person" id="topic_string1"></div><div class="vehicle" id="topic_string2"></div></td></tr>-->
			<tr><td width = "25%">Topic<sup>*</sup></td><td width = 50%><div class="person" id="enter_country_entry"></div><div class="person" id="extend_person_entry"></div><div class="person" id="permit_entry"></div><div class="vehicle" id="drive_entry"></div><div class="vehicle" id="extend_car_entry"></div><div class="vehicle" id="store_entry"></div></td></tr>			
			
			<!-- Entry type -->
			<tr><td>Entry type<sup>*</sup></td><td><div class="link" id="description_entry"></div><div class="link" id="document_entry"></div><div class="link" id="note_link_entry"></div><div class="link" id="business_link_entry"></div><div class="link" id="comment_link_entry"></div></td>
			</tr>
			<tr><td>Title<sup>*</sup></td><td><div id="title_string"></div></td></tr>
			<tr><td><div class="tooltip">Description<span class="tooltiptext">Optional</span></div></td><td><div id="description_string"></div></td></tr>
			<tr><td><div class="tooltip">Link to more information<span class="tooltiptext">Website with more detailed information</span></div></td><td><div id="link_address_string"></div></td></tr>
			<tr class="person_time"><td><div class="tooltip">Stay length<span class="tooltiptext">Maximum length of a continuous stay</span></div></td><td><div id="stay_length_string"></div></td></tr>
			<tr class="person_time"><td><div class="tooltip">Permit validity start<span class="tooltiptext">First possible day of entry, usually on day of issue or on a specified date</span></div></td><td><div id="permit_validity_start_string"></div></td></tr>
			<tr class="person_time"><td><div class="tooltip">Permit validity duration<span class="tooltiptext">Period during which entry is possible, for example 3 months until last entry or 3 months until last exit</span></div></td><td><div id="permit_validity_duration_string"></div></td></tr>
			<tr class="person_time"><td><div class="tooltip">Allowance<span class="tooltiptext">Total time or entries per period, for example 90 days or 2 entries per year</span></div></td><td><div id="allowance_string"></div></td></tr>
			<tr class="person_time"><td><div class="tooltip">Uses<span class="tooltiptext">Number of entries</span></div></td><td><div id="uses_string"></div></td></tr>
			<tr class="person_time"><td><div class="tooltip">Extendable<span class="tooltiptext">Can the stay be extended?</span></div></td><td><div id="extendable_string"></div></td></tr>
			<tr class="person_time"><td><div class="tooltip">Arrival and departure count<span class="tooltiptext">Do arrival and departure day count for 1 day or for 2 days?</span></div></td><td><div id="arrival_string"></div></td></tr>
			<tr class="person_time"><td><div class="tooltip">Where to get<span class="tooltiptext">For example online, consulate, consulate in home country or licensed third party</span></div></td><td><div id="where_to_get_string"></div></td></tr>
			<tr class="person_time"><td>Delivery time</td><td><div id="delivery_time_string"></div></td></tr>
			<tr class="person_time"><td>Costs</td><td><div id="costs_string"></div></td></tr>
			<tr class="vehicle_papers"><td><div class="tooltip">Import permit<span class="tooltiptext">For example temporary import permit (TIP) or Carnet de Passages</span></div></td><td><div id="import_permit_string"></div></td></tr>
			<tr class="vehicle_papers"><td><div class="tooltip">Drivers license<span class="tooltiptext">For example international drivers permit (IDP) or national drivers license. Indicate which convention (1926, 1949 or 1968)</span></div></td><td><div id="drivers_license_string"></div></td></tr>
			<tr class="vehicle_papers"><td><div class="tooltip">Insurance<span class="tooltiptext">Indicate if a third party liability insurance is mandatory</span></div></td><td><div id="insurance_string"></div></td></tr>
			<tr class="vehicle_papers"><td>Right hand drive vehicles permitted</td><td><div id="rhd_string"></div></td></tr>
			<tr><td><div class="tooltip">Coming from<span class="tooltiptext">For example airports only, not at minor border crossings or from a specific country</span></div></td><td><div id="coming_from_string"></div></td></tr>
			<tr class="nationality"><td><div class="tooltip">Nationality<span class="tooltiptext">Specifify if NOT valid for citizens from Europe, North and South America, Australia, New Zealand</span></div></td><td><div id="nationality_string"></div></td></tr>
			<tr><td>Country of residence (add if relevant)</td><td><div id="resident_of_string"></div></td></tr>
			<tr class="registration"><td>Vehicle registration (add if relevant)</td><td><div id="vehicle_registration_string"></div></td></tr>
			<div id="existing_record">
				<tr><td><div class="tooltip">This topic is current<span class="tooltiptext">Topics that are not current are marked for deletion</span></div></td><td><div id="current_string"></div></td></tr>
				<tr><td><i>Last updated</i></td><td><i><div id="update_time_string"></div></i></td></tr>
			</div>
		</table>

		<p id="submit_button"></p>

	</form>
	<button onclick="returnString()" style="font-size: 100%">Return</button>
	<div id="modify_button"><button onclick="showTable('modify_record')" style="font-size: 100%">Modify topic</button></div>
	
	<script>

	//	Display existing record or add new record.
	function fillTable() {
		display_mode = '<?php echo $table_mode; ?>';
		showTable(display_mode);
	}

	//Prepare details form
	function showTable(showmode) {
		
		var showmode; // Currect display mode: show, update or add
		display_mode=showmode;
		var i;
		var dest; // Destination
		var radionow; // Currently selected radio button option or currently active string
		var radcnt; // Number of options for radio button
		var radopts = []; // String with all radio option buttons
		var radstr; // String to be built for radio buttons
		var radchk = ' checked';
		var enttype // Entry type selected
		var top // Topic selected
		var rad = [
			['radio 1a','radio 1b','radio 1c'],
			['radio 2a','radio 2b','radio 2c'],
			['radio 3a','radio 3b','radio 3c'],
			['radio 4a','radio 4b','radio 4c'],
			['radio 5a','radio 5b','radio 5c'],
			['radio 6a','radio 6b','radio 6c']
		];//string parts

		// Needed to show hide link and person document fields.
		top = '<?php echo $str_topic; ?>'
		enttype = '<?php echo $str_entry_type; ?>'
		
		// Prepare to show time details for a person related document.
		if (top == "Entry in country" || top == "Extend stay in country" || top == "Permit") {
			person_info = true;
			$(".nationality").show();
		} else {
			$(".registration").show();
		};
		if (enttype == "Document") {document_info = true };
		if (enttype != "Document" || ( top != "Entry in country" && top != "Extend stay in country" && top != "Permit" )) {	
			$(".person_time").hide();
		} else {
			$(".person_time").show();
		};

		// Prepare to show vehicle paper details for an entry vehicle description
		if ( top == "Drive own vehicle" ) {
			drive_entry_info=true ;
		} else {
			drive_entry_info=false ;
		}
		
		if ( enttype == "Description" ) {
			description_info=true;
		} else {
			description_info=false;
		}
		
		if ( drive_entry_info && description_info ) {
			$(".vehicle_papers").show();
		} else {
			$(".vehicle_papers").hide();
		};

		document.getElementById("destination_string").innerHTML = '<?php echo $destination ?>';

		// === Show record display mode ====================================================================================================================
		if (display_mode == "show_record") {
			document.getElementById("login_button").style.display = "none"; // Hide Google login button and login invitation text
			document.getElementById("submit_button").innerHTML=''; 	// Hide submit button.
		
			//Topic
			document.getElementById("enter_country_entry").innerHTML='<?php echo $str_topic; ?>';
			
			//Entry type
			//document.getElementById("document_entry").innerHTML = '<?php echo $str_entry_type; ?>';
			document.getElementById("document_entry").innerHTML = '<?php echo $str_legend; ?>';			

			//Title
			document.getElementById("title_string").innerHTML='<?php echo $str_title; ?>';
			
			// Description
			var temp = '<?php echo $str_description; ?>';
			var convstring = temp.replace(/(\r\n|\n|\r)/gm, "<br>");  // Replace \n and \r characters with <br>
			document.getElementById("description_string").innerHTML = convstring;
			
			// Link address	
			radionow = '<?php echo $str_link_address; ?>'
			var temp = radionow.length;
			var tempstr = radionow;
			if (temp > 39) { tempstr = "Link" }; // Show full string only if it is not too long (needed for small screen layout)
			document.getElementById("link_address_string").innerHTML="<a href = " + radionow + " target='_blank'>" + tempstr + "</a>";
			
			document.getElementById("stay_length_string").innerHTML='<?php echo $str_stay_length; ?>';
			document.getElementById("permit_validity_start_string").innerHTML='<?php echo $str_permit_validity_start; ?>';
			document.getElementById("permit_validity_duration_string").innerHTML='<?php echo $str_permit_validity_duration; ?>';
			document.getElementById("allowance_string").innerHTML='<?php echo $str_allowance; ?>';
			document.getElementById("uses_string").innerHTML='<?php echo $str_uses; ?>';
			document.getElementById("extendable_string").innerHTML='<?php echo $str_extendable; ?>';
			document.getElementById("arrival_string").innerHTML='<?php echo $str_arrival_departure_count; ?>';
			document.getElementById("where_to_get_string").innerHTML='<?php echo $str_where_to_get; ?>';
			document.getElementById("delivery_time_string").innerHTML='<?php echo $str_delivery_time; ?>';
			document.getElementById("costs_string").innerHTML='<?php echo $str_costs; ?>';
			document.getElementById("import_permit_string").innerHTML='<?php echo $str_import_permit; ?>';
			document.getElementById("drivers_license_string").innerHTML='<?php echo $str_drivers_license; ?>';
			document.getElementById("insurance_string").innerHTML='<?php echo $str_insurance; ?>';
			document.getElementById("rhd_string").innerHTML='<?php echo $str_rhd; ?>';			
			document.getElementById("coming_from_string").innerHTML='<?php echo $str_coming_from; ?>';
			document.getElementById("nationality_string").innerHTML='<?php echo $str_nationality; ?>';
			document.getElementById("resident_of_string").innerHTML='<?php echo $str_resident_of; ?>';
			document.getElementById("vehicle_registration_string").innerHTML='<?php echo $str_vehicle_registration; ?>';
			document.getElementById("update_time_string").innerHTML='<?php echo $str_update_time; ?>';
			
			//Colored background if string not current
			radionow = '<?php echo $str_current; ?>';
			if (radionow == "Yes") {
				document.getElementById("current_string").innerHTML=radionow;
			} else {
				document.getElementById("current_string").innerHTML = '<div style = "background-color: #FF8C00";>' + radionow + '</div>';
			}
			
			document.getElementById("existing_record").style.display="inline";
			
			document.getElementById("modify_button").style.display="inline"; // Show modify button

		// === Modify record ===============================================================================================================================
		} else if (display_mode == "modify_record"){
			
			// Sign in user if needed
			userLogin ();
			
			//Fill ID and destination hidden for the user
			dest="<?php echo $destination ?>";
			
			// Split to allow for single quote in country name
			document.getElementById("fill_id").innerHTML='<input type="hidden" id="id" name="id" value="<?php echo $str_id; ?>">';
			var temp1 = '<input type="hidden" id="destination" name="destination" value="';
			var temp2 = "<?php echo $str_destination; ?>";
			var temp3 = '">';
			document.getElementById("fill_destination").innerHTML= temp1 + temp2 + temp3;
			
			//Topic
			radionow = '<?php echo $str_topic; ?>'; // Get current selection
			rad[0][0] = '<input type="radio" name="topic" value="Entry in country" required';
			rad[0][2] =	'>Entry in country<br>';
			rad[1][0] = '<input type="radio" name="topic" value="Extend stay in country" required';
			rad[1][2] = '>Extend stay in country<br>';
			rad[2][0] = '<input type="radio" name="topic" value="Permit" required';
			rad[2][2] = '>Permit<br>';
			rad[3][0] = '<input type="radio" name="topic" value="Drive own vehicle" required';
			rad[3][2] = '>Drive own vehicle<br>';
			rad[4][0] = '<input type="radio" name="topic" value="Extend vehicle import" required';
			rad[4][2] = '>Extend vehicle import<br>';
			rad[5][0] = '<input type="radio" name="topic" value="Store vehicle while leaving" required';
			rad[5][2] = '>Store vehicle while leaving<br>';
			radopts = ["Entry in country", "Extend stay in country", "Permit", "Drive own vehicle", "Extend vehicle import", "Store vehicle while leaving"];

			rad[0][1] = '';
			if (radopts[0] == radionow) { rad[0][1] = radchk; }
			radstr = rad[0][0] + rad[0][1] + rad[0][2];
			document.getElementById("enter_country_entry").innerHTML = radstr;

			rad[1][1] = '';
			if (radopts[1] == radionow) { rad[1][1] = radchk; }
			radstr = rad[1][0] + rad[1][1] + rad[1][2];
			document.getElementById("extend_person_entry").innerHTML = radstr;

			rad[2][1] = '';
			if (radopts[2] == radionow) { rad[2][1] = radchk; }
			radstr = rad[2][0] + rad[2][1] + rad[2][2];
			document.getElementById("permit_entry").innerHTML = radstr;

			rad[3][1] = '';
			if (radopts[3] == radionow) { rad[3][1] = radchk; }
			radstr = rad[3][0] + rad[3][1] + rad[3][2];
			document.getElementById("drive_entry").innerHTML = radstr;
			
			rad[4][1] = '';
			if (radopts[4] == radionow) { rad[4][1] = radchk; }
			radstr = rad[4][0] + rad[4][1] + rad[4][2];
			document.getElementById("extend_car_entry").innerHTML = radstr;

			rad[5][1] = '';
			if (radopts[5] == radionow) { rad[5][1] = radchk; }
			radstr = rad[5][0] + rad[5][1] + rad[5][2];
			document.getElementById("store_entry").innerHTML = radstr;
			
			// Entry type
			radionow = '<?php echo $str_entry_type; ?>'; // Get current selection
			rad[0][0] = '<input type="radio" name="entry_type" value="Description" required';
			rad[0][2] = '>Topic summary<br>';
			rad[1][0] = '<input type="radio" name="entry_type" value="Document" required';
			rad[1][2] = '>Document details<br>';
			rad[2][0] = '<input type="radio" name="entry_type" value="Note link" required';		
			rad[2][2] = '>Non-commercial information (governments, wikipedia, ...)<br>';
			rad[3][0] = '<input type="radio" name="entry_type" value="Business link" required';		
			rad[3][2] = '>Commercial information (visa bureaus, travel agencies, ...)<br>';			
			rad[4][0] = '<input type="radio" name="entry_type" value="Comment link" required';
			rad[4][2] = '>Traveler feedback (Facebook, blog, forum, ... - unofficial)<br>';
			radopts = ["Description", "Document", "Note link", "Business link", "Comment link"];
			
			rad[0][1] = '';
			if (radopts[0] == radionow) { rad[0][1] = radchk; }
			radstr = rad[0][0] + rad[0][1] + rad[0][2];
			document.getElementById("description_entry").innerHTML = radstr;

			rad[1][1] = '';
			if (radopts[1] == radionow) { rad[1][1] = radchk; }
			radstr = rad[1][0] + rad[1][1] + rad[1][2];
			document.getElementById("document_entry").innerHTML = radstr;

			rad[2][1] = '';
			if (radopts[2] == radionow) { rad[2][1] = radchk; }
			radstr = rad[2][0] + rad[2][1] + rad[2][2];
			document.getElementById("note_link_entry").innerHTML = radstr;

			rad[3][1] = '';
			if (radopts[3] == radionow) { rad[3][1] = radchk; }
			radstr = rad[3][0] + rad[3][1] + rad[3][2];
			document.getElementById("business_link_entry").innerHTML = radstr;				

			rad[4][1] = '';
			if (radopts[4] == radionow) { rad[4][1] = radchk; }
			radstr = rad[4][0] + rad[4][1] + rad[4][2];
			document.getElementById("comment_link_entry").innerHTML = radstr;	

			// Title
			document.getElementById("title_string").innerHTML='<input type="text" name="title" id="title" size="39" required value="<?php echo $str_title; ?>" style="font-size: 100%">';
			document.getElementById("description_string").innerHTML='<textarea rows="10" cols="41" name="description" id="description"  style="font-size: 100%"><?php echo $str_description; ?></textarea>';
			document.getElementById("link_address_string").innerHTML='<input type="text" name="link_address" id="link_address" size="39" value="<?php echo $str_link_address; ?>" style="font-size: 100%">';
			document.getElementById("stay_length_string").innerHTML='<input type="text" name="stay_length" id="stay_length" size="39" value="<?php echo $str_stay_length; ?>" style="font-size: 100%">';
			document.getElementById("permit_validity_start_string").innerHTML='<textarea rows="3" cols="41" name="permit_validity_start" id="permit_validity_start" style="font-size: 100%"><?php echo $str_permit_validity_start; ?></textarea>';
			document.getElementById("permit_validity_duration_string").innerHTML='<textarea rows="3" cols="41" name="permit_validity_duration" id="permit_validity_duration" style="font-size: 100%"><?php echo $str_permit_validity_duration; ?></textarea>';
			document.getElementById("allowance_string").innerHTML='<textarea rows="3" cols="41" name="allowance" id="allowance" style="font-size: 100%"><?php echo $str_allowance; ?></textarea>';			
			
			//Number of uses of the permit
			radionow = '<?php echo $str_uses; ?>';
			rad[0][0] = '<input type="radio" name="uses" value="Single"';
			rad[0][2] =	'>Single<br>';
			rad[1][0] = '<input type="radio" name="uses" value="Double"';
			rad[1][2] = '>Double<br>';
			rad[2][0] = '<input type="radio" name="uses" value="Multiple"';
			rad[2][2] = '>Multiple<br>';
			radcnt = 3;
			radstr="";
			radopts = ["Single", "Double", "Multiple"];
			for (i = 0; i < radcnt; i++) {
				rad[i][1] = '';
				if (radopts[i] == radionow) {
					rad[i][1] = radchk;
				}
				radstr = radstr + rad[i][0] + rad[i][1] + rad[i][2];
			}
			document.getElementById("uses_string").innerHTML = radstr;
			
			document.getElementById("extendable_string").innerHTML='<textarea rows="3" cols="41" name="extendable" id="extendable" style="font-size: 100%"><?php echo $str_extendable; ?></textarea>';				
			
			//Arrival/departure count
			radionow = '<?php echo $str_arrival_departure_count; ?>';
			rad[0][0] = '<input type="radio" name="arrival_departure_count" value="Count as one"';
			rad[0][2] =	'>Count as one<br>';
			rad[1][0] = '<input type="radio" name="arrival_departure_count" value="Count as two"';
			rad[1][2] = '>Count as two<br>';
			radcnt = 2;
			radstr="";
			radopts = ["Count as one", "Count as two"];
			for (i = 0; i < radcnt; i++) {
				rad[i][1] = '';
				if (radopts[i] == radionow) {
					rad[i][1] = radchk;
				}
				radstr = radstr + rad[i][0] + rad[i][1] + rad[i][2];
			}
			document.getElementById("arrival_string").innerHTML = radstr;
				
			document.getElementById("where_to_get_string").innerHTML='<textarea rows="3" cols="41" name="where_to_get" id="where_to_get" style="font-size: 100%"><?php echo $str_where_to_get; ?></textarea>';					
			document.getElementById("delivery_time_string").innerHTML='<textarea rows="3" cols="41" name="delivery_time" id="delivery_time" style="font-size: 100%"><?php echo $str_delivery_time; ?></textarea>';				
			document.getElementById("costs_string").innerHTML='<textarea rows="3" cols="41" name="costs" id="costs" style="font-size: 100%"><?php echo $str_costs; ?></textarea>';		
			document.getElementById("import_permit_string").innerHTML='<textarea rows="3" cols="41" name="import_permit" id="import_permit" style="font-size: 100%"><?php echo $str_import_permit; ?></textarea>';			
			document.getElementById("drivers_license_string").innerHTML='<textarea rows="3" cols="41" name="drivers_license" id="drivers_license" style="font-size: 100%"><?php echo $str_drivers_license; ?></textarea>';
			document.getElementById("insurance_string").innerHTML='<textarea rows="3" cols="41" name="insurance" id="insurance" style="font-size: 100%"><?php echo $str_insurance; ?></textarea>';		
			document.getElementById("rhd_string").innerHTML='<textarea rows="3" cols="41" name="rhd" id="rhd" style="font-size: 100%"><?php echo $str_rhd; ?></textarea>';	
			document.getElementById("coming_from_string").innerHTML='<textarea rows="3" cols="41" name="coming_from" id="coming_from" style="font-size: 100%"><?php echo $str_coming_from; ?></textarea>';	
			document.getElementById("nationality_string").innerHTML='<textarea rows="3" cols="41" name="nationality" id="nationality" style="font-size: 100%"><?php echo $str_nationality; ?></textarea>';	
			document.getElementById("resident_of_string").innerHTML='<textarea rows="3" cols="41" name="resident_of" id="resident_of" style="font-size: 100%"><?php echo $str_resident_of; ?></textarea>';	
			document.getElementById("vehicle_registration_string").innerHTML='<textarea rows="3" cols="41" name="vehicle_registration" id="vehicle_registration" style="font-size: 100%"><?php echo $str_vehicle_registration; ?></textarea>';	
			
			// Document current
			document.getElementById("existing_record").style.display="inline"; // Show line
			radionow = '<?php echo $str_current; ?>';
			rad[0][0] = '<input type="radio" name="current" value="Yes"';
			rad[0][2] =	'>Yes<br>';
			rad[1][0] = '<input type="radio" name="current" value="No"';
			rad[1][2] = '>No<br>';
			radcnt = 2;
			radstr="";
			radopts = ["Yes", "No"];
			for (i = 0; i < radcnt; i++) {
				rad[i][1] = '';
				if (radopts[i] == radionow) {
					rad[i][1] = radchk;
				}
				radstr = radstr + rad[i][0] + rad[i][1] + rad[i][2];
			}
			document.getElementById("current_string").innerHTML = radstr;

		// === Add record ==================================================================================================================================
		} else {
									
			// Sign in user if needed
			userLogin ();
			
			dest="<?php echo $destination ?>";
			document.getElementById("fill_id").innerHTML='<input type="hidden" id="id" name="id" value=0>';
			document.getElementById("fill_destination").innerHTML='<input type="hidden" id="destination" name="destination" value="'+dest+'">';
			
			//Topic
			radionow = '<?php echo $str_topic; ?>';
			rad[0][0] = '<input class="person" type="radio" name="topic" value="Entry in country" required';
			rad[0][2] =	'>Entry in country<br>';
			rad[1][0] = '<input class="person" type="radio" name="topic" value="Extend stay in country" required';
			rad[1][2] = '>Extend stay in country<br>';
			rad[2][0] = '<input class="person" type="radio" name="topic" value="Permit" required';
			rad[2][2] = '>Permit<br>';
			rad[3][0] = '<input class="vehicle" type="radio" name="topic" value="Drive own vehicle" required';
			rad[3][2] = '>Drive own vehicle<br>';
			rad[4][0] = '<input class="vehicle" type="radio" name="topic" value="Extend vehicle import" required';
			rad[4][2] = '>Extend vehicle import<br>';
			rad[5][0] = '<input class="vehicle" type="radio" name="topic" value="Store vehicle while leaving" required';
			rad[5][2] = '>Store vehicle while leaving<br>';
			radcnt = 6;
			radopts = ["Entry in country", "Extend stay in country", "Permit", "Drive own vehicle", "Extend vehicle import", "Store vehicle while leaving"];

			rad[0][1] = '';			
			radstr = rad[0][0] + rad[0][1] + rad[0][2];
			document.getElementById("enter_country_entry").innerHTML = radstr;

			rad[1][1] = '';
			radstr = rad[1][0] + rad[1][1] + rad[1][2];
			document.getElementById("extend_person_entry").innerHTML = radstr;

			rad[2][1] = '';
			radstr = rad[2][0] + rad[2][1] + rad[2][2];
			document.getElementById("permit_entry").innerHTML = radstr;

			rad[3][1] = '';
			radstr = rad[3][0] + rad[3][1] + rad[3][2];
			document.getElementById("drive_entry").innerHTML = radstr;
			
			rad[4][1] = '';
			radstr = rad[4][0] + rad[4][1] + rad[4][2];
			document.getElementById("extend_car_entry").innerHTML = radstr;

			rad[5][1] = '';
			radstr = rad[5][0] + rad[5][1] + rad[5][2];
			document.getElementById("store_entry").innerHTML = radstr;

			// Entry type
			radionow = '<?php echo $str_entry_type; ?>';
			rad[0][0] = '<input id="description_entry" type="radio" name="entry_type" value="Description" required';
			rad[0][2] =	'>Topic summary<br>';
			rad[1][0] = '<input id="document_entry" type="radio" name="entry_type" value="Document" required';
			rad[1][2] = '>Document details<br>';
			rad[2][0] = '<input type="radio" name="entry_type" value="Note link" required';		
			rad[2][2] = '>Non-commercial information (governments, wikipedia, ...)<br>';
			rad[3][0] = '<input type="radio" name="entry_type" value="Business link" required';		
			rad[3][2] = '>Commercial information (visa bureaus, travel agencies, ...)<br>';			
			rad[4][0] = '<input type="radio" name="entry_type" value="Comment link" required';
			rad[4][2] = '>Traveler feedback (Facebook, blog, forum, ... - unofficial)<br>';
			radopts = ["Description", "Document", "Note link","Business link", "Comment link"];
			
			rad[0][1] = '';
			radstr = rad[0][0] + rad[0][1] + rad[0][2];
			document.getElementById("description_entry").innerHTML = radstr;

			rad[1][1] = '';
			radstr = rad[1][0] + rad[1][1] + rad[1][2];
			document.getElementById("document_entry").innerHTML = radstr;

			rad[2][1] = '';
			radstr = rad[2][0] + rad[2][1] + rad[2][2];
			document.getElementById("note_link_entry").innerHTML = radstr;

			rad[3][1] = '';
			radstr = rad[3][0] + rad[3][1] + rad[3][2];
			document.getElementById("business_link_entry").innerHTML = radstr;		

			rad[4][1] = '';
			radstr = rad[4][0] + rad[4][1] + rad[4][2];
			document.getElementById("comment_link_entry").innerHTML = radstr;			
			
			//Title			
			document.getElementById("title_string").innerHTML='<input type="text" name="title" id="title" size="39" required style="font-size: 100%">';
			document.getElementById("description_string").innerHTML='<textarea rows="10" cols="41" name="description" id="description"  style="font-size: 100%"></textarea>';
			document.getElementById("link_address_string").innerHTML='<input type="text" name="link_address" id="link_address" size="39"  style="font-size: 100%">';
			document.getElementById("stay_length_string").innerHTML='<input type="text" name="stay_length" id="stay_length" size="39"  style="font-size: 100%">';
			document.getElementById("permit_validity_start_string").innerHTML='<textarea rows="3" cols="41" name="permit_validity_start" id="permit_validity_start" size="39"  style="font-size: 100%"></textarea>';
			document.getElementById("permit_validity_duration_string").innerHTML='<textarea rows="3" cols="41" name="permit_validity_duration" id="permit_validity_duration" size="39"  style="font-size: 100%"></textarea>';			
			document.getElementById("allowance_string").innerHTML='<textarea rows="3" cols="41" name="allowance" id="allowance" size="39"  style="font-size: 100%"></textarea>';				
					
			//Number of uses of the permit
			radionow = '<?php echo $str_uses; ?>';
			rad[0][0] = '<input type="radio" name="uses" value="Single"';
			rad[0][2] =	'>Single<br>';
			rad[1][0] = '<input type="radio" name="uses" value="Double"';
			rad[1][2] = '>Double<br>';
			rad[2][0] = '<input type="radio" name="uses" value="Multiple"';
			rad[2][2] = '>Multiple<br>';
			radcnt = 3;
			radstr="";
			radopts = ["Single", "Double", "Multiple"];
			for (i = 0; i < radcnt; i++) {
				rad[i][1] = '';
				radstr = radstr + rad[i][0] + rad[i][1] + rad[i][2];
			}
			document.getElementById("uses_string").innerHTML = radstr;
			
			document.getElementById("extendable_string").innerHTML='<textarea rows="3" cols="41" name="extendable" id="extendable" size="39"  style="font-size: 100%"></textarea>';			

			//Arrival/departure count		
			rad [0,0] = '<input type="radio" name="arrival_departure_count" value="Count as one">Count as one<br>';
			rad [1,0] = '<input type="radio" name="arrival_departure_count" value="Count as two">Count as two<br>';
			document.getElementById("arrival_string").innerHTML = rad [0,0] + rad [1,0];

			document.getElementById("where_to_get_string").innerHTML='<textarea rows="3" cols="41" name="where_to_get" id="where_to_get" size="39"  style="font-size: 100%"></textarea>';
			document.getElementById("delivery_time_string").innerHTML='<textarea rows="3" cols="41" name="delivery_time" id="delivery_time" size="39"  style="font-size: 100%"></textarea>';				
			document.getElementById("costs_string").innerHTML='<textarea rows="3" cols="41" name="costs" id="costs" size="39"  style="font-size: 100%"></textarea>';				
			document.getElementById("import_permit_string").innerHTML='<textarea rows="3" cols="41" name="import_permit" id="import_permit" size="39"  style="font-size: 100%"></textarea>';
			document.getElementById("drivers_license_string").innerHTML='<textarea rows="3" cols="41" name="drivers_license" id="drivers_license" size="39"  style="font-size: 100%"></textarea>';
			document.getElementById("insurance_string").innerHTML='<textarea rows="3" cols="41" name="insurance" id="insurance" size="39"  style="font-size: 100%"></textarea>';			
			document.getElementById("rhd_string").innerHTML='<textarea rows="3" cols="41" name="rhd" id="rhd" size="39"  style="font-size: 100%"></textarea>';
			document.getElementById("coming_from_string").innerHTML='<textarea rows="3" cols="41" name="coming_from" id="coming_from" size="39"  style="font-size: 100%"></textarea>';
			document.getElementById("nationality_string").innerHTML='<textarea rows="3" cols="41" name="nationality" id="nationality" size="39"  style="font-size: 100%"></textarea>';
			document.getElementById("resident_of_string").innerHTML='<textarea rows="3" cols="41" name="resident_of" id="resident_of" size="39"  style="font-size: 100%"></textarea>';
			document.getElementById("vehicle_registration_string").innerHTML='<input type="text" name="vehicle_registration" id="vehicle_registration" size="39"  style="font-size: 100%">';
			document.getElementById("vehicle_registration_string").innerHTML='<textarea rows="3" cols="41" name="vehicle_registration" id="vehicle_registration" size="39"  style="font-size: 100%"></textarea>';
			document.getElementById("existing_record").style.display = "none"; // Hide for new records doesn't work for some reason
		}

	}
	</script>
	<script>
	function returnString() {
		var dest="<?php echo $destination ?>";
		window.location.assign("retrieve.php?active_destination=" + dest);
	}
	</script>

	<script>

	// Let user sign if he wants to update or add
	function userLogin () {
		document.getElementById("modify_button").style.display="none"; // Hide modify button
		document.getElementById("submit_button").innerHTML=''; 	// Hide submit button.
		document.getElementById("login_button").style.display="block"; 	// Show Google login button and login invitation text
		
		if (user_email != null ) {
			// Valid login in place
			document.getElementById("submit_button").innerHTML='<input type="hidden" id="updated_by" name="updated_by" value=' + user_email + '><input type="submit" value="Submit">';
			document.getElementById("login_button").style.display="none"; 	// Hide Google login button
		}
	}
	
	// Store user email address
	function onSignIn (googleUser) {
		var profile = googleUser.getBasicProfile();
		user_email = profile.getEmail();
		
		// Hide submit button in show record mode, otherwise show it and enter user email in record
		if (display_mode == "show_record") {
			document.getElementById("submit_button").innerHTML=''; 	
		} else {
			document.getElementById("submit_button").innerHTML='<input type="hidden" id="updated_by" name="updated_by" value=' + user_email + '><input type="submit" value="Submit">';
		}
	}

	</script>
</body>
</html>