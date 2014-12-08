<?php
session_start();

$UsID = $_SESSION['UsID'];
$UsFirstName = $_SESSION['UsFirstName'];
$UsLastName = $_SESSION['UsLastName'];
$UsEmail = $_SESSION['UsEmail'];
$UsPatientID = $_SESSION['UsPatientID'];



if (!isset($UsID))
$UsID = 0;
//$UsID = 1;


include 'connect.php';

$symptomArray = array();
$symptomCount = 0;
$symptomArrayFavorites = array();
$symptomArrayNonFavorites = array();
$symptomFavCount = 0;
$symptomNonFavCount = 0;

$medicationArray = array();
$medicationCount = 0;
$medicationArrayFavorites = array();
$medicationArrayNonFavorites = array();
$medicationFavCount = 0;
$medicationNonFavCount = 0;

$dosageArray = array();
$dosageCount = 0;

$nutritionArray = array();
$nutritionCount = 0;

$hydrationArray = array();
$hydrationCount = 0;

$hydrationAmountArray = array();
$hydrationAmountCount = 0;

$resulta = mysql_query("SELECT SiID, SiName, case when FvSiID IS NOT NULL THEN 1 ELSE 0 END SiFavorite from tblSavedItem
left outer join tblFavoriteItem on FvSiID = SiID and FvUsID = $UsID
where SiUsID in (0,$UsID) and SiType = 1
order by case when FvSiID IS NOT NULL THEN 1 ELSE 0 END desc, SiName") or die(mysql_error());
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

$resultb = mysql_query("SELECT SiID, SiName, case when FvSiID IS NOT NULL THEN 1 ELSE 0 END SiFavorite from tblSavedItem
left outer join tblFavoriteItem on FvSiID = SiID and FvUsID = $UsID
where SiUsID in (0,$UsID) and SiType = 2
order by case when FvSiID IS NOT NULL THEN 1 ELSE 0 END desc, SiName") or die(mysql_error());
while($result = mysql_fetch_array($resultb))
{
$medicationArray[$medicationCount][0] = $result['SiID'];
$medicationArray[$medicationCount][1] = $result['SiName'];
$medicationArray[$medicationCount][2] = $result['SiFavorite'];
$medicationCount++;

if ($result['SiFavorite'] == 1)
{
$medicationArrayFavorites[$medicationFavCount][0] = $result['SiID'];
$medicationArrayFavorites[$medicationFavCount][1] = $result['SiName'];
$medicationFavCount++;
}
else
{
$medicationArrayNonFavorites[$medicationNonFavCount][0] = $result['SiID'];
$medicationArrayNonFavorites[$medicationNonFavCount][1] = $result['SiName'];
$medicationNonFavCount++;
}


}


$resultc = mysql_query("SELECT SiID, SiName from tblSavedItem
where SiUsID in (0,$UsID) and SiType = 3
order by SiName") or die(mysql_error());
while($rowc = mysql_fetch_array($resultc))
{
$nutritionArray[$nutritionCount][0] = $rowc['SiID'];
$nutritionArray[$nutritionCount][1] = $rowc['SiName'];
$nutritionCount++;
}

$resultd = mysql_query("SELECT SiID, SiName from tblSavedItem
where SiUsID in (0,$UsID) and SiType = 4
order by SiName") or die(mysql_error());
while($rowd = mysql_fetch_array($resultd))
{
$hydrationArray[$hydrationCount][0] = $rowd['SiID'];
$hydrationArray[$hydrationCount][1] = $rowd['SiName'];
$hydrationCount++;
}

$resulte = mysql_query("SELECT DISTINCT EnSiID, EnQty from tblEntry
where EnUsID = $UsID and EnType = 4
order by EnQty") or die(mysql_error());
while($rowe = mysql_fetch_array($resulte))
{
$hydrationAmountArray[$hydrationAmountCount][0] = $rowe['EnSiID'];
$hydrationAmountArray[$hydrationAmountCount][1] = $rowe['EnQty'];
$hydrationAmountCount++;
}

$resultf = mysql_query("SELECT DISTINCT EnSiID, EnQty, EnUnID from tblEntry
where EnUsID = $UsID and EnType = 2
order by EnQty, EnUnID") or die(mysql_error());
while($rowf = mysql_fetch_array($resultf))
{
$dosageArray[$dosageCount][0] = $rowe['EnSiID'];
$dosageArray[$dosageCount][1] = $rowe['EnQty'];
$dosageArray[$dosageCount][2] = $rowe['EnUnID'];
$dosageCount++;
}



/*
$resulta = mysql_query("SELECT count(*) theCount from tblOrder where orseen = 0 and orsubmitted = 1") or die(mysql_error());
while($result = mysql_fetch_array($resulta))
{
$theCount = $result['theCount'];
}

$resulta = mysql_query("SELECT count(*) theCount from tblOrder where orfulfilled = 0 and orsubmitted = 1") or die(mysql_error());
while($result = mysql_fetch_array($resulta))
{
$unfulfilledCount = $result['theCount'];
}

$date = date('Y-m-d', time());


*/

$result_string = implodeIt($symptomArray);
$result_string_medication = implodeIt($medicationArray);
$result_string_dosage = implodeIt($dosageArray);
$result_string_nutrition = implodeIt($nutritionArray);
$result_string_hydration = implodeIt($hydrationArray);
$result_string_hydrationamount = implodeIt($hydrationAmountArray);

//$result_string2 = 'A';
//$result_string = 'THISISTEXT52Q';//AbnormalSLSLSinvoluntarySPSPSmuscleSPSPSmovementsQZQZQ0DJDJD35QZQZQAngerSLSLSyellingSLSLSrageSLSLScombativeQZQZQ0DJDJD28QZQZQAnxietyQZQZQ0DJDJD25QZQZQAttentionDSDSDdifficultyQZQZQ0//DJDJD20QZQZQBehavioralSPSPSproblemsQZQZQ0DJDJD63QZQZQBloatingQZQZQ0DJDJD57QZQZQChestSPSPSpainQZQZQ0DJDJD21QZQZQCognitiveSPSPSprocessingSPSPSissuesQZQZQ0DJDJD38QZQZQColdSPSPSintoleranceQZQZQ0DJDJD11QZQZQConfusionQZQZQ0DJDJD61QZQZQConstipationQZQZQ0DJDJD33QZQZQCryingQZQZQ0DJDJD71QZQZQDehydrationQZQZQ0DJDJD29QZQZQDepressionQZQZQ0DJDJD62QZQZQDiarrheaQZQZQ0DJDJD56QZQZQDifficultySPSPSbreathingQZQZQ0DJDJD55QZQZQDifficultySPSPSchewingQZQZQ0DJDJD54QZQZQDifficultySPSPSeatingQZQZQ1DJDJD10QZQZQDifficultySPSPSfallingSPSPSasleepQZQZQ0DJDJD53QZQZQDifficultySPSPSswallowingQZQZQ0DJDJD9QZQZQDifficultySPSPSwakingSPSPSupQZQZQ0DJDJD12QZQZQDifficultySPSPSwithSPSPSlanguageSPSPSorSPSPSwordsQZQZQ0DJDJD76QZQZQDroolingQZQZQ0DJDJD44QZQZQDroopySPSPSeyelidsQZQZQ0DJDJD75QZQZQDrySPSPSmouthQZQZQ0DJDJD49QZQZQExerciseSPSPSintoleranceQZQZQ0DJDJD6QZQZQFatigueQZQZQ0DJDJD79QZQZQFluDSDSDlikeSPSPSsymptomsQZQZQ0DJDJD73QZQZQGallbladderSPSPSdysfunctionQZQZQ0DJDJD69QZQZQGastricSPSPSdysmotilityQZQZQ0DJDJD46QZQZQGeneralizedSPSPSweaknessDSDSDSPSPSwholeSPSPSbodyQZQZQ0DJDJD14QZQZQHeadacheQZQZQ0DJDJD37QZQZQHeatSPSPSintoleranceQZQZQ0DJDJD24QZQZQHyperactivityQZQZQ0DJDJD42QZQZQInabilitySPSPStoSPSPSmoveSPSPSeyesSPSPSnormallyQZQZQ0DJDJD58QZQZQIrregularSPSPSheartbeatQZQZQ0DJDJD72QZQZQIrritableSPSPSbowelQZQZQ0DJDJD5QZQZQLackSPSPSofSPSPScoordinationQZQZQ0DJDJD23QZQZQLanguageSPSPSregressionQZQZQ0DJDJD18QZQZQLegSPSPSPainSPSPS(largeSPSPSmuscleSPSPSgroups)QZQZQ0DJDJD7QZQZQLegsSPSPSfeelingSPSPSQUQUQheavyQUQUQQZQZQ0DJDJD68QZQZQLimbsSPSPSQUQUQfallSPSPSasleepQUQUQSPSPSeasilyQZQZQ0DJDJD78QZQZQLossSPSPSofSPSPSfeelingSLSLSnumbnessQZQZQ0DJDJD27QZQZQMemorySPSPSlossDSDSDSPSPSlongDSDSDtermQZQZQ0DJDJD26QZQZQMemorySPSPSlossDSDSDSPSPSshortDSDSDtermQZQZQ1DJDJD15QZQZQMigraineQZQZQ0DJDJD32QZQZQMoodSPSPSdisturbancesQZQZQ0DJDJD3QZQZQMuscleSPSPStwitchingQZQZQ0DJDJD47QZQZQMuscleSPSPSweaknessDSDSDSPSPSlowerSPSPSbodyQZQZQ0DJDJD48QZQZQMuscleSPSPSweaknessDSDSDSPSPSupperSPSPSbodyQZQZQ0DJDJD59QZQZQNauseaQZQZQ0DJDJD19QZQZQNeckSPSPSpainQZQZQ0DJDJD65QZQZQPainSPSPSwithSPSPSurinationQZQZQ0DJDJD13QZQZQPainDSDSDSPSPSgeneralQZQZQ0DJDJD74QZQZQPancreaticSPSPSdysfunctionQZQZQ0DJDJD43QZQZQPoorSPSPSvisualSPSPSfocusSPSPSandSPSPSeyeSPSPSfatigueQZQZQ0DJDJD31QZQZQPsychosisQZQZQ0DJDJD77QZQZQRashesSPSPSorSPSPSskinSPSPSdiscolorationSLSLSmottlingQZQZQ0DJDJD64QZQZQ//RefluxQZQZQ0DJDJD70QZQZQRefusalSPSPSofSPSPSfoodQZQZQ0DJDJD34QZQZQScreamingSLSLSfeelingSPSPSoutDSDSDofDSDSDcontrolQZQZQ0DJDJD1QZQZQSeizureQZQZQ0DJDJD39QZQZQShiveringQZQZQ0DJDJD50QZQZQShortnessSPSPSofSPSPSbreathSPSPSatSPSPSrestQZQZQ0DJDJD51QZQZQShortnessSPSPSofSPSPSbreathSPSPSuponSPSPSexertionQZQZQ0DJDJD36QZQZQSleepSPSPSdisruptionDSDSDSPSPSgeneralQZQZQ0DJDJD8QZQZQSluggishQZQZQ0DJDJD22QZQZQSocialSPSPSregressionQZQZQ0DJDJD16QZQZQStomachacheDSDSDSPSPSacuteQZQZQ0DJDJD17QZQZQStomachacheDSDSDSPSPSgeneralizedQZQZQ0DJDJD2QZQZQStrokeDSDSDlikeSPSPSepisodeQZQZQ0DJDJD41QZQZQSweatingSPSPSlessSPSPSthanSPSPSnormalQZQZQ0DJDJD40QZQZQSweatingSPSPSmoreSPSPSthanSPSPSnormalQZQZQ0DJDJD67QZQZQTinglingSPSPSinSPSPSarmsSLSLSlegsSLSLStoesSLSLSfingersQZQZQ0DJDJD4QZQZQTremorsSPSPSorSPSPSshakinessQZQZQ0DJDJD45QZQZQVisionSPSPSlossQZQZQ0DJDJD60QZQZQVomitingQZQZQ0DJDJD30QZQZQWithdrawalQZQZQ0';
//$result_string = 'THISISTEXT66QZQZQAbnormalSPSPSstoolQZQZQ0DJDJD52QZQZQAbnormalSLSLSinvoluntarySPSPSmuscleSPSPSmovementsQZQZQ0DJDJD35QZQZQAngerSLSLSyellingSLSLSrageSLSLScombativeQZQZQ0DJDJD28QZQZQAnxietyQZQZQ0DJDJD25QZQZQAttentionDSDSDdifficultyQZQZQ0DJDJD20QZQZQBehavioralSPSPSproblemsQZQZQ0DJDJD63QZQZQBloatingQZQZQ0DJDJD57QZQZQChestSPSPSpainQZQZQ0DJDJD21QZQZQCognitiveSPSPSprocessingSPSPSissuesQZQZQ0DJDJD38QZQZQColdSPSPSintoleranceQZQZQ0DJDJD11QZQZQConfusionQZQZQ0DJDJD61QZQZQConstipationQZQZQ0DJDJD33QZQZQCryingQZQZQ0DJDJD71QZQZQDehydrationQZQZQ0DJDJD29QZQZQDepressionQZQZQ0DJDJD62QZQZQDiarrheaQZQZQ0DJDJD56QZQZQDifficultySPSPSbreathingQZQZQ0DJDJD55QZQZQDifficultySPSPSchewingQZQZQ0DJDJD54QZQZQDifficultySPSPSeatingQZQZQ1DJDJD10QZQZQDifficultySPSPSfallingSPSPSasleepQZQZQ0DJDJD53QZQZQDifficultySPSPSswallowingQZQZQ0DJDJD9QZQZQDifficultySPSPSwakingSPSPSupQZQZQ0DJDJD12QZQZQDifficultySPSPSwithSPSPSlanguageSPSPSorSPSPSwordsQZQZQ0DJDJD76QZQZQDroolingQZQZQ0DJDJD44QZQZQDroopySPSPSeyelidsQZQZQ0DJDJD75QZQZQDrySPSPSmouthQZQZQ0DJDJD49QZQZQExerciseSPSPSintoleranceQZQZQ0DJDJD6QZQZQFatigueQZQZQ0DJDJD79QZQZQFluDSDSDlikeSPSPSsymptomsQZQZQ0DJDJD73QZQZQGallbladderSPSPSdysfunctionQZQZQ0DJDJD69QZQZQGastricSPSPSdysmotilityQZQZQ0DJDJD46QZQZQGeneralizedSPSPSweaknessDSDSDSPSPSwholeSPSPSbodyQZQZQ0DJDJD14QZQZQHeadacheQZQZQ0DJDJD37QZQZQHeatSPSPSintoleranceQZQZQ0DJDJD24QZQZQHyperactivityQZQZQ0DJDJD42QZQZQInabilitySPSPStoSPSPSmoveSPSPSeyesSPSPSnormallyQZQZQ0DJDJD58QZQZQIrregularSPSPSheartbeatQZQZQ0DJDJD72QZQZQIrritableSPSPSbowelQZQZQ0DJDJD5QZQZQLackSPSPSofSPSPScoordinationQZQZQ0DJDJD23QZQZQLanguageSPSPSregressionQZQZQ0DJDJD18QZQZQLegSPSPSPainSPSPS(largeSPSPSmuscleSPSPSgroups)QZQZQ0DJDJD7QZQZQLegsSPSPSfeelingSPSPSQUQUQheavyQUQUQQZQZQ0DJDJD68QZQZQLimbsSPSPSQUQUQfallSPSPSasleepQUQUQSPSPSeasilyQZQZQ0DJDJD78QZQZQLossSPSPSofSPSPSfeelingSLSLSnumbnessQZQZQ0DJDJD27QZQZQMemorySPSPSlossDSDSDSPSPSlongDSDSDtermQZQZQ0DJDJD26QZQZQMemorySPSPSlossDSDSDSPSPSshortDSDSDtermQZQZQ1DJDJD15QZQZQMigraineQZQZQ0DJDJD32QZQZQMoodSPSPSdisturbancesQZQZQ0DJDJD3QZQZQMuscleSPSPStwitchingQZQZQ0DJDJD47QZQZQMuscleSPSPSweaknessDSDSDSPSPSlowerSPSPSbodyQZQZQ0DJDJD48QZQZQMuscleSPSPSweaknessDSDSDSPSPSupperSPSPSbodyQZQZQ0DJDJD59QZQZQNauseaQZQZQ0DJDJD19QZQZQNeckSPSPSpainQZQZQ0DJDJD65QZQZQPainSPSPSwithSPSPSurinationQZQZQ0DJDJD13QZQZQPainDSDSDSPSPSgeneralQZQZQ0DJDJD74QZQZQPancreaticSPSPSdysfunctionQZQZQ0DJDJD43QZQZQPoorSPSPSvisualSPSPSfocusSPSPSandSPSPSeyeSPSPSfatigueQZQZQ0DJDJD31QZQZQPsychosisQZQZQ0DJDJD77QZQZQRashesSPSPSorSPSPSskinSPSPSdiscolorationSLSLSmottlingQZQZQ0DJDJD64QZQZQRefluxQZQZQ0DJDJD70QZQZQRefusalSPSPSofSPSPSfoodQZQZQ0DJDJD34QZQZQScreamingSLSLSfeelingSPSPSoutDSDSDofDSDSDcontrolQZQZQ0DJDJD1QZQZQSeizureQZQZQ0DJDJD39QZQZQShiveringQZQZQ0DJDJD50QZQZQShortnessSPSPSofSPSPSbreathSPSPSatSPSPSrestQZQZQ0DJDJD51QZQZQShortnessSPSPSofSPSPSbreathSPSPSuponSPSPSexertionQZQZQ0DJDJD36QZQZQSleepSPSPSdisruptionDSDSDSPSPSgeneralQZQZQ0DJDJD8QZQZQSluggishQZQZQ0DJDJD22QZQZQSocialSPSPSregressionQZQZQ0DJDJD16QZQZQStomachacheDSDSDSPSPSacuteQZQZQ0DJDJD17QZQZQStomachacheDSDSDSPSPSgeneralizedQZQZQ0DJDJD2QZQZQStrokeDSDSDlikeSPSPSepisodeQZQZQ0DJDJD41QZQZQSweatingSPSPSlessSPSPSthanSPSPSnormalQZQZQ0DJDJD40QZQZQSweatingSPSPSmoreSPSPSthanSPSPSnormalQZQZQ0DJDJD67QZQZQTinglingSPSPSinSPSPSarmsSLSLSlegsSLSLStoesSLSLSfingersQZQZQ0DJDJD4QZQZQTremorsSPSPSorSPSPSshakinessQZQZQ0DJDJD45QZQZQVisionSPSPSlossQZQZQ0DJDJD60QZQZQVomitingQZQZQ0DJDJD30QZQZQWithdrawalQZQZQ0';
//$result_string = 'THISISTEXT66QZQZQAbnormalSPSPSstoolQZQZQ0DJDJD52QZQZQAbnormalSLSLSinvoluntarySPSPSmuscleSPSPSmovementsQZQZQ0DJDJD35QZQZQAngerSLSLSyellingSLSLSrageSLSLScombativeQZQZQ0DJDJD28QZQZQAnxietyQZQZQ0DJDJD25QZQZQAttentionDSDSDdifficultyQZQZQ0DJDJD20QZQZQBehavioralSPSPSproblemsQZQZQ0DJDJD63QZQZQBloatingQZQZQ0DJDJD57QZQZQChestSPSPSpainQZQZQ0DJDJD21QZQZQCognitiveSPSPSprocessingSPSPSissuesQZQZQ0DJDJD38QZQZQColdSPSPSintoleranceQZQZQ0DJDJD11QZQZQConfusionQZQZQ0DJDJD61QZQZQConstipationQZQZQ0DJDJD33QZQZQCryingQZQZQ0DJDJD71QZQZQDehydrationQZQZQ0DJDJD29QZQZQDepressionQZQZQ0DJDJD62QZQZQDiarrheaQZQZQ0DJDJD56QZQZQDifficultySPSPSbreathingQZQZQ0DJDJD55QZQZQDifficultySPSPSchewingQZQZQ0DJDJD54QZQZQDifficultySPSPSeatingQZQZQ1DJDJD10QZQZQDifficultySPSPSfallingSPSPSasleepQZQZQ0DJDJD53QZQZQDifficultySPSPSswallowingQZQZQ0DJDJD9QZQZQDifficultySPSPSwakingSPSPSupQZQZQ0DJDJD12QZQZQDifficultySPSPSwithSPSPSlanguageSPSPSorSPSPSwordsQZQZQ0DJDJD76QZQZQDroolingQZQZQ0DJDJD44QZQZQDroopySPSPSeyelidsQZQZQ0DJDJD75QZQZQDrySPSPSmouthQZQZQ0DJDJD49QZQZQExerciseSPSPSintoleranceQZQZQ0DJDJD6QZQZQFatigueQZQZQ0DJDJD79QZQZQFluDSDSDlikeSPSPSsymptomsQZQZQ0DJDJD73QZQZQGallbladderSPSPSdysfunctionQZQZQ0DJDJD69QZQZQGastricSPSPSdysmotilityQZQZQ0DJDJD46QZQZQGeneralizedSPSPSweaknessDSDSDSPSPSwholeSPSPSbodyQZQZQ0DJDJD14QZQZQHeadacheQZQZQ0DJDJD37QZQZQHeatSPSPSintoleranceQZQZQ0DJDJD24QZQZQHyperactivityQZQZQ0DJDJD42QZQZQInabilitySPSPStoSPSPSmoveSPSPSeyesSPSPSnormallyQZQZQ0DJDJD58QZQZQIrregularSPSPSheartbeatQZQZQ0DJDJD72QZQZQIrritableSPSPSbowelQZQZQ0DJDJD5QZQZQLackSPSPSofSPSPScoordinationQZQZQ0DJDJD23QZQZQLanguageSPSPSregressionQZQZQ0DJDJD18QZQZQLegSPSPSPainSPSPS';
//$result_string = '52QZQZQAbnormalSLSLSinvoluntarySPSPSmuscleSPSPSmovementsQZQZQ0DJDJD35QZQZQAngerSLSLSyellingSLSLSrageSLSLScombativeQZQZQ0DJDJD28QZQZQAnxietyQZQZQ0DJDJD25QZQZQAttentionDSDSDdifficultyQZQZQ0DJDJD20QZQZQBehavioralSPSPSproblemsQZQZQ0DJDJD63QZQZQBloatingQZQZQ0DJDJD57QZQZQChestSPSPSpainQZQZQ0DJDJD21QZQZQCognitiveSPSPSprocessingSPSPSissuesQZQZQ0DJDJD38QZQZQColdSPSPSintoleranceQZQZQ0DJDJD11QZQZQConfusionQZQZQ0DJDJD61QZQZQConstipationQZQZQ0DJDJD33QZQZQCryingQZQZQ0DJDJD71QZQZQDehydrationQZQZQ0DJDJD29QZQZQDepressionQZQZQ0DJDJD62QZQZQDiarrheaQZQZQ0DJDJD56QZQZQDifficultySPSPSbreathingQZQZQ0DJDJD55QZQZQDifficultySPSPSchewingQZQZQ0DJDJD54QZQZQDifficultySPSPSeatingQZQZQ1DJDJD10QZQZQDifficultySPSPSfallingSPSPSasleepQZQZQ0DJDJD53QZQZQDifficultySPSPSswallowingQZQZQ0DJDJD9QZQZQDifficultySPSPSwakingSPSPSupQZQZQ0DJDJD12QZQZQDifficultySPSPSwithSPSPSlanguageSPSPSorSPSPSwordsQZQZQ0DJDJD76QZQZQDroolingQZQZQ0DJDJD44QZQZQDroopySPSPSeyelidsQZQZQ0DJDJD75QZQZQDrySPSPSmouthQZQZQ0DJDJD49QZQZQExerciseSPSPSintoleranceQZQZQ0DJDJD6QZQZQFatigueQZQZQ0DJDJD79QZQZQFluDSDSDlikeSPSPSsymptomsQZQZQ0DJDJD73QZQZQGallbladderSPSPSdysfunctionQZQZQ0DJDJD69QZQZQGastricSPSPSdysmotilityQZQZQ0DJDJD46QZQZQGeneralizedSPSPSweaknessDSDSDSPSPSwholeSPSPSbodyQZQZQ0DJDJD14QZQZQHeadacheQZQZQ0DJDJD37QZQZQHeatSPSPSintoleranceQZQZQ0DJDJD24QZQZQHyperactivityQZQZQ0DJDJD42QZQZQInabilitySPSPStoSPSPSmoveSPSPSeyesSPSPSnormallyQZQZQ0DJDJD58QZQZQIrregularSPSPSheartbeatQZQZQ0DJDJD72QZQZQIrritableSPSPSbowelQZQZQ0DJDJD5QZQZQLackSPSPSofSPSPScoordinationQZQZQ0DJDJD23QZQZQLanguageSPSPSregressionQZQZQ0DJDJD18QZQZQLegSPSPSPainSPSPS(largeSPSPSmuscleSPSPSgroups)QZQZQ0DJDJD7QZQZQLegsSPSPSfeelingSPSPSQUQUQheavyQUQUQQZQZQ0DJDJD68QZQZQLimbsSPSPSQUQUQfallSPSPSasleepQUQUQSPSPSeasilyQZQZQ0DJDJD78QZQZQLossSPSPSofSPSPSfeelingSLSLSnumbnessQZQZQ0DJDJD27QZQZQMemorySPSPSlossDSDSDSPSPSlongDSDSDtermQZQZQ0DJDJD26QZQZQMemorySPSPSlossDSDSDSPSPSshortDSDSDtermQZQZQ1DJDJD15QZQZQMigraineQZQZQ0DJDJD32QZQZQMoodSPSPSdisturbancesQZQZQ0DJDJD3QZQZQMuscleSPSPStwitchingQZQZQ0DJDJD47QZQZQMuscleSPSPSweaknessDSDSDSPSPSlowerSPSPSbodyQZQZQ0DJDJD48QZQZQMuscleSPSPSweaknessDSDSDSPSPSupperSPSPSbodyQZQZQ0DJDJD59QZQZQNauseaQZQZQ0DJDJD19QZQZQNeckSPSPSpainQZQZQ0DJDJD65QZQZQPainSPSPSwithSPSPSurinationQZQZQ0DJDJD13QZQZQPainDSDSDSPSPSgeneralQZQZQ0DJDJD74QZQZQPancreaticSPSPSdysfunctionQZQZQ0DJDJD43QZQZQPoorSPSPSvisualSPSPSfocusSPSPSandSPSPSeyeSPSPSfatigueQZQZQ0DJDJD31QZQZQPsychosisQZQZQ0DJDJD77QZQZQRashesSPSPSorSPSPSskinSPSPSdiscolorationSLSLSmottlingQZQZQ0DJDJD64QZQZQRefluxQZQZQ0DJDJD70QZQZQRefusalSPSPSofSPSPSfoodQZQZQ0DJDJD34QZQZQScreamingSLSLSfeelingSPSPSoutDSDSDofDSDSDcontrolQZQZQ0DJDJD1QZQZQSeizureQZQZQ0DJDJD39QZQZQShiveringQZQZQ0DJDJD50QZQZQShortnessSPSPSofSPSPSbreathSPSPSatSPSPSrestQZQZQ0DJDJD51QZQZQShortnessSPSPSofSPSPSbreathSPSPSuponSPSPSexertionQZQZQ0DJDJD36QZQZQSleepSPSPSdisruptionDSDSDSPSPSgeneralQZQZQ0DJDJD8QZQZQSluggishQZQZQ0DJDJD22QZQZQSocialSPSPSregressionQZQZQ0DJDJD16QZQZQStomachacheDSDSDSPSPSacuteQZQZQ0DJDJD17QZQZQStomachacheDSDSDSPSPSgeneralizedQZQZQ0DJDJD2QZQZQStrokeDSDSDlikeSPSPSepisodeQZQZQ0DJDJD41QZQZQSweatingSPSPSlessSPSPSthanSPSPSnormalQZQZQ0DJDJD40QZQZQSweatingSPSPSmoreSPSPSthanSPSPSnormalQZQZQ0DJDJD67QZQZQTinglingSPSPSinSPSPSarmsSLSLSlegsSLSLStoesSLSLSfingersQZQZQ0DJDJD4QZQZQTremorsSPSPSorSPSPSshakinessQZQZQ0DJDJD45QZQZQVisionSPSPSlossQZQZQ0DJDJD60QZQZQVomitingQZQZQ0DJDJD30QZQZQWithdrawalQZQZQ0';

?>


  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>

<style type="text/css">
.ui-collapsible {
    margin : 10px 10px;
    width: 300px;
    font: 10px;
}
</style>
<SCRIPT language="javascript">



function arrayItDifferently(string)
{

/*
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
*/

//alert(string);

var loc_array = new Array();
string = string.replace(/THISISTEXT/g,"");
string = string.replace(/SPSPS/g," ");
string = string.replace(/DSDSD/g,"-");
string = string.replace(/SLSLS/g,"/");
string = string.replace(/QUQUQ/g,'"');
string = string.replace(/PAOPAOP/g,"(");
string = string.replace(/PACPACP/g,")");
var array = string.split('DJDJD');
for(var i in array)
{
	var one_location_string = array[i];
    var one_location_array = one_location_string.split('QZQZQ');
    loc_array[i] = one_location_array;   
}
return loc_array;
 
}

var selectedDate = 20130625;
var symptomsArray = new Array();
var entryArray = new Array();
var currentItemType = 1;



var result_string = <?php echo json_encode($result_string) ?>;
var result_string_medication = <?php echo json_encode($result_string_medication) ?>;
var result_string_dosage = <?php echo json_encode($result_string_dosage) ?>;
//var result_string_nutrition = <?php echo json_encode($result_string_nutrition) ?>;
//var result_string_hydration = <?php echo json_encode($result_string_hydration) ?>;
//var result_string_hydrationamount = <?php echo json_encode($result_string_hydrationamount) ?>;



//alert (typeof <?= $result_string ?>)
//arrayItDifferently(17);

var symptomsArray = arrayItDifferently(result_string);
var medicationsArray = arrayItDifferently(result_string_medication);



var dosageArray = arrayItDifferently(result_string_dosage);



/*


var nutritionArray = arrayItDifferently(result_string_nutrition);
var hydrationArray = arrayItDifferently(result_string_hydration);
var hydrationAmountArray = arrayItDifferently(result_string_hydrationamount);
*/


//alert(medicationsArray.length);
//alert(symptomsArray.length);

/*

if (event_index >= 0)
{

var event_id = event_array[event_index][0];
var event_start = event_array[event_index][1];
var event_end = event_array[event_index][2];
var event_all_day = parseInt(event_array[event_index][3],10);
var event_name = event_array[event_index][4];
var event_location_old = event_array[event_index][5];
var event_description_old = event_array[event_index][6];
var event_location = event_location_old.replace(new RegExp('<br />', 'g'), '\n');
var event_description = event_description_old.replace(new RegExp('<br />', 'g'), '\n');
var event_pic_id = parseInt(event_array[event_index][7],10);
var event_url = event_array[event_index][8];

event_element_id.value = event_id;


var start_year = parseInt(event_start.substring(0,4),10);
var start_month = parseInt(event_start.substring(4,6),10);
var start_day = parseInt(event_start.substring(6,8),10);
var start_hours = parseInt(event_start.substring(8,10),10);
var start_minutes = parseInt(event_start.substring(10,12),10);

var end_year = parseInt(event_end.substring(0,4),10);
var end_month = parseInt(event_end.substring(4,6),10);
var end_day = parseInt(event_end.substring(6,8),10);
var end_hours = parseInt(event_end.substring(8,10),10);
var end_minutes = parseInt(event_end.substring(10,12),10);



var start_date = new Date();
start_date.setFullYear(start_year);
start_date.setMonth(start_month - 1);
start_date.setDate(start_day);
start_date.setHours(start_hours);
start_date.setMinutes(start_minutes);

var end_date = new Date();
end_date.setFullYear(end_year);
end_date.setMonth(end_month - 1);
end_date.setDate(end_day);
end_date.setHours(end_hours);
end_date.setMinutes(end_minutes);



if (event_all_day == 1)
document.getElementById('event_all_day').checked = true;
else
document.getElementById('event_all_day').checked = false;
toggleAllDay();

//event start and end
//event all day. if checked, function that removes time fields
event_element_name.value = undoSpecialChars(event_name);
//event_element_location.value = undoSpecialChars(event_location);
event_element_description.value = undoSpecialChars(event_description);
event_element_url.value = undoSpecialChars(event_url);
*/

function refresh(whichSelect)
{

if (whichSelect == "aesymptomselectoptions")
{

var theblah = document.getElementById(whichSelect);

var theHTMLString = "<select name='aesymptomselect' id='aesymptomselect' onchange='toggleAddToFavoritesButton()' class='selectstylelarge'>";




for (var i=0; i<symptomsArray.length; i++)
{
/*if (symptomsArray[i][0] == SiID)*/
theHTMLString += "<option value='" + symptomsArray[i][0] + "' style='text-align:right;'";
if (symptomsArray[i][0] == document.getElementById("EnSiID").value)
theHTMLString += " selected";
theHTMLString += ">";
if (symptomsArray[i][2] == 1)
theHTMLString += "*";
theHTMLString += symptomsArray[i][1];
if (symptomsArray[i][2] == 1)
theHTMLString += "*";
theHTMLString += "</option>";

}
theHTMLString += "</select>";
document.getElementById(whichSelect).innerHTML = theHTMLString;
}

if (whichSelect == "aemedicationselectoptions")
{

var theHTMLString = "<select name='aemedicationselect' id='aemedicationselect' onchange='toggleAddToFavoritesButton()' class='selectstylelarge'>";

	for (var i=0; i<medicationsArray.length; i++)
{
/*if (symptomsArray[i][0] == SiID)*/
theHTMLString += "<option value='" + medicationsArray[i][0] + "' style='text-align:right;'";
if (medicationsArray[i][0] == document.getElementById("EnSiID").value)
theHTMLString += " selected";
theHTMLString += ">";
if (medicationsArray[i][2] == 1)
theHTMLString += "*";
theHTMLString += medicationsArray[i][1];
if (medicationsArray[i][2] == 1)
theHTMLString += "*";
theHTMLString += "</option>";

}
theHTMLString += "</select>";


document.getElementById(whichSelect).innerHTML = theHTMLString;
}
/*document.getElementById("EnSiID").value = SiID;*/




if (whichSelect == "aedosageselectoptions")
{

var whichMedication = document.getElementById("EnSiID").value;	

var theHTMLString = "<select name='aedosageselect' id='aedosageselect' class='selectstylelarge'>";

for (var i=0; i<medicationsArray.length; i++)
{
if (dosageArray[i][0] == whichMedication)
{
theHTMLString += "<option value='" + medicationsArray[i][0] + "' style='text-align:right;'";

theHTMLString += ">";

theHTMLString += dosageArray[i][1];

if (dosageArray[i][2] == 1)
theHTMLString += " ml"
else
theHTMLString += " mg"


theHTMLString += "</option>";
}
}
theHTMLString += "</select>";


document.getElementById(whichSelect).innerHTML = theHTMLString;
}






}

function toggle(divid,withgrayview,whichway)
{

	//alert("toggling");

var obj = document.getElementById(divid);

if (whichway == 0)
{

if (obj.style.display == 'none')
{
obj.style.display = '';
if (withgrayview == 1)
toggle("grayview",0,0);
}
else
{
obj.style.display = 'none';
}

} /*end whichway 0*/

if (whichway == 1)
{
if (obj.style.display == 'none')
{
obj.style.display = '';
if (withgrayview == 1)
toggle("grayview",0,0);
}
}

if (whichway == -1)
{
if (obj.style.display == '')
{
obj.style.display = 'none';
if (withgrayview == 1)
toggle("grayview",0,0);
}
}



}

function ffviewclicked(whichffview)
{

if (whichffview == "aenotesview")
{

document.getElementById("aenotestextarea").value = document.getElementById("EnNotes").value;
}

if (whichffview == "aecalview")
{


var dateValue = document.getElementById("EnDate").value;
var yyyy = Math.floor(dateValue/10000);
dateValue = dateValue - (yyyy*10000);
var mm = Math.floor(dateValue/100);
dateValue = dateValue - (mm*100);
var dd = dateValue;


/*20131215*/


setSelectIndex("aecalyear",yyyy);
setSelectIndex("aecalmonth",mm);
setSelectIndex("aecalday",dd);
}

if (whichffview == "aetimeview")
{

var timeValue = document.getElementById("EnTime").value;


var hour = Math.floor(timeValue/100);
var minute = timeValue - hour*100;
var ampm = 1;

if (hour >= 12)
ampm = 2;

if (hour == 0)
hour = 12;

if (hour > 12)
hour = hour - 12;


setSelectIndex("aetimehour",hour);
setSelectIndex("aetimeminute",minute);
setSelectIndex("aetimeampm",ampm);


/*
var timehour = document.getElementById("aetimehour");
var timeminute = document.getElementById("aetimeminute");
var timeampm = document.getElementById("aetimeampm");
var timeint = parseInt(timehour[timehour.selectedIndex].value * 100)
+ parseInt(timeminute[timeminute.selectedIndex].value);
if (timehour[timehour.selectedIndex].value == 12)
timeint = timeint - 1200;
if (timeampm.selectedIndex == 1)
timeint = timeint + 1200;
var obj = document.getElementById("ffview2");

obj.innerHTML = returnTime(timeint,1);
*/

}

//alert(symptomsArray.length);

if (whichffview == "aenameview")
{
if (document.getElementById("EnType").value == 1)
{

toggle("aesymptomview",0,0);
togglenewsymptombutton(0);
refresh("aesymptomselectoptions");
toggleAddToFavoritesButton();

}

if (document.getElementById("EnType").value == 2)
{

toggle("aemedicationview",0,0);
togglenewmedicationbutton(0);
refresh("aemedicationselectoptions");
toggleAddToFavoritesButton();


}


}

if (whichffview == "aeseverityview")
{
	if (document.getElementById("EnType").value == 1)
	{
	toggle("aeseverityview",0,0);
	//aesymptomview
	}
	if (document.getElementById("EnType").value == 2)
	{
		//make sure a medication has been chosen before selecting dosage

	//existingdosageview	
	if (document.getElementById("EnSiID").value == 0)
		alert("Please select a medication first.");
	else
	{
	var dosageCount = 0;
	var whichMedication = document.getElementById("EnSiID").value;
	
	

	for (var i=0; i<dosageArray.length; i++)
	{
		
		
		alert("making it here 11");
		if (dosageArray[i][0] == whichMedication)
		{
			
			dosageCount = 1;
			alert("making it here 26");
		}
		
	}


	alert("making it here 2");
	if (dosageCount == 0)
		document.getElementById("existingdosageview").style.display = 'none';
	else
		document.getElementById("existingdosageview").style.display = '';

	toggle("aedosageview",0,0);
	togglenewdosagebutton(0);
	refresh("aedosageselectoptions");

	alert("making it here 3");
	}
	}

	alert("making it here 4");
}

else
toggle(whichffview,0,0);

}

function togglenewsymptombutton(sideClicked)
{
if (sideClicked == 0)
{
document.getElementById("togglenewsymptomnobuttoncircle").className='circlegold';
document.getElementById("togglenewsymptomyesbuttoncircle").className='circlegray';
document.getElementById("togglenewsymptomnobutton").className='toggleswitchbuttonred';
document.getElementById("togglenewsymptomyesbutton").className='toggleswitchbuttongray';
document.getElementById("newsymptomview").style.display = 'none';
}
if (sideClicked == 1)
{
document.getElementById("togglenewsymptomnobuttoncircle").className='circlegray';
document.getElementById("togglenewsymptomyesbuttoncircle").className='circlegold';
document.getElementById("togglenewsymptomnobutton").className='toggleswitchbuttongray';
document.getElementById("togglenewsymptomyesbutton").className='toggleswitchbuttongreen';
document.getElementById("newsymptomview").style.display = '';
}
}

function togglenewmedicationbutton(sideClicked)
{
if (sideClicked == 0)
{
document.getElementById("togglenewmedicationnobuttoncircle").className='circlegold';
document.getElementById("togglenewmedicationyesbuttoncircle").className='circlegray';
document.getElementById("togglenewmedicationnobutton").className='toggleswitchbuttonred';
document.getElementById("togglenewmedicationyesbutton").className='toggleswitchbuttongray';
document.getElementById("newmedicationview").style.display = 'none';
}
if (sideClicked == 1)
{
document.getElementById("togglenewmedicationnobuttoncircle").className='circlegray';
document.getElementById("togglenewmedicationyesbuttoncircle").className='circlegold';
document.getElementById("togglenewmedicationnobutton").className='toggleswitchbuttongray';
document.getElementById("togglenewmedicationyesbutton").className='toggleswitchbuttongreen';
document.getElementById("newmedicationview").style.display = '';
}
}

function togglenewdosagebutton(sideClicked)
{
if (sideClicked == 0)
{
document.getElementById("togglenewdosagenobuttoncircle").className='circlegold';
document.getElementById("togglenewdosageyesbuttoncircle").className='circlegray';
document.getElementById("togglenewdosagenobutton").className='toggleswitchbuttonred';
document.getElementById("togglenewdosageyesbutton").className='toggleswitchbuttongray';
document.getElementById("aedosageselectoptions").style.display = 'none';
//document.getElementById("newdosageview").style.display = 'none';
}
if (sideClicked == 1)
{
document.getElementById("togglenewdosagenobuttoncircle").className='circlegray';
document.getElementById("togglenewdosageyesbuttoncircle").className='circlegold';
document.getElementById("togglenewdosagenobutton").className='toggleswitchbuttongray';
document.getElementById("togglenewdosageyesbutton").className='toggleswitchbuttongreen';
document.getElementById("aedosageselectoptions").style.display = '';
}
}

function removeplaceholdertext(whichone)
{
	
	if (whichone == 1)
	{
	if (document.getElementById("newsymptomname").value == 'Enter new symptom here')
	document.getElementById("newsymptomname").value = '';
	}
	if (whichone == 2)
	{
	if (document.getElementById("newmedicationname").value == 'Enter new medication here')
	document.getElementById("newmedicationname").value = '';
	}
	if (whichone == 3)
	{
	if (document.getElementById("newdosageamount").value == 'Enter amount here')
	document.getElementById("newdosageamount").value = '';
	}
}

function severitypressed(severity)
{

for (var i=1; i<=10; i++)
{
document.getElementById("severityblock" + i).className='severityblockgray';
}


if (severity <= 2)
document.getElementById("severityblock" + severity).className='severityblockdarkgreen';
else if (severity <= 4)
document.getElementById("severityblock" + severity).className='severityblocklightgreen';
else if (severity <= 6)
document.getElementById("severityblock" + severity).className='severityblockyellow';
else if (severity <= 8)
document.getElementById("severityblock" + severity).className='severityblockorange';
else
document.getElementById("severityblock" + severity).className='severityblockred';

}

function toggleAddToFavoritesButton()
{




if (document.getElementById("EnType").value == 1)
{



var symptomselect = document.getElementById("aesymptomselect");
var SiID = symptomselect[symptomselect.selectedIndex].value;
var isFavorite = 0;

for (var i=0; i<symptomsArray.length; i++)
{
if (symptomsArray[i][0] == SiID)
isFavorite =  symptomsArray[i][2];
}

var obj = document.getElementById("ahreffavoritesymptoms");

if (isFavorite == 1)
{
obj.className='coolbuttonlargered';
obj.innerHTML = 'Remove from Favorite Symptoms';

}
else
{
obj.className='coolbuttonlarge';
obj.innerHTML = 'Add to Favorite Symptoms';

}
}


if (document.getElementById("EnType").value == 2)
{


var medicationselect = document.getElementById("aemedicationselect");
var SiID = medicationselect[medicationselect.selectedIndex].value;
var isFavorite = 0;

for (var i=0; i<medicationsArray.length; i++)
{
if (medicationsArray[i][0] == SiID)
isFavorite = medicationsArray[i][2];
}



var obj = document.getElementById("ahreffavoritemedications");

if (isFavorite == 1)
{
obj.className='coolbuttonlargered';
obj.innerHTML = 'Remove from Favorite Medications';
}
else
{
obj.className='coolbuttonlarge';
obj.innerHTML = 'Add to Favorite Medications';
}
}


}

function cancelCalendar()
{
toggle("grayview",0,0);
toggle("calview",0,0);
}

function cancel(thename,andgrayview)
{
if (andgrayview == 1)
toggle("grayview",0,-1);
toggle(thename,0,0);
}

function save(thename)
{

var readyToToggle = 1;

var ennamealert = 'Please select a symptom.';
if (document.getElementById("EnType").value == 2)
ennamealert = 'Please select a medication.';
if (document.getElementById("EnType").value == 3)
ennamealert = 'Please select a nutrition.';
if (document.getElementById("EnType").value == 4)
ennamealert = 'Please select a hydration.';

var enqtyalert = 'Please select a severity.';
if (document.getElementById("EnType").value == 2)
enqtyalert = 'Please select a dosage.';
if (document.getElementById("EnType").value == 3)
enqtyalert = 'Please select an amount.';
if (document.getElementById("EnType").value == 4)
enqtyalert = 'Please select an amount.';

if (thename == "addeditview")
{
readyToToggle = 0;

if (document.getElementById("EnSiID").value == 0)
alert(ennamealert); //don't delete
else if (document.getElementById("EnQty").value == 0)
alert(enqtyalert); //don't delete
else
{



/*
<input id='EnID' type='hidden' value='0'/>
<input id='EnSiID' type='hidden' value='0'/>
<input id='EnType' type='hidden' value='0'/>
<input id='EnDate' type='hidden' value='0'/>
<input id='EnTime' type='hidden' value='0'/>
<input id='EnQty' type='hidden' value='0'/>
<input id='EnUnID' type='hidden' value='0'/>
<input id='EnNotes' type='hidden' value=''/>
*/


var allValuesConcatenated = 
document.getElementById("EnID").value + 'dave' 
+ document.getElementById("EnSiID").value + 'dave' 
+ document.getElementById("EnType").value + 'dave' 
+ document.getElementById("EnDate").value + 'dave' 
+ document.getElementById("EnTime").value + 'dave' 
+ document.getElementById("EnQty").value + 'dave' 
+ document.getElementById("EnUnID").value; 



var notes = document.getElementById("EnNotes").value;

toggle("spinner",0,1);

ajaxrequest('ajaxfunctions.php', 2, allValuesConcatenated, notes, -1);

}




}

if (thename == "aecalview")
{
var calyear = document.getElementById("aecalyear");
var calmonth = document.getElementById("aecalmonth");
var calday = document.getElementById("aecalday");

var caldate = parseInt(calyear[calyear.selectedIndex].value * 10000)
+ parseInt(calmonth[calmonth.selectedIndex].value * 100)
+ parseInt(calday[calday.selectedIndex].value);

document.getElementById("EnDate").value = caldate; 
document.getElementById("ffview1").innerHTML = returnDate(document.getElementById("EnDate").value,1);
/*
var obj = document.getElementById("ffview1");

obj.innerHTML = returnDate(caldate,1);
*/
}

if (thename == "aetimeview")
{
var timehour = document.getElementById("aetimehour");
var timeminute = document.getElementById("aetimeminute");
var timeampm = document.getElementById("aetimeampm");
var timeint = parseInt(timehour[timehour.selectedIndex].value * 100)
+ parseInt(timeminute[timeminute.selectedIndex].value);
if (timehour[timehour.selectedIndex].value == 12)
timeint = timeint - 1200;
if (timeampm.selectedIndex == 1)
timeint = timeint + 1200;
var obj = document.getElementById("ffview2");

obj.innerHTML = returnTime(timeint,1);
document.getElementById("EnTime").value = timeint; 
}

if (thename == "aesymptomview")
{
var symptomselect = document.getElementById("aesymptomselect");
var SiID = symptomselect[symptomselect.selectedIndex].value;
var chosenSymptomName = '';

for (var i=0; i<symptomsArray.length; i++)
{
if (symptomsArray[i][0] == SiID)
chosenSymptomName =  symptomsArray[i][1];
}

if (document.getElementById("newsymptomview").style.display == '')
{
toggle("spinner",0,1);
var entype = document.getElementById("EnType").value;
ajaxrequest('ajaxfunctions.php', 1, entype, document.getElementById("newsymptomname").value, -1); /*third value should be type of entry*/
readyToToggle = 0;


}
else
{
var obj = document.getElementById("ffview3");
obj.innerHTML = chosenSymptomName;
document.getElementById("EnSiID").value = SiID; 
}
}



if (thename == "aemedicationview")
{
var medicationselect = document.getElementById("aemedicationselect");
var SiID = medicationselect[medicationselect.selectedIndex].value;
var chosenMedicationName = '';

for (var i=0; i<medicationsArray.length; i++)
{
if (medicationsArray[i][0] == SiID)
chosenMedicationName =  medicationsArray[i][1];
}

if (document.getElementById("newmedicationview").style.display == '')
{
	
toggle("spinner",0,1);
var entype = document.getElementById("EnType").value;
ajaxrequest('ajaxfunctions.php', 1, entype, document.getElementById("newmedicationname").value, -1); /*third value should be type of entry*/
readyToToggle = 0;


}
else
{
	
var obj = document.getElementById("ffview3");
obj.innerHTML = chosenMedicationName;
document.getElementById("EnSiID").value = SiID; 
}
}

if (thename == "aeseverityview")
{
var x = 0;
for (var i=1; i<=10; i++)
{
if (document.getElementById("severityblock" + i).className != 'severityblockgray')
x = i;
}

var obj = document.getElementById("ffview4");
obj.innerHTML = x + ' (' + nameForSeverity(x) + ')';

document.getElementById("EnQty").value = x; 

}

if (thename == "aenotesview")
{


document.getElementById("EnNotes").value = document.getElementById("aenotestextarea").value;


document.getElementById("ffview5").innerHTML = document.getElementById("EnNotes").value;

}

if (thename == "aedosageview")
{
	//newdosageamount
	//newdosageunitselect
	//dave next

if (1 == 1)
{
document.getElementById("EnQty").value = document.getElementById("newdosageamount").value;
document.getElementById("EnUnID").value = document.getElementById("newdosageunitselect").selectedIndex + 1;
}
else
{

var selectedvalue = document.getElementById("aedosageselect")[document.getElementById("aedosageselect").selectedIndex].value; 



for (var i=0; i<dosageArray.length; i++) {
if (selectedvalue == dosageArray[i][1])
{

	document.getElementById("EnQty").value = dosageArray[i][1];
	document.getElementById("EnUnID").value = dosageArray[i][2];
	
}

}



}

var intPart = document.getElementById("EnQty").value;
var unitPart = '';

if (document.getElementById("EnUnID").value == 1)
	unitPart = ' ml';
if (document.getElementById("EnUnID").value == 2)
	unitPart = ' mg';


document.getElementById("ffview4").innerHTML = intPart + unitPart;

}

if (readyToToggle == 1)
toggle(thename,0,0);

}

function nameForSeverity(severity)
{
if (severity <= 2)
return "Mild";
else if (severity <= 4)
return "Medium";
else if (severity <= 6)
return "Bad";
else if (severity <= 8)
return "Severe";
else
return "Horrible";
}

function newEntry(entryType)
{

document.getElementById("EnType").value = entryType;

var obj = document.getElementById("aeheaderbarview");
if (entryType == 1)
{
obj.innerHTML = "New Symptom";
document.getElementById("ffview3label").innerHTML = 'Symptom'; 
document.getElementById("ffview4label").innerHTML = 'Severity'; 
}
if (entryType == 2)
{
obj.innerHTML = "New Medication";
document.getElementById("ffview3label").innerHTML = 'Medication'; 
document.getElementById("ffview4label").innerHTML = 'Amount'; 
}
if (entryType == 3)
{
obj.innerHTML = "New Nutrition";
document.getElementById("ffview3label").innerHTML = 'Nutrition'; 
document.getElementById("ffview4label").innerHTML = 'Amount'; 
}
if (entryType == 4)
{
obj.innerHTML = "New Hydration";
document.getElementById("ffview3label").innerHTML = 'Hydration'; 
document.getElementById("ffview4label").innerHTML = 'Amount'; 
}
if (entryType == 5)
{
obj.innerHTML = "New Note";
}

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1;
var yyyy = today.getFullYear();

setSelectIndex("aecalyear",yyyy);
setSelectIndex("aecalmonth",mm);
setSelectIndex("aecalday",dd);


document.getElementById("EnDate").value = yyyy*10000+mm*100+dd; 
document.getElementById("EnTime").value = today.getHours()*100+today.getMinutes(); 

document.getElementById("ffview1").innerHTML = returnDate(document.getElementById("EnDate").value,1);
document.getElementById("ffview2").innerHTML = returnTime(document.getElementById("EnTime").value,1);

//set medication, amount, notes back to 0
document.getElementById("ffview3").innerHTML = "Click to Select";
document.getElementById("ffview4").innerHTML = "Click to Select";
document.getElementById("ffview5").innerHTML = "Click to Enter Notes";



document.getElementById("EnID").value = 0;
document.getElementById("EnSiID").value = 0;
document.getElementById("EnQty").value = 0;
document.getElementById("EnUnID").value = 0;
document.getElementById("EnNotes").value = '';




toggle("newentryview",0,0);
toggle("addeditview",0,0);
}

function editEntry(EnID)
{

document.getElementById("EnID").value = EnID;


for (var i=0; i<entryArray.length; i++)
{



if (entryArray[i][0] == EnID)
{

document.getElementById("EnType").value = entryArray[i][2];
document.getElementById("EnDate").value = entryArray[i][3];
document.getElementById("EnTime").value = entryArray[i][4];

document.getElementById("EnSiID").value = entryArray[i][1];
document.getElementById("EnQty").value = entryArray[i][5];



document.getElementById("ffview1").innerHTML = returnDate(document.getElementById("EnDate").value,1);
document.getElementById("ffview2").innerHTML = returnTime(document.getElementById("EnTime").value,1);



document.getElementById("EnType").value = entryArray[i][2];



if (entryArray[i][2] == 1) //symptom
{

document.getElementById("aeheaderbarview").innerHTML = "Edit Symptom";
document.getElementById("ffview3label").innerHTML = 'Symptom'; 
document.getElementById("ffview4label").innerHTML = 'Severity'; 

for (var j=0; j<symptomsArray.length; j++)
{

if (symptomsArray[j][0] == entryArray[i][1])
{
document.getElementById("ffview3").innerHTML = symptomsArray[j][1];
break;
}
}
document.getElementById("ffview4").innerHTML = entryArray[i][5] + ' (' + nameForSeverity(entryArray[i][5]) + ')';
}
if (entryArray[i][2] == 2) //medication
{
	document.getElementById("aeheaderbarview").innerHTML = "Edit Medication";
	document.getElementById("ffview3label").innerHTML = 'Medication'; 
	document.getElementById("ffview4label").innerHTML = 'Amount'; 
}
if (entryArray[i][2] == 3) //nutrition
{
	document.getElementById("aeheaderbarview").innerHTML = "Edit Nutrition";
	document.getElementById("ffview3label").innerHTML = 'Nutrition'; 
	document.getElementById("ffview4label").innerHTML = 'Amount'; 
}
if (entryArray[i][2] == 4) //hydration
{
	document.getElementById("aeheaderbarview").innerHTML = "Edit Hydration";
	document.getElementById("ffview3label").innerHTML = 'Hydration'; 
	document.getElementById("ffview4label").innerHTML = 'Amount'; 
}
if (entryArray[i][2] == 5) //note
{
	document.getElementById("aeheaderbarview").innerHTML = "Edit Note";
}



document.getElementById("EnUnID").value = entryArray[i][6]; 
document.getElementById("EnNotes").value = entryArray[i][7];



break;
}
}

toggle("grayview",0,1);
toggle("addeditview",0,0);
}


function setSelectIndex(object,value)
{

var theObject = document.getElementById(object);

for (var i=0; i<theObject.length; i++) {
if (value == theObject[i].value)
{
theObject.selectedIndex = i;
break;
}
}

}

function setTextFromSelect(object,textObject)
{
var theObject = document.getElementById(object);
var theTextObject = document.getElementById(textObject);
theTextObject.innerHTML = theObject[theObject.selectedIndex].text;
}


function toggleCalendar()
{




var obj2 = document.getElementById('calview');


if (obj2.style.display == 'none')
{
obj2.style.display = '';
toggle("grayview",0,0);
}
else
{
var calyear = document.getElementById("calyear");
var calmonth = document.getElementById("calmonth");
var calday = document.getElementById("calday");



var caldate = parseInt(calyear[calyear.selectedIndex].value * 10000)
+ parseInt(calmonth[calmonth.selectedIndex].value * 100)
+ parseInt(calday[calday.selectedIndex].value);


obj2.style.display = 'none';

toggle("spinner",0,1);



ajaxrequest('ajaxfunctions.php',0,caldate,-1,-1);

document.getElementById("DateViewDate").value = caldate;

}


}


function addRemoveSymptom()
{
toggle("spinner",0,0);
}

function changeWidth(a,b)
{
var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
a.style.width = width;

}

function loginPressed()
{
	
	var loginemail = document.getElementById("loginemail").value;
	
	var loginpassword = CryptoJS.MD5(document.getElementById("loginpassword").value);
	
	ajaxrequest('ajaxfunctions.php',3,loginemail,loginpassword,-1);

	
}

function get_XmlHttp() {
  // create the variable that will contain the instance of the XMLHttpRequest object (initially with null value)
  var xmlHttp = null;

  if(window.XMLHttpRequest) {		// for Forefox, IE7+, Opera, Safari, ...
    xmlHttp = new XMLHttpRequest();
  }
  else if(window.ActiveXObject) {	// for Internet Explorer 5 or 6
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  return xmlHttp;
}





// sends data to a php file, via POST, and displays the received answer
function ajaxrequest(php_file, theProc, var1, var2, var3) 
{
  var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance

  // create pairs index=value with data that must be sent to server
  //var  the_data = 'test='+document.getElementById('txt2').innerHTML;
  
  var  the_data = 'function='+theProc+'&var1='+var1+'&var2='+var2+'&var3='+var3;
  
	//alert(the_data);
  

  request.open("POST", php_file, true);			// set the request

  // adds  a header to tell the PHP script to recognize the data as is sent via POST
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(the_data);		// calls the send() method with datas as parameter



	//var thisArray = arrayIt("1*^*^*20120302*^*^*1340*^*^*Shivering*^*^*8*|*|*24*^*^*387*|*|*30*^*^*714");
	//alert(thisArray[1][1]);


  // Check request status
  // If the response is received completely, will be transferred to the HTML tag with tagID
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
   
      //document.getElementById(tagID).innerHTML = request.responseText;
      
      if (theProc == 0)
      {
      
      var div = document.getElementById('dayview');
      entryArray = arrayIt(request.responseText);
      
	var thisArray = arrayIt(request.responseText);
	var htmlString = "";
	var arrayCount = 0;

	


if (request.responseText.length > 0)
{

arrayCount = thisArray.length;


for (var i=0; i<thisArray.length; i++) {
	htmlString += "<div class='svview' style='background: #";
	if (i % 2 == 0)
	htmlString += "EEEEEE;'>";
	else
	htmlString += "CCCCCC;'>";
	
	
	
   	htmlString += "<img class='svicon' src='icons/type" + thisArray[i][2] + "icon.png'/>";
   	
   	//alert(thisArray[i][1]);
   	
   	var EnType = thisArray[i][2];
   	
   	
   	var dateInt = parseInt(thisArray[i][3]);
   	var timeInt = parseInt(thisArray[i][4]);
   	var EnID = parseInt(thisArray[i][0]);
   	var EnSiID = parseInt(thisArray[i][1]);
   	htmlString += "<div class='svdate'>" + returnDate(dateInt,2) + "</div>";
   	htmlString += "<div class='svtime'>" + returnTime(timeInt,1) + "</div>";
   	
   	
   	
   	/*
   	htmlString += "<div class='svdate'><?php echo returnDate(";
   	htmlString += thisArray[i][1];
   	
   	htmlString += ",2); ?></div>";
   	htmlString += "<div class='svtime'><?php echo returnTime(" + parseInt(thisArray[i][2]) + ",1); ?></div>";
   	*/
   	//alert(thisArray[i][3].length);
   		
   	

   	var abbrevName = '';

   	if (EnType == 1)
   	{

   	for (var j=0; j<symptomsArray.length; j++)
	{
	if (symptomsArray[j][0] == EnSiID)
	{
	
	abbrevName = symptomsArray[j][1];
	
	}
	}

	}

	if (EnType == 2)
   	{

   	for (var j=0; j<medicationsArray.length; j++)
	{
	if (medicationsArray[j][0] == EnSiID)
	{
	
	abbrevName = medicationsArray[j][1];
	
	}
	}

	}
	

   	if (abbrevName.length > 16)
   	abbrevName = abbrevName.substring(0,16) + '..';
   	
 	
   	
   	htmlString += "<div class='svname'>" + abbrevName + "</div>";
   	
   	htmlString += "<div class='svseverity'>" + thisArray[i][5];

   	if (EnType == 1)
		htmlString += " (" + nameForSeverity(thisArray[i][5]) + ")</div>";
	if (EnType == 2)
	{
		if (thisArray[i][6] == 1)
			htmlString += ' ml</div>';
		if (thisArray[i][6] == 2)
			htmlString += ' mg</div>';

	}
   



   	htmlString += "<a href='javascript:editEntry(" + EnID + ")'><img class='svpencil' src='icons/Pencil.png'/></a>";
   	
	htmlString += "</div>";
	
	
	
}
}


/*fill the rest with blank spaces*/

for (var i=arrayCount; i<8; i++) {
	htmlString += "<div class='svview' style='background: #";
	if (i % 2 == 0)
	htmlString += "EEEEEE;'>";
	else
	htmlString += "CCCCCC;'>";
	
	
	
   	
   	
	htmlString += "</div>";
	
}




div.innerHTML = htmlString;



var div2 = document.getElementById('dateviewdate');


div2.innerHTML = returnDate(var1,1);

      
 toggle("spinner",1,-1);

 
 
 } //end theProc = 0

 if (theProc == 1) /*adding a new item. refresh when done*/
 {
 if (request.responseText.length > 0)
{


if (var1 == 1)
{

var startPos = request.responseText.indexOf("ITEMIDDIVIDER");
var theResponseText = request.responseText.substring(startPos + "itemiddivider".length);
var SiID = request.responseText.substring(0,startPos);


 symptomsArray = arrayItDifferently(theResponseText);
 var chosenSymptomName = '';

 
 for (var i=0; i<symptomsArray.length; i++)
{
if (symptomsArray[i][0] == SiID)
chosenSymptomName = symptomsArray[i][1];
}

document.getElementById("EnSiID").value = SiID; 
document.getElementById("ffview3").innerHTML = chosenSymptomName; 
 

toggle("spinner",0,-1);
toggle("aesymptomview",0,0);
}




if (var1 == 2)
{

var startPos = request.responseText.indexOf("ITEMIDDIVIDER");
var theResponseText = request.responseText.substring(startPos + "itemiddivider".length);
var SiID = request.responseText.substring(0,startPos);


 symptomsArray = arrayItDifferently(theResponseText);
 var chosenSymptomName = '';

 
 for (var i=0; i<medicationsArray.length; i++)
{
if (medicationsArray[i][0] == SiID)
chosenSymptomName = symptomsArray[i][1];
}

document.getElementById("EnSiID").value = SiID; 
document.getElementById("ffview3").innerHTML = chosenSymptomName; 
 

toggle("spinner",0,-1);
toggle("aemedicationview",0,0);
}













}
else
{
/*error handling*/
}
 
 } //end theProc = 1

 if (theProc == 2)
 {

ajaxrequest('ajaxfunctions.php',0,document.getElementById("DateViewDate").value,-1,-1);


 	toggle("addeditview",0,-1);
 	//toggle("spinner",1,-1); //will be taken care of with refresh
 }

 if (theProc == 3)
 {
 	if (request.responseText.length > 0)
{

if (request.responseText.length > 10)
{

	//log them in
	alert('Your login was successful!'); 
	var loginArray = new Array();
	
	loginArray = request.responseText.substring(10,request.responseText.length).split('*^*^*');
	//request.responseText.substring(10,request.responseText.length-10).split('*^*^*');

	

	
	document.getElementById("UsIDInput").value = loginArray[0];
	document.getElementById("UsFirstNameInput").value = loginArray[1];
	document.getElementById("UsLastNameInput").value = loginArray[2];
	document.getElementById("UsEmailInput").value = loginArray[3];
	document.getElementById("UsPatientIDInput").value = loginArray[4];
	




	document.getElementById("welcomeheader").innerHTML = 'Welcome, ' + loginArray[1] + '!';

	toggle('logindiv',0,-1);
	toggle('welcomediv',0,1);
	
	
}
else
{
	alert('The email/password you provided was incorrect. Please try again.')
}


}
else
{
	//error handling
}

 } //end theProc = 3

 if (theProc == 4) //registration attempt
 {

 	var string = request.responseText.replace(/THISISTEXT/g,"");

 	if (request.responseText.length > 0)
 	{
 	if (string == '0')
 	{
 	alert ('Sorry, but that email address is already taken');
 	}
 	else
 	{
 		//check to see if it was entered successfully or email was taken
	document.getElementById("UsFirstNameInput").value = document.getElementById("registerfirstname").value;
    document.getElementById("UsLastNameInput").value = document.getElementById("registerlastname").value;
	document.getElementById("UsEmailInput").value = document.getElementById("registeremail").value;
	document.getElementById("UsPatientIDInput").value = document.getElementById("registerpatientid").value;
	document.getElementById("welcomeheader").innerHTML = 'Welcome, ' + document.getElementById("registerfirstname").value + '!';
	toggle('newaccountdiv',0,-1);
	toggle('welcomediv',0,1);
	}
	}
	else
	{
	//error handling
	}

 }

 if (theProc == 5) //update account details
 {

 	if (request.responseText.length > 0)
 	{
 	if (string == '0')
 	{
 	alert ('Sorry, but that email address is already taken');
 	}
 	else
 	{
 	
 	document.getElementById("addeditaccountheader").innerHTML = "Edit Account";
	document.getElementById("UsFirstNameInput").value = document.getElementById("registerfirstname").value;
    document.getElementById("UsLastNameInput").value = document.getElementById("registerlastname").value;
	document.getElementById("UsEmailInput").value = document.getElementById("registeremail").value;
	document.getElementById("UsPatientIDInput").value = document.getElementById("registerpatientid").value;
 	document.getElementById("welcomeheader").innerHTML = 'Welcome, ' + document.getElementById("registerfirstname").value + '!';
 	
 	alert('Your changes have been made');
 		
 		
 		
 		
 		
	toggle('newaccountdiv',0,-1);
	//toggle('welcomediv',0,1);
	}
	}
	else
	{
	//error handling
	}

 }


if (theProc == 6) //log out
 {

 	if (request.responseText.length > 0)
 	{
	toggle('welcomediv',0,-1);
	toggle('logindiv',0,1);
	}
	else
	{
	//error handling
	}

 }
 
    }
  }
}

function newAccountPressed()
{
	document.getElementById("addeditaccountheader").innerHTML = "Create a New Account";
	document.getElementById("registerfirstname").value = '';
	document.getElementById("registerlastname").value = '';
	document.getElementById("registeremail").value = '';
	document.getElementById("registerpassword").style.display = '';
	document.getElementById("changepassword").style.display = 'none';
	document.getElementById("registerpassword").value = '';
	document.getElementById("registerpatientid").value = '';
	document.getElementById("addeditaccountsavetext").innerHTML = 'Register';
	toggle("newaccountdiv",0,1);
}

function cancelNewAccount()
{
	toggle("newaccountdiv",0,-1);
}

/*
function registerAccountPressed()
{
	var allValuesConcatenated = 
document.getElementById("loginfirstname").value + 'DELIMITER' 
+ document.getElementById("loginlastname").value + 'DELIMITER'  
+ document.getElementById("loginemail").value + 'DELIMITER' 
+ CryptoJS.MD5(document.getElementById("loginpassword").value) + 'DELIMITER'  
+ document.getElementById("loginpatientid").value; 
alert(allValuesConcatenated);
	//ajaxrequest('ajaxfunctions.php',4,allValuesConcatenated,-1,-1); //perform the signout	
}
*/

function registerNewAccount()
{
if (document.getElementById("addeditaccountheader").innerHTML == "Edit Account")
{
//check if anything is empty. if so, pop up alert. if not, run ajax query
	if (document.getElementById("registerfirstname").value.length == 0)
		alert("Please enter a first name");
	else if (document.getElementById("registerlastname").value.length == 0)
		alert("Please enter a last name");
	else if (document.getElementById("registeremail").value.length == 0)
		alert("Please enter a valid email address");
	else if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("registeremail").value) == false)  
		alert("Please enter a valid email address");
	else
	{
		var allValuesConcatenated = 
document.getElementById("registerfirstname").value + 'DELIMITER' 
+ document.getElementById("registerlastname").value + 'DELIMITER'  
+ document.getElementById("registeremail").value + 'DELIMITER' 
+ ' ' + 'DELIMITER'  
+ document.getElementById("registerpatientid").value; 


ajaxrequest('ajaxfunctions.php',5,allValuesConcatenated,-1,-1); //submit account details

}
}
else
{
	
	//check if anything is empty. if so, pop up alert. if not, run ajax query
	if (document.getElementById("registerfirstname").value.length == 0)
		alert("Please enter a first name");
	else if (document.getElementById("registerlastname").value.length == 0)
		alert("Please enter a last name");
	else if (document.getElementById("registeremail").value.length == 0)
		alert("Please enter a valid email address");
	else if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("registeremail").value) == false)  
		alert("Please enter a valid email address");
	else if (document.getElementById("registerpassword").value.length == 0)
		alert("Please enter a password");
	else
	{
		var allValuesConcatenated = 
document.getElementById("registerfirstname").value + 'DELIMITER' 
+ document.getElementById("registerlastname").value + 'DELIMITER'  
+ document.getElementById("registeremail").value + 'DELIMITER' 
+ CryptoJS.MD5(document.getElementById("registerpassword").value) + 'DELIMITER'  
+ document.getElementById("registerpatientid").value; 


ajaxrequest('ajaxfunctions.php',4,allValuesConcatenated,-1,-1); //submit account details
}	
	
	
	}
}

function editAccountPressed()
{
	document.getElementById("addeditaccountheader").innerHTML = "Edit Account";
	document.getElementById("registerfirstname").value = document.getElementById("UsFirstNameInput").value;
	document.getElementById("registerlastname").value = document.getElementById("UsLastNameInput").value;
	document.getElementById("registeremail").value = document.getElementById("UsEmailInput").value;
	document.getElementById("registerpassword").value = '';//document.getElementById("UsEmailInput").value;
	document.getElementById("registerpassword").style.display = 'none';
	document.getElementById("changepassword").style.display = '';
	document.getElementById("registerpatientid").value = document.getElementById("UsPatientIDInput").value;
	document.getElementById("addeditaccountsavetext").innerHTML = 'Save';
	toggle("newaccountdiv",0,1);
}

function signoutAccountPressed()
{
	ajaxrequest('ajaxfunctions.php',6,-1,-1,-1); //perform the signout	
	toggle('welcomediv',0,-1);
	toggle('logindiv',0,1);
	
	
	//toggle("newaccountdiv",0,1);
}

function refreshToday()
{
	var today = new Date();
	document.getElementById("DateViewDate").value = today.getFullYear()*10000+ (today.getMonth()+1)*100 + today.getDate();
	ajaxrequest('ajaxfunctions.php',0,document.getElementById("DateViewDate").value,-1,-1);	
}

function addToFavoriteSymptomsPressed()
{
var symptomselect = document.getElementById("aesymptomselect");
var SiID = symptomselect[symptomselect.selectedIndex].value;
var UsID = document.getElementById("UsIDInput").value;
toggle("spinner",0,1);
ajaxtogglefavoritesymptom(UsID,SiID);
}

function addToFavoriteMedicationsPressed()
{
var medicationselect = document.getElementById("aemedicationselect");
var SiID = medicationselect[medicationselect.selectedIndex].value;
var UsID = document.getElementById("UsIDInput").value;
toggle("spinner",0,1);
ajaxtogglefavoritesymptom(UsID,SiID);
}

function ajaxtogglefavoritesymptom(UsID,SiID) {
  var request =  get_XmlHttp();		// call the function for the XMLHttpRequest instance
  var the_data = 'UsID='+UsID+'&SiID='+SiID;
  request.open("POST", "togglefavoritesymptom.php", true);			
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(the_data);		// calls the send() method with datas as parameter

  request.onreadystatechange = function() {
    if (request.readyState == 4) { 
	

if (request.responseText.length > 0)
{


if (document.getElementById("EnType").value == 1)
{
symptomsArray = arrayItDifferently(request.responseText);


var currentClass = document.getElementById("ahreffavoritesymptoms").className; //='coolbuttonlargered')
var symptomselect = document.getElementById("aesymptomselect");




var SiID = symptomselect[symptomselect.selectedIndex].value;
var sympName = '';

for (var i=0; i<symptomsArray.length; i++)
{
if (symptomsArray[i][0] == SiID)
sympName =  symptomsArray[i][1];
}

if (currentClass == 'coolbuttonlargered')
{

symptomselect[symptomselect.selectedIndex].text = sympName;

}
else
{
symptomselect[symptomselect.selectedIndex].text = '*' + sympName + '*';
}

toggleAddToFavoritesButton();
}
else
{
medicationsArray = arrayItDifferently(request.responseText);


var currentClass = document.getElementById("ahreffavoritemedications").className; //='coolbuttonlargered')
var symptomselect = document.getElementById("aemedicationselect");




var SiID = symptomselect[symptomselect.selectedIndex].value;
var sympName = '';

for (var i=0; i<medicationsArray.length; i++)
{
if (medicationsArray[i][0] == SiID)
sympName =  medicationsArray[i][1];
}

if (currentClass == 'coolbuttonlargered')
{

symptomselect[symptomselect.selectedIndex].text = sympName;

}
else
{
symptomselect[symptomselect.selectedIndex].text = '*' + sympName + '*';
}

toggleAddToFavoritesButton();
}




}

}
toggle("spinner",0,-1);
}
}


function clearNotes()
{
document.getElementById("aenotestextarea").value = '';
}

function menuButtonPressed(buttonInt)
{
if (buttonInt == 0)
{
toggle("aboutView",0,1);
}
if (buttonInt == 1)
{
toggle("trackerView",0,1);
refreshToday();
}
if (buttonInt == 2)
{
alert("This is not available yet.");
}
}

function createReportPressed(buttonInt)
{
toggle("reportView",0,1);
}


function reportButtonPressed(buttonInt)
{
if (buttonInt == 0)
{
toggle("symptomChartView",0,1);
}
if (buttonInt == 1)
{
toggle("exportReportView",0,1);
}
}


function returnDate(dateint,returnType)
{

var yearint = (dateint - dateint % 10000)/10000;
dateint = dateint - yearint*10000;
var monthint = (dateint - dateint % 100)/100;
dateint = dateint - monthint*100;
var dayint = dateint;
 //echo $dateint;
 
 
 
 var m_names = new Array("January", "February", "March", 
"April", "May", "June", "July", "August", "September", 
"October", "November", "December");

if (returnType == 1)
return m_names[monthint - 1] + ' ' + dayint + ', ' + yearint;
if (returnType == 2)
return monthint + '/' + dayint + '/' + yearint;

}

function returnTime(dateint,returnType)
{

var hoursintpre = (dateint - dateint % 100)/100;
var hoursint = 0;
var ampm = "";

if (hoursintpre == 0)
hoursint = 12;
else if (hoursintpre > 12)
hoursint = hoursintpre - 12;
else
hoursint = hoursintpre;

if (hoursintpre < 12)
ampm = "AM";
else
ampm = "PM";


dateint = dateint - hoursintpre*100;
var minutesint = dateint;
var extrazero = "";
if (minutesint < 10)
extrazero = "0";
 //echo $dateint;

if (returnType == 1)
return hoursint + ":" + extrazero + minutesint + ' ' + ampm;

}

function arrayIt(string)
{
var loc_array = new Array();
var array = string.split('*|*|*');
for(var i in array)
{
	var one_location_string = array[i];
    var one_location_array = one_location_string.split('*^*^*');
    loc_array[i] = one_location_array;   
}
return loc_array;
}








</script>
<script src="/js/bootstrap-datepicker.js"></script>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>MitoAction</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="./css/font-awesome.css" rel="stylesheet">
    
    <link href="./css/adminia.css" rel="stylesheet"> 
    
    <link href="./css/datepicker.css" rel="stylesheet"> 
    
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>
<script src="http://jquerymobile.com/demos/1.0b1/experiments/themeswitcher/jquery.mobile.themeswitcher.js"></script>
 
  <script type="text/javascript">
$(function () {
    $('#hccontainer').highcharts({
        title: {
            text: 'Monthly Average Temperature',
            x: -20 //center
        },
        subtitle: {
            text: 'Source: WorldClimate.com',
            x: -20
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Temperature (°C)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '°C'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Tokyo',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
        }, {
            name: 'New York',
            data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
        }, {
            name: 'Berlin',
            data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
        }, {
            name: 'London',
            data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
        }]
    });
});
		</script>
 



 <!--<link href="./css/adminia-responsive.css" rel="stylesheet"> -->
  
    

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
  </head>


