<html>

<head>
<title>OTP Hiker - West Valley Car Pool Schedule</title>
<meta name="keywords"
content="OTP, West, Valley, Car, Pool, Schedule">
<meta name="description" content="OTP Hiker West Valley Car Pool Schedule">
</head>

<?php

	require_once('carpool/array2xml.php');
	
	//arrays
	$nameArray = ['anna', 'carol', 'grant', 'jimc', 'jimh', 'joel', 'john', 'phil', 'ralph', 'shirley', 'vicky', 'udml'];
	$rsvpArray = ['','','','','','','','','','','',''];
	$statusArray = ['status1','status2','status3','status4'];
	$statusNameArray = ['', '', '', '']; 
	
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
		if (isset($_POST['meet1'])){
			if ($_POST['meet1'] == $name){
				saveStatus('status2', $name);
			}	
		}
		if (isset($_POST['driver2'])){
			if ($_POST['driver2'] == $name){
				saveStatus('status3', $name);
			}	
		}
		if (isset($_POST['meet2'])){
			if ($_POST['meet2'] == $name){
				saveStatus('status4', $name);
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

<body bgcolor="#ffffff">

<div align="center">
  <table width="600"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td scope="col"><p align="center"><img src="carpool/hline.gif" width="600" height="5"><strong><font size="4" face="Verdana, Arial, Helvetica, sans-serif"><a href="http://www.otphiker.com"><br>
        <br>
        OTP Hiker</a></font></strong></p>
      <h1 align="center"><img src="carpool/hline.gif" width="600" height="5"></h1></td>
    </tr>
  </table>
  <p align="center"><strong><font color="#000000" size="4" face="Verdana, Arial, Helvetica, sans-serif"><a href="http://www.otphiker.com/carpool.php">West Valley Car Pool Schedule</a></font></strong></p><br>
  
</div>
  <table align="center" width="700" cellspacing="1">
    <tr>
          <td>
          <div align="center">
  <table width="600" border="1" cellspacing="1" cellpadding="5">
    <tr>
      <td><p align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Please indicate your availability for <a href="hikes/1310.html">Hike #1307, Garapito Trail to Hub Junction</a>, on Wednesday, February 8, 2017. </p>
      
      <p align="left"><u><strong>IMPORTANT: To avoid inadvertant updating current online data with old "cached" data stored on your device, please click the refresh link on your browser.  The refresh button is a circular arrow and can usually be found on the top address (URL) window.</strong></u></p>
      
        <p align="left">Check yes or no next to your name and click Submit. </p>
        
        <p align="left">The next designated driver(s) are determined by the lowest cumulative passenger miles accumulated, identified in green.  See <a href="carpool/Driver_Selection.pdf">Driver Selection</a>. </p>
        <p align="left">If the number of hikers exceeds the seating capacity of the primary driver (Driver 1), then the secondary driver (Driver 2) will be assigned based on next lowest cumulative passenger-miles. If designated drivers are not hiking this week, then the next available driver will be chosen based on the next driver priority on the <a href="carpool/Driver_Selection.pdf">Driver Selection</a> spreadsheet.</p>
        <p align="left">In general, meeting location will be the home of the primary designated driver. </p>
        <p align="left">Jim Hartung has kindly provided a more detailed explanation and instructions for this new process. See <a href="carpool/Instructions.pdf">Instructions</a>.</p>   
<p align="left">Click Submit to save your entry.</font>
       </p>
        
        
        <table width="495" border="1">
          <tbody>
          <p align="left"><font size="1">
          <form name="myform1" method="post">
            <tr>
              <th height="49" colspan="9" scope="col"><p><a href="../hikes/1307.html">Hike #1307, Garapito Trail to Hub Junction</a><br>Wednesday, February 8, 2017<br>
                
              </p></th>
            </tr>
            <tr>
              <th width="169" scope="col">Name</th>
              <th width="35" scope="col">Seats</th>
              <th width="35" scope="col">Yes</th>
              <th width="35" scope="col">No</th>
              <th width="35" scope="col">No Response</th>
              <th width="35" scope="col">Driver 1</th>
              <th width="35" scope="col">Meet 1</th>
              <th width="35" scope="col">Driver 2</th>
              <th width="35" scope="col">Meet 2</th>
            </tr>
            <tr>
              <td>Anna</td>
              <td>5</td>
              <td><input type="radio" name="anna" id="annayes" value="Yes" <?php if ($rsvpArray[0] == 'yes'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="anna" id="annano" value="No" <?php if ($rsvpArray[0] == 'no'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="anna" id="annanr" value="NR" <?php if ($rsvpArray[0] == 'nr'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver1" id="driver1anna" value="anna" <?php if ($statusNameArray['0'] == 'anna'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet1" id="meet1anna" value="anna" <?php if ($statusNameArray['1'] == 'anna'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2anna" value="anna" <?php if ($statusNameArray['2'] == 'anna'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2anna" value="anna" <?php if ($statusNameArray['3'] == 'anna'){ echo 'checked'; } ?>></td>
            </tr>
              <tr>
              <td>Carol</td>
              <td>5</td>
              <td><input type="radio" name="carol" id="carolyes" value="Yes" <?php if ($rsvpArray[1] == 'yes'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="carol" id="carolno" value="No" <?php if ($rsvpArray[1] == 'no'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="carol" id="carolnr" value="NR" <?php if ($rsvpArray[1] == 'nr'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver1" id="driver1carol" value="carol" <?php if ($statusNameArray['0'] == 'carol'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet1" id="meet1carol" value="carol" <?php if ($statusNameArray['1'] == 'carol'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2carol" value="carol" <?php if ($statusNameArray['2'] == 'carol'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2carol" value="carol" <?php if ($statusNameArray['3'] == 'carol'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td>Grant</td>
              <td>5</td>
              <td><input type="radio" name="grant" id="grantyes" value="Yes" <?php if ($rsvpArray[2] == 'yes'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="grant" id="grantno" value="No" <?php if ($rsvpArray[2] == 'no'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="grant" id="grantnr" value="NR" <?php if ($rsvpArray[2] == 'nr'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver1" id="driver1grant" value="grant" <?php if ($statusNameArray['0'] == 'grant'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet1" id="meet1grant" value="grant" <?php if ($statusNameArray['1'] == 'grant'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2grant" value="grant" <?php if ($statusNameArray['2'] == 'grant'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2grant" value="grant" <?php if ($statusNameArray['3'] == 'grant'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td>Jim C.</td>
              <td>5</td>
              <td><input type="radio" name="jimc" id="jimcyes" value="Yes" <?php if ($rsvpArray[3] == 'yes'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="jimc" id="jimcno" value="No" <?php if ($rsvpArray[3] == 'no'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="jimc" id="jimcnr" value="NR" <?php if ($rsvpArray[3] == 'nr'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver1" id="driver1jimc" value="jimc" <?php if ($statusNameArray['0'] == 'jimc'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet1" id="meet1jimc" value="jimc" <?php if ($statusNameArray['1'] == 'jimc'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2jimc" value="jimc" <?php if ($statusNameArray['2'] == 'jimc'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2jimc" value="jimc" <?php if ($statusNameArray['3'] == 'jimc'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td>Jim H.</td>
              <td>5</td>
              <td><input type="radio" name="jimh" id="jimhyes" value="Yes" <?php if ($rsvpArray[4] == 'yes'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="jimh" id="jimhno" value="No" <?php if ($rsvpArray[4] == 'no'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="jimh" id="jimhnr" value="NR" <?php if ($rsvpArray[4] == 'nr'){ echo 'checked'; } ?>></td>
          <td><input type="radio" name="driver1" id="driver1jimh" value="jimh" <?php if ($statusNameArray['0'] == 'jimh'){ echo 'checked'; } ?>></td>></td>
              <td><input type="radio" name="meet1" id="meet1jimh" value="jimh" <?php if ($statusNameArray['1'] == 'jimh'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2jimh" value="jimh" <?php if ($statusNameArray['2'] == 'jimh'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2jimh" value="jimh" <?php if ($statusNameArray['3'] == 'jimh'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td>Joel</td>
              <td>7</td>
              <td><input type="radio" name="joel" id="joelyes" value="Yes" <?php if ($rsvpArray[5] == 'yes'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="joel" id="joelno" value="No" <?php if ($rsvpArray[5] == 'no'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="joel" id="joelnr" value="NR" <?php if ($rsvpArray[5] == 'nr'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver1" id="driver1joel" value="joel" <?php if ($statusNameArray['0'] == 'joel'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet1" id="meet1joel" value="joel" <?php if ($statusNameArray['1'] == 'joel'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2joel" value="joel" <?php if ($statusNameArray['2'] == 'joel'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2joel" value="joel" <?php if ($statusNameArray['3'] == 'joel'){ echo 'checked'; } ?>></td>
            </tr>
            
            <tr>
              <td>John</td>
              <td>5</td>
              <td><input type="radio" name="john" id="johnyes" value="Yes" <?php if ($rsvpArray[6] == 'yes'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="john" id="johnno" value="No" <?php if ($rsvpArray[6] == 'no'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="john" id="johnnr" value="NR" <?php if ($rsvpArray[6] == 'nr'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver1" id="driver1john" value="john" <?php if ($statusNameArray['0'] == 'john'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet1" id="meet1john" value="john" <?php if ($statusNameArray['1'] == 'john'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2john" value="john" <?php if ($statusNameArray['2'] == 'john'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2john" value="john" <?php if ($statusNameArray['3'] == 'john'){ echo 'checked'; } ?>></td>
            </tr>
                      
            <tr>
              <td>Phil</td>
              <td>5/7</td>
              <td><input type="radio" name="phil" id="philyes" value="Yes" <?php if ($rsvpArray[7] == 'yes'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="phil" id="philno" value="No" <?php if ($rsvpArray[7] == 'no'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="phil" id="philnr" value="NR" <?php if ($rsvpArray[7] == 'nr'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver1" id="driver1phil" value="phil" <?php if ($statusNameArray['0'] == 'phil'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet1" id="meet1phil" value="phil" <?php if ($statusNameArray['1'] == 'phil'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2phil" value="phil" <?php if ($statusNameArray['2'] == 'phil'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2phil" value="phil" <?php if ($statusNameArray['3'] == 'phil'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td>Ralph</td>
              <td>6</td>
              <td><input type="radio" name="ralph" id="ralphyes" value="Yes" <?php if ($rsvpArray[8] == 'yes'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="ralph" id="ralphno" value="No" <?php if ($rsvpArray[8] == 'no'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="ralph" id="ralphnr" value="NR" <?php if ($rsvpArray[8] == 'nr'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver1" id="driver1ralph" value="ralph" <?php if ($statusNameArray['0'] == 'ralph'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet1" id="meet1ralph" value="ralph" <?php if ($statusNameArray['1'] == 'ralph'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2ralph" value="ralph" <?php if ($statusNameArray['2'] == 'ralph'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2ralph" value="ralph" <?php if ($statusNameArray['3'] == 'ralph'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td>Shirley</td>
              <td>7</td>
              <td><input type="radio" name="shirley" id="shirleyyes" value="Yes" <?php if ($rsvpArray[9] == 'yes'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="shirley" id="shirleyno" value="No" <?php if ($rsvpArray[9] == 'no'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="shirley" id="shirleynr" value="NR" <?php if ($rsvpArray[9] == 'nr'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver1" id="driver1shirley" value="shirley" <?php if ($statusNameArray['0'] == 'shirley'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet1" id="meet1shirley" value="shirley" <?php if ($statusNameArray['1'] == 'shirley'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2shirley" value="shirley" <?php if ($statusNameArray['2'] == 'shirley'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2shirley" value="shirley" <?php if ($statusNameArray['3'] == 'shirley'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td>Vicky</td>
              <td>5</td>
              <td><input type="radio" name="vicky" id="vickyyes" value="Yes" <?php if ($rsvpArray[10] == 'yes'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="vicky" id="vickyno" value="No" <?php if ($rsvpArray[10] == 'no'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="vicky" id="vickynr" value="NR" <?php if ($rsvpArray[10] == 'nr'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver1" id="driver1vicky" value="vicky" <?php if ($statusNameArray['0'] == 'vicky'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet1" id="meet1vicky" value="vicky" <?php if ($statusNameArray['1'] == 'vicky'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2vicky" value="vicky" <?php if ($statusNameArray['2'] == 'vicky'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2vicky" value="vicky" <?php if ($statusNameArray['3'] == 'vicky'){ echo 'checked'; } ?>></td>
            </tr>
            <tr>
              <td colspan="5"> Undetermined Driver and Meeting Location</td>
              <td><input type="radio" name="driver1" id="driver1ud" value="udml" <?php if ($statusNameArray['0'] == 'udml'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet1" id="meet1uml" value="udml" <?php if ($statusNameArray['1'] == 'udml'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="driver2" id="driver2ud" value="udml" <?php if ($statusNameArray['2'] == 'udml'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="meet2" id="meet2uml" value="udml" <?php if ($statusNameArray['3'] == 'udml'){ echo 'checked'; } ?>></td>
            </tr>
            </font></font></p>
          </tbody>
        </table>
        <p><strong>Start Time</strong></font></font></p>
        <table width="268" border="1">
          <tbody>
            <tr>
              <td width="45">6:30</td>
              <td width="45">6:45</td>
              <td width="45">7:00</td>
              <td width="45">7:15</td>
              <td width="45">7:30</td>
              <td width="45">7:45</td>
              <td width="45">8:00</td>
              <td width="45">8:15</td>
              <td width="45">8:30</td>
              <td width="45">8:45</td>
            </tr>
            <tr>
              <td><input type="radio" name="radiostart" id="630" value="630" <?php if ($result['time'] == '630'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="radiostart" id="645" value="645" <?php if ($result['time'] == '645'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="radiostart" id="700" value="700" <?php if ($result['time'] == '700'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="radiostart" id="715" value="715" <?php if ($result['time'] == '715'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="radiostart" id="730" value="730" <?php if ($result['time'] == '730'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="radiostart" id="745" value="745" <?php if ($result['time'] == '745'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="radiostart" id="800" value="800" <?php if ($result['time'] == '800'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="radiostart" id="815" value="815" <?php if ($result['time'] == '815'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="radiostart" id="830" value="830" <?php if ($result['time'] == '830'){ echo 'checked'; } ?>></td>
              <td><input type="radio" name="radiostart" id="845" value="845" <?php if ($result['time'] == '845'){ echo 'checked'; } ?>></td>
            </tr>
          </tbody>
        </table>
        
        <br>
        <input type="submit" value="Submit">
        </form>
  </table>
</div>
<blockquote><blockquote><div align="center">
  <table width="600"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
                <div align="center"></div>              
              <form method="GET" action=http://www.google.com/custom>
          </form></td></tr>
      </table>
    </div>
    <div align="center">
      <table width="600"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td scope="col"><div align="left">
            <p><font size="2"><em><font face="Verdana, Arial, Helvetica, sans-serif"> <strong><font size="2"><em><font face="Verdana, Arial, Helvetica, sans-serif"><img src="carpool/hline.gif" width="600" height="5"></font></em></font></strong><br>
                <br>
              Last Modified at 12:10 am PDT on 02/04/2017<br>
              <br>
             
                    </font><img src="carpool/hline.gif" width="600" height="5"><br>
                </font></p>
          </div></td>
        </tr>
      </table>
  
  </div>
  </blockquote>
</blockquote>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2679891-3";
urchinTracker();
</script></body>
</html>
