<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?><?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

<div class="slider">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

	<div class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<img
						class="preview_picture"
						border="0"
						src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
						width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
						height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
						alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
						style="float:left"
						/>
			<?else:?>
				<img
					class="preview_picture"
					border="0"
					src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
					width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
					height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
					alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
					title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
					style="float:left"
					/>
			<?endif;?>
		<?endif?>
		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
			<span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
		<?endif?>
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
		<div class="slick_title"><?echo $arItem["NAME"]?></div>
			<?else:?>
				<b><?echo $arItem["NAME"]?></b>
			<?endif;?>
		<?endif;?>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
	<div class="slick_descr"><?echo $arItem["PREVIEW_TEXT"];?><br><br><a class="<?echo $arItem['PROPERTIES']['BUTTON1CLASS']['VALUE'];?>" href="<?echo $arItem['PROPERTIES']['BUTTON1LINK']['VALUE']?>"><?echo $arItem['PROPERTIES']['BUTTON1TEXT']['VALUE'];?></a></div>
		<?endif;?>
		<?foreach($arItem["FIELDS"] as $code=>$value):?>
			<small>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			</small><br />
		<?endforeach;?>
		<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
			<small>
			<?=$arProperty["NAME"]?>:&nbsp;
			<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
				<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
			<?else:?>
				<?=$arProperty["DISPLAY_VALUE"];?>
			<?endif?>
			</small><br />
		<?endforeach;?>
	</div>
<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
<style>
div.news-list
{
	word-wrap: break-word;
}
div.news-list img.preview_picture
{
	float:left;
	margin:0 4px 6px 0;
}
.news-date-time {
	color:#486DAA;
}
.slick_title{
	    position: absolute;
    top: 20%;
    font-weight: 800;
    color: white;
    font-size: 25px;
    margin-left: 45px;
}
	.slick_descr{
    position: absolute;
    top: 30%;
    margin-left: 45px;
    color: white;
    font-size: 14px;
    width: 386px;
	line-height: 17px;
margin-top: 10px;
}
	.preview_picture{
		width:1069px;
		height:226px;
}
@media (max-width:1000px){
	.slider, .slick-slider{
	display:none!important;
}
}
.slider{
	width: 80%;
    margin: 0 auto;
}
.slide {
  height: 200px;
}
.slider img{
	opacity: 0.5;
}

.slider .slick-arrow{
    position: absolute;
    top: 50%;
    margin: -15px 0 0 0;
    z-index: 2;
    font-size: 0;
    width: 30px;
    height: 30px;
    border: 0;
  }
.slider .slick-arrow.slick-prev{
	left: -15px;
    background: url('/bitrix/templates/aspro_max/images/svg/left_slick_new.svg') 0 0 / 100% no-repeat;
}

.slider .slick-arrow.slick-next{
    right: -15px;
    background: url('/bitrix/templates/aspro_max/images/svg/right_slick_new.svg') 0 0 / 100% no-repeat;
}


.dots-style {
  text-align: center;
  display: flex;
  justify-content: center;
  list-style: none;
  position: absolute;
   bottom: -10px;
    left: 50%;
}

.dots-style li{
	margin:0 0 0 10px;
}

.dots-style button {
	background: #fff;
    border: none;
    border-radius: 50%;
    font-size: 0;
    height: 6px;
    width: 6px;
    outline: none;
}

.dots-style li[class="slick-active"] button {
  background: #999999;
}


.dots-style li.slick-active {
  display: inline-block;
}
</style>
					<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript">
	$('.slider').slick({
slidesToShow: 1,
  infinite: true,
  arrow:true,
  variableWidth: true,
  centerMode: true,
  dots:true,
  dotsClass: 'dots-style'
	});


</script>