<body> <!-- <body onload="refreshToday();"> -->
	<center>
	<script src="../../js/highcharts.js"></script>
<script src="../../js/modules/exporting.js"></script>
	
	<?php
	echo "<input type='hidden' id='UsIDInput' value='$UsID'/>";
	echo "<input type='hidden' id='UsFirstNameInput' value='$UsFirstName'/>";
	echo "<input type='hidden' id='UsLastNameInput' value='$UsLastName'/>";
	echo "<input type='hidden' id='UsEmailInput' value='$UsEmail'/>";
	echo "<input type='hidden' id='UsPatientIDInput' value='$UsPatientID'/>";
	echo "<input type='hidden' id='CurrentSiIDInput' value='-1'/>";
	echo "<input type='hidden' id='CurrentSiTypeInput' value='-1'/>";
	?>
	



<?php
if ($UsID > 0)
{
	echo "<div id = 'logindiv' style='width:300px; 
			border: 2px solid #000000;
			position: absolute;
			top: 0px;
			left:0;
        right:0;
			margin-left:auto;
        margin-right:auto;
        display: none;
			'>";
}
else
{
	echo "<div id = 'logindiv' style='width:300px; 
			border: 2px solid #000000;
			position: absolute;
			top: 0px;
			left:0;
        right:0;
			margin-left:auto;
        margin-right:auto;
        
			'>";
}
?>




				<center>
				<div class='headerbarview'>
				MitoAction
				
				</div>
				
