<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="OTP, hiker, hiking">
<meta name="description" content="OTP Hiker - CarPool">
<title>OTP Hiker - West Valley Car Pool Schedule</title>
<link href="css/css_style.css" rel="stylesheet" type="text/css">
<!-- Phone -->
<link href="css/phone.css" rel="stylesheet" type="text/css">

<script>
	//Runs a given function every x milliseconds.  Seconds * 1000 to get the number.
	var interval = setInterval(disableSubmitButtom, 60000);

	function disableSubmitButtom() {
		document.getElementById('submitButton').disabled = true;
		//Enter the disabled button text here
		document.getElementById('submitButton').value = "Please refresh your page";
		document.getElementById('submitButton').style.color = 'red';
		document.getElementById('submitButton').style.fontSize = '15px';
		clearInterval(interval);
	}
</script>
	
</head>
 
	<?php
	
	//set headers to NOT cache a page
  	header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  	header("Pragma: no-cache"); //HTTP 1.0
  	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

	require_once('carpool/array2xml.php');
	
	//arrays
	
	$attendNameArray = ['tsai', 'sahyounie', 'hartungj', 'fashehj', 'rutherford', 'shoukry', 'ferkle', 'feinblatts', 'sahyounis', 'fasheha'];
	
	$nameArray = ['amy', 'elias', 'jimh', 'john', 'phil', 'ralph', 'robert', 'shirley', 'sonia', 'tona'];
	
	$nameMapping = array(
		
		'tsai' => 'amy',
		'sahyounie' => 'elias',
		'hartungj' => 'jimh',
		'fashehj' => 'john',
		'rutherford' => 'phil',
		'shoukry' => 'ralph',
		'ferkle' => 'robert',
		'feinblatts' => 'shirley',
		'sahyounis' => 'sonia',
		'fasheha' => 'tona',
		
	);
	
	$rsvpArray = ['','','','','','','','','',''];
	$statusArray = ['status1','status2','status3'];
	$statusNameArray = ['', '', '']; 
	
	//load file
	$xml=simplexml_load_file("carpool/data.xml") or die("Error: Cannot create object");
	$json_string = json_encode($xml);
	$result = json_decode($json_string, TRUE);
	
	$attendXml=simplexml_load_file("attend/data.xml") or die("Error: Cannot create object");
	$attendJson_string = json_encode($attendXml);
	$attendResult = json_decode($attendJson_string, TRUE);
	
	//get name list
	function checkData($name, $num, $result){
		if ($result[$name]['rsvp']){
			$GLOBALS['rsvpArray'][$num] = $result[$name]['rsvp'];
		}
	}
	
	function checkAttendData($name, $result){
		if ($result[$name]['rsvp']){
			$mappedName = $GLOBALS['nameMapping'][$name]; 
			$key = array_search($mappedName, $GLOBALS['nameArray']);
			$GLOBALS['rsvpArray'][$key] = $result[$name]['rsvp'];
		}
	}
	
	
	//get carpool list
	function checkStatus($status, $num, $result){
		if ($result[$status]){
			$GLOBALS['statusNameArray'][$num] = $result[$status]; 
		}
	}
	
	//saving functions
	function saveRSVP($name, $response){
		$GLOBALS['result'][$name]['rsvp'] = $response;
	}
	function saveAttendRSVP($name, $response){
		$GLOBALS['attendResult'][$name]['rsvp'] = $response;
	}
	function saveStatus($status, $response){
		$GLOBALS['result'][$status] = $response;
	}
	function saveTime($time){
		$GLOBALS['result']['time'] = $time;
	}
	
	foreach ($nameArray as $name){
		if (isset($_POST[$name])){
			if ($_POST[$name] == 'Yes'){
				saveRSVP($name, 'yes');
			}
			else if($_POST[$name] == 'No'){
				saveRSVP($name, 'no');
			}
			else if($_POST[$name] == 'NR'){
				saveRSVP($name, 'nr');
			}
		}
	}
	
	foreach ($attendNameArray as $name){
		$mappedName = $GLOBALS['nameMapping'][$name];
		if (isset($_POST[$mappedName])){
			if ($_POST[$mappedName] == 'Yes'){
				saveAttendRSVP($name, 'yes');
			}
			else if($_POST[$mappedName] == 'No'){
				saveAttendRSVP($name, 'no');
			}
			else if($_POST[$mappedName] == 'NR'){
				saveAttendRSVP($name, 'nr');
			}
		}
	}
	
	foreach ($nameArray as $name){
		if (isset($_POST['driver1'])){
			if ($_POST['driver1'] == $name){
				saveStatus('status1', $name);
			}
		}

		if (isset($_POST['driver2'])){
			if ($_POST['driver2'] == $name){
				saveStatus('status2', $name);
			}	
		}
		if (isset($_POST['meet'])){
			if ($_POST['meet'] == $name){
				saveStatus('status3', $name);
			}	
		}
		else{
			//do nothing
		}
	}
	
	if (isset($_POST['radiostart'])){
		saveTime($_POST['radiostart']);
	}
	
	// Converts PHP Array to XML with the root element being 'root-element-here'
	$xml = Array2XML::createXML('people', $result);
	$attendXml = Array2XML::createXML('people', $attendResult);
	  
	//echo $xml->saveXML();
	$xml->save('carpool/data.xml');
	$attendXml->save('attend/data.xml');
	  
	$iterator = 0;
	foreach ($nameArray as $x){
		checkData($x, $iterator, $result);
		$iterator++;
	}
	
	$iterator = 0;
	foreach ($statusArray as $x){
		checkStatus($x, $iterator, $result);
		$iterator++;
	}

	//repeat with carpool data and replace
	foreach ($attendNameArray as $x){
		checkAttendData($x, $attendResult);
	}
	
