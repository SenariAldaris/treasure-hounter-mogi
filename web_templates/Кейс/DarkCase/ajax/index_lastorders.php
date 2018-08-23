<?
function loadsHtmlLast(){
$arrs=json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/ajax/cron_info.php"),true);

$prefix = "fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz";
for($i=0;$i<10;$i++){
$html .=<<<HTML

<div title="" class="oflo {$arrs[$i]["type"]} item{$arrs[$i]["id"]}" style="" data-original-title="{$arrs[$i]["firstName"]}">
<img src="//steamcommunity-a.akamaihd.net/economy/image/$prefix{$arrs[$i]["image"]}/125fx125">
<div class="ofloname">{$arrs[$i]["fake_nickname"]}</div></div>
HTML;
}
return $html;
}

?>