<div style="width:300px; height: 364px; background: #EEEEEE; position: relative;">
				</div>
							
<div style=
"text-align: left;
color: black;
width:260px;
top: 50px;
left: 20px;
height: 30px;
position: absolute;">Email Address</div>

<input type='text' id='loginemail'  style="
text-align: center;
width:260px;
top: 80px;
left: 20px;
height: 50px;
position: absolute;"
></input>

<div style=
"text-align: left;
color: black;
width:260px;
top: 136px;
left: 20px;
height: 30px;
position: absolute;">Password</div>

<input type='password' id='loginpassword' style="
text-align: center;
width:260px;
top: 166px;
left: 20px;
height: 50px;
position: absolute;"></input>

<a href='javascript:loginPressed()' rel='ahreflogin' id='ahreflogin' class='coolbutton' style='right: 20px;
top: 230px;
position: absolute;
'>Login</a>

<div style=
"text-align: center;
color: black;
width:260px;
top: 300px;
left: 20px;
height: 30px;
position: absolute;">Don't have an account?</div>

<a href='javascript:newAccountPressed()' rel='ahrefnewaccount' id='ahrefnewaccount' class='coolbuttonlarge' style='left: 30px;
top: 340px;
position: absolute;
'>Create a Free Account</a>

			
				
				
				<!-- 
				<div class='headerbarview'>
				Tracker 
				
				
				</div>
				-->