?>

<body>
<div id="wrapper">

<!-- #BeginLibraryItem "/Library/header.lbi" -->
<div id="header">OTP &amp; Others<br>
<em>Hiking &amp; Debating Society</em> </div><!-- #EndLibraryItem --><!-- #BeginLibraryItem "/Library/searchbar.lbi" --><div id="search">
                <form method=GET action=http://www.google.com/custom>
                  <table bgcolor=#E89101
                   cellspacing=0 border=0>
                    <tr valign=top>
                      <td> <strong><A HREF=http://www.google.com/search> </A> </strong></td>
                      <td> <strong>

                        <input TYPE=text name=q size=31 maxlength=255 value="">
                        <input type=submit name=sa VALUE="Google Search">
                        <input type=hidden name=cof VALUE="AH:center;GL:0;S:http://www.philrutherford.com;AWFID:50053db864367844;">
                        <font face=arial,sans-serif size=-1>
                        <input type=hidden name=domains value="www.otphiker.com"><br>

                        <input type=radio name=sitesearch value="" checked>
                        </font></strong><font face=arial,sans-serif size=-1><font size="2" face="Verdana, Arial, Helvetica, sans-serif">www</font><strong>
                        <input type=radio name=sitesearch value="www.otphiker.com">
                        </strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">www.otphiker.com</font></font>
                      </td>
                    </tr>
                  </table>
                </form>
              </div><!-- #EndLibraryItem --><!-- #BeginLibraryItem "/Library/navbar.lbi" --><div id="navigation">
  &nbsp;&nbsp;&nbsp; 
  <a href="index.html" title="Home">Home</a>&nbsp;&nbsp;&nbsp;
  <a href="about.html" title="About">About</a>&nbsp;&nbsp;&nbsp;
  <a href="site_map.html" title="Site-Map">Site-Map</a>&nbsp;&nbsp;&nbsp;
  <a href="schedule.html" title="Schedule">Schedule</a>&nbsp;&nbsp;&nbsp;
  <a href="attend.php" title="Attendance">Attendance</a>&nbsp;&nbsp;&nbsp;
  <a href="leader.html" title="Leader">Leader</a>&nbsp;&nbsp;&nbsp;
  <a href="description.html" title="Description">Description</a>&nbsp;&nbsp;&nbsp;
  <a href="history.html" title="History">History</a>&nbsp;&nbsp;&nbsp;
  <a href="database.html" title="Database">Database</a>&nbsp;&nbsp;&nbsp;
  <a href="safety.html" title="Safety">Safety</a>&nbsp;&nbsp;&nbsp;
  <a href="site_information.html" title="Site-Information">Site-Information</a>&nbsp;&nbsp;&nbsp;
  <a href="notices.html" title="News & Notices">News/Notices</a>&nbsp;&nbsp;&nbsp;
  <a href="trip_plan.html" title="Trip-Plan">Trip-Plan</a>&nbsp;&nbsp;&nbsp;
  <a href="links.html" title="External Links">Links</a>&nbsp;&nbsp;&nbsp;
  <a href="photos.html" title="Photos">Photos</a>&nbsp;&nbsp;&nbsp;
  <a href="photos.html" title="Videos">Videos</a>&nbsp;&nbsp;&nbsp;
  
  <a href="mikes_page.html" title="Mike's Page">Mike's Page</a>&nbsp;&nbsp;&nbsp;
  
  <a href="Memorial.html" title="Memorial">Memorial</a>&nbsp;&nbsp;&nbsp;
  <a href="contacts.html" title="Contacts">Contacts
  </a>
  </div><!-- #EndLibraryItem --><!--  Body Text   --> 
  
 <div id="body_text">
 <div id="body_inner">
	 
      
