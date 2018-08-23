<?

error_reporting(0);
function steamRandom($skill,$caseOpen,$case){
include_once($_SERVER["DOCUMENT_ROOT"].'/ajax/configRandom.php');
foreach($caseR[$caseOpen] as $k1 => $v1)$sum[] =$v1["price"];
$sum = max($sum);
$rand = rand(0,$sum);

foreach($caseR[$caseOpen] as $k => $v){
$sums = $sum  / 100 * $v["price"];
 if($v["open"] == "true" and $v["price"] > $rand){
	// print_r("$rand > ".$v["price"]." - $k<br>");
	 $s++;
	$cases[$s]= $k; 
 }
}

$casesCount = count($cases)-1;
$casesRand =  1;
if($casesCount !== 1)$casesRand= rand(1,$casesCount);

	//print_r($casesCount);
	//print_r(" / $rand - $sum /");
//	print_r($cases[$casesRand]);

					return $cases[$casesRand]; 

			
}
?>