</div>

<?php
if ($UsID > 0)
{
	echo "<div id = 'welcomediv' style='width:300px; 
			border: 2px solid #000000;
			position: absolute;
			top: 0px;
			left:0;
        right:0;
			margin-left:auto;
        margin-right:auto;
			'>";
}
else
{
	echo "<div id = 'welcomediv' style='width:300px; 
			border: 2px solid #000000;
			position: absolute;
			top: 0px;
			left:0;
        right:0;
			margin-left:auto;
        margin-right:auto;
        display: none;
			'>";
}
?>



				<center>
				<div class='headerbarview' id='welcomeheader'>
					Welcome, <?php echo $_SESSION['UsFirstName']; ?>!
				
				
				</div>
				
<div style="width:300px; height: 364px; 

background: url(../img/body-bg.png) repeat 0 0;
 position: relative;">
				</div>
							



<div onClick='menuButtonPressed(0)' class='menubutton' style='
left: 10px;
top: 100px;'>

<div class='menubuttonicon'>
<center><img src='icons/aboutusicon.png' width='40px' height='40px'/></center>
</div>

<div class='menubuttonlabel'>About Us</div>

</div>

<div onClick='menuButtonPressed(1)' class='menubutton' style='
left: 110px;
top: 100px;'>

<div class='menubuttonicon'>
<center><img src='icons/trackericon.png' width='40px' height='40px'/></center>
</div>