<h1>WEST VALLEY CAR POOL SCHEDULE</h1>
<div align="center">
 
  <table width="600" border="0" cellspacing="1" cellpadding="5">
    <tr>
		<td>
			
			
			<p align="left">Please indicate your availability for next week's hike.</p>
			
			
      
			<p align="left"><strong><font color="#ff0000">IMPORTANT: To avoid inadvertent updating current online data with old "cached" data stored on your device, please click the refresh button on your browser BEFORE entering your seletion and submitting.  The refresh button is a circular arrow and can usually be found next to the top address (URL) window.</font></strong></p>
      
        <p align="left">Check yes or no next to your name and click Submit.</p>
        
        <p align="left">The next designated driver(s) are determined by the lowest cumulative passenger-miles accumulated, identified in green.  See <a href="carpool/Driver_Selection.pdf">Driver Selection</a>.</p>
        <p align="left">If the number of hikers exceeds the seating capacity of the primary driver (Drive 1), then the secondary driver (Drive 2) will be assigned based on next lowest cumulative passenger-miles. If designated driver(s) are not hiking this week, then the next available driver(s) will be chosen based on the next driver priority on the <a href="carpool/Driver_Selection.pdf">Driver Selection</a> spreadsheet.</p>
        <p align="left">In general, meeting location will be the home of the primary designated driver.</p>
        <p align="left">For more detailed explanation and instructions on the use of this process, go to <a href="carpool_instructions.html">instructions</a>.</p>   
			<p align="left">Click the Submit button to save your entry.</p>
			<table width="90%" bordercolor="#ababab" border="1" cellspacing="0" cellpadding="3">
          <tbody>
          
          <form name="myform1" method="post">
            <tr>
				<th height="49" colspan="9" scope="col">
					
					
         <p><a href="hikes/1526.html">Hike #1526 Strawberry Peak Circumnavigation</a><br>
					  Wednesday, May 10, 2023<br>
					  
					  				  </p>		  
					
                
              </th>
            </tr>
            <tr>
              <th width="80" scope="col">Name</th>
              <th width="35" scope="col">Seats</th>
              <th width="35" scope="col">Yes</th>
              <th width="35" scope="col">No</th>
              <th width="35" scope="col">Silent</th>
              <th width="35" scope="col">Drive 1</th>
			  <th width="35" scope="col">Drive 2</th>
              <th width="35" scope="col">Meet</th>
            </tr>
            
            <?php 
            $yes = 0;
            $no = 0;
            $nr = 0;
			$index = 0;
			?>
            
            <tr>
              <td align="center">Amy</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="amy" id="amyyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="amy" id="amyno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="amy" id="amynr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1amy" value="amy" <?php if ($statusNameArray['0'] == 'amy'){ echo 'checked'; } ?>></td>
              
              <td align="center"><input type="radio" name="driver2" id="driver2amy" value="amy" <?php if ($statusNameArray['1'] == 'amy'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetamy" value="amy" <?php if ($statusNameArray['2'] == 'amy'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
			  
			  
             <tr>
              <td align="center">Elias</td>
              <td align="center">4</td>
              <td align="center"><input type="radio" name="elias" id="eliasyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="elias" id="eliasno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="elias" id="eliasnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1elias" value="elias" <?php if ($statusNameArray['0'] == 'elias'){ echo 'checked'; } ?>></td>
              
              <td align="center"><input type="radio" name="driver2" id="driver2elias" value="elias" <?php if ($statusNameArray['1'] == 'elias'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetelias" value="elias" <?php if ($statusNameArray['2'] == 'elias'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
             
                                     
              
			  
			  
			  			           
            
            
            <tr>
              <td align="center">Jim H.</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="jimh" id="jimhyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="jimh" id="jimhno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="jimh" id="jimhnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
          		<td align="center"><input type="radio" name="driver1" id="driver1jimh" value="jimh" <?php if ($statusNameArray['0'] == 'jimh'){ echo 'checked'; } ?>></td>
             
              <td align="center"><input type="radio" name="driver2" id="driver2jimh" value="jimh" <?php if ($statusNameArray['1'] == 'jimh'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetjimh" value="jimh" <?php if ($statusNameArray['2'] == 'jimh'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
			  
			  
            
            
            
            <tr>
              <td align="center">John</td>
              <td align="center">6</td>
              <td align="center"><input type="radio" name="john" id="johnyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="john" id="johnno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="john" id="johnnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1john" value="john" <?php if ($statusNameArray['0'] == 'john'){ echo 'checked'; } ?>></td>
              
              <td align="center"><input type="radio" name="driver2" id="driver2john" value="john" <?php if ($statusNameArray['1'] == 'john'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetjohn" value="john" <?php if ($statusNameArray['2'] == 'john'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
			
			
                      
            <tr>
              <td align="center">Phil</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="phil" id="philyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="phil" id="philno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="phil" id="philnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1phil" value="phil" <?php if ($statusNameArray['0'] == 'phil'){ echo 'checked'; } ?>></td>
             
              <td align="center"><input type="radio" name="driver2" id="driver2phil" value="phil" <?php if ($statusNameArray['1'] == 'phil'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetphil" value="phil" <?php if ($statusNameArray['2'] == 'phil'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td align="center">Ralph</td>
              <td align="center">6</td>
              <td align="center"><input type="radio" name="ralph" id="ralphyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="ralph" id="ralphno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="ralph" id="ralphnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1ralph" value="ralph" <?php if ($statusNameArray['0'] == 'ralph'){ echo 'checked'; } ?>></td>
            
              <td align="center"><input type="radio" name="driver2" id="driver2ralph" value="ralph" <?php if ($statusNameArray['1'] == 'ralph'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetralph" value="ralph" <?php if ($statusNameArray['2'] == 'ralph'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
			
			<tr>
              <td align="center">Robert</td>
              <td align="center">4</td>
              <td align="center"><input type="radio" name="robert" id="robertyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="robert" id="robertno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="robert" id="robertnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1robert" value="robert" <?php if ($statusNameArray['0'] == 'robert'){ echo 'checked'; } ?>></td>
            
              <td align="center"><input type="radio" name="driver2" id="driver2robert" value="robert" <?php if ($statusNameArray['1'] == 'robert'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetrobert" value="robert" <?php if ($statusNameArray['2'] == 'robert'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td align="center">Shirley</td>
              <td align="center">7</td>
              <td align="center"><input type="radio" name="shirley" id="shirleyyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="shirley" id="shirleyno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="shirley" id="shirleynr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1shirley" value="shirley" <?php if ($statusNameArray['0'] == 'shirley'){ echo 'checked'; } ?>></td>
          
              <td align="center"><input type="radio" name="driver2" id="driver2shirley" value="shirley" <?php if ($statusNameArray['1'] == 'shirley'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetshirley" value="shirley" <?php if ($statusNameArray['2'] == 'shirley'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
			  
			  <tr>
              <td align="center">Sonia</td>
              <td align="center">4</td>
              <td align="center"><input type="radio" name="sonia" id="soniayes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="sonia" id="soniano" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="sonia" id="sonianr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1sonia" value="sonia" <?php if ($statusNameArray['0'] == 'sonia'){ echo 'checked'; } ?>></td>
          
              <td align="center"><input type="radio" name="driver2" id="driver2sonia" value="sonia" <?php if ($statusNameArray['1'] == 'sonia'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetsonia" value="sonia" <?php if ($statusNameArray['2'] == 'sonia'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
			  
			  
			  <tr>
              <td align="center">Tona</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="tona" id="tonayes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="tona" id="tonano" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="tona" id="tonanr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1tona" value="tona" <?php if ($statusNameArray['0'] == 'tona'){ echo 'checked'; } ?>></td>
              
              <td align="center"><input type="radio" name="driver2" id="driver2tona" value="tona" <?php if ($statusNameArray['1'] == 'tona'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meettona" value="tona" <?php if ($statusNameArray['2'] == 'tona'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            
            
            <tr>
              <td width="80" align="right"><strong>Totals</strong></td>
              <td width="35" align="center">-</td>
             
              <td width="35" align="center"> <?php echo $yes ?> </td>
              <td width="35" align="center"> <?php echo $no ?> </td>
              <td width="35" align="center"> <?php echo $nr ?> </td>
              <td width="35" align="center">-</td>
              <td width="35" align="center">-</td>
              <td width="35" align="center">-</td>
            </tr>
            
            </p>
          </tbody>
        </table>
	 <p><strong>Start Time</strong></p>
        <table width="268" bordercolor="#ababab" border="1" cellspacing="0" cellpadding="3">
          <tbody>
            <tr>
              <td align="center" width="45">6:30</td>
              <td align="center" width="45">6:45</td>
              <td align="center" width="45">7:00</td>
              <td align="center" width="45">7:15</td>
              <td align="center" width="45">7:30</td>
              <td align="center" width="45">7:45</td>
              <td align="center" width="45">8:00</td>
              <td align="center" width="45">8:15</td>
              <td align="center" width="45">8:30</td>
              <td align="center" width="45">8:45</td>
            </tr>
            <tr>
              <td align="center"><input type="radio" name="radiostart" id="630" value="630" <?php if ($result['time'] == '630'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="radiostart" id="645" value="645" <?php if ($result['time'] == '645'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="radiostart" id="700" value="700" <?php if ($result['time'] == '700'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="radiostart" id="715" value="715" <?php if ($result['time'] == '715'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="radiostart" id="730" value="730" <?php if ($result['time'] == '730'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="radiostart" id="745" value="745" <?php if ($result['time'] == '745'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="radiostart" id="800" value="800" <?php if ($result['time'] == '800'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="radiostart" id="815" value="815" <?php if ($result['time'] == '815'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="radiostart" id="830" value="830" <?php if ($result['time'] == '830'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="radiostart" id="845" value="845" <?php if ($result['time'] == '845'){ echo 'checked'; } ?>></td>
            </tr>
	</table>
          </tbody>
        </table>
        
	<p align+"center"><font color="#ff0000"><strong>BEFORE YOU MAKE YOUR SELECTION, PLEASE REFRESH THIS PAGE
	  BY CLICKING THE CIRCULAR ARROW IN THE BROWSER ADDRESS WINDOW.<br>
	  YOU THEN HAVE ONE MINUTE TO SUBMIT YOUR SELECTION.
	</strong></font></p>
		<p align="center"><input id="submitButton" type="submit" value="Submit"></p>
		
	  <p align="center"><font color="#ff0000">Congratulations, you have also submitted your </font><a href="attend.php">attendance</a>.</p>
      </td>
</tr>
  </table>
	<br>
</div>       
    </div>
  </div><!-- #BeginLibraryItem "/Library/navbar.lbi" --><div id="navigation">
  &nbsp;&nbsp;&nbsp; 
  <a href="index.html" title="Home">Home</a>&nbsp;&nbsp;&nbsp;
  <a href="about.html" title="About">About</a>&nbsp;&nbsp;&nbsp;
  <a href="site_map.html" title="Site-Map">Site-Map</a>&nbsp;&nbsp;&nbsp;
  <a href="schedule.html" title="Schedule">Schedule</a>&nbsp;&nbsp;&nbsp;
  <a href="attend.php" title="Attendance">Attendance</a>&nbsp;&nbsp;&nbsp;
  <a href="leader.html" title="Leader">Leader</a>&nbsp;&nbsp;&nbsp;
  <a href="description.html" title="Description">Description</a>&nbsp;&nbsp;&nbsp;
  <a href="history.html" title="History">History</a>&nbsp;&nbsp;&nbsp;
  <a href="database.html" title="Database">Database</a>&nbsp;&nbsp;&nbsp;
  <a href="safety.html" title="Safety">Safety</a>&nbsp;&nbsp;&nbsp;
  <a href="site_information.html" title="Site-Information">Site-Information</a>&nbsp;&nbsp;&nbsp;
  <a href="notices.html" title="News & Notices">News/Notices</a>&nbsp;&nbsp;&nbsp;
  <a href="trip_plan.html" title="Trip-Plan">Trip-Plan</a>&nbsp;&nbsp;&nbsp;
  <a href="links.html" title="External Links">Links</a>&nbsp;&nbsp;&nbsp;
  <a href="photos.html" title="Photos">Photos</a>&nbsp;&nbsp;&nbsp;
  <a href="photos.html" title="Videos">Videos</a>&nbsp;&nbsp;&nbsp;
  
  <a href="mikes_page.html" title="Mike's Page">Mike's Page</a>&nbsp;&nbsp;&nbsp;
  
  <a href="Memorial.html" title="Memorial">Memorial</a>&nbsp;&nbsp;&nbsp;
  <a href="contacts.html" title="Contacts">Contacts
  </a>
  </div><!-- #EndLibraryItem --><div id="footer">
  
  <div id="footer_left">
Copyright &copy; 1983-2022 OTP Hiker<br>
Last updated at 5:12 pm PDT on 05/03/2023<br>


</div>

<!--  End Body Text   -->

  
  

</div>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="new/js/bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
_uacct = "UA-2679891-3";
urchinTracker();
</script>

<!-- #BeginLibraryItem "/Library/target_blank.lbi" -->
<script> jQuery(document.links)   .filter(function() {     return this.hostname != window.location.hostname;   })     .attr('target', '_blank'); </script>
<!-- #EndLibraryItem --> 

</div></body>
</html>
