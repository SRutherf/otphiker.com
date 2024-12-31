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

	require_once('attend/array2xml.php');
	
	//arrays
	
	$nameArray = ['anderson', 'babcock', 'baumgart', 'bergstromd', 'cahill', 'camacho', 'dewolf', 'dillenback', 'domingo', 'fasheha', 'fashehj', 'fassnacht', 'feinblatts', 'ferkle', 'frederick', 'gardnerja', 'gardnerji', 'goislard', 'hartungj', 'kaczmarek', 'kingd', 'kingr', 'lam', 'leete', 'liu', 'lum', 'martin', 'mascarenhas', 'mcdiarmid', 'morton', 'neff', 'noguer', 'obert', 'prum', 'rutherford', 'sahyounie', 'sahyounis', 'sanchez', 'shoukry', 'singer', 'suzuki', 'tatum', 'tillotson', 'tsai', 'unger', 'wolff'];
	
	$carNameArray = ['amy', 'angela', 'elias', 'jimh', 'john', 'patty', 'phil', 'ralph', 'robert', 'shirley', 'sonia', 'tona'];
	
	$nameMapping = array(
		
		'amy' => 'tsai',
		'angela' => 'neff',
		'elias' => 'sahyounie',
		'jimh' => 'hartungj',
		'john' => 'fashehj',
		'patty' => 'liu',
		'phil' => 'rutherford',
		'ralph' => 'shoukry',
		'robert' => 'ferkle',
		'shirley' => 'feinblatts',
		'sonia' => 'sahyounis',
		'tona' => 'fasheha',
		
	);
	
	$rsvpArray = ['','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''];
	
	
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
		  
		  
		  <p align="left">If you wish, you may let your fellow hikers know if you plan on attending next week's hike.</p>
		  
		  <p align="left"><strong><font color="#ff0000">IMPORTANT: To avoid inadvertent updating current online data with old "cached" data stored on your device, please click the refresh button on your browser BEFORE entering your seletion and submitting.  The refresh button is a circular arrow and can usually be found next to the top address (URL) window.</font></strong></p>
		  
		  <p align="left">Check &quot;Yes&quot; or &quot;No&quot; next to your name and click the &quot;Submit Your Choice&quot; button at the bottom of the page.</p>
		  <table width="90%" bordercolor="#ababab" border="1" cellspacing="0" cellpadding="3">
		    <tbody>            
            
            <form name="myform1" method="post"> 
             <tr>
              <th height="49" colspan="9" scope="col">
				  
				  
				  <p><a href="hikes/1554.html">Hike #1554 Griffith Park - Mineral Springs</a><br>
					  Wednesday, December 13, 2023<br>
					                    </p>
				  
				 
				 </th>
            </tr>
            <tr>
              <th width="292" scope="col">Name</th>
              
              <th width="112" scope="col">Yes</th>
              <th width="112" scope="col">No</th>
              <th width="112" scope="col"><p>Silent
              </p></th>
              
            </tr>
            
            <?php 
            $yes = 0;
            $no = 0;
            $nr = 0;
			$index = 0;
			?>
            
				
			<tr>
              <td width="292">Anderson, Niamh</td>
              
              <td width="112" align="center"><input type="radio" name="anderson" id="andersonyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="anderson" id="andersonno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="anderson" id="andersonnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
            <tr>
              <td width="292">Babcock, Steve</td>
              
              <td width="112" align="center"><input type="radio" name="babcock" id="babcockyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="babcock" id="babcockno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="babcock" id="babcocknr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
              				
			<tr>
              <td width="292">Baumgart, Ted</td>
             
              <td width="112" align="center"><input type="radio" name="baumgart" id="baumgartyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="baumgart" id="baumgartno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="baumgart" id="baumgartnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>		
				
				
            <tr>
              <td width="292">Bergstrom, Dan</td>
             
              <td width="112" align="center"><input type="radio" name="bergstromd" id="bergstromdyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="bergstromd" id="bergstromdno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="bergstromd" id="bergstromdnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            <tr>
              <td width="292">Cahill, Marryl</td>
             
              <td width="112" align="center"><input type="radio" name="cahill" id="cahillyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="cahill" id="cahillno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="cahill" id="cahillnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
          
            </tr>
            
				
			<tr>
              <td width="292">Camacho, Mariana</td>
             
              <td width="112" align="center"><input type="radio" name="camacho" id="camachoyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="camacho" id="camachono" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="camacho" id="camachonr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
          
            </tr>	
            
                       
			
				
            
            <tr>
              <td width="292">De Wolf, Bob</td>
              
              <td width="112" align="center"><input type="radio" name="dewolf" id="dewolfyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="dewolf" id="dewolfno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="dewolf" id="dewolfnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
				
				<tr>
              <td width="292">Dillenback, Mike</td>
              
              <td width="112" align="center"><input type="radio" name="dillenback" id="dillenbackyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="dillenback" id="dillenbackno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="dillenback" id="dillenbacknr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
				<tr>
              <td width="292">Domingo, Maria</td>
              
              <td width="112" align="center"><input type="radio" name="domingo" id="domingoyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="domingo" id="domingono" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="domingo" id="domingonr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>	
				
				
            <tr>
              <td width="292">Fasheh, Antoinette</td>
             
              <td width="112" align="center"><input type="radio" name="fasheha" id="fashehayes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="fasheha" id="fashehano" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="fasheha" id="fashehanr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Fasheh, John</td>
             
              <td width="112" align="center"><input type="radio" name="fashehj" id="fashehjyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="fashehj" id="fashehjno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="fashehj" id="fashehjnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Fassnacht, Dennis</td>
             
              <td width="112" align="center"><input type="radio" name="fassnacht" id="fassnachtyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="fassnacht" id="fassnachtno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="fassnacht" id="fassnachtnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            
            
            <tr>
              <td width="292">Feinblatt, Shirley</td>
             
              <td width="112" align="center"><input type="radio" name="feinblatts" id="feinblattsyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="feinblatts" id="feinblattsno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="feinblatts" id="feinblattsnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            
            <tr>
              <td width="292">Ferkle, Robert</td>
             
              <td width="112" align="center"><input type="radio" name="ferkle" id="ferkleyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="ferkle" id="ferkleno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="ferkle" id="ferklenr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            
            
            
            <tr>
              <td width="292">Frederick, Rich</td>
             
              <td width="112" align="center"><input type="radio" name="frederick" id="frederickyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="frederick" id="frederickno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="frederick" id="fredericknr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Gardner, Jan</td>
             
              <td width="112" align="center"><input type="radio" name="gardnerja" id="gardnerjayes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="gardnerja" id="gardnerjano" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="gardnerja" id="gardnerjanr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Gardner, Jim</td>
             
              <td width="112" align="center"><input type="radio" name="gardnerji" id="gardnerjiyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="gardnerji" id="gardnerjino" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="gardnerji" id="gardnerjinr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Goislard, Marie-Paule</td>
             
              <td width="112" align="center"><input type="radio" name="goislard" id="goislardyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="goislard" id="goislardno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              
              <td width="112" align="center"><input type="radio" name="goislard" id="goislardnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            
            
            
            
            
            <tr>
              <td width="292">Hartung, Jim</td>
             
              <td width="112" align="center"><input type="radio" name="hartungj" id="hartungjyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="hartungj" id="hartungjno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              
              <td width="112" align="center"><input type="radio" name="hartungj" id="hartungjnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            
            
            <tr>
              <td width="292">Kaczmarek, Tom</td>
             
              <td width="112" align="center"><input type="radio" name="kaczmarek" id="kaczmarekyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="kaczmarek" id="kaczmarekno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="kaczmarek" id="kaczmareknr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">King, Dorothy</td>
             
              <td width="112" align="center"><input type="radio" name="kingd" id="kingdyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="kingd" id="kingdno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="kingd" id="kingdnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
				
			<tr>
              <td width="292">King, Randy</td>
             
              <td width="112" align="center"><input type="radio" name="kingr" id="kingryes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="kingr" id="kingrno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="kingr" id="kingrnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
					<tr>
              <td width="292">Lam, Kitty</td>
             
              <td width="112" align="center"><input type="radio" name="lam" id="lamyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="lam" id="lamno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="lam" id="lamnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Leete, John</td>
             
              <td width="112" align="center"><input type="radio" name="leete" id="leeteyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="leete" id="leeteno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="leete" id="leetenr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
			
				<tr>
              <td width="292">Liu, Patty</td>
             
              <td width="112" align="center"><input type="radio" name="liu" id="liuyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="liu" id="liuno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="liu" id="liunr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
			
            
            <tr>
              <td width="292">Lum, Annette</td>
             
              <td width="112" align="center"><input type="radio" name="lum" id="lumyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="lum" id="lumno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="lum" id="lumnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
				
				<tr>
              <td width="292">Martin, Rick</td>
             
              <td width="112" align="center"><input type="radio" name="martin" id="martinyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="martin" id="martinno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="martin" id="martinnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
				<tr>
              <td width="292">Mascarenhas, Sheridan</td>
             
              <td width="112" align="center"><input type="radio" name="mascarenhas" id="mascarenhasyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="mascarenhas" id="mascarenhasno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="mascarenhas" id="mascarenhasnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr> 
				
				<tr>
              <td width="292">McDiarmid, Andrew</td>
             
              <td width="112" align="center"><input type="radio" name="mcdiarmid" id="mcdiarmidyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="mcdiarmid" id="mcdiarmidno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="mcdiarmid" id="mcdiarmidnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
				
				
            
            <tr>
              <td width="292">Morton, John</td>
             
              <td width="112" align="center"><input type="radio" name="morton" id="mortonyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="morton" id="mortonno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="morton" id="mortonnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
			<tr>
              <td width="292">Neff, Angela</td>
             
              <td width="112" align="center"><input type="radio" name="neff" id="neffyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="neff" id="neffno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="neff" id="neffnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>	
				
            
            <tr>
              <td width="292">Noguer, Veronica</td>
             
              <td width="112" align="center"><input type="radio" name="noguer" id="nogueryes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="noguer" id="noguerno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="noguer" id="noguernr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Obert, Ron</td>
             
              <td width="112" align="center"><input type="radio" name="obert" id="obertyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="obert" id="obertno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="obert" id="obertnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            
            
            <tr>
              <td width="292">Prum, Sam</td>
             
              <td width="112" align="center"><input type="radio" name="prum" id="prumyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="prum" id="prumno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="prum" id="prumnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            
            
            <tr>
              <td width="292">Rutherford, Phil</td>
             
              <td width="112" align="center"><input type="radio" name="rutherford" id="rutherfordyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="rutherford" id="rutherfordno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="rutherford" id="rutherfordnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
				<tr>
              <td width="292">Sahyouni, Elias</td>
             
              <td width="112" align="center"><input type="radio" name="sahyounie" id="sahyounieyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="sahyounie" id="sahyounieno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="sahyounie" id="sahyounienr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
				<tr>
              <td width="292">Sahyouni, Sonia</td>
             
              <td width="112" align="center"><input type="radio" name="sahyounis" id="sahyounisyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="sahyounis" id="sahyounisno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="sahyounis" id="sahyounisnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
				
				
			<tr>
              <td width="292">Sanchez, Randy</td>
             
              <td width="112" align="center"><input type="radio" name="sanchez" id="sanchezyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="sanchez" id="sanchezno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="sanchez" id="sancheznr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>	
				
            
                       
            
            
            <tr>
              <td width="292">Shoukry, Ralph</td>
             
              <td width="112" align="center"><input type="radio" name="shoukry" id="shoukryyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="shoukry" id="shoukryno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="shoukry" id="shoukrynr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Singer, Bob</td>
             
              <td width="112" align="center"><input type="radio" name="singer" id="singeryes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="singer" id="singerno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="singer" id="singernr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
           
            
                      
            
            <tr>
              <td width="292">Suzuki, Wendell</td>
             
              <td width="112" align="center"><input type="radio" name="suzuki" id="suzukiyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="suzuki" id="suzukino" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="suzuki" id="suzukinr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
			<tr>
              <td width="292">Tatum, Robin</td>
             
              <td width="112" align="center"><input type="radio" name="tatum" id="tatumyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="tatum" id="tatumno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="tatum" id="tatumnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>		
				
				<tr>
              <td width="292">Tillotson, Joe</td>
             
              <td width="112" align="center"><input type="radio" name="tillotson" id="tillotsonyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="tillotson" id="tillotsonno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="tillotson" id="tillotsonnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
			<tr>
              <td width="292">Tsai, Amy</td>
             
              <td width="112" align="center"><input type="radio" name="tsai" id="tsaiyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="tsai" id="tsaino" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="tsai" id="tsainr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>	
				
            
			  <tr>
              <td width="292">Unger, Phil</td>
             
              <td width="112" align="center"><input type="radio" name="unger" id="umgeryes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="unger" id="ungerno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="unger" id="ungernr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
			
           <tr>
              <td width="292">Wolff, Jim</td>
             
              <td width="112" align="center"><input type="radio" name="wolff" id="wolffyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="wolff" id="wolffno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="wolff" id="wolffnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>            
            
            
            
            
            <tr>
              <td align="right"><strong>Totals</strong></td>
             
              <td width="112" align="center"> <?php echo $yes ?> </td>
              <td width="112" align="center"> <?php echo $no ?> </td>
              <td width="112" align="center"> <?php echo $nr ?> </td>
              
            </tr>				
           
    </table>
        
          </tbody>
      </table>
		  
	<p align+"center"><font color="#ff0000"><strong>BEFORE YOU MAKE YOUR SELECTION, PLEASE REFRESH THIS PAGE
	  BY CLICKING THE CIRCULAR ARROW IN THE BROWSER ADDRESS WINDOW.<br>
	  YOU THEN HAVE ONE MINUTE TO SUBMIT YOUR SELECTION.
	</strong></font></p>	  
		  
  <p align="center"><input id="submitButton" type="submit" value="Submit Your Choice"></p>
  
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
Last updated at 4:32 pm PST on 12/06/2023<br>

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