<div class='menubuttonlabel'>Tracker</div>

</div>

<div onClick='menuButtonPressed(2)' class='menubutton' style='
left: 210px;
top: 100px;'>

<div class='menubuttonicon'>
<center><img src='icons/glossaryicon.png' width='40px' height='40px'/></center>
</div>

<div class='menubuttonlabel'>Glossary</div>

</div>



<a href='javascript:editAccountPressed()' rel='ahrefeditaccount' id='ahrefeditaccount' class='coolbuttonlarge' style='left: 30px;
top: 280px;
position: absolute;
'>Edit Account Settings</a>

<a href='javascript:signoutAccountPressed()' rel='ahrefsignoutaccount' id='ahrefsignoutaccount' class='coolbuttonlarge' style='left: 30px;
top: 340px;
position: absolute;
'>Sign Out</a>

			
				
				
				<!-- 
				<div class='headerbarview'>
				Tracker 
				
				
				</div>
				-->
</div>







<!-- New Account Creation

First Name
Last Name
Email
Password
Patient ID

-->


<div id = 'newaccountdiv' style='width:300px; 
			border: 2px solid #000000;
			position: absolute;
			top: 0px;
			left:0;
        right:0;
			margin-left:auto;
        margin-right:auto;
        display: none;
			'>


				<center>
				<div class='headerbarview' id='addeditaccountheader'>
				Create a New Account
				
				</div>
				
