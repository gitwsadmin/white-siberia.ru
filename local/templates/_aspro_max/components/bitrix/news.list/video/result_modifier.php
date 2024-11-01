<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult["ITEMS"] as $key => $val){
	preg_match("/https?:\/\/(.*)\.(.*)\/(.*)/", $val["PROPERTIES"]["VIDEO"]["VALUE"], $matches);
	$video_id = $matches["3"];
	$arResult["ITEMS"][$key]["VIDEO"] = $video_id;
}