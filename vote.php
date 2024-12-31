<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="OTP, hiker, hiking">
<meta name="description" content="OTP Hiker - Vote">
<title>OTP Hiker - Vote</title>
<link href="css/css_style.css" rel="stylesheet" type="text/css">
<!-- Phone -->
<link href="css/phone.css" rel="stylesheet" type="text/css"
media="only screen and (max-width:480px)">


</head>
	
	<?php

	require_once('vote/array2xml.php');
	
	//arrays
	
	$nameArray = ['babcock', 'bassett', 'benner', 'bergstromd', 'cahill', 'carlin', 'chady', 'costello', 'dewolf', 'decker', 'fasheha', 'fashehj', 'fassnacht', 'feinblattj', 'feinblatts', 'ferrington', 'forbessp', 'forbessr', 'frederick', 'gardnerja', 'gardnerji', 'gessner', 'grohs', 'hartungc', 'hartungj', 'jahn', 'kaczmarek', 'kingd', 'kingr', 'leete', 'lipman', 'maclean', 'morton', 'nakagawa', 'noguer', 'obert', 'piekunka', 'prum', 'ritter', 'rutherford', 'savell', 'schugel', 'shoukry', 'singer', 'spotts', 'suzuki', 'wallp', 'weiss'];
	
	
	$rsvpArray = ['','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''];
	
	
	//load file
	$xml=simplexml_load_file("vote/data.xml") or die("Error: Cannot create object");
	$json_string = json_encode($xml);
	$result = json_decode($json_string, TRUE);
	
	

	//delete file
	//unlink('vote/data.xml');
	
	//get name list
	function checkData($name, $num, $result){
		if ($result[$name]['rsvp']){
			$GLOBALS['rsvpArray'][$num] = $result[$name]['rsvp'];
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
	
	
	
	
	// Converts PHP Array to XML with the root element being 'root-element-here'
	$xml = Array2XML::createXML('people', $result);
		  
	//echo $xml->saveXML();
	$xml->save('vote/data.xml');
		  
	$iterator = 0;
	foreach ($nameArray as $x){
		checkData($x, $iterator, $result);
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
  
<h1>VOTE FOR EARLY START DURING SUMMER MONTHS</h1>
  

<div align="center">
  <table width="600" border="0" cellspacing="1" cellpadding="5">
    <tr>
      <td><p align="left">Would you like to start one hour earlier, meeting at 8:00 am and hiking at 8:30 am during the summer months of July, August and September?&nbsp; Would you like to use the remaining summer hikes this year as a test case to see if this proposal works?</p>
		  <p align="left"><font color="#ff0000">Check &quot;Yes&quot; or &quot;No&quot; next to your name and click the &quot;Submit Your Choice&quot; button at the bottom of the page.</font> </p>
                     
        
        <table width="90%" bordercolor="#ababab" border="1" cellspacing="0" cellpadding="3">
          <tbody>            
            
            <form name="myform1" method="post"> 
             <tr>
              <th height="49" colspan="9" scope="col"><p>Meet at 8:00 am and hike at 8:30 am during the summer months of July, August and September<br>
                
              </p></th>
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
              <td width="292">Babcock, Steve</td>
              
              <td width="112" align="center"><input type="radio" name="babcock" id="babcockyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="babcock" id="babcockno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="babcock" id="babcocknr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
              <tr>
              <td width="292">Bassett, Roland</td>
             
              <td width="112" align="center"><input type="radio" name="bassett" id="bassettyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="bassett" id="bassettno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="bassett" id="bassettnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
				
			<tr>
              <td width="292">Benner, Richard</td>
             
              <td width="112" align="center"><input type="radio" name="benner" id="benneryes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="benner" id="bennerno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="benner" id="bennernr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Carlin, Jim</td>
             
              <td width="112" align="center"><input type="radio" name="carlin" id="carlinyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="carlin" id="carlinno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="carlin" id="carlinnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Chady, John</td>
             
              <td width="112" align="center"><input type="radio" name="chady" id="chadyyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="chady" id="chadyno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="chady" id="chadynr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
                      
            <tr>
              <td width="292">Costello, Mickey</td>
              <td width="112" align="center"><input type="radio" name="costello" id="costelloyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="costello" id="costellono" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="costello" id="costellonr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Decker, Anna</td>
              
              <td width="112" align="center"><input type="radio" name="decker" id="deckeryes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="decker" id="deckerno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="decker" id="deckernr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Feinblatt, Joel</td>
             
              <td width="112" align="center"><input type="radio" name="feinblattj" id="feinblattjyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="feinblattj" id="feinblattjno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="feinblattj" id="feinblattjnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Ferrington, Dorothy</td>
             
              <td width="112" align="center"><input type="radio" name="ferrington" id="ferringtonyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="ferrington" id="ferringtonno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="ferrington" id="ferringtonnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Forbess, Pat</td>
             
              <td width="112" align="center"><input type="radio" name="forbessp" id="forbesspyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="forbessp" id="forbesspno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="forbessp" id="forbesspnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Forbess, Ron</td>
             
              <td width="112" align="center"><input type="radio" name="forbessr" id="forbessryes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="forbessr" id="forbessrno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="forbessr" id="forbessrnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Gessner, Mike</td>
             
              <td width="112" align="center"><input type="radio" name="gessner" id="gessneryes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="gessner" id="gessnerno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="gessner" id="gessnernr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            
            <tr>
              <td width="292">Grohs, Anneliese</td>
             
              <td width="112" align="center"><input type="radio" name="grohs" id="grohsyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="grohs" id="grohsno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="grohs" id="grohsnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Hartung, Carol</td>
             
              <td width="112" align="center"><input type="radio" name="hartungc" id="hartungcyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="hartungc" id="hartungcno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="hartungc" id="hartungcnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Hartung, Jim</td>
             
              <td width="112" align="center"><input type="radio" name="hartungj" id="hartungjyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="hartungj" id="hartungjino" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              
              <td width="112" align="center"><input type="radio" name="hartungj" id="hartungjnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Jahn, Wolfgang</td>
             
              <td width="112" align="center"><input type="radio" name="jahn" id="jahnyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="jahn" id="jahnno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="jahn" id="jahnnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Leete, John</td>
             
              <td width="112" align="center"><input type="radio" name="leete" id="leeteyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="leete" id="leeteno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="leete" id="leetenr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Lipman, Bernie</td>
             
              <td width="112" align="center"><input type="radio" name="lipman" id="lipmanyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="lipman" id="lipmanno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="lipman" id="lipmannr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            <tr>
              <td width="292">Maclean, Norm</td>
             
              <td width="112" align="center"><input type="radio" name="maclean" id="macleanyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="maclean" id="macleanno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="maclean" id="macleannr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Nakagawa, John</td>
             
              <td width="112" align="center"><input type="radio" name="nakagawa" id="nakagawayes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="nakagawa" id="nakagawano" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="nakagawa" id="nakagawanr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Piekunka, Ron</td>
             
              <td width="112" align="center"><input type="radio" name="piekunka" id="piekunkayes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="piekunka" id="piekunkano" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="piekunka" id="piekunkanr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Ritter, Vicky</td>
             
              <td width="112" align="center"><input type="radio" name="ritter" id="ritteryes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="ritter" id="ritterno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="ritter" id="ritternr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Savell, Larry</td>
             
              <td width="112" align="center"><input type="radio" name="savell" id="savellyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="savell" id="savellno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="savell" id="savellnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Schugel, Joanie</td>
             
              <td width="112" align="center"><input type="radio" name="schugel" id="schugelyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="schugel" id="schugelno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="schugel" id="schugelnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Spotts, Jim</td>
             
              <td width="112" align="center"><input type="radio" name="spotts" id="spottsyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="spotts" id="spottsno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="spotts" id="spottsnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
              <td width="292">Wall, Peter</td>
             
              <td width="112" align="center"><input type="radio" name="wallp" id="wallpyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="wallp" id="wallpno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="wallp" id="wallpnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
              <?php $index = $index + 1 ?>
              
            </tr>
            
            <tr>
              <td width="292">Weiss, Alice</td>
             
              <td width="112" align="center"><input type="radio" name="weiss" id="weissyes" value="Yes" <?php if ($rsvpArray[$index] == 'yes'){ echo 'checked'; $yes = $yes + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="weiss" id="weissno" value="No" <?php if ($rsvpArray[$index] == 'no'){ echo 'checked'; $no = $no + 1; } ?>></td>
              
              <td width="112" align="center"><input type="radio" name="weiss" id="weissnr" value="NR" <?php if ($rsvpArray[$index] == 'nr'){ echo 'checked'; $nr = $nr + 1; } ?>></td>
              
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
  <input type="submit" title="Submit Your Choice" value="Submit Your Choice" color="#FFE085">
  </form>
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
Last updated at 4:27 pm PDT on 08/21/2019<br>

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