<div style="width:300px; height: 364px; background: #EEEEEE; position: relative;">
				</div>
							
<div style=
"text-align: left;
color: black;
width:260px;
top: 46px;
left: 20px;
height: 30px;
line-height: 30px;
position: absolute;">First Name</div>

<input type='text' id='registerfirstname'  style="
text-align: center;
width:260px;
top: 76px;
left: 20px;
height: 30px;
position: absolute;"
></input>

<div style=
"text-align: left;
color: black;
width:260px;
top: 106px;
left: 20px;
height: 30px;
line-height: 30px;
position: absolute;">Last Name</div>

<input type='text' id='registerlastname' style="
text-align: center;
width:260px;
top: 136px;
left: 20px;
height: 30px;
position: absolute;"></input>

<div style=
"text-align: left;
color: black;
width:260px;
top: 166px;
left: 20px;
height: 30px;
line-height: 30px;
position: absolute;">Email Address</div>

<input type='text' id='registeremail' style="
text-align: center;
width:260px;
top: 196px;
left: 20px;
height: 30px;
position: absolute;"></input>

<div style=
"text-align: left;
color: black;
width:260px;
top: 226px;
left: 20px;
height: 30px;
line-height: 30px;
position: absolute;">Password</div>

<input type='password' id='registerpassword' style="
text-align: center;
width:260px;
top: 256px;
left: 20px;
height: 30px;
position: absolute;"></input>

<a href='javascript:changePassword()' id='changepassword' class='coolbutton' style='left: 20px;
top: 256px;
height: 20px;
width: 250px;
position: absolute;
padding: 5px 5px 5px 5px;
'>Change Password</a>

<div style=
"text-align: left;
color: black;
width:260px;
top: 286px;
left: 20px;
height: 30px;
line-height: 30px;
position: absolute;">Patient ID</div>

<input type='text' id='registerpatientid' style="
text-align: center;
width:260px;
top: 316px;
left: 20px;
height: 30px;
position: absolute;"></input>

<a href='javascript:cancelNewAccount()' class='coolbutton' style='left: 20px;
top: 356px;
position: absolute;
'>Cancel</a>

<a href='javascript:registerNewAccount()' rel='ahreflogin' id='ahreflogin' class='coolbutton' style='right: 20px;
top: 356px;
position: absolute;
'><div id='addeditaccountsavetext'>Register</div></a>



			
				
				
				<!-- 
				<div class='headerbarview'>
				Tracker 
				
				
				</div>
				-->
</div>
	
<div id='grayview' class='grayview' style='display: none'></div>
<div id='spinner' class='spinner' style='display: none'>
<img src='/spinner.gif'/>
</div>
<div id='calview' class='calview' style='display: none'>
<div class='headerbarview'>
				Choose Date <?php echo count($symptomArray);?>
				
				</div>
				<br>
<select name='calyear' id='calyear' class='selectstyle'>
<?php
$firstYear = 2012;
$thisYear = date("Y");
for ($a = $firstYear; $a <= $thisYear; $a++)
echo "<option value='$a' style='text-align:center;'><center>$a</option>";
echo "</select><br><br>";
$months = array("January","February","March","April","May","June","July","August","September","October","November","December");
echo "<select name='calmonth' id='calmonth' class='selectstyle'>";
$monthcount = 1;
foreach($months as $value)
{
echo "<option value='$monthcount'>$value</option>";
$monthcount++;
}
echo "</select><br><br>";
echo "<select name='calday' id='calday' class='selectstyle'>";
for($day = 1; $day <= 31; $day++)
{
echo "<option value='$day'>$day</option>";
}
echo "</select><br><br>";


?>
<a href='#' onClick='cancelCalendar()' class='coolbutton' style='left: 10px;
top: 402px;
position: absolute;
'>Cancel</a>

<a href='#' onClick='toggleCalendar()' class='coolbutton' style='right: 10px;
top: 402px;
position: absolute;
'>Save</a>

</select>
</div>

<div id='addeditview' class='calview' style='display: none'>
<input id='EnID' type='hidden' value='0'/>
<input id='EnSiID' type='hidden' value='0'/>
<input id='EnType' type='hidden' value='0'/>
<input id='EnDate' type='hidden' value='0'/>
<input id='EnTime' type='hidden' value='0'/>
<input id='EnQty' type='hidden' value='0'/>
<input id='EnUnID' type='hidden' value='0'/>
<input id='EnNotes' type='hidden' value=''/>
<div class='headerbarview' id='aeheaderbarview'>New Entry</div>

<div style='position: absolute; text-align:left; left: 10px; top: 50px; width: 160px; font-weight: bold;'>Date</div>
<div style='position: absolute; text-align:left; left: 190px; top: 50px; width: 100px; font-weight: bold;'>Time</div>
<div id='ffview3label' style='position: absolute; text-align:left; left: 10px; top: 150px; width: 160px; font-weight: bold;'>Name</div>
<div id='ffview4label' style='position: absolute; text-align:left; left: 190px; top: 150px; width: 100px; font-weight: bold;'>Severity</div>
<div style='position: absolute; text-align:left; left: 10px; top: 250px; width: 160px; font-weight: bold;'>Notes</div>

<a href='javascript:ffviewclicked("aecalview")' class='ffview' style='position: absolute; left: 10px; top: 80px; width: 160px;'><div id='ffview1'>Date</div></a>
<a href='javascript:ffviewclicked("aetimeview")' class='ffview' style='position: absolute; left: 190px; top: 80px; width: 100px;'><div id='ffview2'>Time</div></a>
<a href='javascript:ffviewclicked("aenameview")' class='ffview' style='position: absolute; left: 10px; top: 180px; width: 160px;'><div id='ffview3'>Click to Select</div></a>
<a href='javascript:ffviewclicked("aeseverityview")' class='ffview' style='position: absolute; left: 190px; top: 180px; width: 100px;'><div id='ffview4'>Click to Select</div></a>
<a href='javascript:ffviewclicked("aenotesview")' class='ffview' style='position: absolute; left: 10px; top: 280px; width: 280px; height:100px;'><div id='ffview5'>Click to Enter Notes</div></a>


<a href='#' onClick='cancel("addeditview",1)' class='coolbutton' style='left: 10px;
top: 402px;
position: absolute;
'>Cancel</a>

<a href='#' onClick='save("addeditview")' class='coolbutton' style='right: 10px;
top: 402px;
position: absolute;
'>Save</a>

</div>


<div id='newentryview' class='calview' style='display: none'>
<div class='headerbarview'>
				New Entry
				</div>
				<br>

<!-- Symptom -->			
<div onClick='newEntry(1)' class='newentrybutton' style='background: #FF0000;
left: 40px;
top: 70px;'>

<div class='newentrybuttonicon'>
<center><img src='icons/type1blankicon.png' width='40px' height='40px'/></center>
</div>

<div class='newentrybuttonlabel'>Symptom</div>

</div>

<!-- Medication -->			
<div onClick='newEntry(2)' class='newentrybutton' style='background: #006600;
right: 40px;
top: 70px;'>

<div class='newentrybuttonicon'>
<center><img src='icons/type2blankicon.png' width='60px' height='40px'/></center>
</div>

<div class='newentrybuttonlabel'>Medication</div>

</div>

<!-- Nutrition -->			
<div onClick='newEntry(3)' class='newentrybutton' style='background: #0000FF;
left: 40px;
top: 180px;'>

<div class='newentrybuttonicon'>
<center><img src='icons/type3blankicon.png' width='60px' height='40px'/></center>
</div>

<div class='newentrybuttonlabel'>Nutrition</div>

</div>

<!-- Hydration -->			
<div onClick='newEntry(4)' class='newentrybutton' style='background: #FF6600;
right: 40px;
top: 180px;'>

<div class='newentrybuttonicon'>
<center><img src='icons/type4blankicon.png' width='40px' height='40px'/></center>
</div>

<div class='newentrybuttonlabel'>Hydration</div>

</div>

<!-- Note -->			
<div onClick='newEntry(5)' class='newentrybutton' style='background: #CCCC00;
left: 110px;
top: 290px;'>

<div class='newentrybuttonicon'>
<center><img src='icons/type5blankicon.png' width='40px' height='40px'/></center>
</div>

<div class='newentrybuttonlabel'>Note</div>

</div>
				
<a href='#' onClick='cancel("newentryview",1)' class='coolbutton' style='left: 10px;
top: 402px;
position: absolute;
'>Cancel</a>




</select>
</div>


<div id='aecalview' class='calview' style='display: none'>
<div class='headerbarview'>
				Choose Date
				
				</div>
				<br>
<select name='aecalyear' id='aecalyear' class='selectstyle'>
<?php
$firstYear = 2012;
$thisYear = date("Y");
for ($a = $firstYear; $a <= $thisYear; $a++)
echo "<option value='$a' style='text-align:center;'><center>$a</option>";
echo "</select><br><br>";
$months = array("January","February","March","April","May","June","July","August","September","October","November","December");
echo "<select name='aecalmonth' id='aecalmonth' class='selectstyle'>";
$monthcount = 1;
foreach($months as $value)
{
echo "<option value='$monthcount'>$value</option>";
$monthcount++;
}
echo "</select><br><br>";
echo "<select name='aecalday' id='aecalday' class='selectstyle'>";
for($day = 1; $day <= 31; $day++)
{
echo "<option value='$day'>$day</option>";
}
echo "</select><br><br>";


