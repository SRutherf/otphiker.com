<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="OTP, hiker, hiking">
<meta name="description" content="OTP Hiker - Attendance">
<title>OTP Hiker - Attendance</title>
<link href="css/css_style.css" rel="stylesheet" type="text/css">
<!-- Phone -->
<link href="css/phone.css" rel="stylesheet" type="text/css"
media="only screen and (max-width:480px)">


</head>
	
	<?php

	require_once('attend/array2xml.php');
	
	//arrays
	
	$nameArray = ['babcock', 'bassett', 'baumgart', 'bergstromd', 'cahill', 'carlinj', 'carlinm', 'chady', 'costello', 'dewolf', 'dillenback', 'fasheha', 'fashehj', 'fassnacht', 'feinblattj', 'feinblatts', 'ferkle', 'frederick', 'gardnerja', 'gardnerji', 'hartungj', 'kaczmarek', 'kingd', 'kingr', 'martin', 'morton', 'noguer', 'obert', 'piekunka', 'prum', 'ritter', 'rutherford', 'sanchez', 'savell', 'shoukry', 'singer', 'spotts', 'suzuki'];
	
	$carNameArray = ['tona', 'jimc', 'jimh', 'joel', 'john', 'margie', 'phil', 'ralph', 'shirley'];
	
	$nameMapping = array(
		
		'tona' => 'fasheha',
		
		'jimc' => 'carlinj',
		'jimh' => 'hartungj',
		'joel' => 'feinblattj',
		'john' => 'fashehj',
		'margie' => 'carlinm',
		'phil' => 'rutherford',
		'ralph' => 'shoukry',
		'shirley' => 'feinblatts',
		
	);
	
	$rsvpArray = ['','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''];
	
	
	//load file
	$xml=simplexml_load_file("attend/data.xml") or die("Error: Cannot create object");
	$json_string = json_encode($xml);
	$result = json_decode($json_string, TRUE);
	
	$carXml=simplexml_load_file("carpool/data.xml") or die("Error: Cannot create object");
	$carJson_string = json_encode($carXml);
	$carResult = json_decode($carJson_string, TRUE);
	
	//delete file
	//unlink('carpool/data.xml');
	
	//delete file
	//unlink('attend/data.xml');
	
	//get name list
	function checkData($name, $num, $result){
		if ($result[$name]['rsvp']){
			$GLOBALS['rsvpArray'][$num] = $result[$name]['rsvp'];
		}
	}
	
	function checkCarData($name, $result){
		if ($result[$name]['rsvp']){
			$mappedName = $GLOBALS['nameMapping'][$name]; 
			$key = array_search($mappedName, $GLOBALS['nameArray']);
			$GLOBALS['rsvpArray'][$key] = $result[$name]['rsvp'];
		}
	}
	
		
	//saving functions
	function saveRSVP($name, $response){
		$GLOBALS['result'][$name]['rsvp'] = $response;
	}
	function saveCarRSVP($name, $response){
		$GLOBALS['carResult'][$name]['rsvp'] = $response;
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
	
	foreach ($carNameArray as $name){
		$mappedName = $GLOBALS['nameMapping'][$name];
		if (isset($_POST[$mappedName])){
			if ($_POST[$mappedName] == 'Yes'){
				saveCarRSVP($name, 'yes');
			}
			else if($_POST[$mappedName] == 'No'){
				saveCarRSVP($name, 'no');
			}
			else if($_POST[$mappedName] == 'NR'){
				saveCarRSVP($name, 'nr');
			}
		}
	}
	
	
	
	// Converts PHP Array to XML with the root element being 'root-element-here'
	$xml = Array2XML::createXML('people', $result);
	$carXml = Array2XML::createXML('people', $carResult);
	  
	//echo $xml->saveXML();
	$xml->save('attend/data.xml');
	$carXml->save('carpool/data.xml');
	  
	$iterator = 0;
	foreach ($nameArray as $x){
		checkData($x, $iterator, $result);
		$iterator++;
	}
	
	//repeat with carpool data and replace
	foreach ($carNameArray as $x){
		checkCarData($x, $carResult);
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
  </div><!-- #EndLibraryItem --><div id="body_text">
<div id="body_inner">
  
<h1>ATTENDANCE FOR THE NEXT HIKE</h1>
  

<div align="center">
  <table width="600" border="0" cellspacing="1" cellpadding="5">
    <tr>
		<td>
			
			
			<p align="left">Please indicate your availability for next week's hike.</p>
			
			
      
		  <p align="left"><strong>IMPORTANT: To avoid inadvertant updating current online data with old "cached" data stored on your device, please click the refresh link on your browser.  The refresh button is a circular arrow and can usually be found on the top address (URL) window.</strong></p>
      
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
					
					
					<p><a href="hikes/1446.html">Hike #1446 Forrestal/Portuguese Bend Reserves</a><br>Wednesday, July 14, 2021</p>
					
                
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
              <td align="center">Antoinette</td>
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
              <td align="center">Jim C.</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="jimc" id="jimcyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="jimc" id="jimcno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="jimc" id="jimcnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1jimc" value="jimc" <?php if ($statusNameArray['0'] == 'jimc'){ echo 'checked'; } ?>></td>
            
              <td align="center"><input type="radio" name="driver2" id="driver2jimc" value="jimc" <?php if ($statusNameArray['1'] == 'jimc'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetjimc" value="jimc" <?php if ($statusNameArray['2'] == 'jimc'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td align="center">Jim H.</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="jimh" id="jimhyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="jimh" id="jimhno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="jimh" id="jimhnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
          		<td align="center"><input type="radio" name="driver1" id="driver1jimh" value="jimh" <?php if ($statusNameArray['0'] == 'jimh'){ echo 'checked'; } ?>></td>></td>
             
              <td align="center"><input type="radio" name="driver2" id="driver2jimh" value="jimh" <?php if ($statusNameArray['1'] == 'jimh'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetjimh" value="jimh" <?php if ($statusNameArray['2'] == 'jimh'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td align="center">Joel</td>
              <td align="center">7</td>
              <td align="center"><input type="radio" name="joel" id="joelyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="joel" id="joelno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="joel" id="joelnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1joel" value="joel" <?php if ($statusNameArray['0'] == 'joel'){ echo 'checked'; } ?>></td>
             
              <td align="center"><input type="radio" name="driver2" id="driver2joel" value="joel" <?php if ($statusNameArray['1'] == 'joel'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetjoel" value="joel" <?php if ($statusNameArray['2'] == 'joel'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td align="center">John</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="john" id="johnyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="john" id="johnno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="john" id="johnnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1john" value="john" <?php if ($statusNameArray['0'] == 'john'){ echo 'checked'; } ?>></td>
              
              <td align="center"><input type="radio" name="driver2" id="driver2john" value="john" <?php if ($statusNameArray['1'] == 'john'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetjohn" value="john" <?php if ($statusNameArray['2'] == 'john'){ echo 'checked'; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
			
			<tr>
              <td align="center">Margie</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="margie" id="margieyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="margie" id="margieno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="margie" id="margienr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1margie" value="margie" <?php if ($statusNameArray['0'] == 'margie'){ echo 'checked'; } ?>></td>
              
              <td align="center"><input type="radio" name="driver2" id="driver2margie" value="margie" <?php if ($statusNameArray['1'] == 'margie'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetmargie" value="margie" <?php if ($statusNameArray['2'] == 'margie'){ echo 'checked'; } ?>></td>
              
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
              <td align="center">Vicky</td>
              <td align="center">-</td>
              <td align="center"><input type="radio" name="vicky" id="vickyyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              <td align="center"><input type="radio" name="vicky" id="vickyno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              <td align="center"><input type="radio" name="vicky" id="vickynr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1vicky" value="vicky" <?php if ($statusNameArray['0'] == 'vicky'){ echo 'checked'; } ?>></td>
          
              <td align="center"><input type="radio" name="driver2" id="driver2vicky" value="vicky" <?php if ($statusNameArray['1'] == 'vicky'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetvicky" value="vicky" <?php if ($statusNameArray['2'] == 'vicky'){ echo 'checked'; } ?>></td>
              
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
  <input type="submit" title="Submit Your Choice" value="Submit Your Choice" color="#FFE085">
  
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
Copyright &copy; 1989-Present -  OTP Hiker<br>
Last updated at 7:36 pm PDT on 07/07/2021<br>

</div>

<!--  End Body Text   --> 

</div>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2679891-3";
urchinTracker();
</script>

<!-- #BeginLibraryItem "/Library/target_blank.lbi" -->
<script> jQuery(document.links)   .filter(function() {     return this.hostname != window.location.hostname;   })     .attr('target', '_blank'); </script>
<!-- #EndLibraryItem -->

</div>
</body>
</html>
