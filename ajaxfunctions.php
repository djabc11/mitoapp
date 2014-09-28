<?php
session_start();
include 'connect.php';
$UsID = $_SESSION['UsID'];
$function = $_POST['function'];
$var1 = $_POST['var1'];
$var2 = $_POST['var2'];
$var3 = $_POST['var3'];

/*
$function = $_GET['function'];
$var1 = $_GET['var1'];
$var2 = $_GET['var2'];
$var3 = $_GET['var3'];
*/



/*
$function = 0;
$var1 = 20131225;
*/

/*
$function = 4;
$var1 = 'DaveDELIMITERAaronDELIMITERaarondb@bc.eduDELIMITER1610838743cc90e3e4fdda748282d9b8DELIMITER';
*/

//mail('davidaaronbc11@gmail.com', 'Test', $var1);

/*
$function = 2;
$var1 = '0dave25dave1dave20131224dave1438dave6dave0';
$var2 = '';
*/

//$theDate = 20130629;
$returnString = '';

/*
$function = $_GET['function'];
$var1 = $_GET['var1'];
$var2 = $_GET['var2'];
$var3 = $_GET['var3'];
*/

/*
echo $function;
echo "<br>";
echo $var1;
echo "<br>";
echo $var2;
echo "<br>";
echo $var3;
echo "<br>";
*/