?>
<a href='#' onClick='cancel("aecalview",0)' class='coolbutton' style='left: 10px;
top: 402px;
position: absolute;
'>Cancel</a>

<a href='#' onClick='save("aecalview")' class='coolbutton' style='right: 10px;
top: 402px;
position: absolute;
'>Save</a>

</div>

<div id='aetimeview' class='calview' style='display: none'>
<div class='headerbarview'>
				Choose Time
				
				</div>
				<br>
<select name='aetimehour' id='aetimehour' class='selectstylesmall'>
<?php
$firstHour = 1;
for ($a = $firstHour; $a <= 12; $a++)
echo "<option value='$a' style='text-align:right;'>$a</option>";
echo "</select>:
<select name='aetimeminute' id='aetimeminute' class='selectstylesmall'>";
$firstMinute = 0;
for ($b = $firstMinute; $b <= 59; $b++)
{
echo "<option value='$b'>";
if ($b < 10)
echo "0";
echo "$b</option>";
}

echo "</select> &nbsp&nbsp&nbsp&nbsp
";

echo "<select name='aetimeampm' id='aetimeampm' class='selectstylesmall'>";
echo "<option value='1'><center>AM</center></option>";
echo "<option value='2'><center>PM</center></option>";
echo "</select><br><br>";


?>
<a href='#' onClick='cancel("aetimeview",0)' class='coolbutton' style='left: 10px;
top: 402px;
position: absolute;
'>Cancel</a>

<a href='#' onClick='save("aetimeview")' class='coolbutton' style='right: 10px;
top: 402px;
position: absolute;
'>Save</a>

</div>




<div id='aesymptomview' class='calview' style='display: none'>
<div class='headerbarview'>
				Select Symptom
				
				</div>
				<br>
<div id='aesymptomselectoptions'>
<select name='aesymptomselect' id='aesymptomselect' onchange='toggleAddToFavoritesButton()' class='selectstylelarge'>
<?php
for ($a = 0; $a < count($symptomArrayFavorites); $a++)
{
$b = $symptomArrayFavorites[$a][0];
$c = '*'.$symptomArrayFavorites[$a][1].'*';
echo "<option value='$b' style='text-align:right;'>$c</option>";
}
for ($a = 0; $a < count($symptomArrayNonFavorites); $a++)
{
$b = $symptomArrayNonFavorites[$a][0];
$c = $symptomArrayNonFavorites[$a][1];
echo "<option value='$b' style='text-align:right;'>$c</option>";
}
?>

</select>
</div>
<br><br>";




<a href='javascript:addToFavoriteSymptomsPressed()' rel='ahreffavoritesymptoms' id='ahreffavoritesymptoms' class='coolbuttonlarge' style='left: 30px;
top: 120px;
position: absolute;
'>Add to Favorite Symptoms</a>

<div class='headerbarviewgray' style='top: 200px; position: absolute;'>
				Add a New Symptom
				
				</div>


<div id='togglenewsymptomswitch' class='toggleswitch' style='left: 30px;
top: 260px;
position: absolute;
'>
<div id='togglenewsymptomnobutton' onClick='togglenewsymptombutton(0)' class='toggleswitchbuttonred' style='left: 0px;
top: 0px;
position: absolute;
'>
<div id='togglenewsymptomnobuttoncircle' class='circlegold'></div>
<div id='togglenewsymptomnobuttontext' class='tsbtext'>NO</div>
</div>
<div id='togglenewsymptomyesbutton' onClick='togglenewsymptombutton(1)' class='toggleswitchbuttongray' style='left: 120px;
top: 0px;
position: absolute;
'>
<div id='togglenewsymptomyesbuttoncircle' class='circlegray'></div>
<div id='togglenewsymptomyesbuttontext' class='tsbtext'>YES</div>
</div>
</div>

<div id='newsymptomview'>
<input type='text' id='newsymptomname' onclick='removeplaceholdertext(1)' style="
text-align: center;
width:240px;
top: 320px;
left: 30px;
height: 50px;
position: absolute;"
value = 'Enter new symptom here'></input>
</div>


<a href='#' onClick='cancel("aesymptomview",0)' class='coolbutton' style='left: 10px;
top: 402px;
position: absolute;
'>Cancel</a>

<a href='#' onClick='save("aesymptomview")' class='coolbutton' style='right: 10px;
top: 402px;
position: absolute;
'>Save</a>

</div>








<div id='aemedicationview' class='calview' style='display: none'>
<div class='headerbarview'>
				Select Medication
				
				</div>
				<br>
<div id='aemedicationselectoptions'>
<select name='aemedicationselect' id='aemedicationselect' onchange='toggleAddToFavoritesButton()' class='selectstylelarge'>
<?php
for ($a = 0; $a < count($medicationArrayFavorites); $a++)
{
$b = $medicationArrayFavorites[$a][0];
$c = '*'.$medicationArrayFavorites[$a][1].'*';
echo "<option value='$b' style='text-align:right;'>$c</option>";
}
for ($a = 0; $a < count($medicationArrayNonFavorites); $a++)
{
$b = $medicationArrayNonFavorites[$a][0];
$c = $medicationArrayNonFavorites[$a][1];
echo "<option value='$b' style='text-align:right;'>$c</option>";
}
?>

</select>
</div>
<br><br>";




<a href='javascript:addToFavoriteMedicationsPressed()' rel='ahreffavoritemedications' id='ahreffavoritemedications' class='coolbuttonlarge' style='left: 30px;
top: 120px;
position: absolute;
'>Add to Favorite Medications</a>

<div class='headerbarviewgray' style='top: 200px; position: absolute;'>
				Add a New Medication
				
				</div>


<div id='togglenewmedicationswitch' class='toggleswitch' style='left: 30px;
top: 260px;
position: absolute;
'>
<div id='togglenewmedicationnobutton' onClick='togglenewmedicationbutton(0)' class='toggleswitchbuttonred' style='left: 0px;
top: 0px;
position: absolute;
'>
<div id='togglenewmedicationnobuttoncircle' class='circlegold'></div>
<div id='togglenewmedicationnobuttontext' class='tsbtext'>NO</div>
</div>
<div id='togglenewmedicationyesbutton' onClick='togglenewmedicationbutton(1)' class='toggleswitchbuttongray' style='left: 120px;
top: 0px;
position: absolute;
'>
<div id='togglenewmedicationyesbuttoncircle' class='circlegray'></div>
<div id='togglenewmedicationyesbuttontext' class='tsbtext'>YES</div>
</div>
</div>

<div id='newmedicationview'>
<input type='text' id='newmedicationname' onclick='removeplaceholdertext(2)' style="
text-align: center;
width:240px;
top: 320px;
left: 30px;
height: 50px;
position: absolute;"
value = 'Enter new medication here'></input>
</div>


<a href='#' onClick='cancel("aemedicationview",0)' class='coolbutton' style='left: 10px;
top: 402px;
position: absolute;
'>Cancel</a>

<a href='#' onClick='save("aemedicationview")' class='coolbutton' style='right: 10px;
top: 402px;
position: absolute;
'>Save</a>

</div>















<div id='aeseverityview' class='calview' style='display: none'>
<div class='headerbarview'>
				Select Severity
				
				</div>
				<br>	
				
				
<?php

for ($a = 0; $a < 10; $a++)
{
$x = 50+($a % 2)*100;
$y = 70+($a - ($a % 2))/2*60;
$b = $a+1;

//echo "<div class='severityblockgray' style='position: absolute; left: 100px; top: 200px;'></div>";

echo "<div class='severityblockgray' id='severityblock$b' onClick='severitypressed($b)' style='position: absolute; left: $x; top: $y;'>
<div class='sevblocktitle'>";
if ($a < 2)
echo "Mild";
else if ($a < 4)
echo "Medium";
else if ($a < 6)
echo "Bad";
else if ($a < 8)
echo "Severe";
else
echo "Horrible";

echo "</div>
<div class='sevblocknumber'>$b</div>

</div>";

}
?>

<a href='#' onClick='cancel("aeseverityview",0)' class='coolbutton' style='left: 10px;
top: 402px;
position: absolute;
'>Cancel</a>

<a href='#' onClick='save("aeseverityview")' class='coolbutton' style='right: 10px;
top: 402px;
position: absolute;
'>Save</a>

</div>


<div id='aenotesview' class='calview' style='display: none'>
<div class='headerbarview'>
				Enter Notes
				
				</div>
				<br>


<textarea id='aenotestextarea' style='resize: none; width: 240px; height: 100px;'>


</textarea>

<a href='javascript:clearNotes()' rel='ahreffavoritesymptoms' id='ahreffavoritesymptoms' class='coolbuttonlargered' style='left: 30px;
top: 180px;
position: absolute;
'>Clear Notes</a>


<a href='#' onClick='cancel("aenotesview",0)' class='coolbutton' style='left: 10px;
top: 402px;
position: absolute;
'>Cancel</a>

<a href='#' onClick='save("aenotesview")' class='coolbutton' style='right: 10px;
top: 402px;
position: absolute;
'>Save</a>

</div>






<div id='aedosageview' class='calview' style='display: none'>
<div class='headerbarview'>
				Enter Dosage
				
				</div>
				<br>	
				
				




<div id='newdosageview'>
<input type='text' id='newdosageamount' onclick='removeplaceholdertext(3)' style="
text-align: center;
width:120px;
top: 90px;
left: 55px;
height: 50px;
position: absolute;"
value = 'Enter amount here'></input>


<select name='newdosageunit' id='newdosageunitselect' class='selectstylesmall' style="
top: 90px;
left: 195px;
height: 50px;
position: absolute;">
<option value='1'>ml</option>
<option value='2'>mg</option>

</select>

</div>



<br><br>

<div id='existingdosageview'>
<div class='headerbarviewgray' style='top: 200px; position: absolute;'>
				Choose an Existing Dosage
				
				</div>


<div id='togglenewdosageswitch' class='toggleswitch' style='left: 30px;
top: 260px;
position: absolute;
'>
<div id='togglenewdosagenobutton' onClick='togglenewdosagebutton(0)' class='toggleswitchbuttonred' style='left: 0px;
top: 0px;
position: absolute;
'>
<div id='togglenewdosagenobuttoncircle' class='circlegold'></div>
<div id='togglenewdosagenobuttontext' class='tsbtext'>NO</div>
</div>
<div id='togglenewdosageyesbutton' onClick='togglenewdosagebutton(1)' class='toggleswitchbuttongray' style='left: 120px;
top: 0px;
position: absolute;
'>
<div id='togglenewdosageyesbuttoncircle' class='circlegray'></div>
<div id='togglenewdosageyesbuttontext' class='tsbtext'>YES</div>
</div>
</div>



<div id='aedosageselectoptions' style='
top: 320px;
position: absolute;'
>
<center>
<select name='aedosageselect' id='aedosageselect' class='selectstylelarge'>


</select>
</center>
</div>
</div>


<a href='#' onClick='cancel("aedosageview",0)' class='coolbutton' style='left: 10px;
top: 402px;
position: absolute;
'>Cancel</a>

<a href='#' onClick='save("aedosageview")' class='coolbutton' style='right: 10px;
top: 402px;
position: absolute;
'>Save</a>

</div>




<div id='reportView' class='calview' style='display: none;
background: url(../img/body-bg.png) repeat 0 0;
'>
<div class='headerbarview'>

				<img style='left: 20px;
top: 5px;
position: absolute;' src='img/back_button.png' onClick='toggle("reportView",0,0)' width='50' height='33'/>


				Create Report
				
				</div>
				




							



<div onClick='reportButtonPressed(0)' class='menubuttonlarge' style='
left: 70px;
top: 60px;'>

<div class='menubuttonlargeicon'>
<center><img src='icons/symptomcharticon.png' width='80px' height='80px'/></center>
</div>

<div class='menubuttonlargelabel'>Symptom Chart</div>

</div>

<div onClick='reportButtonPressed(1)' class='menubuttonlarge' style='
left: 70px;
top: 250px;'>

<div class='menubuttonlargeicon'>
<center><img src='icons/fullreporticon.png' width='80px' height='80px'/></center>
</div>

<div class='menubuttonlargelabel'>Full Report</div>

</div>





</div>



<div id='symptomChartView' class='calview' style='display: none;'>

<div class='headerbarview'>

				<img style='left: 20px;
top: 5px;
position: absolute;' src='img/back_button.png' onClick='toggle("symptomChartView",0,0)' width='50' height='33'/>


				Symptom Chart
				
				</div>
				
				<div id="hccontainer" style="width:280px; height:300px;"></div>




</div>









			
			
			
			<div id='trackerView' style='width:300px; 
			border: 2px solid #000000;
			background-color: #000000;
			position: absolute;
			top: 0px;
			left:0;
        right:0;
			margin-left:auto;
        margin-right:auto;
        display: none;
			'>
				
					
				<div class='headerbarview'>

				<img style='left: 20px;
top: 5px;
position: absolute;' src='img/back_button.png' onClick='toggle("trackerView",0,0)' width='50' height='33'/>


				Tracker 
				
				</div>

				<div class='dateview'>
				<input id='DateViewDate' type='hidden' value='20130625'/>
				<img style='left: 24px;
top: 8px;
position: absolute;' src='icons/83-calendar@2x.png' onClick='toggleCalendar()' width='28' height='28'/>

<img style='right: 24px;
top: 8px;
position: absolute;' src='icons/331-circle-plus@2x.png' onClick='toggle("newentryview",1,0)' width='28' height='28'/>

				
				<div id='dateviewdate'>
				<!--<?php echo returnDate(20130625,1); ?>-->
				</div>
				</div>
				<div id='dayview'>
				
				
				<?php
				
				$resultb = mysql_query("SELECT * from vwEntryDetail where EnUsID = $UsID and EnDate = 20130629 order by EnTime") or die(mysql_error());
				while($result = mysql_fetch_array($resultb))
				{
				//$FuID = $result['FuID'];
				}
				
				?>
				
				
				
				<!--
				
				<div style="width:300px; height: 40px; background: #EEEEEE; position: relative;">
				<img style='left: 7px;
top: 7px;
position: absolute;
border-radius: 4px;
' src='icons/type1icon.png' width='26' height='26'/>
				<div align='left' style='left: 40px;
top: 2px;
position: absolute;
height: 16px;
width: 70px'>12/25/2013
</div>
<div align='left' style='left: 40px;
top: 20px;
position: absolute;
height: 16px;
width: 70px;
font-size: 12px;
color: #336600;
'><b>1:40 PM</b>
</div>


<div align='left' style='left: 120px;
top: 2px;
position: absolute;
height: 16px;
width: 140px'><b>Shivering</b>
</div>
<div align='left' style='left: 120px;
top: 20px;
position: absolute;
height: 16px;
width: 140px;
font-size: 12px;
'>8 (Severe)
</div>
<img style='right: 6px;
top: 6px;
position: absolute;
' src='icons/Pencil.png' width='28' height='28'/>

				</div>
				<div class='svview' style="background: #CCCCCC">
				
				<img class='svicon' src='icons/type2icon.png'/>
				<div class='svdate'><?php echo returnDate(20131126,2); ?></div>
				<div class='svtime'>2:03 PM</div>
				<div class='svname'>Advil</div>
				<div class='svseverity'>10 ml</div>
				<img class='svpencil' src='icons/Pencil.png'/>
				
				</div>
				<div style="width:300px; height: 40px; background: #EEEEEE; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #CCCCCC; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #EEEEEE; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #CCCCCC; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #EEEEEE; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #CCCCCC; position: relative;">
				</div>
				
				-->

				<div style="width:300px; height: 40px; background: #EEEEEE; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #CCCCCC; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #EEEEEE; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #CCCCCC; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #EEEEEE; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #CCCCCC; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #EEEEEE; position: relative;">
				</div>
				<div style="width:300px; height: 40px; background: #CCCCCC; position: relative;">
				</div>



				</div> 
				
				<a href='javascript:createReportPressed()' class='coolbuttonmediumred' style='left: 30px;
