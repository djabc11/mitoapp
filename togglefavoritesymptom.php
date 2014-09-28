<?php
include 'connect.php';
//$UsID = $_SESSION['UsID'];
$UsID = $_POST['UsID'];
$SiID = $_POST['SiID'];

$UsID = 1;
//$SiID = 26;

$returnString = '';
$sqlToRun = 'insert into tblFavoriteItem (FvSiID,FvUsID) values ('.$SiID.','.$UsID.')';

$resultb = mysql_query("SELECT * from tblFavoriteItem where FvUsID = $UsID and FvSiID = $SiID") or die(mysql_error());
				while($result = mysql_fetch_array($resultb))
				{
				$sqlToRun = 'delete from tblFavoriteItem where FvSiID = '.$SiID.' and FvUsID = '.$UsID;
				}
				
mysql_query($sqlToRun);				


$symptomArray = array();
$symptomCount = 0;
$symptomArrayFavorites = array();
$symptomArrayNonFavorites = array();
$symptomFavCount = 0;
$symptomNonFavCount = 0;

$resulta = mysql_query("SELECT SiID, SiName, case when FvSiID IS NOT NULL THEN 1 ELSE 0 END SiFavorite from tblSavedItem
left outer join tblFavoriteItem on FvSiID = SiID and FvUsID = $UsID
where SiUsID in (0,$UsID) and SiType = 1
order by case when FvSiID IS NOT NULL THEN 1 ELSE 0 END DESC, SiName") or die(mysql_error());
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


$returnString = implodeIt($symptomArray);

echo $returnString;


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