if ($function == 0)
{
$resultb = mysql_query("SELECT * from tblEntry where EnUsID = $UsID and EnDate = $var1 order by EnTime") or die(mysql_error());
				while($result = mysql_fetch_array($resultb))
				{
				$EnID = $result['EnID'];
				
				
				$EnSiID = $result['EnSiID'];
				$EnType = $result['EnType'];
				$EnDate = $result['EnDate'];
				$EnTime = $result['EnTime'];
				//$EnName = $result['EnName'];
				$EnUnID = $result['EnUnID'];
				$EnQty = $result['EnQty'];
				//$EnQty = displaySeverity($EnType,$result['EnQty'],$UnName);
				
				$returnString .= $EnID;
				$returnString .= '*^*^*';
				$returnString .= $EnSiID;
				$returnString .= '*^*^*';
				
				$returnString .= $EnType;
				
				
				
				$returnString .= '*^*^*';
				
				
				
				$returnString .= $EnDate;
				
				
				
				$returnString .= '*^*^*';
				
				
				$returnString .= $EnTime;
				$returnString .= '*^*^*';
				
				$returnString .= $EnQty;
				$returnString .= '*^*^*';
				$returnString .= $EnUnID;
				$returnString .= '*^*^*';
				$returnString .= $EnNotes;
				$returnString .= '*|*|*';
				
				// old order: EnType,EnDate,EnTime,EnSiID,EnQty,EnID
				
				
				//$FuID = $result['FuID'];
				}
				
				$returnString = substr($returnString,0,strlen($returnString) - 5);

echo $returnString;
}
if ($function == 1) /*new item*/
{
$resultb = mysql_query("SELECT MAX(SiItemID) MaxSiItemID FROM tblSavedItem WHERE SiUsID IN (0,$UsID) AND SiType = $var1") or die(mysql_error());
while($result = mysql_fetch_array($resultb))
{
$MaxSiItemID = $result['MaxSiItemID'] + 1;
}
$resultb = mysql_query("SELECT MAX(SiID) MaxSiID FROM tblSavedItem WHERE SiUsID IN (0,$UsID) AND SiType = $var1") or die(mysql_error());
while($result = mysql_fetch_array($resultb))
{
$MaxSiID = $result['MaxSiID'] + 1;
}

mysql_query("INSERT INTO tblSavedItem (SiID,SiUsID, SiType, SiItemID, SiName) VALUES ($MaxSiID,$UsID,$var1,$MaxSiItemID,'$var2')") or die(mysql_error());
$returnString = $MaxSiID.'ITEMIDDIVIDER';


$symptomArray = array();
$symptomCount = 0;
$symptomArrayFavorites = array();
$symptomArrayNonFavorites = array();
$symptomFavCount = 0;
$symptomNonFavCount = 0;

$resulta = mysql_query("SELECT SiID, SiName, case when FvSiID IS NOT NULL THEN 1 ELSE 0 END SiFavorite from tblSavedItem
left outer join tblFavoriteItem on FvSiID = SiID and FvUsID = $UsID
where SiUsID in (0,1) and SiType = $var1
order by SiName") or die(mysql_error());
while($result = mysql_fetch_array($resulta))
{
$symptomArray[$symptomCount][0] = $result['SiID'];
$symptomArray[$symptomCount][1] = $result['SiName'];
$symptomArray[$symptomCount][2] = $result['SiFavorite'];
$symptomCount++;

if ($result['SiFavorite'] == 1)
{
$symptomArrayFavorites[$symptomFavCount][0] = $result['SiID'];
$symptomArrayFavorites[$symptomFavCount][1] = $result['SiName'];
$symptomFavCount++;
}
else
{
$symptomArrayNonFavorites[$symptomNonFavCount][0] = $result['SiID'];
$symptomArrayNonFavorites[$symptomNonFavCount][1] = $result['SiName'];
$symptomNonFavCount++;
}


}


$returnString .= implodeIt($symptomArray);

echo $returnString;




}

if ($function == 2) /*new/edit entry*/
{

$entryArray = explode('dave',$var1);
$EnID = $entryArray[0];
$EnSiID = $entryArray[1];
$EnType = $entryArray[2];
$EnDate = $entryArray[3];
$EnTime = $entryArray[4];
$EnQty = $entryArray[5];
$EnUnID = $entryArray[6];
$EnName = '';

$resulta = mysql_query("Select SiName from tblSavedItem where SiID = $EnSiID limit 1") or die(mysql_error());
while($result = mysql_fetch_array($resulta))
{
$EnName = $result['SiName'];
}


if ($EnID == 0)
mysql_query("INSERT INTO tblEntry (EnUsID,EnSiID,EnType,EnDate,EnTime,EnName,EnQty,EnUnID,EnNotes) VALUES ($UsID,$EnSiID,$EnType,$EnDate,$EnTime,'$EnName',$EnQty,$EnUnID,'$var2')");
else
mysql_query("UPDATE tblEntry SET EnSiID = $EnSiID, EnDate = $EnDate, EnTime = $EnTime, EnName = '$EnName', EnQty = $EnQty, EnUnID = $EnUnID, EnNotes = '$var2' WHERE EnID = $EnID");

}

function displaySeverity($EnType,$EnQty,$UnName)
{
if ($EnType == 1)
{
if ($EnQty < 3)
return $EnQty . ' (Mild)';
else if ($EnQty < 5)
return $EnQty . ' (Medium)';
else if ($EnQty < 7)
return $EnQty . ' (Bad)';
else if ($EnQty < 9)
return $EnQty . ' (Severe)';
else
return $EnQty . ' (Horrible)';
}
else
{
if ($UnName == 'NULL')
return $EnQty;
else
return $EnQty . '' . $UnName;
}


}

if ($function == 3) /*login attempt*/
{
	$UsID = 0;
	$returnString = 'THISISTEXT';

$resultb = mysql_query("SELECT * from tblUser where UsEmail = '$var1' and UsPassword = '$var2' limit 1") or die(mysql_error());
				while($result = mysql_fetch_array($resultb))
				{
				$UsID = $result['UsID'];
				$UsFirstName = $result['UsFirstName'];
				$UsLastName = $result['UsLastName'];
				$UsEmail = $result['UsEmail'];
				$UsPatientID = $result['UsPatientID'];
				$returnString .= $UsID;
				$returnString .= '*^*^*';
				$returnString .= $UsFirstName;
				$returnString .= '*^*^*';
				$returnString .= $UsLastName;
				$returnString .= '*^*^*';
				$returnString .= $UsEmail;
				$returnString .= '*^*^*';
				$returnString .= $UsPatientID;
				$_SESSION['UsID'] = $UsID;
				$_SESSION['UsFirstName'] = $UsFirstName;
				$_SESSION['UsLastName'] = $UsLastName;
				$_SESSION['UsEmail'] = $UsEmail;
				$_SESSION['UsPatientID'] = $UsPatientID;
				
				}
				


echo $returnString;

}

if ($function == 4) /*registration attempt*/
{

	$entryArray = explode('DELIMITER',$var1);
	$UsFirstName = $entryArray[0];
	$UsLastName = $entryArray[1];
	$UsEmail = $entryArray[2];
	$UsPassword = $entryArray[3];
	$UsPatientID = $entryArray[4];
	$returnString = 'THISISTEXT';
	


$resulta = mysql_query("SELECT count(*) userCount from tblUser where UsEmail = '$UsEmail'") or die(mysql_error());
				while($result = mysql_fetch_array($resulta))
				{
				$userCount = $result['userCount'];
				}

$resultb = mysql_query("SELECT (MAX(UsID) + 1) UsID from tblUser") or die(mysql_error());
				while($result = mysql_fetch_array($resultb))
				{
				$UsID = $result['UsID'];
				}				

if ($userCount == 0)
{
mysql_query("INSERT INTO tblUser (UsID,UsFirstName,UsLastName,UsEmail,UsPassword,UsDate,UsPatientID) VALUES ($UsID,'$UsFirstName','$UsLastName','$UsEmail','$UsPassword',NOW(),'$UsPatientID')");
$_SESSION['UsID'] = $UsID;
				$_SESSION['UsFirstName'] = $UsFirstName;
				$_SESSION['UsLastName'] = $UsLastName;
				$_SESSION['UsEmail'] = $UsEmail;
				$_SESSION['UsPatientID'] = $UsPatientID;

}
else
$UsID = 0;	

$returnString .= $UsID;
echo $returnString;

}


if ($function == 5) /*update account details*/
{

	$entryArray = explode('DELIMITER',$var1);
	$UsFirstName = $entryArray[0];
	$UsLastName = $entryArray[1];
	$UsEmail = $entryArray[2];
	$UsPassword = $entryArray[3];
	$UsPatientID = $entryArray[4];
	$returnString = 'THISISTEXT';

$resulta = mysql_query("SELECT count(*) userCount from tblUser where UsEmail = '$UsEmail' and UsID <> $UsID") or die(mysql_error());
				while($result = mysql_fetch_array($resulta))
				{
				$userCount = $result['userCount'];
				}	

if ($userCount == 0)	
{
mysql_query("UPDATE tblUser SET UsFirstName = '$UsFirstName',UsLastName = '$UsLastName',UsEmail = '$UsEmail',UsPatientID = '$UsPatientID' WHERE UsID = $UsID");
$_SESSION['UsID'] = $UsID;
				$_SESSION['UsFirstName'] = $UsFirstName;
				$_SESSION['UsLastName'] = $UsLastName;
				$_SESSION['UsEmail'] = $UsEmail;
				$_SESSION['UsPatientID'] = $UsPatientID;
}
else
$UsID = 0;	

$returnString .= $UsID;
echo $returnString;

}

if ($function == 6) /*update account details*/
{
session_unset();
$returnString = 'THISISTEXT';
}


 function implodeIt($the_array)
{
$tmpArr = array();
foreach ($the_array as $sub) {
  $tmpArr[] = implode('QZQZQ', $sub);
}

$resultstring = implode('DJDJD', $tmpArr);
$resultstring2 = str_replace("\r\n","",$resultstring);
$resultstring2 = str_replace(" ","SPSPS",$resultstring2);
$resultstring2 = str_replace("-","DSDSD",$resultstring2);
$resultstring2 = str_replace("/","SLSLS",$resultstring2);
$resultstring2 = str_replace('"',"QUQUQ",$resultstring2);
$resultstring2 = str_replace('(',"PAOPAOP",$resultstring2);
$resultstring2 = str_replace(')',"PACPACP",$resultstring2);
$resultstring2 = 'THISISTEXT'.$resultstring2;

return $resultstring2;
}



?>