top: 410px;
position: absolute;'>Create Report</a>
				
				<!-- end of dayview -->
				<div class='headerbarview'>
				<!--Tracker! -->
				
		
				
				
				</div>
</div>









<div id='aboutView' style='width:300px; 
			border: 2px solid #000000;
			background: url(../img/body-bg.png) repeat 0 0;
			position: absolute;
			top: 0px;
			left:0;
        right:0;
			margin-left:auto;
        margin-right:auto;
        display: none;
			'>
				
					
				<div class='headerbarview'>

				<img style='left: 20px;
top: 5px;
position: absolute;' src='img/back_button.png' onClick='toggle("aboutView",0,0)' width='50' height='33'/>


				About Us 
				
				</div>

				
				<div style="width:300px; height: 364px; position: relative;">
				
				<div style="width:300px; top: 10px; height: 30px; position: relative;
				font-size: 20px;
text-align:center;
font-weight: bold;">
				Our Help-Line
				</div>
				<div style="width:300px; top: 10px; height: 30px; position: relative;
				font-size: 24px;
text-align:center;
font-weight: bold;
color: #44AA11;">
				1-888-MITO-411
				</div>
				<div style="width:300px; top: 76px; height: 30px; position: absolute;
				font-size: 20px;
text-align:center;
font-weight: bold;">
				Mission Statement
				</div>
				<div style="width:280px; left: 10px; top: 100px; height: 30px; position: absolute;
				font-size: 15px;
text-align:center;
font-weight: bold;
color: #44AA11;">
				MitoAction's mission is to improve quality of life for all who are affected by Mitochondrial disorders through support, education, and advocacy initiatives.
				</div>
				<div style="width:150px; top: 215px; height: 30px; position: absolute;
				font-size: 16px;
text-align:center;
font-weight: bold;
color: #000000;">
				Feedback
				</div>
				<div style="width:150px; top: 238px; position: absolute;
				font-size: 11px;
				line-height: 1.5;
text-align:center;
font-weight: bold;
color: #44AA11;">
				Have any questions or comments? Send us an email at <a href='mailto:info@mitoaction.org'>info@mitoaction.org</a>
				</div>
				<div style="width:150px; top: 215px; left: 150px; height: 30px; position: absolute;
				font-size: 16px;
text-align:center;
font-weight: bold;
color: #000000;">
				Donate
				</div>
				<div style="width:150px; top: 238px; left: 150px; position: absolute;
				font-size: 11px;
				line-height: 1.5;
text-align:center;
font-weight: bold;
color: #44AA11;">
				Support this app and other programs by making a $5 donation at <a href='http://mitoaction.org/donate' target='_blank'>mitoaction.org/donate</a>
				</div>
				
				
				
				<a href='#' onClick='toggle("FAQPage",0,0)' class='coolbuttonlarge' style='
top: 316px;
left: 30px;
position: absolute;
'>View MitoAction FAQ's</a>
				
				
				
				</div>

				
				<!-- end of aboutview -->
				
</div>


<div id='FAQPage' style='width:300px; 
			border: 2px solid #000000;
			background: url(../img/body-bg.png) repeat 0 0;
			position: absolute;
			top: 0px;
			left:0;
        right:0;
			margin-left:auto;
        margin-right:auto;
        display: none;
        height: 408px;
			'>
<div class='headerbarview'>

				<img style='left: 20px;
top: 5px;
position: absolute;' src='img/back_button.png' onClick='toggle("FAQPage",0,0)' width='50' height='33'/>


				MitoAction FAQ's 
				
				</div>
<div data-role="page" style='width:300px; height: 364px; top: 44px; position: absolute;'>
<!--
	<div data-role="header">
		<h1>My Title</h1>
	</div>
	-->



<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>What are Mitochondria?</font></h3>
   <h3><font color='44AA11'>What are Mitochondria?</font></h3>
  
  <div style='text-align: left;'>
  <ul>
<li>Mitochondria are tiny organelles found in almost every cell in the body.</li>
<li>They are known as the "powerhouse of the cell." </li>
<li>They are responsible for creating more than 90% of cellular energy. </li>
<li>They are necessary in the body to sustain life and support growth. </li>
<li>They are composed of tiny packages of enzymes that turn nutrients into cellular energy </li>
<li>Mitochondrial failure causes cell injury that leads to cell death. When multiple organ cells die there is organ failure.</li>
</ul>
</div>
<center>
Watch the 5-minute video, "How Energy is Made"<br><br>
<object style="height: 183px; width: 300px"><param name="movie" value="http://www.youtube.com/v/6_2oN1oTK-g?version=3&feature=player_embedded"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="http://www.youtube.com/v/6_2oN1oTK-g?version=3&feature=player_embedded" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="300" height="183"></object>
</center>
   
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>What is Mitochondrial Disease?</font></h3>
   <h3><font color='44AA11'>What is Mitochondrial Disease?</font></h3>
   <ul>
<li>Mitochondrial disease is a chronic, genetic disorder that occurs when the mitochondria of the cell fails to produce enough energy for cell or organ function.</li>
<li>The incidence about 1:3000-4000 individuals in the US. This is similar to the incidence of cystic fibrosis of caucasian births in the U.S.</li>
<li>There are many forms of mitochondrial disease. </li>
<li>Mitochondrial disease is inherited in a number of different ways </li>
<li>Mitochondrial disease presents very differently from individual to individual. </li>
<li>There may be one individual in a family or many individuals affected over a number of generations.</li>
</ul>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>What are the Symptoms of Mitochondrial Disease?</font></h3>
   <h3><font color='44AA11'>What are the Symptoms of Mitochondrial Disease?</font></h3>
   <p>The severity of mitochondrial disease symptoms is different from person to person. The most common symptoms are:</p>
<ul>
<li>Poor Growth</li>
<li>Loss of muscle coordination, muscle weakness</li>
<li>Neurological problems, seizures</li>
<li>Autism, autistic spectrum, autistic-like features</li>
<li>Visual and/or hearing problems</li>
<li>Developmental delays, learning disabilities</li>
<li>Heart, liver or kidney disease</li>
<li>Gastrointestinal disorders, severe constipation</li>
<li>Diabetes</li>
<li>Increased risk of infection </li>
<li>Thyroid and/or adrenal dysfunction </li>
<li>Autonomic dysfunction </li>
<li>Neuropsychological changes characterized by confusion, disorientation and memory loss. </li>
</ul>
</p>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>How common are mitochondrial diseases?</font></h3>
   <h3><font color='44AA11'>How common are mitochondrial diseases?</font></h3>
   <ul>
<li>About one in 4,000 children in the United States will develop mitochondrial disease by the age of 10 years.</li>
<li>One thousand to 4,000 children per year in the United Sates are born with a type of mitochondrial disease.</li>
<li>In adults, many diseases of aging have been found to have defects of mitochondrial function. </li>
<li>These include, but are not limited to, type 2 diabetes, Parkinson's disease, atherosclerotic heart disease, stroke, Alzheimer's disease, and cancer. In addition, many medicines can injure the mitochondria.</li>
</ul>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>What causes mitochondrial disease?</font></h3>
   <h3><font color='44AA11'>What causes mitochondrial disease?</font></h3>
   <p>For many patients, mitochondrial disease is an inherited condition that runs in families (genetic). An uncertain percentage of patients acquire symptoms due to other factors, including mitochondrial toxins.</p>
<p>It is important to determine which type of mitochondrial disease inheritance is present, in order to predict the risk of recurrence for future children. The types of mitochondrial disease inheritance include:</p>
<ul>
<li>DNA (DNA contained in the nucleus of the cell) inheritance. Also called autosomal inheritance.                   
<ul>
<li>If this gene trait is recessive (one gene from each parent), often no other family members appear to be affected. There is a 25 percent chance of the trait occurring in other siblings.</li>
<li>If this gene trait is dominant (a gene from either parent), the disease often occurs in other family members. There is a 50 percent chance of the trait occurring in other siblings.</li>
</ul>
</li>
</ul>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>MtDNA (DNA contained in the mitochondria) inheritance.</font></h3>
   <h3><font color='44AA11'>MtDNA (DNA contained in the mitochondria) inheritance.</font></h3>
   <ul>
<li>There is a 100 percent chance of the trait occurring in other siblings, since all mitochondria are inherited from the mother, although symptoms might be either more or less severe.</li>
</ul>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>Combination of mtDNA and nDNA defects:</font></h3>
   <h3><font color='44AA11'>Combination of mtDNA and nDNA defects:</font></h3>
   <ul>
<li>Relationship between nDNA and mtDNA and their correlation in mitochondrial formation is unknown</li>
</ul>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>Random occurrences</font></h3>
   <h3><font color='44AA11'>Random occurrences</font></h3>
   <ul>
<li>Diseases specifically from deletions of large parts of the mitochondrial DNA molecule are usually sporadic without affecting other family member</li>
<li>Medicines or other toxic substances can trigger mitochondrial disease</li>
</ul>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>How is Mitochondrial Disease Diagnosed?</font></h3>
   <h3><font color='44AA11'>How is Mitochondrial Disease Diagnosed?</font></h3>
   <ul>
<li>There is no reliable and consistent means of diagnosis.</li>
<li>Diagnosis can be made by one of the few physicians that specializes in mitochondrial disease.</li>
<li>Diagnosis can be made by blood DNA testing and/or muscle biopsy but neither of these tests are completely reliable.</li>
</ul>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>How is Mitochondrial Disease Treated?</font></h3>
   <h3><font color='44AA11'>How is Mitochondrial Disease Treated?</font></h3>
   <ul>
<li>Treatment consists of vitamin therapy and conserving energy.</li>
<li>The goal is to improve symptoms and slow progression of the disease.</li>
<li>Conserve energy</li>
<li>Pace activities</li>
<li>Maintain an ambient environmental temperature</li>
<li>Avoid exposure to illness</li>
<li>Ensure adequate nutrition and hydration</li>
</ul>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>Misdiagnosis</font></h3>
   <h3><font color='44AA11'>Misdiagnosis</font></h3>
   <ul>
<li>Lack of understanding of the disease and misinterpretation of symptoms can lead to misdiagnosis.</li>
<li>Further progression of symptoms can occur if the symptoms are missed and opportunities for treatment and support are not recognized.</li>
</ul>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>What are the Challenges of living with Mitochondrial Disease?</font></h3>
   <h3><font color='44AA11'>What are the Challenges of living with Mitochondrial Disease?</font></h3>
   <ul>
<li>Affects multiple organs, affects multiple family members, affects multiple generations.</li>
<li>Lack of awareness and understanding of the disease</li>
<li>Families are continuously forces to expend their very limited energy to explain their disease, advocate for themselves and fight for services. </li>
<li>Mitochondrial disease is often an " invisible disease."                   
<ul>
<li>Good day - patients look fine and healthy. They have more energy and appear rested. </li>
<li>Bad day - - patients appear tired to significantly ill. They are obviously fatigued and/or have significant illness. Repeated "bad days"often lead to decompensation and patients have difficulty returning to baseline.</li>
</ul>
</li>
<li></li>
<li>Mitochondrial disease is unpredictable. Day to day, hour to hour patients can develop symptoms and their stability can be threatened.</li>
<li>Difficulties establishing a diagnosis interfere with a patient's ability to obtain adequate recognition, medical care, adequate insurance coverage, healthcare supports and disability services.</li>
<li>Lack of understanding of the disease and misinterpretation of symptoms can lead to misdiagnosis. Further progression of symptoms can occur if the symptoms are missed and opportunities for treatment and support are not recognized.</li>
<li>An individual can become symptomatic at any time in life despite the fact that it is inherited.</li>
<li>It is difficult to diagnose.</li>
</ul>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>What is the Prognosis for Someone?</font></h3>
   <h3><font color='44AA11'>What is the Prognosis for Someone?</font></h3>
   <ul>
<li>The prognosis is variable. Some people live a normal life and are minimally affected, others can be severely compromised with the disease. </li>
<li>It is completely individualized </li>
<li>The prognosis is unpredictable. </li>
</ul>
</div>

<div data-role="collapsible" data-iconpos="right" data-theme="c">
   <h3><font color='44AA11'>MitoAction's Goals</font></h3>
   <h3><font color='44AA11'>MitoAction's Goals</font></h3>
   <ul>
<li>To improve quality of life for adults and children affected by mitochondrial disease.</li>
<li>To internationally raise awareness about mitochondrial disorders, and their relationship to other diseases.</li>
<li>To provide specifc and practical materials that help patients to manage their symptoms</li>
<li>To aggregate and connect the international mitochondrial disease community. </li>
<li>To create tools which empower patients and caregivers to be advocates for themselves or their children. </li>
</ul>
</div>


<!--
<div data-role="collapsible-set">

	<div data-role="collapsible" data-collapsed="false" data-iconpos="right">
	<h3>Section 1</h3>
	<p>I'm the collapsible set content for section B.</p>
	</div>
	
	<div data-role="collapsible">
	<h3>Section 2</h3>
	<p>I'm the collapsible set content for section B.</p>
	</div>
	
</div>


	<div data-role="content">	
		<p>Hello world</p>		
	</div>
-->
</div><!-- /page -->
</div>






<!--
<h5 style="cursor:pointer;" onclick="ajaxrequest('date_data.php', 'context')"><u>Click</u></h5>
<div id="txt2">This string will be sent with Ajax to the server, via POST, and processed with PHP</div>
<div id="context">Here will be displayed the response from the php script.</div>


 
<div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="mm-dd-yyyy">
  <input class="span2" size="16" type="text" value="12-02-2012">
  <span class="add-on"><i class="icon-th"></i></span>
</div>
 -->
 <?php
 
 function returnDollars($theAmount,$precision)
 {
 return '$'.round($theAmount,$precision);
 }
 
 function returnDate($dateint,$returnType)
 {
 $yearint = ($dateint - $dateint % 10000)/10000;
 //echo $yearint;
 $dateint = $dateint - $yearint*10000;
 $monthint = ($dateint - $dateint % 100)/100;
 //echo $monthint;
 $dateint = $dateint - $monthint*100;
 $dayint = $dateint;
 //echo $dateint;
 
 $actualdate = mktime(0, 0, 0, $monthint, $dateint, $yearint);
 //echo date_format($actualdate,'Y-m-d H:i:s');
 
 
 if ($returnType == 1)
 $actualdate2 = date('F j, Y',$actualdate);
 if ($returnType == 2)
 $actualdate2 = date('n/j/Y',$actualdate);
echo $actualdate2;

 
 
 /*return date("F j, Y, g:i a"); */
 }
 
 function returnTime($timeint,$returnType)
 {
 $hourint = ($timeint - $timeint % 100)/100;
 $timeint = $timeint - $hourint*100;
 $minuteint = $timeint;
 
 $actualdate = mktime($hourint, $minuteint, 0, 1, 1, 2000);
 
 if ($returnType == 1)
 $actualdate2 = date('g:i A',$actualdate);

echo $actualdate2;
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
  

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->



  </body>
</html>
