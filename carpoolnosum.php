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
<link href="css/phone.css" rel="stylesheet" type="text/css"
media="only screen and (max-width:480px)">


</head>
 
<?php

	require_once('carpool/array2xml.php');
	
	//arrays
	$nameArray = ['anna', 'tona', 'carol', 'jimc', 'jimh', 'joel', 'john', 'phil', 'ralph', 'shirley', 'vicky'];
	$rsvpArray = ['','','','','','','','','','',''];
	$statusArray = ['status1','status2','status3'];
	$statusNameArray = ['', '', '']; 
	
	//load file
	$xml=simplexml_load_file("carpool/data.xml") or die("Error: Cannot create object");
	$json_string = json_encode($xml);
	$result = json_decode($json_string, TRUE);
	
	//delete file
	unlink('carpool/data.xml');
	
	//get name list
	function checkData($name, $num, $result){
		if ($result[$name]['rsvp']){
			$GLOBALS['rsvpArray'][$num] = $result[$name]['rsvp'];
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
	  
	//echo $xml->saveXML();
	$xml->save('carpool/data.xml');
	  
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
  <a href="attend_carpool.html" title="Attendance">Attendance</a>&nbsp;&nbsp;&nbsp;
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
  <table width="700" cellspacing="1">
    <tr>
          <td>
          <div align="center">
  <table width="600" border="0" cellspacing="1" cellpadding="0">
    <tr>
		<td><p align="left">Please indicate your availability for <a href="hikes/1331.html">Hike #1331, Chilao to Horse Flats and Mt. Hillyer</a>, on Wednesday, August 9, 2017.</p>
      
		  <p align="left"><font color="#ff0000">IMPORTANT: To avoid inadvertant updating current online data with old "cached" data stored on your device, please click the refresh link on your browser.  The refresh button is a circular arrow and can usually be found on the top address (URL) window.</font></p>
      
        <p align="left">Check yes or no next to your name and click Submit.</p>
        
        <p align="left">The next designated driver(s) are determined by the lowest cumulative passenger-miles accumulated, identified in green.  See <a href="carpool/Driver_Selection.pdf">Driver Selection</a>.</p>
        <p align="left">If the number of hikers exceeds the seating capacity of the primary driver (Driver 1), then the secondary driver (Driver 2) will be assigned based on next lowest cumulative passenger-miles. If designated driver(s) are not hiking this week, then the next available driver(s) will be chosen based on the next driver priority on the <a href="carpool/Driver_Selection.pdf">Driver Selection</a> spreadsheet.</p>
        <p align="left">In general, meeting location will be the home of the primary designated driver.</p>
        <p align="left">For more detailed explanation and instructions on the use of this process, go to <a href="carpool_instructions.html">instructions</a>.</p>   
    <p align="left">Click Submit to save your entry.</p>
          <table width="495" bordercolor="#ababab" border="1" cellspacing="0" cellpadding="3">
          <tbody>
          <p align="left">
          <form name="myform1" method="post">
            <tr>
				<th height="49" colspan="9" scope="col"><p><a href="hikes/1331.html">Hike #1331, Chilao to Horse Flats and Mt. Hillyer</a><br>Wednesday, August 9, 2017</p>
                
              </th>
            </tr>
            <tr>
              <th width="80" scope="col">Name</th>
              <th width="35" scope="col">Seats</th>
              <th width="35" scope="col">Yes</th>
              <th width="35" scope="col">No</th>
              <th width="35" scope="col">No Response</th>
              <th width="35" scope="col">Driver 1</th>             <th width="35" scope="col">Driver 2</th>
              <th width="35" scope="col">Meet</th>
            </tr>
            <tr>
              <td align="center">Anna</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="anna" id="annayes" value="Yes" <?php if ($rsvpArray[0] == 'yes'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="anna" id="annano" value="No" <?php if ($rsvpArray[0] == 'no'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="anna" id="annanr" value="NR" <?php if ($rsvpArray[0] == 'nr'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1anna" value="anna" <?php if ($statusNameArray['0'] == 'anna'){ echo 'checked'; } ?>></td>
              
              <td align="center"><input type="radio" name="driver2" id="driver2anna" value="anna" <?php if ($statusNameArray['1'] == 'anna'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetanna" value="anna" <?php if ($statusNameArray['2'] == 'anna'){ echo 'checked'; } ?>></td>
            </tr>
             
             <tr>
              <td align="center">Antoinette</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="tona" id="tonayes" value="Yes" <?php if ($rsvpArray[1] == 'yes'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="tona" id="tonano" value="No" <?php if ($rsvpArray[1] == 'no'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="tona" id="tonanr" value="NR" <?php if ($rsvpArray[1] == 'nr'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1tona" value="tona" <?php if ($statusNameArray['0'] == 'tona'){ echo 'checked'; } ?>></td>
              
              <td align="center"><input type="radio" name="driver2" id="driver2tona" value="tona" <?php if ($statusNameArray['1'] == 'tona'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meettona" value="tona" <?php if ($statusNameArray['2'] == 'tona'){ echo 'checked'; } ?>></td>
            </tr>
                                     
              <tr>
              <td align="center">Carol</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="carol" id="carolyes" value="Yes" <?php if ($rsvpArray[2] == 'yes'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="carol" id="carolno" value="No" <?php if ($rsvpArray[2] == 'no'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="carol" id="carolnr" value="NR" <?php if ($rsvpArray[2] == 'nr'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1carol" value="carol" <?php if ($statusNameArray['0'] == 'carol'){ echo 'checked'; } ?>></td>
             
              <td align="center"><input type="radio" name="driver2" id="driver2carol" value="carol" <?php if ($statusNameArray['1'] == 'carol'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetcarol" value="carol" <?php if ($statusNameArray['2'] == 'carol'){ echo 'checked'; } ?>></td>
            </tr>
            
            <tr>
              <td align="center">Jim C.</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="jimc" id="jimcyes" value="Yes" <?php if ($rsvpArray[3] == 'yes'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="jimc" id="jimcno" value="No" <?php if ($rsvpArray[3] == 'no'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="jimc" id="jimcnr" value="NR" <?php if ($rsvpArray[3] == 'nr'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1jimc" value="jimc" <?php if ($statusNameArray['0'] == 'jimc'){ echo 'checked'; } ?>></td>
            
              <td align="center"><input type="radio" name="driver2" id="driver2jimc" value="jimc" <?php if ($statusNameArray['1'] == 'jimc'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetjimc" value="jimc" <?php if ($statusNameArray['2'] == 'jimc'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td align="center">Jim H.</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="jimh" id="jimhyes" value="Yes" <?php if ($rsvpArray[4] == 'yes'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="jimh" id="jimhno" value="No" <?php if ($rsvpArray[4] == 'no'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="jimh" id="jimhnr" value="NR" <?php if ($rsvpArray[4] == 'nr'){ echo 'checked'; } ?>></td>
          		<td align="center"><input type="radio" name="driver1" id="driver1jimh" value="jimh" <?php if ($statusNameArray['0'] == 'jimh'){ echo 'checked'; } ?>></td>></td>
             
              <td align="center"><input type="radio" name="driver2" id="driver2jimh" value="jimh" <?php if ($statusNameArray['1'] == 'jimh'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetjimh" value="jimh" <?php if ($statusNameArray['2'] == 'jimh'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td align="center">Joel</td>
              <td align="center">7</td>
              <td align="center"><input type="radio" name="joel" id="joelyes" value="Yes" <?php if ($rsvpArray[5] == 'yes'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="joel" id="joelno" value="No" <?php if ($rsvpArray[5] == 'no'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="joel" id="joelnr" value="NR" <?php if ($rsvpArray[5] == 'nr'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1joel" value="joel" <?php if ($statusNameArray['0'] == 'joel'){ echo 'checked'; } ?>></td>
             
              <td align="center"><input type="radio" name="driver2" id="driver2joel" value="joel" <?php if ($statusNameArray['1'] == 'joel'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetjoel" value="joel" <?php if ($statusNameArray['2'] == 'joel'){ echo 'checked'; } ?>></td>
            </tr>
            
            <tr>
              <td align="center">John</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="john" id="johnyes" value="Yes" <?php if ($rsvpArray[6] == 'yes'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="john" id="johnno" value="No" <?php if ($rsvpArray[6] == 'no'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="john" id="johnnr" value="NR" <?php if ($rsvpArray[6] == 'nr'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1john" value="john" <?php if ($statusNameArray['0'] == 'john'){ echo 'checked'; } ?>></td>
              
              <td align="center"><input type="radio" name="driver2" id="driver2john" value="john" <?php if ($statusNameArray['1'] == 'john'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetjohn" value="john" <?php if ($statusNameArray['2'] == 'john'){ echo 'checked'; } ?>></td>
            </tr>
                      
            <tr>
              <td align="center">Phil</td>
              <td align="center">5/7</td>
              <td align="center"><input type="radio" name="phil" id="philyes" value="Yes" <?php if ($rsvpArray[7] == 'yes'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="phil" id="philno" value="No" <?php if ($rsvpArray[7] == 'no'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="phil" id="philnr" value="NR" <?php if ($rsvpArray[7] == 'nr'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1phil" value="phil" <?php if ($statusNameArray['0'] == 'phil'){ echo 'checked'; } ?>></td>
             
              <td align="center"><input type="radio" name="driver2" id="driver2phil" value="phil" <?php if ($statusNameArray['1'] == 'phil'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetphil" value="phil" <?php if ($statusNameArray['2'] == 'phil'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td align="center">Ralph</td>
              <td align="center">6</td>
              <td align="center"><input type="radio" name="ralph" id="ralphyes" value="Yes" <?php if ($rsvpArray[8] == 'yes'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="ralph" id="ralphno" value="No" <?php if ($rsvpArray[8] == 'no'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="ralph" id="ralphnr" value="NR" <?php if ($rsvpArray[8] == 'nr'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1ralph" value="ralph" <?php if ($statusNameArray['0'] == 'ralph'){ echo 'checked'; } ?>></td>
            
              <td align="center"><input type="radio" name="driver2" id="driver2ralph" value="ralph" <?php if ($statusNameArray['1'] == 'ralph'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetralph" value="ralph" <?php if ($statusNameArray['2'] == 'ralph'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td align="center">Shirley</td>
              <td align="center">7</td>
              <td align="center"><input type="radio" name="shirley" id="shirleyyes" value="Yes" <?php if ($rsvpArray[9] == 'yes'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="shirley" id="shirleyno" value="No" <?php if ($rsvpArray[9] == 'no'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="shirley" id="shirleynr" value="NR" <?php if ($rsvpArray[9] == 'nr'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1shirley" value="shirley" <?php if ($statusNameArray['0'] == 'shirley'){ echo 'checked'; } ?>></td>
          
              <td align="center"><input type="radio" name="driver2" id="driver2shirley" value="shirley" <?php if ($statusNameArray['1'] == 'shirley'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetshirley" value="shirley" <?php if ($statusNameArray['2'] == 'shirley'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td align="center">Vicky</td>
              <td align="center">5</td>
              <td align="center"><input type="radio" name="vicky" id="vickyyes" value="Yes" <?php if ($rsvpArray[10] == 'yes'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="vicky" id="vickyno" value="No" <?php if ($rsvpArray[10] == 'no'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="vicky" id="vickynr" value="NR" <?php if ($rsvpArray[10] == 'nr'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="driver1" id="driver1vicky" value="vicky" <?php if ($statusNameArray['0'] == 'vicky'){ echo 'checked'; } ?>></td>
             
              <td align="center"><input type="radio" name="driver2" id="driver2vicky" value="vicky" <?php if ($statusNameArray['1'] == 'vicky'){ echo 'checked'; } ?>></td>
              <td align="center"><input type="radio" name="meet" id="meetvicky" value="vicky" <?php if ($statusNameArray['2'] == 'vicky'){ echo 'checked'; } ?>></td>
            </tr>
            
            </p>
          </tbody>
        </table>
        <p><strong>Start Time</strong></font></font></p>
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
          </tbody>
        </table>
        
        
		<p align="center"><input type="submit" value="Submit"></p>
		</form>
	  <p align="center"><font color="#ff0000">Please also submit your </font><a href="attend.php">attendance</a>.</p>
      </td>
    </tr>
  </table>
</div>
          </td>
          </tr>
          </table>
          </div>
        
    </div>
  </div><!-- #BeginLibraryItem "/Library/navbar.lbi" --><div id="navigation">
  &nbsp;&nbsp;&nbsp; 
  <a href="index.html" title="Home">Home</a>&nbsp;&nbsp;&nbsp;
  <a href="about.html" title="About">About</a>&nbsp;&nbsp;&nbsp;
  <a href="site_map.html" title="Site-Map">Site-Map</a>&nbsp;&nbsp;&nbsp;
  <a href="schedule.html" title="Schedule">Schedule</a>&nbsp;&nbsp;&nbsp;
  <a href="attend_carpool.html" title="Attendance">Attendance</a>&nbsp;&nbsp;&nbsp;
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
Last updated at 9:12 pm PDT on 08/02/2017<br>


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
